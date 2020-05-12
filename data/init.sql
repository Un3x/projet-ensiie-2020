CREATE TABLE Membre(
    id INTEGER PRIMARY KEY,
    username VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE,
    passwd VARCHAR,
	points INTEGER
);

CREATE TABLE Administrateur(
	Id_MembreA INTEGER PRIMARY KEY,
	Droit INTEGER, /* 0 = superAdmin, 1 = Admin*/
	FOREIGN KEY (Id_MembreA) REFERENCES Membre(id) on delete cascade
);

CREATE TABLE Association(
	Id_Assoc INTEGER PRIMARY KEY,
	Nom_assoc VARCHAR
);

CREATE TABLE Reunion(
	Id_Assoc INTEGER NOT NULL,
	Id_reu  INTEGER PRIMARY KEY,
	Date_debut_reu TIMESTAMP,
	Date_fin_reu TIMESTAMP,
	Id_MembreA INTEGER,
	Descriptif TEXT,
	FOREIGN KEY (Id_MembreA) REFERENCES Administrateur(Id_MembreA) on delete cascade
);

CREATE TABLE Demandes_user_Superadmin(
	username VARCHAR,
	Nom_assoc VARCHAR
);

CREATE TABLE Appartenir(
	Id_Assoc INTEGER,
	Id_Membre INTEGER,
	Nom_Assoc VARCHAR,
	username VARCHAR,
	FOREIGN KEY (Id_Assoc) REFERENCES Association(Id_Assoc),
	FOREIGN KEY (Id_Membre) REFERENCES Membre(id) on delete cascade
);

CREATE TABLE Administrer(
	Id_Assoc INTEGER,
	Id_Membre INTEGER,
	FOREIGN KEY (Id_Assoc) REFERENCES Association(Id_Assoc),
	FOREIGN KEY (Id_Membre) REFERENCES Administrateur(Id_MembreA) on delete cascade
);

CREATE TABLE Participations(
	Id_reu INTEGER,
	Id_Membre INTEGER,
	statut INTEGER NOT NULL, --statut = [ 0:Oui , 1:Non , 2:En_Attente , 3:A_participé retard non enregistré, 4:A_participé retard enregistré ]
	retard TIME, --représente la durée du retard
	FOREIGN KEY (Id_reu) REFERENCES Reunion(Id_reu),
	FOREIGN KEY (Id_Membre) REFERENCES Membre(id) on delete cascade
);

CREATE TABLE Paris(
	id_paris INTEGER PRIMARY KEY,
	player INTEGER,
	id_reu INTEGER,
	id_user INTEGER,
	retard TIME,
	mise INTEGER,
	date_paris TIMESTAMP,
	statut INTEGER NOT NULL --statut = [ 0:Résultats à venir , 1:Résultats en attente , 2:Victoire non consultée , 
							 --               3:Défaite non consultée, 4:Victoire consultée, 5:Défaite consultée ]
);

create view Vue_admin as select(Administrateur.Id_MembreA) 
	from Membre 
	join Administrateur on (Membre.id = Administrateur.Id_MembreA);


INSERT INTO Membre (id,username,passwd, email, created_at, points)  VALUES (1,'unex','nenex', 'patati@patata.com', NOW(),500);
INSERT INTO Membre (id,username,passwd, email, created_at, points)  VALUES (2,'caillou','voyou', 'caillou@rocher.com',  NOW(),500);
INSERT INTO Membre (id,username,passwd, email, created_at, points)  VALUES (3,'viteira','teteh', 'vivi@taira.com', NOW(),500);
INSERT INTO Membre (id,username,passwd, email, created_at, points)  VALUES (4,'césar','jules','jule@cesar.com', NOW(),500);
INSERT INTO Membre (id,username,passwd, email, created_at, points)  VALUES (5,'gengis','regis','gengis@khan.com', NOW(),500);
INSERT INTO Membre (id,username,passwd, email, created_at, points)  VALUES (6,'roberto','rodriguez','mon@poto.com', NOW(),1000000);
INSERT INTO Membre (id,username,passwd, email, created_at, points)  VALUES (7,'gongoin','goulayant','gg@ez.com', NOW(),500);
INSERT INTO Membre (id,username,passwd, email, created_at, points)  VALUES (8,'michael','daubasse','assez@moyen.com', NOW(),500);
INSERT INTO Membre (id,username,passwd, email, created_at, points)  VALUES (9,'flavio','charpente','miaou@miaou.com', NOW(),2000000);
INSERT INTO Membre (id,username,passwd, email, created_at, points)  VALUES (10,'patron','chef','le@boss.com', NOW(),500);

INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (1,'BDE');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (2,'Cuisine');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (3,'BDS');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (4,'BDA');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (5,'I-TV');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (6,'Bakaclub');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (7,'DansIIE');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (8,'Riien');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (9,'LaTurboFiesta');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (10,'LesRamasseursDeMonaie');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (11,'LeCulteDeFayes');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (12,'DeglingosClub');

--INSERT INTO Demandes_user_Superadmin (username, Nom_assoc) VALUES ('cesar', 'Cuisine' ); 
--INSERT INTO Demandes_user_Superadmin (username, Nom_assoc) VALUES ('flavio', 'Bakaclub'); 

INSERT INTO Administrateur (Id_MembreA, Droit) VALUES (1, 0);
INSERT INTO Administrateur (Id_MembreA, Droit) VALUES (4, 1);
INSERT INTO Administrateur (Id_MembreA, Droit) VALUES (10, 1);

INSERT INTO Administrer (Id_Assoc, Id_Membre) VALUES (3, 4);
INSERT INTO Administrer (Id_Assoc, Id_Membre) VALUES (4, 4);
INSERT INTO Administrer (Id_Assoc, Id_Membre) VALUES (6, 4);
INSERT INTO Administrer (Id_Assoc, Id_Membre) VALUES (1, 10);

INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (3,1,'BDS');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (4,1,'BDA');

INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (1,1,'BDE');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (1,2,'BDE');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (1,10,'BDE');

INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (6,1,'Bakaclub');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (6,2,'Bakaclub');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (6,3,'Bakaclub');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (6,4,'Bakaclub');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (6,5,'Bakaclub');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (6,6,'Bakaclub');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (6,7,'Bakaclub');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (6,8,'Bakaclub');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (6,9,'Bakaclub');

INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (3,2,'BDS');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (3,3,'BDS');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (4,2,'BDA');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (4,3,'BDA');

INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (1,9,'BDE');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (2,9,'Cuisine');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (3,9,'BDS');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (4,9,'BDA');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (5,9,'I-TV');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (7,9,'DansIIE');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (8,9,'Riien');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (9,9,'LaTurboFiesta');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (10,9,'LesRamasseursDeMonaie');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (11,9,'LeCulteDeFayes');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (12,9,'DeglingosClub');



INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,1,'2020-05-04 08:00:00','2020-05-04 10:00:00', 10);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,2,'2020-05-05 11:00:00','2020-05-05 12:00:00', 10);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,3,'2020-05-05 16:00:00','2020-05-05 18:00:00', 10);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,4,'2020-05-06 08:00:00','2020-05-06 09:00:00', 10);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,5,'2020-05-06 18:00:00','2020-05-06 19:00:00', 10);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,6,'2020-05-07 18:30:00','2020-05-07 19:00:00', 10);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,7,'2020-05-08 14:00:00','2020-05-08 20:00:00', 10);

INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,8,'2020-05-11 08:00:00','2020-05-11 10:00:00', 10);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,9,'2020-05-12 15:00:00','2020-05-12 17:00:00', 10);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,10,'2020-05-13 11:00:00','2020-05-13 11:20:00', 10);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,11,'2020-05-14 18:40:00','2020-05-14 20:00:00', 10);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA, Descriptif) VALUES (1,12,'2020-05-15 14:00:00','2020-05-15 16:30:00', 10, 'LA réu intéressant à ne pas manquer');

INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,13,'2020-05-18 11:00:00','2020-05-18 12:00:00', 10);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,14,'2020-05-19 16:00:00','2020-05-19 18:40:00', 10);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,15,'2020-05-20 08:00:00','2020-05-20 09:20:00', 10);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,16,'2020-05-21 14:40:00','2020-05-21 15:00:00', 10);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,17,'2020-05-22 14:00:00','2020-05-22 16:30:00', 10);


INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (3,18,'2020-05-11 08:00:00','2020-05-11 09:00:00', 4);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (3,19,'2020-05-12 15:30:00','2020-05-12 16:30:00', 4);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (3,20,'2020-05-13 09:00:00','2020-05-13 12:00:00', 4);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (3,21,'2020-05-14 18:30:00','2020-05-14 20:00:00', 4);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (3,22,'2020-05-15 11:00:00','2020-05-15 14:00:00', 4);


INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,23,'2020-05-04 18:00:00','2020-05-04 20:00:00', 4);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,24,'2020-05-05 18:00:00','2020-05-05 20:00:00', 4);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,25,'2020-05-06 18:00:00','2020-05-06 20:00:00', 4);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,26,'2020-05-07 18:00:00','2020-05-07 20:00:00', 4);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,27,'2020-05-08 18:00:00','2020-05-08 20:00:00', 4);

INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,28,'2020-05-11 18:00:00','2020-05-11 20:00:00', 4);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,29,'2020-05-12 18:00:00','2020-05-12 20:00:00', 4);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,30,'2020-05-13 18:00:00','2020-05-13 20:00:00', 4);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,31,'2020-05-14 18:00:00','2020-05-14 20:00:00', 4);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,32,'2020-05-15 18:00:00','2020-05-15 20:00:00', 4);

INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,33,'2020-05-18 18:00:00','2020-05-18 20:00:00', 4);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,34,'2020-05-19 18:00:00','2020-05-19 20:00:00', 4);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,35,'2020-05-20 18:00:00','2020-05-20 20:00:00', 4);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,36,'2020-05-21 18:00:00','2020-05-21 20:00:00', 4);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,37,'2020-05-22 18:00:00','2020-05-22 20:00:00', 4);


INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (1,1,4,'00:02:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (2,1,4,'00:00:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (3,1,4,'00:05:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (4,1,4,'00:02:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (5,1,4,'00:10:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (6,1,4,'00:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (7,1,4,'00:07:00');
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (8,1,3);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (9,1,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (10,1,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (11,1,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (12,1,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (13,1,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (14,1,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (15,1,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (16,1,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (17,1,0);

INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (1,2,4,'00:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (2,2,4,'00:20:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (3,2,4,'00:35:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (4,2,4,'00:20:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (5,2,4,'00:40:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (6,2,4,'00:20:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (7,2,4,'00:25:00');
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (8,2,3);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (9,2,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (10,2,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (11,2,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (12,2,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (13,2,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (14,2,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (15,2,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (16,2,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (17,2,0);

INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (1,9,4,'01:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (2,9,4,'00:20:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (3,9,4,'00:03:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (4,9,4,'00:30:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (5,9,4,'00:00:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (6,9,4,'00:00:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (7,9,4,'00:40:00');
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (8,9,3);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (9,9,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (10,9,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (11,9,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (12,9,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (13,9,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (14,9,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (15,9,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (16,9,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (17,9,2);

INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (1,10,4,'00:00:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (2,10,4,'00:00:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (3,10,4,'00:00:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (4,10,4,'00:00:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (5,10,4,'00:00:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (6,10,4,'00:00:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (7,10,4,'00:00:00');
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (8,10,3);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (9,10,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (10,10,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (11,10,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (12,10,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (13,10,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (14,10,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (15,10,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (16,10,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (17,10,0);


INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (18,2,3);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,2,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (20,2,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (21,2,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (22,2,2);

INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (18,3,3);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,3,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (20,3,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (21,3,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (22,3,2);

INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (18,4,3);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,4,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (20,4,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (21,4,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (22,4,2);

INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (18,9,3);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,9,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (20,9,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (21,9,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (22,9,2);


INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (23,1,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (24,1,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (25,1,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (26,1,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (27,1,1);
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (28,1,4,'00:07:00');
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (29,1,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (30,1,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (31,1,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (32,1,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (33,1,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (34,1,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (35,1,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (36,1,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (37,1,2);

INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (23,2,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (24,2,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (25,2,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (26,2,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (27,2,1);
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (28,2,4,'00:07:00');
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (29,2,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (30,2,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (31,2,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (32,2,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (33,2,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (34,2,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (35,2,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (36,2,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (37,2,2);

INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (23,3,4,'00:40:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (24,3,4,'00:42:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (25,3,4,'00:44:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (26,3,4,'00:50:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (27,3,4,'00:10:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (28,3,4,'01:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (29,3,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (30,3,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (31,3,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (32,3,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (33,3,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (34,3,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (35,3,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (36,3,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (37,3,2);

INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (23,4,4,'00:11:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (24,4,4,'00:20:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (25,4,4,'00:22:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (26,4,4,'00:24:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (27,4,4,'00:23:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (28,4,4,'00:27:00');
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (29,4,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (30,4,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (31,4,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (32,4,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (33,4,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (34,4,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (35,4,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (36,4,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (37,4,2);

INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (23,5,4,'00:12:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (24,5,4,'00:12:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (25,5,4,'00:20:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (26,5,4,'00:14:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (27,5,4,'00:13:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (28,5,4,'00:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (29,5,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (30,5,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (31,5,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (32,5,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (33,5,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (34,5,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (35,5,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (36,5,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (37,5,2);

INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (23,6,4,'00:02:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (24,6,4,'00:03:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (25,6,4,'00:03:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (26,6,4,'00:02:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (27,6,4,'00:03:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (28,6,4,'00:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (29,6,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (30,6,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (31,6,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (32,6,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (33,6,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (34,6,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (35,6,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (36,6,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (37,6,2);

INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (23,7,4,'00:08:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (24,7,4,'00:00:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (25,7,4,'00:00:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (26,7,4,'00:00:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (27,7,4,'00:00:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (28,7,4,'00:00:00');
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (29,7,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (30,7,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (31,7,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (32,7,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (33,7,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (34,7,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (35,7,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (36,7,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (37,7,2);

INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (23,8,4,'00:02:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (24,8,4,'00:07:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (25,8,4,'00:01:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (26,8,4,'00:00:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (27,8,4,'00:03:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (28,8,4,'00:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (29,8,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (30,8,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (31,8,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (32,8,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (33,8,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (34,8,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (35,8,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (36,8,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (37,8,2);

INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (23,9,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (24,9,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (25,9,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (26,9,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (27,9,1);
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (28,9,4,'00:08:00');
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (29,9,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (30,9,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (31,9,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (32,9,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (33,9,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (34,9,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (35,9,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (36,9,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (37,9,2);

INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (23,10,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (24,10,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (25,10,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (26,10,1);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (27,10,1);
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (28,10,4,'00:02:00');
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (29,10,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (30,10,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (31,10,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (32,10,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (33,10,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (34,10,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (35,10,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (36,10,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (37,10,2);


INSERT INTO Paris (id_paris, player, id_reu, id_user, retard, mise, date_paris, statut) VALUES (2, 6, 28, 4, '00:15:00', 100, NOW(), 3);
INSERT INTO Paris (id_paris, player, id_reu, id_user, retard, mise, date_paris, statut) VALUES (4, 6, 28, 6, '00:15:00', 100, NOW(), 2);
INSERT INTO Paris (id_paris, player, id_reu, id_user, retard, mise, date_paris, statut) VALUES (5, 6, 28, 7, '00:15:00', 100, NOW(), 3);
INSERT INTO Paris (id_paris, player, id_reu, id_user, retard, mise, date_paris, statut) VALUES (6, 6, 28, 8, '00:15:00', 100, NOW(), 2);

INSERT INTO Paris (id_paris, player, id_reu, id_user, retard, mise, date_paris, statut) VALUES (7, 6, 18, 2, '00:15:00', 100, NOW(), 1);
INSERT INTO Paris (id_paris, player, id_reu, id_user, retard, mise, date_paris, statut) VALUES (8, 6, 18, 3, '00:15:00', 100, NOW(), 1);
