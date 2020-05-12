CREATE TABLE Utilisateur(
    pseudo VARCHAR(20) PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    mot_de_passe VARCHAR(20) NOT NULL,
    date_creation DATE NOT NULL,
    mail VARCHAR(50),
    statut BOOLEAN NOT NULL DEFAULT false,
    banni BOOLEAN NOT NULL
);

CREATE TABLE Liste(
    id SERIAL PRIMARY KEY,
    nom_liste VARCHAR(100) NOT NULL,
    likes INTEGER DEFAULT 0
);


CREATE TABLE Ravoir(
    pseudo VARCHAR(20) NOT NULL,
    id_liste INTEGER NOT NULL,
    CONSTRAINT  fk_avoir_pseudo FOREIGN KEY (pseudo) REFERENCES Utilisateur(pseudo),
    CONSTRAINT  fk_avoir_id_liste FOREIGN KEY (id_liste) REFERENCES Liste(id),
    PRIMARY KEY (pseudo,id_liste)    
);


CREATE TABLE Oeuvre(
    numero SERIAL PRIMARY KEY,
    titre VARCHAR(100) NOT NULL,
    lien_photo VARCHAR,
    synopsis TEXT,
    date_sortie DATE 
);

CREATE TABLE Livre(
    M1_cle INTEGER NOT NULL,
    nb_pages INTEGER NOT NULL,
    langue VARCHAR(50) NOT NULL,
    genre VARCHAR(50) NOT NULL,
    CONSTRAINT fk_M1 FOREIGN KEY (M1_cle) REFERENCES Oeuvre(numero)
);

CREATE TABLE Film(
    M2_cle INTEGER NOT NULL,
    realisateur VARCHAR(50),
    genre VARCHAR(50) NOT NULL,
    duree SMALLINT NOT NULL,
    producteur VARCHAR(50),
    CONSTRAINT fk_M2 FOREIGN KEY (M2_cle) REFERENCES Oeuvre(numero)
);

CREATE TABLE Serie(
    M3_cle INTEGER NOT NULL,
    nb_ep INTEGER,
    nb_saisons INTEGER,
    duree SMALLINT NOT NULL,
    genre VARCHAR(50) NOT NULL,
    anime SMALLINT NOT NULL,
    CONSTRAINT fk_M3 FOREIGN KEY (M3_cle) REFERENCES Oeuvre(numero)
);

CREATE VIEW Vlivre(numero,titre,lien_photo,date_sortie,nb_pages,langue,genre) AS SELECT Oeuvre.numero,Oeuvre.titre,Oeuvre.lien_photo,Oeuvre.date_sortie,Livre.nb_pages,Livre.langue,Livre.genre FROM Oeuvre JOIN Livre ON Oeuvre.numero = Livre.M1_cle;
CREATE VIEW Vfilm(numero,titre,lien_photo,date_sortie,realisateur,genre,duree,producteur) AS SELECT Oeuvre.numero,Oeuvre.titre,Oeuvre.lien_photo,Oeuvre.date_sortie,Film.realisateur,Film.genre,Film.duree,Film.producteur FROM Oeuvre JOIN Film ON Oeuvre.numero = Film.M2_cle;
CREATE VIEW Vserie(numero,titre,lien_photo,date_sortie,nb_ep,nb_saisons,duree,genre,anime) AS SELECT Oeuvre.numero,Oeuvre.titre,Oeuvre.lien_photo,Oeuvre.date_sortie,Serie.nb_ep,Serie.nb_saisons,Serie.duree,Serie.genre,Serie.anime FROM Oeuvre JOIN Serie ON Oeuvre.numero = Serie.M3_cle;

CREATE TABLE EtreDans(
    numero INTEGER NOT NULL,
    id_liste INTEGER NOT NULL,
    CONSTRAINT  fk_etre_dans_numero FOREIGN KEY (numero) REFERENCES Oeuvre(numero),
    CONSTRAINT  fk_etre_dans_id_liste FOREIGN KEY (id_liste) REFERENCES Liste(id),
    PRIMARY KEY (numero,id_liste)    
);


