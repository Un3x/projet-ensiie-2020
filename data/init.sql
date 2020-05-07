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
INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (6,'bla','bla','bla@khan.com', NOW());
INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (7,'dimi','tri','dimitri@watel.com', NOW());
INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (8,'thomas','comes','thomas@watel.com', NOW());

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
INSERT INTO Demandes_user_Superadmin (username, Nom_assoc) VALUES ('bla', 'I-TV'); 
INSERT INTO Demandes_user_Superadmin (username, Nom_assoc) VALUES ('dimi', 'BDE'); 
INSERT INTO Demandes_user_Superadmin (username, Nom_assoc) VALUES ('cailou', 'Bakaclub'); 

INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,1,'2008-01-01 00:00:01','2008-01-01 23:59:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,2,'2009-01-01 00:00:01','2009-01-01 23:59:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,3,'2010-01-01 00:00:01','2010-01-01 23:59:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,4,'2011-01-01 00:00:01','2011-01-01 23:59:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,5,'2011-01-01 00:00:01','2011-01-01 23:59:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (1,6,'2012-01-01 00:00:01','2012-01-01 23:59:59', 1);
INSERT INTO Reunion (Id_Assoc, Id_reu, Date_debut_reu, Date_fin_reu, Id_MembreA) VALUES (4,7,'2020-04-26 14:30:00','2020-04-26 14:30:01', 5);

INSERT INTO Appartenir (Id_Assoc, Id_membre, Nom_Assoc, username) VALUES (1,2, 'BDE','caillou');

INSERT INTO Administrer (Id_Assoc, Id_Membre) VALUES (3, 5);
INSERT INTO Administrer (Id_Assoc, Id_Membre) VALUES (4, 8);
