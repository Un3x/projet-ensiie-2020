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


INSERT INTO Membre (id,username,passwd, email, created_at, points)  VALUES (1,'unex','nenex', 'patati@patata.com', NOW(),0);
INSERT INTO Membre (id,username,passwd, email, created_at, points)  VALUES (2,'caillou','voyou', 'caillou@rocher.com',  NOW(),500);
INSERT INTO Membre (id,username,passwd, email, created_at, points)  VALUES (3,'viteira','teteh', 'vivi@taira.com', NOW(),0);
INSERT INTO Membre (id,username,passwd, email, created_at, points)  VALUES (4,'césar','jules','jule@cesar.com', NOW(),0);
INSERT INTO Membre (id,username,passwd, email, created_at, points)  VALUES (5,'gengis','regis','gengis@khan.com', NOW(),0);
INSERT INTO Membre (id,username,passwd, email, created_at, points)  VALUES (6,'roberto','rodriguez','mon@poto.com', NOW(),100000);
INSERT INTO Membre (id,username,passwd, email, created_at, points)  VALUES (7,'gongoin','goulayant','gg@ez.com', NOW(),0);
INSERT INTO Membre (id,username,passwd, email, created_at, points)  VALUES (8,'michael','daubasse','assez@moyen.com', NOW(),0);
INSERT INTO Membre (id,username,passwd, email, created_at, points)  VALUES (9,'flavio','charpente','miaou@miaou.com', NOW(),3184860);

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

INSERT INTO Administrateur (Id_MembreA, Droit) VALUES (1, 0); 
INSERT INTO Administrateur (Id_MembreA, Droit) VALUES (5, 1); 
INSERT INTO Administrateur (Id_MembreA, Droit) VALUES (8, 1); 

INSERT INTO Demandes_user_Superadmin (username, Nom_assoc) VALUES ('cesar', 'Cuisine' ); 
INSERT INTO Demandes_user_Superadmin (username, Nom_assoc) VALUES ('flavio', 'Bakaclub'); 


INSERT INTO Administrer (Id_Assoc, Id_Membre) VALUES (3, 5);
INSERT INTO Administrer (Id_Assoc, Id_Membre) VALUES (4, 8);


INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,1,'2020-05-04 08:00:00','2020-05-04 09:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,2,'2020-05-05 09:00:00','2020-05-05 13:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,3,'2020-05-05 16:00:00','2020-05-05 17:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,4,'2020-05-11 16:00:00','2020-05-11 19:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,5,'2020-05-11 16:30:00','2020-05-11 18:45:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,7,'2020-05-06 10:00:00','2020-05-06 14:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,8,'2020-05-19 09:00:00','2020-05-19 10:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,9,'2020-05-08 11:30:00','2020-05-08 14:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,10,'2020-05-22 10:00:00','2020-05-22 15:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,11,'2020-05-08 09:00:00','2020-05-08 16:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,12,'2020-05-08 14:30:00','2020-05-08 16:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,13,'2020-05-13 08:30:00','2020-05-13 16:00:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,14,'2020-05-13 08:30:00','2020-05-13 09:00:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,15,'2020-05-06 16:00:00','2020-05-06 18:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,16,'2020-05-08 16:30:00','2020-05-08 17:30:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA, Descriptif) VALUES (1,17,'2020-05-04 12:00:00','2020-05-04 15:59:00', 1, 'Aaaaah oké');
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA, Descriptif) VALUES (6,18,'2020-05-04 12:00:00','2020-05-04 15:59:00', 1, 'Turbo party entre bonnes gens et personnes cultivées âme-sensible-friendly');
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,19,'2020-05-13 08:00:00','2020-05-13 11:59:00', 1);

INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (2,20,'2020-05-12 08:00:00','2020-05-12 11:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (3,21,'2020-05-12 08:00:00','2020-05-12 11:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (4,22,'2020-05-12 08:00:00','2020-05-12 11:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (5,23,'2020-05-12 08:00:00','2020-05-12 11:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (7,24,'2020-05-12 08:00:00','2020-05-12 11:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (8,25,'2020-05-12 08:00:00','2020-05-12 11:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (9,26,'2020-05-12 08:00:00','2020-05-12 11:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (10,27,'2020-05-12 08:00:00','2020-05-12 11:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (11,28,'2020-05-12 08:00:00','2020-05-12 11:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (12,29,'2020-05-12 08:00:00','2020-05-12 11:59:00', 1);

INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (2,30,'2020-05-04 08:00:00','2020-05-04 11:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (3,31,'2020-05-04 08:00:00','2020-05-04 11:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (4,32,'2020-05-04 08:00:00','2020-05-04 11:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (5,33,'2020-05-04 08:00:00','2020-05-04 11:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (7,34,'2020-05-04 08:00:00','2020-05-04 11:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (8,35,'2020-05-04 08:00:00','2020-05-04 11:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (9,36,'2020-05-04 08:00:00','2020-05-04 11:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (10,37,'2020-05-04 08:00:00','2020-05-04 11:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (11,38,'2020-05-04 08:00:00','2020-05-04 11:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (12,39,'2020-05-04 08:00:00','2020-05-04 11:59:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,40,'2020-05-05 19:00:00','2020-05-05 20:00:00', 1);

INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (3,51,'2020-05-04 08:00:00','2020-05-04 09:59:00', 5);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (3,52,'2020-05-04 16:00:00','2020-05-04 17:00:00', 5);



INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (1,2,'BDE');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (6,1,'Bakaclub');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (6,2,'Bakaclub');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (6,3,'Bakaclub');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (6,4,'Bakaclub');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (6,5,'Bakaclub');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (6,6,'Bakaclub');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (6,7,'Bakaclub');

INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (3,5,'BDS');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (3,2,'Cuisine');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (3,3,'BDS');

INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (6,8,'Bakaclub');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (1,9,'BDE');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (2,9,'Cuisine');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (3,9,'BDS');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (4,9,'BDA');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (5,9,'I-TV');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (6,9,'Bakaclub');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (7,9,'DansIIE');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (8,9,'Riien');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (9,9,'LaTurboFiesta');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (10,9,'LesRamasseursDeMonaie');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (11,9,'LeCulteDeFayes');
INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_assoc) VALUES (12,9,'DeglingosClub');


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

INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (51,2,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (51,3,0);

INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (18,1,0,'00:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (18,2,3,'00:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (18,3,3,'00:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (18,4,3,'00:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (18,5,3,'00:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (18,6,3,'00:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (18,7,3,'00:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (18,8,3,'00:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (18,9,3,'00:15:00');


INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (30,9,3,'00:10:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (31,9,3,'00:30:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (32,9,3,'01:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (33,9,3,'01:27:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (34,9,3,'00:02:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (35,9,3,'00:00:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (36,9,3,'00:00:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (38,9,3,'00:10:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (39,9,3,'00:50:00');


INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,1,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,2,2);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,3,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,4,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,5,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,6,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,7,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,8,0);
INSERT INTO Participations (Id_reu, Id_membre, statut) VALUES (19,9,0);

INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (40,1,3,'00:05:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (40,2,3,'00:02:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (40,3,3,'00:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (40,4,3,'00:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (40,5,3,'00:25:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (40,6,3,'00:32:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (40,7,4,'00:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (40,8,4,'00:15:00');
INSERT INTO Participations (Id_reu, Id_membre, statut, retard) VALUES (40,9,4,'00:15:00');

INSERT INTO Paris (id_paris, player, id_reu, id_user, retard, mise, date_paris, statut) VALUES (1, 6, 19, 1, '00:15:00', 100, NOW(), 0);
INSERT INTO Paris (id_paris, player, id_reu, id_user, retard, mise, date_paris, statut) VALUES (2, 6, 19, 2, '00:15:00', 100, NOW(), 0);
INSERT INTO Paris (id_paris, player, id_reu, id_user, retard, mise, date_paris, statut) VALUES (3, 6, 19, 3, '00:15:00', 100, NOW(), 0);
INSERT INTO Paris (id_paris, player, id_reu, id_user, retard, mise, date_paris, statut) VALUES (4, 6, 19, 4, '00:15:00', 100, NOW(), 0);
INSERT INTO Paris (id_paris, player, id_reu, id_user, retard, mise, date_paris, statut) VALUES (5, 6, 19, 5, '00:15:00', 100, NOW(), 0);
INSERT INTO Paris (id_paris, player, id_reu, id_user, retard, mise, date_paris, statut) VALUES (6, 6, 19, 8, '00:15:00', 100, NOW(), 0);

INSERT INTO Paris (id_paris, player, id_reu, id_user, retard, mise, date_paris, statut) VALUES (7, 2, 40, 1, '00:25:00', 100, NOW(), 3);
INSERT INTO Paris (id_paris, player, id_reu, id_user, retard, mise, date_paris, statut) VALUES (8, 2, 40, 2, '00:20:00', 100, NOW(), 5);
INSERT INTO Paris (id_paris, player, id_reu, id_user, retard, mise, date_paris, statut) VALUES (9, 2, 40, 3, '00:15:00', 100, NOW(), 2);
INSERT INTO Paris (id_paris, player, id_reu, id_user, retard, mise, date_paris, statut) VALUES (10, 2, 40, 4, '00:12:00', 100, NOW(), 4);
INSERT INTO Paris (id_paris, player, id_reu, id_user, retard, mise, date_paris, statut) VALUES (11, 2, 40, 5, '00:13:00', 100, NOW(), 3);
INSERT INTO Paris (id_paris, player, id_reu, id_user, retard, mise, date_paris, statut) VALUES (12, 2, 40, 8, '00:15:00', 100, NOW(), 1);