CREATE TABLE Noter(
    pseudo VARCHAR(20) NOT NULL,
    numero INTEGER NOT NULL,
    note SMALLINT,
    CONSTRAINT  fk_noter_pseudo FOREIGN KEY (pseudo) REFERENCES Utilisateur(pseudo),
    CONSTRAINT  fk_noter_numero FOREIGN KEY (numero) REFERENCES Oeuvre(numero),
    PRIMARY KEY (pseudo,numero)    
);

CREATE TABLE Commentaire(
    id SERIAL PRIMARY KEY,
    pseudo VARCHAR(20) NOT NULL,
    numero INTEGER NOT NULL,
    texte TEXT,
    date_com TIMESTAMP,
    alerte VARCHAR(20),
    CONSTRAINT fk_link_pseudo FOREIGN KEY (pseudo) REFERENCES Utilisateur(pseudo),
    CONSTRAINT fk_link_id FOREIGN KEY (numero) REFERENCES Oeuvre(numero)
);

CREATE TABLE Suivre(
    suiveur VARCHAR(15) NOT NULL,
    suivi VARCHAR(15) NOT NULL,
    CONSTRAINT fk_suiveur FOREIGN KEY (suiveur) REFERENCES Utilisateur(pseudo),
    CONSTRAINT fk_suivi FOREIGN KEY (suivi) REFERENCES Utilisateur(pseudo),
    PRIMARY KEY (suiveur, suivi)
);

CREATE TABLE Liker(
    liste INTEGER NOT NULL,
    pseudo VARCHAR(20) NOT NULL,
    CONSTRAINT fk_liste FOREIGN KEY (liste) REFERENCES Liste(id),
    CONSTRAINT fk_pseudo FOREIGN KEY (pseudo) REFERENCES Utilisateur(pseudo),
    PRIMARY KEY(liste,pseudo)
);

SET datestyle = dmy;


insert into Utilisateur (pseudo, prenom, nom, mot_de_passe, date_creation, mail, statut, banni) values ('admin', 'admin', 'admin','123456', '12/4/2000', 'orugg0@bbc.co.uk', true, false);
insert into Utilisateur (pseudo, prenom, nom, mot_de_passe, date_creation, mail, statut, banni) values ('Pain Reli', 'Omero', 'Rugg','123456', '12/4/2000', 'nicolas.brunel@ensiie.fr', true, false);
insert into Utilisateur (pseudo, prenom, nom, mot_de_passe, date_creation, mail, statut, banni) values ('Olay Profe', 'Diane','Nettleship', '32087', '12/4/2000','dnettleship1@shop-pro.jp', false, false);
insert into Utilisateur (pseudo, prenom, nom, mot_de_passe, date_creation, mail, statut, banni) values ('Olanzapi', 'Ayn', 'MacTrustam','3192864832', '12/4/2000', 'amactrustam2@japanpost.jp', false, false);
insert into Utilisateur (pseudo, prenom, nom, mot_de_passe, date_creation, mail, statut, banni) values ('Tea Tree Anti', 'Hobard', 'Plampin','42981329871','12/4/2000', 'hplampin3@wikia.com', false, false);
insert into Utilisateur (pseudo, prenom, nom, mot_de_passe, date_creation, mail, statut, banni) values ('Dior Bronze', 'Faina', 'Brunke','51293Y1', '12/4/2000', 'fbrunke4@independent.co.uk', false, true);
insert into Utilisateur (pseudo, prenom, nom, mot_de_passe, date_creation, mail, statut, banni) values ('Doxycycli', 'Davina', 'Issett', '612831','12/4/2000', 'dissett5@alexa.com',false, false);
insert into Utilisateur (pseudo, prenom, nom, mot_de_passe, date_creation, mail, statut, banni) values ('Aplicare Tot', 'Ardenia', 'McGriffin','71038021', '12/4/2000', 'amcgriffin6@wired.com',false, false);
insert into Utilisateur (pseudo, prenom, nom, mot_de_passe, date_creation, mail, statut, banni) values ('All Day Moist', 'Elna', 'Dalwood', '82713','12/4/2000', 'edalwood7@sohu.com',false, false);
insert into Utilisateur (pseudo, prenom, nom, mot_de_passe, date_creation, mail, statut, banni) values ('Milk of Magne', 'Malvin', 'Keilty', '912831','12/4/2000','mkeilty8@yelp.com',false, true);
insert into Utilisateur (pseudo, prenom, nom, mot_de_passe, date_creation, mail, statut, banni) values ('HYDROCHLOR', 'Rube', 'Langfield', '10&23889','12/4/2000','rlangfield9@tinyurl.com',false, false);
insert into Utilisateur (pseudo, prenom, nom, mot_de_passe, date_creation, mail, statut, banni) values ('Modafinil', 'Irma', 'Varrow', '111203912','12/4/2000','ivarrowa@apache.org',false, true);

