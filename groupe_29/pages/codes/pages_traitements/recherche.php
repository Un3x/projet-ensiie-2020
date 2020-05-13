<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

    //process a l'envoi du formulaire ie quand l'utilsateur clique sur le bouton form
    if(isset($_POST['form'])) {
        //Connexion a la base de donnée
       //J'utilise les id de Chipie pour Uniformiser et ne pas avoir à changer à chaque fois
        /*$PARAM_hote='localhost'; //chemin vers le serveur
        $PARAM_port='5432';
        $PARAM_nom_bd='ipw'; // nom de notre bdd
        $PARAM_utilisateur='cao_caroline'; // nom d'utilisateur pour se connecter
        $PARAM_mot_passe='123'; // mdp de l'utilisateur pour se connecter
 */
        $PARAM_hote='localhost'; //chemin vers le serveur
        $PARAM_port='5432';
        $PARAM_nom_bd='projet_web'; // nom de notre bdd
        $PARAM_utilisateur='lauriane'; // nom d'utilisateur pour se connecter
        $PARAM_mot_passe='lauriane'; // mdp de l'utilisateur pour se connecter
 
        try
        {  
            $pdo =  new PDO('pgsql:host='.$PARAM_hote.';port='.$PARAM_port.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
         
        catch(Exception $e)
        {
            echo 'Erreur Postgresql, prb d acces a la bdd.';
             
        }
 
 
        //Récupérations du texte entré par l'utilisateur
        $surname = htmlentities($_POST['surname']);
        $firstname = htmlentities($_POST['firstname']);
        $pseudo = htmlentities($_POST['pseudo']);
        $asso = htmlentities($_POST['asso']);

        $lecture = htmlentities($_POST['Aime_lire']);
        $voyage = htmlentities($_POST['Aime_voyager']);
 
        //requete : on récupère toutes lignes de "utilisateur" où prenom et nom correspondent à ce que l'utilsateur a cherché

        //SELECT * from utilisateur JOIN gout ON utilisateur.id=gout.id JOIN association ON utilisateur.id=association.id;

        $sql = "SELECT * FROM utilisateur JOIN association ON utilisateur.id=association.id JOIN gout ON utilisateur.id=gout.id WHERE lower(prenom) like :prenom AND lower(nom) like :nom AND lower(pseudo) like :pseudo AND lower(nom_association) like :asso ";

        if (!empty($_POST['Aime_lire'])) {
            $sql .= "AND aime_lire = :aime_lire ";
        }
        if (!empty($_POST['Aime_voyager'])) {
            $sql .= "AND aime_voyager = :aime_voyager ";
        }

        $req = $pdo->prepare($sql);
        $req->bindValue(":prenom", "%".strtolower($firstname)."%");
        $req->bindValue(":nom", "%".strtolower($surname)."%");
        $req->bindValue(":pseudo", "%".strtolower($pseudo)."%");
        $req->bindValue(":asso", "%".strtolower($asso)."%");

        if (!empty($_POST['Aime_lire'])) {
            $req->bindValue(":aime_lire", $lecture);
        }
        if (!empty($_POST['Aime_voyager'])) {
            $req->bindValue(":aime_voyager", $voyage);
        }

        $req->execute();

        //pour l'instant juste j'affiche tous les sujets de notre requete, pour voir si ça marche, il faudra ensuite que ça apparaisse sous forme de proposition pour que sa redirige vers la page chosie
        
?>
<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8"/>
        <title> Resultat de la recherche </title>
        <link rel="stylesheet" type="text/css" href="../../mises_en_pages/res_recherche.css">
    </head>

    <body>

        <div class="topbar">
            <a href="../4_Page_2.php">Accueil</a>
            <a class="actif" href="../formulaire_de_recherche.php">Rechercher un ami</a>
            <a href="../Profil.php">Mon profil</a> 
            <a href="../deconnexion.php" class="param">Déconnexion</a>
        </div>

        <div class="form">
            <fieldset>
                <legend><span class="number"></span>Resultat de la recherche</legend>
                


                <?php

while($donnees = $req->fetch(PDO::FETCH_OBJ)) {

?>
    <center>
    <div class = "etiquette"> <?php
    echo '<a href = "../profil_a_visite.php?nom='.$donnees->nom.'&prenom='.$donnees->prenom.'&pseudo='.$donnees->pseudo.'">'.$donnees->nom.' "'.$donnees->pseudo.'" '.$donnees->prenom;
?>          </div>
    <br/>
    <br/>
    </center>
     <?php
}
?>
</fieldset>
</div>
<?php

}
?>

</body>
</html>