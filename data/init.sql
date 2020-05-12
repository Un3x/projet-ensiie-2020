 
CREATE TABLE Membre
(
    id_membre SERIAL PRIMARY KEY,
    nom VARCHAR(30),
    prenom VARCHAR(30),
    pseudo VARCHAR(16) NOT NULL UNIQUE,
    email VARCHAR(100)UNIQUE,
    password VARCHAR(200) NOT NULL,
    adresse VARCHAR(200),
    telephone VARCHAR(15),
    role VARCHAR(30),
    etat VARCHAR(10),
    check(role IN ('Membre','Administrateur')),
    check(etat IN ('rien','accuse','signale')),
    CONSTRAINT Unique_membre UNIQUE (pseudo,email)
);

CREATE TABLE Objet
(
  id_obj SERIAL PRIMARY KEY,
  nom VARCHAR(50) NOT NULL,
  id_Proprietaire INT NOT NULL,
  Disponible boolean,
  Debut_disp date,
  Fin_disp date,
  Categorie VARCHAR(50),
  image varchar(200) DEFAULT 'default.jpg',
  FOREIGN KEY (id_Proprietaire) REFERENCES Membre(id_membre)
);


CREATE TABLE Emprunt
(
    id_emprunt INT PRIMARY KEY NOT NULL,
    Objet INT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    Emprunteur INT NOT NULL,
    Preteur INT NOT NULL,
    FOREIGN KEY (Objet)  REFERENCES Objet(id_obj) ON DELETE CASCADE,
    FOREIGN KEY (Emprunteur)  REFERENCES Membre(id_membre),
    FOREIGN KEY (Preteur)  REFERENCES Membre(id_membre)
);

CREATE TABLE Text
(
  id_text SERIAL PRIMARY KEY,
  message VARCHAR(2000) NOT NULL,
  date_msg DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
  emetteur INT NOT NULL,
  recepteur INT NOT NULL,
  FOREIGN KEY (Emetteur) REFERENCES Membre(id_membre),
  FOREIGN KEY (Recepteur) REFERENCES Membre(id_membre)
);

CREATE TABLE Favoris (
id_obj INTEGER NOT NULL REFERENCES Objet(id_obj),
id_membre INTEGER NOT NULL REFERENCES Membre(id_membre),
CONSTRAINT pkFavoris_obj_mbr PRIMARY KEY(id_obj, id_membre)
);

CREATE TABLE Demander (
id_obj INTEGER NOT NULL REFERENCES Objet(id_obj),
id_membre INTEGER NOT NULL REFERENCES Membre(id_membre),
CONSTRAINT pkDemande_obj_mbr PRIMARY KEY(id_obj, id_membre)
);

CREATE TABLE Commenter (
id_obj INTEGER NOT NULL REFERENCES Objet(id_obj),
id_membre INTEGER NOT NULL REFERENCES Membre(id_membre),
commentaire VARCHAR(2000),
date_commentaire DATE,
CONSTRAINT pkCommente_obj_mbr PRIMARY KEY(id_obj, id_membre)
);




INSERT INTO Membre (nom, prenom, pseudo, email, password, adresse,telephone, role, etat)  VALUES ('jeremy', 'morvan', 'chauve', 'pin@80', 'pelicano', '4 rue lare', '0240', 'Membre', 'rien');
INSERT INTO Membre (nom, prenom, pseudo, email, password, adresse,telephone, role, etat)  VALUES ('gilles', 'stella', 'moustache', 'jurassic@park', 'brachiosaure', '5 rue lare', '0680', 'Administrateur', 'rien');
INSERT INTO Text (Message, date_msg, Emetteur, Recepteur)  VALUES ('coucou toi', NOW(), 1, 2);

