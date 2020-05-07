CREATE TABLE Membre(
    id INTEGER PRIMARY KEY,
    username VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE,
    passwd VARCHAR
);

CREATE TABLE Administrateur(
	Id_MembreA INTEGER PRIMARY KEY,
	Droit INTEGER, /* 0 = superAdmin, 1 = Admin*/
	FOREIGN KEY (Id_MembreA) REFERENCES Membre(id)
);

CREATE TABLE Association(
	Id_Assoc VARCHAR PRIMARY KEY,
	Nom_assoc VARCHAR
);

CREATE TABLE Reunion(
	Id_Assoc VARCHAR NOT NULL,
	Id_reu  VARCHAR PRIMARY KEY,
	Date_debut_reu TIMESTAMP,
	Date_fin_reu TIMESTAMP,
	Id_MembreA INTEGER,
	Descriptif TEXT,
	FOREIGN KEY (Id_MembreA) REFERENCES Administrateur(Id_MembreA)
);

CREATE TABLE Demandes_user_Superadmin(
	username VARCHAR,
	Nom_assoc VARCHAR
);

CREATE TABLE Appartenir(
	Id_Assoc VARCHAR,
	Id_Membre INTEGER,
	Nom_Assoc VARCHAR,
	username VARCHAR,
	FOREIGN KEY (Id_Assoc) REFERENCES Association(Id_Assoc),
	FOREIGN KEY (Id_Membre) REFERENCES Membre(id)
);

CREATE TABLE Administrer(
	Id_Assoc VARCHAR,
	Id_Membre INTEGER,
	FOREIGN KEY (Id_Assoc) REFERENCES Association(Id_Assoc),
	FOREIGN KEY (Id_Membre) REFERENCES Administrateur(Id_MembreA)
);

CREATE TABLE Participations(
	Id_reu VARCHAR,
	Id_Membre INTEGER,
	statut INTEGER NOT NULL, --statut = [ 0:Oui , 1:Non , 2:En_Attente , 3:A participé ]
	retard TIMESTAMP, --représente la durée du retard
	FOREIGN KEY (Id_reu) REFERENCES Reunion(Id_reu),
	FOREIGN KEY (Id_Membre) REFERENCES Membre(id)
);


create view Vue_admin as select(Administrateur.Id_MembreA) 
	from Membre 
	join Administrateur on (Membre.id = Administrateur.Id_MembreA);

INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (1,'unex','nenex', 'patati@patata.com', NOW());
INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (2,'caillou','voyou', 'caillou@rocher.com',  NOW());
INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (3,'viteira','teteh', 'vivi@taira.com', NOW());
INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (4,'cesar','jules','jule@cesar.com', NOW());
INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (5,'gengis','regis','gengis@khan.com', NOW());
INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (6,'roberto','rodriguez','mon@poto.com', NOW());
INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (7,'gongoin','goulayant','gg@ez.com', NOW());
INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (8,'michael','daubasse','assez@moyen.com', NOW());
INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (9,'flavio','charpente','miaou@miaou.com', NOW());

INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (1,'BDE');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (2,'Cuisine');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (3,'BDS');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (4,'BDA');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (5,'I-TV');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (6,'Bakaclub');

INSERT INTO Administrateur (Id_MembreA, Droit) VALUES (1, 0); 
INSERT INTO Administrateur (Id_MembreA, Droit) VALUES (5, 1); 
INSERT INTO Administrateur (Id_MembreA, Droit) VALUES (8, 1); 

INSERT INTO Demandes_user_Superadmin (username, Nom_assoc) VALUES ('cesar', 'Cuisine' ); 
INSERT INTO Demandes_user_Superadmin (username, Nom_assoc) VALUES ('cailou', 'Bakaclub'); 

INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,1,'2020-05-04 08:00:00','2008-01-01 09:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,2,'2020-05-05 09:00:00','2009-01-01 13:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,3,'2020-05-05 16:00:00','2009-01-01 17:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,4,'2020-05-11 16:00:00','2009-01-01 19:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,5,'2020-05-11 16:30:00','2009-01-01 18:45:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,7,'2020-05-06 10:00:00','2010-01-01 14:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,8,'2020-05-19 09:00:00','2011-01-01 10:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,9,'2020-05-07 11:30:00','2011-01-01 14:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,10,'2020-05-22 10:00:00','2011-01-01 15:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,11,'2020-05-08 09:00:00','2012-01-01 16:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,12,'2020-05-07 14:30:00','2011-01-01 16:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,13,'2020-05-13 08:30:00','2009-01-01 16:00:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,14,'2020-05-13 08:30:00','2009-01-01 09:00:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,15,'2020-05-06 16:00:00','2010-01-01 18:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,16,'2020-05-07 16:30:00','2011-01-01 17:30:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA, Descriptif) VALUES (1,17,'2020-05-04 12:00:00','2008-01-01 15:59:00', 1, 'Aaaaah oké');
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA, Descriptif) VALUES (6,18,'2020-05-04 12:00:00','2008-01-01 15:59:00', 1, 'Turbo party entre bonnes gens et personnes cultivées âme-sensible-friendly');
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,19,'2020-05-07 08:00:00','2008-01-01 11:59:00', 1);

INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_Assoc, username) VALUES (1,2, 'BDE','caillou');

INSERT INTO Administrer (Id_Assoc, Id_Membre) VALUES (3, 5);
INSERT INTO Administrer (Id_Assoc, Id_Membre) VALUES (4, 8);

INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_Assoc, username) VALUES (2,2, 'Cuisine','caillou');
INSERT INTO Appartenir (Id_Assoc, Id_membre) VALUES (1,2);
INSERT INTO Appartenir (Id_Assoc, Id_membre) VALUES (6,1);
INSERT INTO Appartenir (Id_Assoc, Id_membre) VALUES (6,2);
INSERT INTO Appartenir (Id_Assoc, Id_membre) VALUES (6,3);
INSERT INTO Appartenir (Id_Assoc, Id_membre) VALUES (6,4);
INSERT INTO Appartenir (Id_Assoc, Id_membre) VALUES (6,5);
INSERT INTO Appartenir (Id_Assoc, Id_membre) VALUES (6,6);
INSERT INTO Appartenir (Id_Assoc, Id_membre) VALUES (6,7);
INSERT INTO Appartenir (Id_Assoc, Id_membre) VALUES (6,8);
INSERT INTO Appartenir (Id_Assoc, Id_membre) VALUES (6,9);

INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (1,2,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (2,2,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (3,2,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (4,2,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (5,2,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (7,2,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (8,2,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (9,2,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (10,2,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (11,2,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (12,2,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (13,2,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (14,2,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (15,2,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (16,2,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (17,2,0);

INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (18,1,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (18,2,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (18,3,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (18,4,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (18,5,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (18,6,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (18,7,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (18,8,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (18,9,0);

INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,1,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,2,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,3,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,4,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,5,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,6,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,7,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,8,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,9,0);
