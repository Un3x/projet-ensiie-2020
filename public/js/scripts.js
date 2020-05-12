// Thomas Meyer <thomasmeyer@outlook.fr>

"use strict";

/**
 * CONSTRUCTEUR
 * 
 * Initialise les structures de données internes à partir des données du
 * challenge 'background' et de la partie 'foreground' qui a été 
 * éventuellement déjà enregistrée par le joueur.
 * 
 * Plusieurs données décrivant le challenge et la partie jouée sont stockées
 * dans des attributs internes. Plus particulièrement, on a une représentation
 * du graphe par liste des arêtes et une représentation de l'automate par 
 * matrice de transition.
 */
var Game = function (background, foreground) {
    
    // @see https://flatuicolors.com/palette/defo
    this.primaryColor = "#bdc3c7"; // Silver
    
    /* States [... [x, y] ...]
     * 
     * Liste des sommets avec leurs coordonnées. La position dans la liste
     * donne l'indice du sommet.
     */
    this.state = background.state;
    
    /* Edges [... [from, to] ...]
     * 
     * Liste des arêtes du graphe orienté. La position dans la liste donne 
     * l'indice de l'arête.
     */
    this.edge = background.edge;
    
    /* Accepting states
     * 
     * Liste de booléens de même taille que this.state. true signifie que
     * le sommet est acceptant. false signifie le contraire.
     */
    this.accepting = background.accepting;
    
    /* Par convention, on considère que le sommet d'indice 0 est le sommet
     * de départ de l'automate.
     */
    
    /* Symbols
     * 
     * Un symbole est représenté par un entier entre 0 et size.
     */
    this.symbol = {
        size: background.numberOfSymbols,
        /* @see https://flatuicolors.com/palette/defo
         * 
         * Pour connaître la couleur d'un symbole, il faut prendre la couleur
         * ayant le même indice. On a 4 symboles au maximum pour le moment.
         */
        color: [
            "#2980b9", // Belize Hole
            "#c0392b", // Pomegranate
            "#27ae60", // Nephritis
            "#8e44ad"  // Wisteria
        ]
    };
    
    /* Mémorise les tags "symbole" de la fenêtre de dialogue de sélection des
     * transitions. Facilite l'actualisation des symboles quand on sélectionne 
     * une arête.
     */
    this.modalSymbols = new Array(this.symbol.size);
    
    /* Pour ajouter dynamiquement les symboles du challenge à la fenêtre de 
     * dialogue.
     */
    var selectSymbol = document.getElementById("select-symbol");
    
    /* Générer les tags "symbole" de la fenêtre de dialogue en fonction des
     * données du challenge.
     */
    for (var s = 0 ; s < this.symbol.size ; s++) {
        
        // Création et personnalisation du tag "symbole"
        var symbol = document.createElement("div");
        symbol.style.backgroundColor = this.symbol.color[s];
        symbol.style.opacity = 0.5;
        symbol.attributes.s = s;
        
        /* Ajout d'un évènement pour permettre de (dé)-sélectionner un symbole
         * pour une arête donnée.
         */
        symbol.addEventListener("click", function (e) {
            // Symbole non sélectionné avant, sélectionné après
            if (e.target.style.opacity == 0.5) {
                e.target.style.opacity = 1;
                game.addSymbol(e.target.attributes.s);
            }
            // Symbole sélectionné avant, non sélectionné après
            else {
                e.target.style.opacity = 0.5;
                game.removeSymbol(e.target.attributes.s);
            }
        });
        
        // Ajout à la page et mémorisation
        selectSymbol.appendChild(symbol);
        this.modalSymbols[s] = symbol;
    }
    
    /* Sequences
     * 
     * Tableau contenant les séquences du challenge. Chaque séquence est une
     * liste de taille variable contenant les indices des symboles de la 
     * séquence.
     */
    this.sequence = background.sequence;
    
    /* Pour ajouter dynamiquement les différentes séquences à la liste des
     * séquences du jeu.
     */
    var selectSequence = document.getElementById("select-sequence");
    
    /* On mémorise les différentes séquences du jeu affichées sur la page pour 
     * attribuer un couleur en fonction du résultat de l'évaluation.
     */
    this.cartoucheSequences = new Array(this.sequence.length);
    
    /* Générer la liste des séquences du challenge en fonction des données du
     * challenge.
     */
    for (var s = 0 ; s < this.sequence.length ; s++) {
        
        // Création de l'élément liste et style
        var sequence = document.createElement("li");
        sequence.classList.add("list-group-item");
        
        /* Dans cette liste, on ajoute autant de pastilles colorées pour 
         * représenter les symboles de la séquence en cours.
         */
        for (var t = 0 ; t < this.sequence[s].length ; t++) {
            // Création du tag "pastille", spécification de la couleur et ajout
            var symbol = document.createElement("div");
            symbol.style.backgroundColor = this.symbol.color[this.sequence[s][t]];
            sequence.appendChild(symbol);
        }
        
        // Ajout à la page et mémorisation
        selectSequence.appendChild(sequence);
        this.cartoucheSequences[s] = sequence;
    }
    
    /* Transitions
     * 
     * Matrice des transitions. Il y a autant de lignes que de sommets et autant
     * de colonnes que de symboles. Pour avoir la transition de symbole s à partir
     * du sommet u, il faut regarder à la case d'indices [u)[s]. Chaque élément de 
     * la matrice est : soit null en l'absence de cette transition ; soit au 
     * format [to, pastilleAffichéeParKonvas].
     */
    this.transition = new Array(this.state.length);
    
    /* Containers for symbols
     * 
     * Pour afficher les symboles sur le graphe, on utilise un "container" qui est
     * est caractérisé par [x, y, dx, dy] avec (x, y) la position du premier symbole
     * à afficher et (dx, dy) les écarts à ajouter à la position du symbole précédent
     * pour connaître la position du symbole suivant.
     */
    this.symbolContainer = new Array(this.edge.length);
    
    /* To create the transition matrix
     * 
     * On initialise la matrice des transitions à null pour le moment.
     */
    for (var from = 0 ; from < this.state.length ; from++) {
        this.transition[from] = new Array(this.symbol.size);
        for (var s = 0 ; s < this.symbol.size ; s++) {
            this.transition[from][s] = null;
        }
    }
    
    /* To fill the transition matrix
     * 
     * Ensuite, on utilise les données de la partie jouée 'foreground' pour remplir
     * la matrice avec les transitions et symboles enregistrés.
     */
    for (var t = 0 ; t < this.edge.length ; t++) {
        
        var [from, to] = this.edge[t];
        
        for (var s = 0 ; s < this.symbol.size ; s++) {
            if (foreground.symbolsOfTransition[t][s]) {
                // On ne dispose par encore de la référence à l'objet
                this.transition[from][s] = [to, null];
            }
        }
        
        // [x, y, dx, dy]
        this.symbolContainer[t] = null;
    }
    
    // The stage
    this.stage = new Konva.Stage({
        container: 'container',
        width: 1000,
        height: 500
    });
    
    // On spécifie les dimensions du container d'affichage
    var container = document.getElementById("container");
    container.style.width = "1000px";
    container.style.height = "500px";
    
    /* Nécessaire pour connaître la transition sélectionnée à l'affichage 
     * de la fenêtre de dialogue.
     */
    this.currentTransition = null;
    
    // The layer
    this.layer = new Konva.Layer();
    this.stage.add(this.layer);
};