INSERT INTO Liste (nom_liste,likes) VALUES ('Favoris',33);
INSERT INTO Liste (nom_liste,likes) VALUES ('Favoris',503);
insert into Liste ( nom_liste,likes) values ( 'Nicotine Polacrilex',5000);
insert into Liste ( nom_liste,likes) values ( 'Lidocaine Hydrochloride and Epinephrine Bitartrate',30);
insert into Liste ( nom_liste,likes) values ( 'Naproxen Sodium',40);
insert into Liste ( nom_liste,likes) values ( 'memantine hydrochloride',12);
insert into Liste ( nom_liste,likes) values ( 'TRICLOSAN',6);
insert into Liste ( nom_liste,likes) values ( 'Flumazenil',57);
insert into Liste ( nom_liste,likes) values ( 'vancomycin hydrochloride',10);
insert into Liste ( nom_liste,likes) values ( 'Methocarbamol',37);
insert into Liste ( nom_liste,likes) values ( 'Ragweed Short',22);


INSERT INTO Ravoir (pseudo,id_liste) VALUES ('Pain Reli',1);
INSERT INTO Ravoir (pseudo,id_liste) VALUES ('Aplicare Tot',2);
INSERT INTO Ravoir (pseudo,id_liste) VALUES ('Doxycycli',3);
INSERT INTO Ravoir (pseudo,id_liste) VALUES ('Pain Reli',5);
INSERT INTO Ravoir (pseudo,id_liste) VALUES ('Tea Tree Anti',3);
INSERT INTO Ravoir (pseudo,id_liste) VALUES ('Dior Bronze',4);
INSERT INTO Ravoir (pseudo,id_liste) VALUES ('Dior Bronze',8);
INSERT INTO Ravoir (pseudo,id_liste) VALUES ('Aplicare Tot',6);
INSERT INTO Ravoir (pseudo,id_liste) VALUES ('Olay Profe',7);
INSERT INTO Ravoir (pseudo,id_liste) VALUES ('Aplicare Tot',9);
INSERT INTO Ravoir (pseudo,id_liste) VALUES ('Pain Reli',10);
 
