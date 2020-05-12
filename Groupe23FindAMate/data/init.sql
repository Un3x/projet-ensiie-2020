DROP TABLE IF EXISTS utilisateur;
DROP TABLE IF EXISTS game;
DROP TABLE IF EXISTS search;
DROP TABLE IF EXISTS favoriteGame;
DROP TABLE IF EXISTS acquired;
DROP TABLE IF EXISTS friend;

CREATE TABLE utilisateur  (
    utilisateurId SERIAL PRIMARY KEY,
    pseudo VARCHAR(16) NOT NULL UNIQUE ,
    created_at TIMESTAMP WITH TIME ZONE,
    promo VARCHAR DEFAULT NULL,
    isAdmin VARCHAR DEFAULT 'FALSE',
    pseudoDiscord VARCHAR DEFAULT NULL,
    email VARCHAR NOT NULL UNIQUE,
    passwd VARCHAR NOT NULL
);

CREATE TABLE game (
    gameId SERIAL PRIMARY KEY,
    gameName VARCHAR(30) NOT NULL UNIQUE,
    isFree INTEGER , 
    GameDescription VARCHAR(100),
    isAccepted INTEGER DEFAULT 0  /* égal à 0 si la demande d'ajout du jeu est en cours, 1 si elle est acceptée, -1 si elle est refusée*/
);

CREATE TABLE search (
    searchid SERIAL PRIMARY KEY,
    began_at TIMESTAMP WITH TIME ZONE,
    pseudo VARCHAR NOT NULL REFERENCES utilisateur(pseudo) ON UPDATE CASCADE ON DELETE CASCADE,
    gameName VARCHAR NOT NULL REFERENCES game(gameName) ON UPDATE CASCADE ON DELETE CASCADE,
    playersToFind INTEGER,
    title VARCHAR
);

CREATE TABLE acquired (
    pseudo VARCHAR REFERENCES utilisateur(pseudo) ON UPDATE CASCADE ON DELETE CASCADE,
    gameName VARCHAR NOT NULL REFERENCES game(gameName) ON UPDATE CASCADE ON DELETE CASCADE,
    gameId SERIAL REFERENCES game(gameId) ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT pk1 PRIMARY KEY(pseudo, gameId)
);


CREATE TABLE message (
    messageid SERIAL PRIMARY KEY,
    searchId SERIAL REFERENCES search(searchid) ON UPDATE CASCADE ON DELETE CASCADE,
    emittor VARCHAR REFERENCES utilisateur(pseudo) ON UPDATE CASCADE ON DELETE CASCADE,
    sent_at TIMESTAMP WITH TIME ZONE,
    content VARCHAR NOT NULL
);

INSERT INTO utilisateur (utilisateurId, pseudo, email, created_at,promo,isAdmin,passwd) VALUES (DEFAULT, 'Lomarak', 'lomarak78700@gmail.com', NOW(),2022,'TRUE','74c6ed23385afad8a75336bd7608ec537fcf3f35');
INSERT INTO utilisateur (utilisateurId, pseudo, email, created_at,promo,isAdmin,passwd) VALUES (DEFAULT, 'Wyss', 'arthur.trehet@gmail.com', NOW(),2022,'TRUE','74c6ed23385afad8a75336bd7608ec537fcf3f35');
INSERT INTO utilisateur (utilisateurId, pseudo, email, created_at,promo,isAdmin,passwd) VALUES (DEFAULT, 'Moula','thibautarnould@hotmail.fr',NOW(),2022,'TRUE','74c6ed23385afad8a75336bd7608ec537fcf3f35');
INSERT INTO utilisateur (utilisateurId, pseudo, email, created_at,promo,isAdmin,passwd) VALUES (DEFAULT, 'Raquette','teoguilhou@hotmail.fr',NOW(),2022,'TRUE','74c6ed23385afad8a75336bd7608ec537fcf3f35');

INSERT INTO game (gameId, gameName, isFree, GameDescription, isAccepted) VALUES (DEFAULT, 'league of legends', 1, 'jeu en équipe 5v5 (moba)',1);
INSERT INTO game (gameId, gameName, isFree, GameDescription, isAccepted) VALUES (DEFAULT, 'teamfight tactics', 1, 'autochess',1);
INSERT INTO game (gameId, gameName, isFree, GameDescription, isAccepted) VALUES (DEFAULT, 'dofus', 1, 'mmorpg',1);


INSERT INTO search (began_at, pseudo, gameName, playersToFind, title) VALUES (NOW(), 'Wyss', 'league of legends', 4, 'scrim grosse ligue');
INSERT INTO search (began_at, pseudo, gameName, playersToFind, title) VALUES (NOW(), 'Lomarak', 'league of legends', 1, 'duo chall 500 lp mini');
INSERT INTO search (began_at, pseudo, gameName, playersToFind, title) VALUES (NOW(), 'Raquette', 'league of legends', 1, 'cherche support décent');
INSERT INTO search (began_at, pseudo, gameName, playersToFind, title) VALUES (NOW(), 'Raquette', 'dofus', 3, 'recherche team donjon incarnam');
INSERT INTO search (began_at, pseudo, gameName, playersToFind, title) VALUES (NOW(), 'Wyss', 'teamfight tactics', 1, 'cherche un adversaire pour un entrainement');



 /*
CREATE TABLE friend (
    utilisateurId1 SERIAL REFERENCES utilisateur(utilisateurId),
    friend1 SERIAL,
    friend2 SERIAL, 
    friend3 SERIAL, 
    ...
    friend25 SERIAL,
); */