/**
 * Utilisée par un Event sur un tag "symbole" de la fenêtre de dialogue pour
 * ajouter le symbole 's' sur la transition courante. La matrice de transition
 * est modifiée. Une pastille représentant le symbole est ajoutée sur la scène.
 */
Game.prototype.addSymbol = function (s) {
    // Récupérer la transition courante
    var [from, to] = this.edge[this.currentTransition];
    // Ajouter uniquement si pas déjà fait
    if (this.transition[from][s] === null) {
        // Créer la pastille à afficher
        var symbol = new Konva.Circle ({
            x: 0,
            y: 0,
            radius: 5,
            fill: this.symbol.color[s]
        });
        // Afficher
        this.layer.add(symbol);
        // Modifier la matrice de transition
        this.transition[from][s] = [to, symbol];
        // Actualiser l'affichage pour la transition courante
        this.refreshSymbolContainer(this.currentTransition);
    }
};

/**
 * Utilisée par un Event sur un tag "symbole de la fenêtre de transition pour
 * retirer le symbole 's' de la transition courante. La matrice de transition
 * est modifiée. La pastille représentant le symbole est retirée de la scène.
 */
Game.prototype.removeSymbol = function (s) {
    // Récupérer la transition courante
    var [from, to] = this.edge[this.currentTransition];
    // Retirer uniquement si pas déjà fait
    if (this.transition[from][s] !== null) {
        // Supprimer le pastille de la scène
        this.transition[from][s][1].destroy();
        // Modifier la matrice des transitions
        this.transition[from][s] = null;
        // Actualiser l'affichage de la transition courante
        this.refreshSymbolContainer(this.currentTransition);
    }
};