insert into Oeuvre (numero, titre, lien_photo, synopsis, date_sortie) values (1, 'Avatar','img/avatar.jpg', 'Malgré sa paralysie, Jake Sully, un ancien marine immobilisé dans un fauteuil roulant, est resté un combattant au plus profond de son être. Il est recruté pour se rendre à des années-lumière de la Terre, sur Pandora, où de puissants groupes industriels exploitent un minerai rarissime destiné à résoudre la crise énergétique sur Terre.','16/12/2009');
insert into Oeuvre (numero, titre, lien_photo, synopsis, date_sortie) values (2, 'Pulp Fiction','img/pulpfiction.jpg','L''odyssée sanglante et burlesque de petits malfrats dans la jungle de Hollywood à travers trois histoires qui sentremêlent. Dans un restaurant, un couple de jeunes braqueurs, Pumpkin et Yolanda, discutent des risques que comporte leur activité. Deux truands, Jules Winnfield et son ami Vincent Vega, qui revient dAmsterdam, ont pour mission de récupérer une mallette au contenu mystérieux et de la rapporter à Marsellus Wallace.','26/10/1994');
insert into Oeuvre (numero, titre, lien_photo, synopsis, date_sortie) values (3, 'Rocky','img/rocky.jpg','Rocky Balboa travaille pour Tony Gazzo, un usurier, et dispute de temps à autre des combats de boxe pour quelques dizaines de dollars sous l''appellation de l''Étalon Italien. Cependant, Mickey, propriétaire du club de boxe où Rocky a l''habitude de sentraîner, décide de céder son casier à un boxeur plus talentueux.','25/03/1976');
insert into Oeuvre (numero, titre, lien_photo, synopsis, date_sortie) values (4, 'Interstellar','img/interstellar.jpg','Dans un futur proche, la Terre est de moins en moins accueillante pour l''humanité qui connaît une grave crise alimentaire. Le film raconte les aventures d''un groupe d''explorateurs qui utilise une faille récemment découverte dans l''espace-temps afin de repousser les limites humaines et partir à la conquête des distances astronomiques dans un voyage interstellaire.','05/11/2014');
insert into Oeuvre (numero, titre, lien_photo, synopsis, date_sortie) values (5, 'Inception','img/inception.jpg','Dom Cobb est un voleur expérimenté dans l''art périlleux de l''extraction : sa spécialité consiste à s''approprier les secrets les plus précieux d''un individu, enfouis au plus profond de son subconscient, pendant qu''il rêve et que son esprit est particulièrement vulnérable. Très recherché pour ses talents dans l''univers trouble de l''espionnage industriel, Cobb est aussi devenu un fugitif traqué dans le monde entier. Cependant, une ultime mission pourrait lui permettre de retrouver sa vie d''avant.','21/07/2010');
INSERT INTO Oeuvre(numero, titre, lien_photo, synopsis, date_sortie) VALUES (6,'Wonder Woman 2','img/wonderwoman2.jpg','Suite des aventures de Diana Prince, alias Wonder Woman, Amazone devenue une super-héroïne dans notre monde.','12/08/2020');
INSERT INTO Oeuvre(numero, titre, lien_photo, synopsis, date_sortie) VALUES (7,'Forrest Gump','img/forrestgump.jpg','Au fil des différents interlocuteurs qui viennent s''asseoir tour à tour à côté de lui sur un banc, Forrest Gump raconte la fabuleuse histoire de sa vie. Sa vie est à l''image d''une plume qui se laisse porter par le vent, tout comme Forrest se laisse porter par les événements qu''il traverse dans l''Amérique de la seconde moitié du 20e siècle.','28/06/1994');
INSERT INTO Oeuvre(numero, titre, lien_photo, synopsis, date_sortie) VALUES (8,'La Ligne verte','img/laligneverte.jpg','Paul Edgecomb, pensionnaire centenaire d''une maison de retraite, est hanté par ses souvenirs. Gardien-chef du pénitencier de Cold Mountain, en 1935, en Louisiane, il était chargé de veiller au bon déroulement des exécutions capitales au bloc E (la ligne verte) en s''efforçant d''adoucir les derniers moments des condamnés. Parmi eux se trouvait un colosse du nom de John Coffey, accusé du viol et du meurtre de deux fillettes.','01/03/2000');
INSERT INTO Oeuvre(numero, titre, lien_photo, synopsis, date_sortie) VALUES (9,'Titanic','img/titanic.jpg','En 1997, l''épave du Titanic est l''objet d''une exploration fiévreuse, menée par des chercheurs de trésor en quête d''un diamant bleu qui se trouvait à bord. Frappée par un reportage télévisé, l''une des rescapés du naufrage, âgée de 102 ans, Rose DeWitt, se rend sur place et évoque ses souvenirs. 1912. Fiancée à un industriel arrogant, Rose croise sur le bateau un artiste sans le sou.','07/01/1998');
INSERT INTO Oeuvre(numero, titre, lien_photo, synopsis, date_sortie) VALUES (10,'Star Wars IV: Un nouvel espoir','img/starwars4.jpg','Il y a bien longtemps, dans une galaxie très lointaine. La guerre civile fait rage entre l''Empire galactique et l''Alliance rebelle. Capturée par les troupes de choc de l''Empereur menées par le sombre et impitoyable Dark Vador, la princesse Leia Organa dissimule les plans de l''Etoile Noire, une station spatiale invulnérable, à son droïde R2-D2 avec pour mission de les remettre au Jedi Obi-Wan Kenobi.','19/10/1977');
INSERT INTO Oeuvre(numero, titre, lien_photo, synopsis, date_sortie) VALUES (11,'Jurrasic World','img/jurrasicworld.jpg','L''île Nublar accueille maintenant un parc thématique complètement fonctionnel sur les dinosaures, appelé Jurassic World. Après dix ans d''opération et un nombre de visiteurs en chute libre, une nouvelle attraction est créée dans le but d''attirer d''autres curieux, mais les résultats ne sont pas exactement ceux auxquels l''organisation s''attendait.','10/06/2015');
INSERT INTO Oeuvre(numero, titre, lien_photo, synopsis, date_sortie) VALUES (12,'OSS 117: Alerte rouge en Afrique noire','img/oss117.jpg','L''intrigue d''OSS 117 : Alerte rouge en Afrique Noire se déroulera dans les années 1970-1980, à la différence des deux précédents films qui prenaient place entre le milieu des années 1950 et 1960.','20/02/2021');
INSERT INTO Oeuvre(numero, titre, lien_photo, synopsis, date_sortie) VALUES (13,'Fast and Furious 9','img/fastandfurious.jpg','Dominic Toretto et son équipe unissent leurs forces pour combattre l''assassin le plus habile et le conducteur le plus performant qu''ils aient jamais rencontré : son frère abandonné.','20/05/2020');
INSERT INTO Oeuvre(numero, titre, lien_photo, synopsis, date_sortie) VALUES (14,'L''énigme de la chambre 622','img/chambre622.jpg','L''Énigme de la Chambre 622. Résumé : Une nuit de décembre, un meurtre a lieu au Palace de Verbier, dans les Alpes suisses. L''enquête de police n''aboutira jamais.','27/05/2020');
INSERT INTO Oeuvre(numero, titre, lien_photo, synopsis, date_sortie) VALUES (15,'West Side Story','img/westsidestory.jpg','Upper West Side, années 1950. Deux bandes de jeunes s''affrontent : d''un côté les Sharks dirigés par Bernardo et de l''autre les Jets, avec Riff à leur tête. Tony, lié au Jets, va s''éprendre de Maria, la sœur de Bernardo.','16/12/2020');
INSERT INTO Oeuvre(numero, titre, lien_photo, synopsis, date_sortie) VALUES (16,'Black Widow','img/blackwidow.jpg','Il arrive un moment où il faut choisir entre ce que le monde veut que tu sois et ce que tu es vraiment.','28/10/2020');
INSERT INTO Oeuvre(numero, titre, lien_photo, synopsis, date_sortie) VALUES (17,'Mulan','img/mulan.jpg','Lorsque l''empereur de Chine décrète qu''un homme par famille doit servir dans l''armée impériale pour défendre le pays des envahisseurs du Nord, Hua Mulan, la fille aînée d''un guerrier honoré, prend la place de son père malade. Se faisant passer pour un homme, Hua Jun, elle est mise à l''épreuve tout au long de son périple l''obligeant à mobiliser sa force intérieure et à exploiter son véritable potentiel. C''est un voyage épique qui la transformera en guerrière honorée et lui fera gagner le respect de la nation ainsi que la fierté de son père.','22/07/2020');
INSERT INTO Oeuvre(numero, titre, lien_photo, synopsis, date_sortie) VALUES (18,'Conjuring 3 : sous l''emprise du diable','Une affaire terrifiante de meurtre et de présence maléfique mystérieuse ébranle même les enquêteurs paranormaux Ed et Lorraine Warren, pourtant très aguerris. Dans cette affaire issue de leurs dossiers secrets, Ed et Lorrain commencent par se battre pour protéger l''âme d''un petit garçon, puis basculent dans un monde radicalement inconnu. C''est la première fois dans l''histoire des États-Unis qu''un homme soupçonné de meurtre plaide la possession démoniaque comme ligne de défense.','10/09/2020');
INSERT INTO Oeuvre(numero, titre, lien_photo, synopsis, date_sortie) VALUES (19,'The Umbrella Academy 2','img/theumbrellaacademy2.jpg','En 1989, le même jour, quarante-trois bébés sont inexplicablement nés de femmes qui n''étaient pas enceintes et que rien ne relie. Sir Reginald Hargreeves, un industriel milliardaire, adopte sept de ces enfants et crée The Umbrella Academy pour les préparer à sauver le monde.','20/10/2020');
INSERT INTO Oeuvre(numero, titre, lien_photo, synopsis, date_sortie) VALUES (20,'Stranger Things 4','img/strangerthings4.jpg','Jim Hopper : le shérif de Stranger Things est-il vivant ou mort ? Le suspense est levé par la première bande-annonce de la saison 4. A la fin d''un long plan remontant un chemin de fer bâti par des prisonniers, on y découvre Jim Hopper, le crâne et la moustache rasés, mais bien vivant.','20/06/2021');
INSERT INTO Oeuvre(numero, titre, lien_photo, synopsis, date_sortie) VALUES (21,'Solo Leveling','/img/220px-Solo_Leveling_Webtoon.png','Depuis qu''un portail connectant notre monde à un monde peuplé de monstres et de créatures en tout genre est apparu, des personnes "ordinaires" ont acquis la capacité de chasser ces derniers. On les appelle les chasseurs. Vous pensez qu''ils sont tous balaises ?','10/12/2018');
INSERT INTO Oeuvre(numero, titre, lien_photo, synopsis, date_sortie) VALUES (22,'Game of Thrones','/img/got.jpg','Le Royaume des Sept Couronnes, dont la capitale est Port-Réal (500 000 habitants), est constitué de sept provinces régies par des « maisons » dont la plupart des chefs aspirent à monter sur le trône. La mort du roi aiguise les appétits. Ce royaume occupe tout le sud du continent de Westeros. À l''extrême-nord, un gigantesque mur de glace protège le royaume de plusieurs créatures potentiellement dangereuses, celui-ci est supervisé par la garde de nuit une organisation militaire officielle qui vise à protéger le mur et le royaume des menaces du grand nord. Au-delà du mur vivent des créatures « primitives », les Sauvageons qui tentent d''envahir le royaume pour fuir des créatures mythiques et très dangereuses que l''on pensait disparues depuis plusieurs siècles. À l''est, au-delà d’un détroit, se trouve le continent d’Essos sur lequel une jeune princesse en exil prépare son retour. ','20/10/2010');
INSERT INTO Oeuvre(numero, titre, lien_photo, synopsis, date_sortie) VALUES (23,'Tower of god','img/Tower-of-god.jpeg','Que désirez-vous? La richesse? La gloire? Le pouvoir? La vengeance? Ou une chose qui surpasse toutes les autres ? Quel que soit votre désir, il se trouve ici !','20/06/2021');


