CREATE TABLE user(
    id VARCHAR PRIMARY KEY,
    username VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE
);

CREATE TABLE Administrateur(
	Id_MembreA VARCHAR,
	FOREIGN KEY (Id_MembreA) REFERENCES user(id)
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
	FOREIGN KEY (Id_Membre) REFERENCES user(id)
);

CREATE TABLE Administrer(
	Id_Assoc VARCHAR,
	Id_Membre VARCHAR,
	FOREIGN KEY (Id_Assoc) REFERENCES Association(Id_Assoc),
	FOREIGN KEY (Id_Membre) REFERENCES user(id)
);

CREATE TABLE Participations(
	Id_reu VARCHAR,
	Id_Membre VARCHAR,
	FOREIGN KEY (Id_reu) REFERENCES Reunion(Id_reu),
	FOREIGN KEY (Id_Membre) REFERENCES user(id)
);

create view Vue_admin as select(Administrateur.Id_MembresA) 
	from user 
	join Administration on (user.id = Administrateur.Id_MembresA);

INSERT INTO "user" (username, email, created_at)  VALUES ('unex', 'patati@patata.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('caillou', 'caillou@rocher.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('viteira', 'vivi@taira.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('césar', 'jule@cesar.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('gengis', 'gengis@khan.com', NOW());