/**
 * Retourne un booléen indiquant si l'arc (from, to) existe dans la liste des 
 * arcs du graphe.
 */
Game.prototype.existsEdge = function (from, to) {
    for (var t = 0 ; t < this.edge.length ; t++) {
        var [tfrom, tto] = this.edge[t];
        if (tfrom === from && tto === to) {
            return true;
        }
    }
    return false;
};

/**
 * Affiche l'automate sur la scène. Cette fonction est appelée uniquement à
 * l'initialisation.
 */
Game.prototype.draw = function () {
    
    // To draw states
    for (var s = 0 ; s < this.state.length ; s++) {
        this.drawState(s);
    }
    
    /* To draw transitions
     * 
     * On distingue les différents types de transitions possibles : simples,
     * doubles ou sur un même sommet.
     */
    for (var t = 0 ; t < this.edge.length ; t++) {
        
        var [from, to] = this.edge[t];
        
        // Self
        if (from === to) {
            this.drawSelfTransition(t, from);
        }
        
        // Simple
        else if (!this.existsEdge(to, from)) {
            this.drawSimpleTransition(t, from, to);
        }
        
        // Double
        else {
            this.drawDoubleTransition(t, from, to);
        }
    }
    
    // To end, we have to display
    this.layer.batchDraw();
};

/**
 * Affiche le sommet d'indice 'state'. Les données de position sont
 * trouvées dans la liste des dommets.
 */
Game.prototype.drawState = function (state) {
    
    // A state is represented by a circle
    var [x, y] = this.state[state];
    var circle = new Konva.Circle ({
        x: x,
        y: y,
        radius: 20,
        fill: state === 0 ? "#d35400" : this.primaryColor,
        stroke: this.accepting[state] ? "#d35400" : this.primaryColor,
        strokeWidth: 3
    });
    this.layer.add(circle);
};

/**
 * Utilisée pour actualiser les états des différents tags "symbole" de la 
 * fenêtre de dialogue en fonction des symboles actuellement présent dans le
 * modèle pour l'arc d'indice 't'.
 */ 
Game.prototype.displaySymbols = function (t) {
    // L'arc courant
    var [from, to] = this.edge[t];
    
    for (var s = 0 ; s < this.symbol.size ; s++) {
        // Le symbole 's' est présent pour l'arc 't'
        if (this.transition[from][s] !== null && this.transition[from][s][0] === to) {
            this.modalSymbols[s].style.opacity = 1;
        }
        // Le symbole 's' n'est pas présent pour l'arc 't'
        else {
            this.modalSymbols[s].style.opacity = 0.5;
        }
    }
};

/**
 * Affiche l'arc 't' sur la scène en fonctions des coordonnées d'affichage
 * 'points' et de la tension éventuelle 'tension' de l'arc. Cette fonction
 * est utilisée pour afficher les différents types d'arcs du graphe.
 */
Game.prototype.drawTransition = function (t, points, tension) {
    
    // Configuration d'affichage
    var config = {
        points: points,
        
        pointerLength: 10,
        pointerWidth: 10,
        
        fill: this.primaryColor,
        stroke: this.primaryColor,
        
        strokeWidth: 3,
    };
    
    // Ce paramètre permet de spécifier une courbure ou non pour l'arc
    if (tension !== null) {
        config.tension = tension;
    }
    
    var z = t;
    
    // Création de l'arc
    var arrow = new Konva.Arrow(config);
    
    /* Ajout d'un évènement pour permettre l'ouverture de la fenêtre de 
     * dialogue en cliquant sur l'arc.
     */
    arrow.on("click", function (e) {
        game.currentTransition = z;
        game.displaySymbols(t);
        $("#select-symbol-modal").modal("show");
    });
    
    this.layer.add(arrow);    
};

/**
 * Affiche le symbole 's' sur l'arc 't' à la position '(x, y)'.
 */
