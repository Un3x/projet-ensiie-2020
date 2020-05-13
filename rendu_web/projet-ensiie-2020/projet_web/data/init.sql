CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    username VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    password VARCHAR NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE
);

INSERT INTO "user" (username, email, password, created_at)  VALUES ('unex', 'patati@patata.com', 'password', NOW());
INSERT INTO "user" (username, email, password, created_at)  VALUES ('caillou', 'caillou@rocher.com', 'password', NOW());
INSERT INTO "user" (username, email, password, created_at)  VALUES ('viteira', 'vivi@taira.com', 'password', NOW());
INSERT INTO "user" (username, email, password, created_at)  VALUES ('césar', 'jule@cesar.com', 'password', NOW());
INSERT INTO "user" (username, email, password, created_at)  VALUES ('gengis', 'gengis@khan.com', 'password', NOW());

CREATE TABLE "njv" (
    edition INT PRIMARY KEY,
    jour DATE NOT NULL
);


INSERT INTO "njv" (edition, jour) VALUES ('58', '06.09.2019');
INSERT INTO "njv" (edition, jour) VALUES ('59', '03.10.2019');
INSERT INTO "njv" (edition, jour) VALUES ('61', '07.02.2020');
INSERT INTO "njv" (edition, jour) VALUES ('62', '06.03.2020');


CREATE TABLE "smash" (
	/*type INT CHECK (type BETWEEN 1 AND 2), */
	nombreParticipant INT CHECK (nombreParticipant>1),
	edition_smash INT NOT NULL,
	FOREIGN KEY (edition_smash) REFERENCES njv(edition),
	PRIMARY KEY(edition_smash/*,type*/)
);

INSERT INTO "smash" (nombreParticipant,edition_smash) VALUES ('10', '58');

CREATE TABLE "lol" (
	nombreParticipant INT CHECK (nombreParticipant>1),
	edition_lol INT NOT NULL,
	FOREIGN KEY (edition_lol) REFERENCES njv(edition),
	PRIMARY KEY(edition_lol)
);

CREATE TABLE "joueur" (
	pseudo VARCHAR PRIMARY KEY,
	ELO_Smash INT,
	ELO_LoL INT
);

INSERT INTO "joueur" (pseudo,elo_smash,elo_lol) VALUES ('Babyface', '1000','1000');
INSERT INTO "joueur" (pseudo,elo_smash,elo_lol) VALUES ('Baguette', '1000','1000');
INSERT INTO "joueur" (pseudo,elo_smash,elo_lol) VALUES ('Jed', '1000','1000');
INSERT INTO "joueur" (pseudo,elo_smash,elo_lol) VALUES ('Shiro', '1000','1000');
INSERT INTO "joueur" (pseudo,elo_smash,elo_lol) VALUES ('Damn', '1000','1000');
INSERT INTO "joueur" (pseudo,elo_smash,elo_lol) VALUES ('Gowo', '1000','1000');
INSERT INTO "joueur" (pseudo,elo_smash,elo_lol) VALUES ('Kronk', '1000','1000');
INSERT INTO "joueur" (pseudo,elo_smash,elo_lol) VALUES ('Ruo', '1000','1000');
INSERT INTO "joueur" (pseudo,elo_smash,elo_lol) VALUES ('Elfa', '1000','1000');
INSERT INTO "joueur" (pseudo,elo_smash,elo_lol) VALUES ('Exe', '1000','1000');

CREATE TABLE "participation_lol" (
	pseudo VARCHAR REFERENCES joueur(pseudo) ON UPDATE CASCADE ON DELETE CASCADE,
	edition_lol INT REFERENCES lol(edition_lol) ON UPDATE CASCADE ON DELETE CASCADE,
	classement INT NOT NULL CHECK (classement>0),
	CONSTRAINT participation_lol_key PRIMARY KEY (pseudo, edition_lol)
);



CREATE TABLE "participation_smash" (
	pseudo VARCHAR REFERENCES joueur(pseudo) ON UPDATE CASCADE ON DELETE CASCADE,
	edition_smash INT REFERENCES smash(edition_smash) ON UPDATE CASCADE ON DELETE CASCADE,
	/*type INT REFERENCES smash(type) ON UPDATE CASCADE ON DELETE CASCADE,*/
	classement INT NOT NULL CHECK (classement>0)
	/*CONSTRAINT participation_smash_key PRIMARY KEY (pseudo,edition_smash)*/
);

INSERT INTO "participation_smash" (pseudo,edition_smash,classement) VALUES ('Babyface', '58','1');
INSERT INTO "participation_smash" (pseudo,edition_smash,classement) VALUES ('Baguette', '58','2');
INSERT INTO "participation_smash" (pseudo,edition_smash,classement) VALUES ('Jed', '58','3');
INSERT INTO "participation_smash" (pseudo,edition_smash,classement) VALUES ('Shiro', '58','4');
INSERT INTO "participation_smash" (pseudo,edition_smash,classement) VALUES ('Damn', '58','5');
INSERT INTO "participation_smash" (pseudo,edition_smash,classement) VALUES ('Gowo', '58','5');
INSERT INTO "participation_smash" (pseudo,edition_smash,classement) VALUES ('Kronk', '58','7');
INSERT INTO "participation_smash" (pseudo,edition_smash,classement) VALUES ('Ruo', '58','7');
INSERT INTO "participation_smash" (pseudo,edition_smash,classement) VALUES ('Elfa', '58','9');
INSERT INTO "participation_smash" (pseudo,edition_smash,classement) VALUES ('Exe', '58','9');