insert into EtreDans(numero, id_liste) values (1,1);
insert into EtreDans(numero, id_liste) values (2,1);
insert into EtreDans(numero, id_liste) values (5,2);
insert into EtreDans(numero, id_liste) values (4,9);
insert into EtreDans(numero, id_liste) values (3,9);
insert into EtreDans(numero, id_liste) values (2,2);
insert into EtreDans(numero, id_liste) values (1,3);
INSERT INTO EtreDans(numero,id_liste) VALUES (2,3);
INSERT INTO EtreDans(numero,id_liste) VALUES (3,4);
INSERT INTO EtreDans(numero,id_liste) VALUES (7,6);
INSERT INTO EtreDans(numero,id_liste) VALUES (11,10);
INSERT INTO EtreDans(numero,id_liste) VALUES (9,10);
INSERT INTO EtreDans(numero,id_liste) VALUES (7,10);
INSERT INTO EtreDans(numero,id_liste) VALUES (4,10);

insert into Film (M2_cle, realisateur, genre, duree, producteur) values (1,'James Cameron','Animation',162,'Jon Landau');
insert into Film (M2_cle, realisateur, genre, duree, producteur) values (2,'Quentin Tarantino','Biopic',154,'Quentin Tarantino');
insert into Film (M2_cle, realisateur, genre, duree, producteur) values (3,'John G.Avildsen','Drame',119,'Robert Chartoff');
insert into Film (M2_cle, realisateur, genre, duree, producteur) values (4,'Christopher Nolan','Documentaire',169,'Warner Bros');
insert into Film (M2_cle, realisateur, genre, duree, producteur) values (5,'Christopher Nolan','Comédie',148,'Warner Bros');