Game.prototype.drawSymbol = function (t, s, x, y) {
    
    // Création du symbole
    var symbol = new Konva.Circle ({
        x: x,
        y: y,
        radius: 5,
        fill: this.symbol.color[s]
    });
    
    // Récupération des données de l'arc
    var [from, to] = this.edge[t];
    
    // On mémorise l'objet représentant le symbole
    this.transition[from][s][1] = symbol;
    this.layer.add(symbol);
};

/**
 * Dessine le "container" contenant les symboles présents sur l'arc 't'. Les
 * données '(x, y, dx, dy)' permettent de spécifier la position et l'orientation
 * de ce "container".
 */
Game.prototype.drawSymbolContainer = function (t, x, y, dx, dy) {
    
    // On mémorise les paramètres d'affichage du "container"
    this.symbolContainer[t] = [x, y, dx, dy];
    
    // Arc d'affichage
    var [from, to] = this.edge[t];
    
    // Compteur comptant la position du ième symbole présent sur l'arc
    var i = 1;
    
    // On affiche successivement chaque symbole effectivement présent sur l'arc
    for (var s = 0 ; s < this.symbol.size ; s++) {
        if (this.transition[from][s] !== null && this.transition[from][s][0] === to) {
            this.drawSymbol(t, s, x + dx * i, y + dy * i);
            i = i + 1;
        }
    }
};

/**
 * Actualise l'affichage du "container" pour l'arc 't'. On déplace les symboles
 * encore présent sur l'arc après l'ajout ou le retrait d'un symbole.
 */
Game.prototype.refreshSymbolContainer = function (t) {
    
    // Compteur comptant la position du ième symbole présent sur l'arc
    var i = 1;
    
    // Arc
    var [from, to] = this.edge[t];
    
    // Paramètres d'affichage du "container"
    var [x, y, dx, dy] = this.symbolContainer[t];
    
    // On affiche successivement chaque symbole effectivement présent sur l'arc
    for (var s = 0 ; s < this.symbol.size ; s++) {
        
        if (this.transition[from][s] !== null && this.transition[from][s][0] === to) {
            
            // Le symbole est déplacé à sa bonne position sur la scène
            var symbol = this.transition[from][s][1];
            symbol.x(x + dx * i);
            symbol.y(y + dy * i);
            
            i = i + 1;
        }
    }
    
    this.layer.batchDraw();
};

/**
 * Dessine un arc 't' courbé sur un même sommet 'state'. Cette fonction
 * calcule les coordonnées d'affichage de cet arc avant d'utiliser 
 * 'drawTransition' pour l'affichage. Elle détermine également les 
 * paramètres d'affichage du "container" avant d'utiliser 
 * 'drawSymbolContainer'.
 */
Game.prototype.drawSelfTransition = function (t, state) {
    
    // Cet angle spécifie l'orientation de l'arc autour du sommet. Modifiable.
    var angle = Math.PI / 2;
    
    // Coordonnées du sommet
    var [x, y] = this.state[state];
    
    // Position du point de passage permettant d'afficher l'arc courbé
    var x3 = x - 60 * Math.sin(angle - Math.PI / 4);
    var y3 = y - 60 * Math.cos(angle - Math.PI / 4);
    
    //
    this.drawTransition(t, [
        // Point de départ
        x - 20 * Math.sin(angle),
        y - 20 * Math.cos(angle),
        // Point de passage de l'arc
        x3,
        y3,
        // point d'arrivé
        x - 20 * Math.sin(angle - Math.PI / 2),
        y - 20 * Math.cos(angle - Math.PI / 2)
    ], 2.5); // Courbure 2.5. Modifiable.
    
    // Ecarts à utiliser pour l'affichage du "container" des symboles
    var dx = - 15 * Math.sin(angle - Math.PI / 4);
    var dy = - 15 * Math.cos(angle - Math.PI / 4);
    
    this.drawSymbolContainer(t, x3, y3, dx, dy);
};

/**
 * Dessine un arc 't' simple entre un sommet 'from' et un sommet 'to'.
 * Cette fonction calcule les coordonnées d'affichage de cet arc avant 
 * d'utiliser 'drawTransition' pour l'affichage. Elle détermine également 
 * les paramètres d'affichage du "container" avant d'utiliser 
 * 'drawSymbolContainer'.
 */
