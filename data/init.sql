
CREATE TABLE "Users" (
  id SERIAL PRIMARY KEY,
  firstName VARCHAR NOT NULL,
  lastName VARCHAR NOT NULL,
  pseudo VARCHAR NOT NULL,
  password VARCHAR NOT NULL,
  suspendedAccount BOOLEAN NOT NULL DEFAULT FALSE,
  isAdmin BOOLEAN NOT NULL DEFAULT FALSE
);

INSERT INTO "Users" (firstName, lastName, pseudo, password, suspendedAccount, isAdmin)
VALUES ('John', 'Doe', 'admin', 'password', FALSE, TRUE);

INSERT INTO "Users" (firstName, lastName, pseudo, password, suspendedAccount, isAdmin)
VALUES ('Bourse', 'Coddity', 'coddity', 'coddity', FALSE, TRUE);

INSERT INTO "Users" (firstName, lastName, pseudo, password, suspendedAccount, isAdmin)
VALUES ('Thomas', 'Meyer', 'tm', 'password', FALSE, TRUE);

INSERT INTO "Users" (firstName, lastName, pseudo, password, suspendedAccount, isAdmin)
VALUES ('Romain', 'Beuzelin', 'rb', 'password', FALSE, TRUE);

INSERT INTO "Users" (firstName, lastName, pseudo, password, suspendedAccount, isAdmin)
VALUES ('El Mehdi', 'Kossir', 'md', 'password', FALSE, TRUE);

INSERT INTO "Users" (firstName, lastName, pseudo, password)
VALUES ('Joueur', 'Un', 'j1', 'password');

INSERT INTO "Users" (firstName, lastName, pseudo, password)
VALUES ('Joueur', 'Deux', 'j2', 'password');

INSERT INTO "Users" (firstName, lastName, pseudo, password)
VALUES ('Joueur', 'Trois', 'j3', 'password');

CREATE TABLE "Challenges" (
  id SERIAL PRIMARY KEY,
  name VARCHAR NOT NULL,
  difficultyLevel INTEGER,
  description TEXT,
  sequenceNumber INTEGER
);

INSERT INTO "Challenges" (name, difficultyLevel, description, sequenceNumber)
VALUES ('Challenge 1', 1, '{}', 5);

INSERT INTO "Challenges" (name, difficultyLevel, description, sequenceNumber)
VALUES ('Challenge 2', 2, '{}', 2);

INSERT INTO "Challenges" (name, difficultyLevel, description, sequenceNumber)
VALUES ('Challenge 3', 3, '{}', 6);

INSERT INTO "Challenges" (name, difficultyLevel, description, sequenceNumber)
VALUES ('Challenge 5', 4, '{}', 3);

INSERT INTO "Challenges" (name, difficultyLevel, description, sequenceNumber)
VALUES ('Challenge 5', 5, '{}', 5);

CREATE TABLE  "ChallengesPlayed" (
  idUser INTEGER NOT NULL,
  idChallenge INTEGER NOT NULL,
  progression INTEGER,
  savePlayersSolution VARCHAR,
  PRIMARY KEY (idUser,idChallenge),

  CONSTRAINT ChallengesPlayed_idChallenge_fkey FOREIGN KEY (idChallenge)
      REFERENCES "Challenges" (id) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE,

  CONSTRAINT ChallengesPlayed_idUser_fkey FOREIGN KEY (idUser)
     REFERENCES "Users" (id) MATCH SIMPLE
     ON UPDATE CASCADE ON DELETE CASCADE

);
INSERT INTO "ChallengesPlayed" (idUser, idChallenge, progression, savePlayersSolution)
   VALUES (1, 1,2, 'ma progression');