insert into Livre(M1_cle,nb_pages,langue,genre) values(21,400,'Anglais,Français,Coréen','Webtoon');
insert into Livre(M1_cle,nb_pages,langue,genre) values(23,1000,'Anglais,Français,Coréen','Webtoon');

insert into Serie(M3_cle,nb_ep ,nb_saisons ,duree, genre ,anime) values(22,80,8,60,'Action',0);

INSERT INTO Noter (pseudo,numero,note) VALUES ('Pain Reli',3,5);
INSERT INTO Noter (pseudo,numero,note) VALUES ('Dior Bronze',2,3);
INSERT INTO Noter (pseudo,numero,note) VALUES ('Olay Profe',1,4);
INSERT INTO Noter (pseudo,numero,note) VALUES ('Dior Bronze',5,1);
INSERT INTO Noter (pseudo,numero,note) VALUES ('Modafinil',4,2);
INSERT INTO Noter (pseudo,numero,note) VALUES ('Aplicare Tot',4,3);

insert into Commentaire (pseudo,numero, texte,date_com) values ('Pain Reli',2,'Cette oeuvre est tout bonnement majestueuse !','12/04/2002');
insert into Commentaire (pseudo,numero, texte,date_com) values ('Doxycycli',2,'Je suis un spammeur !','12/04/2012');
insert into Commentaire (pseudo,numero, texte,date_com) values ('Doxycycli',2,'Je suis un spammeur !!!!! !','12/04/2010');
insert into Commentaire (pseudo,numero, texte,date_com) values ('Doxycycli',2,'Je peux spammer ce site et il ne peut rien faire !','12/05/2010');
insert into Commentaire (pseudo,numero, texte,date_com) values ('Doxycycli',2,'SPAM!','12/06/2002');
insert into Commentaire (pseudo,numero, texte,date_com) values ('Tea Tree Anti',10,'Retour aux bases','12/06/2003');
insert into Commentaire (pseudo,numero, texte,date_com) values ('Aplicare Tot',2,'Jen ai eu les larmes aux yeux','25/10/2005');
insert into Commentaire (pseudo,numero,alerte,texte,date_com) values ('Dior Bronze',5,'vulgarité','De la merde','07/05/2012');
insert into Commentaire (pseudo,numero, texte,date_com) values ('Pain Reli',1,'Dommage que la fin ai été bâclée, sinon pas mal','02/06/2015');

insert into Suivre(suiveur,suivi) values ('Pain Reli','Aplicare Tot');
insert into Suivre(suiveur,suivi) values ('Modafinil','Dior Bronze');
insert into Suivre(suiveur,suivi) values ('Olay Profe','Doxycycli');
insert into Suivre(suiveur,suivi) values ('Doxycycli','Olay Profe');