Game.prototype.drawSimpleTransition = function (t, from, to) {
    
    // Coordonnées des points de départ et d'arrivé
    var [x1, y1] = this.state[from];
    var [x2, y2] = this.state[to];
    
    /* On utilise getConnectorPoints pour ne pas pointer sur les centres
     * des sommets.
     */
    this.drawTransition(
        t, this.getConnectorPoints(x1, y1, x2, y2), null
    );
    
    // Point milieu pour l'affichage du container
    var x3 = (x1 + x2) / 2;
    var y3 = (y1 + y2) / 2;
    
    // Ecarts à utiliser en fonction des positions relatives des sommets
    var dx = Math.sign(y2 - y1) * 15
    var dy = Math.sign(x2 - x1) * 15;
    
    this.drawSymbolContainer(t, x3, y3, dx, dy);
};

/**
 * Dessine un arc 't' courbé entre un sommet 'from' et un sommet 'to'.
 * Cette fonction calcule les coordonnées d'affichage de cet arc avant 
 * d'utiliser 'drawTransition' pour l'affichage. Elle détermine également 
 * les paramètres d'affichage du "container" avant d'utiliser 
 * 'drawSymbolContainer'.
 */
Game.prototype.drawDoubleTransition = function (t, from, to) {
    
    // Coordonnées des points de départ et d'arrivé
    var [x1, y1] = this.state[from];
    var [x2, y2] = this.state[to];
    
    /* Coordonnées du point de passage, en écart par rapport au point milieu
     * et en fonction des positions relatives des sommets.
     */
    var x3 = Math.sign(y2 - y1) * 30 + (x1 + x2) / 2;
    var y3 = Math.sign(x2 - x1) * 30 + (y1 + y2) / 2;
    
    /* On utilise getConnectorPoints pour ne pas pointer sur les centres
     * des sommets.
     */
    var [x1, y1, x2, y2] = this.getConnectorPoints(x1, y1, x2, y2);
    
    this.drawTransition(
        t, [x1, y1, x3, y3, x2, y2], 0.5
    );
    
    // Ecarts à utiliser en fonction des positions relatives des sommets
    var dx = Math.sign(y2 - y1) * 15
    var dy = Math.sign(x2 - x1) * 15;
    
    this.drawSymbolContainer(t, x3, y3, dx, dy);
};

/**
 * Cette fonction permet d'obtenir des coordonnées en écart par rapport aux
 * centres des sommets de coordonnées '(x1, y1)' et '(x2, y2)'. Cela évite
 * d'avoir des flèches qui pointent directement sur les centres de sommets,
 * ce qui est moche.
 */
Game.prototype.getConnectorPoints = function (x1, y1, x2, y2) {
    
    var dx = x2 - x1;
    var dy = y2 - y1;
    
    var angle = Math.atan2(-dy, dx);
    var radius = 20;
    
    return [
        x1 - radius * Math.cos(angle + Math.PI),
        y1 + radius * Math.sin(angle + Math.PI), 
        x2 - radius * Math.cos(angle),
        y2 + radius * Math.sin(angle)
    ];
    
};

/**
 * Retourne un booléen indiquant le résultat de l'évalution de l'automate
 * sur la séquence 's'. true signifie que la séquence est vérifiée. false
 * signifie le contraire.
 */
Game.prototype.evalOne = function (s) {
    
    // Position initiale : contention, c'est le sommet 0
    var current = 0;
    
    // Pour chaque symbole de la séquence
    for (var symbol = 0; symbol < this.sequence[s].length; symbol++) {
        
        /* Chercher s'il existe une transition à partir du sommet courant
         * qui contient ce symbole.
         */
        if (this.transition[current][this.sequence[s][symbol]] === null) {
            return false;
        }
        
        // Si c'est le cas, continuer avec le nouveau sommet
        current = this.transition[current][this.sequence[s][symbol]][0];
    }
    
    // L'automate accepte la séquence si le sommet d'arrivé est acceptant
    return this.accepting[current];
};

/**
 * Evalue l'automate sur chaque séquence stockée en interne et affiche les résultats
 * sur la page. Rouge pour un échec et Vert pour un succès.
 */
Game.prototype.evalAll = function (s) {
    
    for (var s = 0; s < this.sequence.length; s++) {
        if (this.evalOne(s)) {
            this.cartoucheSequences[s].style.borderBottom = "solid 2px #2ecc71";
        }
        else {
            this.cartoucheSequences[s].style.borderBottom = "solid 2px #e74c3c";
        }
    }
};
