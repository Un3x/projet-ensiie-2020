CREATE TABLE Membre(
    id INTEGER PRIMARY KEY,
    username VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE,
    passwd VARCHAR
);

CREATE TABLE Administrateur(
	Id_MembreA INTEGER PRIMARY KEY,
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
	FOREIGN KEY (Id_MembreA) REFERENCES Administrateur(Id_MembreA)
);

CREATE TABLE Appartenir(
	Nom_Assoc VARCHAR,
	username VARCHAR,
	FOREIGN KEY (Nom_Assoc) REFERENCES Association(Nom_Assoc),
	FOREIGN KEY (username) REFERENCES Membre(username)
	Id_Assoc VARCHAR,
	Id_Membre INTEGER,
	FOREIGN KEY (Id_Assoc) REFERENCES Association(Id_Assoc),
	FOREIGN KEY (Id_Membre) REFERENCES Membre(id)
);

CREATE TABLE Administrer(
	Id_Assoc VARCHAR,
	Id_Membre INTEGER,
	FOREIGN KEY (Id_Assoc) REFERENCES Association(Id_Assoc),
	FOREIGN KEY (Id_Membre) REFERENCES Membre(id)
);

CREATE TABLE Participations(
	Id_reu VARCHAR,
	Id_Membre INTEGER,
	FOREIGN KEY (Id_reu) REFERENCES Reunion(Id_reu),
	FOREIGN KEY (Id_Membre) REFERENCES Membre(id)
);

create view Vue_admin as select(Administrateur.Id_MembreA) 
	from Membre 
	join Administrateur on (Membre.id = Administrateur.Id_MembreA);

INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (1,'unex','nenex', 'patati@patata.com', NOW());
INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (2,'caillou','voyou', 'caillou@rocher.com',  NOW());
INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (3,'viteira','teteh', 'vivi@taira.com', NOW());
INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (4,'césar','jules','jule@cesar.com', NOW());
INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (5,'gengis','regis','gengis@khan.com', NOW());


INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (1,'BDE');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (2,'Cuisine');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (3,'BDS');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (4,'BDA');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (5,'I-TV');
INSERT INTO Association (Id_Assoc, Nom_assoc) VALUES (6,'Bakaclub');

INSERT INTO Administrateur (Id_MembreA) VALUES (1); 
INSERT INTO Administrateur (Id_MembreA) VALUES (5); 

INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,1,'2008-01-01 08:00:01','2008-01-01 09:59:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,2,'2009-01-01 09:00:01','2009-01-01 13:59:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,3,'2009-01-01 16:00:01','2009-01-01 17:59:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,4,'2009-01-01 16:00:01','2009-01-01 19:59:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,5,'2009-01-01 16:30:01','2009-01-01 18:45:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,7,'2010-01-01 10:00:01','2010-01-01 14:59:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,8,'2011-01-01 09:00:01','2011-01-01 10:59:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,9,'2011-01-01 11:30:01','2011-01-01 14:59:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,10,'2011-01-01 10:00:01','2011-01-01 15:59:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,11,'2012-01-01 09:00:01','2012-01-01 16:59:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,12,'2011-01-01 14:30:01','2011-01-01 16:59:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,13,'2009-01-01 08:30:01','2009-01-01 16:00:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,14,'2009-01-01 08:30:01','2009-01-01 09:00:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,15,'2010-01-01 16:00:01','2010-01-01 18:59:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,16,'2011-01-01 16:30:01','2011-01-01 17:30:00', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,17,'2008-01-01 12:00:01','2008-01-01 15:59:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,18,'2008-01-01 12:00:01','2008-01-01 15:59:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (6,19,'2011-01-01 08:00:01','2008-01-01 11:59:59', 1);


INSERT INTO Appartenir (Id_Assoc, Id_membre) VALUES (1,2);
INSERT INTO Appartenir (Id_Assoc, Id_membre) VALUES (6,1);
INSERT INTO Appartenir (Id_Assoc, Id_membre) VALUES (6,4);
INSERT INTO Appartenir (Id_Assoc, Id_membre) VALUES (6,2);
