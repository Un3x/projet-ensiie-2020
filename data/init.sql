CREATE TABLE "nb_online" (
    ip VARCHAR(15) NOT NULL,
    ti BIGINT NOT NULL
);

CREATE TABLE "in_game" (
    id_game INT,
    pseudo VARCHAR NOT NULL,
    team INT NOT NULL,
    mdj VARCHAR NOT NULL,
    voteautre INT
    
);

CREATE TABLE "utilisateurs" (
    num_id SERIAL PRIMARY KEY,
    ip VARCHAR(15) NOT NULL,
    pseudo VARCHAR NOT NULL,
    mdp VARCHAR NOT NULL,
    mail VARCHAR
);

CREATE TABLE "joueurs" (
    num_id SERIAL PRIMARY KEY,
    pseudo VARCHAR NOT NULL,
    role_princ INT,
    role_second INT
);

CREATE TABLE "administrateurs" (
    num_id SERIAL PRIMARY KEY,
    pseudo VARCHAR NOT NULL
);


CREATE TABLE "partie" (
    id_partie SERIAL PRIMARY KEY,
    duree TIME,
    condition_win VARCHAR
);

CREATE TABLE "map" (
    id_map SERIAL PRIMARY KEY,
    meteo INT,
    terrain VARCHAR,
    vote INT
);

INSERT INTO "utilisateurs" (ip, pseudo, mdp, mail) VALUES ('127.0.0.1', 'corrian', 'corrian', 'corrian@gmail.com');
INSERT INTO "administrateurs" (pseudo) VALUES ('corrian');
INSERT INTO "joueurs" (pseudo, role_princ, role_second) VALUES ('corrian', 0, 0);
INSERT INTO "partie" (id_partie, duree, condition_win) VALUES (1, '00:30:00', 'win');
INSERT INTO "map" (meteo, terrain, vote) VALUES (2, 'mountain', 0);
INSERT INTO "map" (meteo, terrain, vote) VALUES (1, 'sea', 0);
INSERT INTO "map" (meteo, terrain, vote) VALUES (3, 'beach', 0);
INSERT INTO "map" (meteo, terrain, vote) VALUES (2, 'plains', 0);
INSERT INTO "map" (meteo, terrain, vote) VALUES (2, 'city', 0);
INSERT INTO "map" (meteo, terrain, vote) VALUES (3, 'desert', 0);
INSERT INTO "in_game" (id_game,pseudo, team, mdj, voteautre) VALUES (1,'tata',1,'3v3',0);
INSERT INTO "in_game" (id_game,pseudo, team, mdj, voteautre) VALUES (1,'toto',1,'3v3',0);
INSERT INTO "in_game" (id_game,pseudo, team, mdj, voteautre) VALUES (1,'titi',1,'3v3',0);
INSERT INTO "in_game" (id_game,pseudo, team, mdj, voteautre) VALUES (2,'tutu',1,'3v3',0);
INSERT INTO "in_game" (id_game,pseudo, team, mdj, voteautre) VALUES (1,'tyty',2,'3v3',0);
INSERT INTO "in_game" (id_game,pseudo, team, mdj, voteautre) VALUES (1,'tbtb',2,'3v3',0);
INSERT INTO "in_game" (id_game,pseudo, team, mdj, voteautre) VALUES (1,'tctc',2,'3v3',0);
INSERT INTO "in_game" (id_game,pseudo, team, mdj, voteautre) VALUES (2,'tdtd',1,'5v5',0);
