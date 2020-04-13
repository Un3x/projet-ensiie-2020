CREATE TABLE Membre(
    id VARCHAR PRIMARY KEY,
    username VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE,
    passwd VARCHAR
);

CREATE TABLE Administrateur(
	Id_MembreA VARCHAR PRIMARY KEY,
	FOREIGN KEY (Id_MembreA) REFERENCES Membre(id)
);

CREATE TABLE Association(
	Id_Assoc VARCHAR PRIMARY KEY
);

CREATE TABLE Reunion(
	Id_Assoc VARCHAR NOT NULL,
	Id_reu VARCHAR PRIMARY KEY,
	Date_reu date NOT NULL,
	Horaire TIMESTAMP,
	Id_MembreA VARCHAR,
	FOREIGN KEY (Id_MembreA) REFERENCES Administrateur(Id_MembreA)
);

CREATE TABLE Appartenir(
	Id_Assoc VARCHAR,
	Id_Membre VARCHAR,
	FOREIGN KEY (Id_Assoc) REFERENCES Association(Id_Assoc),
	FOREIGN KEY (Id_Membre) REFERENCES Membre(id)
);

CREATE TABLE Administrer(
	Id_Assoc VARCHAR,
	Id_Membre VARCHAR,
	FOREIGN KEY (Id_Assoc) REFERENCES Association(Id_Assoc),
	FOREIGN KEY (Id_Membre) REFERENCES Membre(id)
);

CREATE TABLE Participations(
	Id_reu VARCHAR,
	Id_Membre VARCHAR,
	FOREIGN KEY (Id_reu) REFERENCES Reunion(Id_reu),
	FOREIGN KEY (Id_Membre) REFERENCES Membre(id)
);

create view Vue_admin as select(Administrateur.Id_MembreA) 
	from Membre 
	join Administrateur on (Membre.id = Administrateur.Id_MembreA);

INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (1,'unex','nenex', 'patati@patata.com', NOW());
INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (2,'caillou','voyou', 'caillou@rocher.com', NOW());
INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (3,'viteira','teteh', 'vivi@taira.com', NOW());
INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (4,'césar','jules','jule@cesar.com', NOW());
INSERT INTO Membre (id,username,passwd, email, created_at)  VALUES (5,'gengis','regis','gengis@khan.com', NOW());
