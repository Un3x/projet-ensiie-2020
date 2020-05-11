CREATE TABLE "nb_online" (
    ip VARCHAR NOT NULL,
    ti BIGINT NOT NULL
);

CREATE TABLE "in_game" (
    pseudo VARCHAR NOT NULL,
    mdj VARCHAR,
    team INT,
    id_game INT,
    vote INT
);

CREATE TABLE "utilisateurs" (
    num_id SERIAL PRIMARY KEY,
    ip VARCHAR NOT NULL,
    pseudo VARCHAR NOT NULL,
    mdp VARCHAR NOT NULL,
    mail VARCHAR
);

CREATE TABLE "joueurs" (
    num_id SERIAL PRIMARY KEY,
    pseudo VARCHAR NOT NULL,
    role_princ VARCHAR,
    role_second VARCHAR
);

CREATE TABLE "administrateurs" (
    num_id SERIAL PRIMARY KEY,
    pseudo VARCHAR NOT NULL
);


CREATE TABLE "partie" (
    id_partie SERIAL PRIMARY KEY,
    duree TIME,
    map INT,
    condition_win VARCHAR
);

CREATE TABLE "map" (
    id_carte SERIAL PRIMARY KEY,
    meteo VARCHAR,
    terrain VARCHAR,
    mdj VARCHAR
);

INSERT INTO "utilisateurs" (ip, pseudo, mdp, mail) VALUES ('127.0.0.1', 'corrian', 'corrian', 'corrian@gmail.com');
INSERT INTO "administrateurs" (pseudo) VALUES ('corrian');
INSERT INTO "joueurs" (pseudo, role_princ, role_second) VALUES ('corrian', 'fill', 'fill');
INSERT INTO "partie" (id_partie, duree, condition_win) VALUES (1, '00:30:00', 'win');
INSERT INTO "map" (meteo, terrain, mdj) VALUES ('cloud', 'mountain', '5v5');
INSERT INTO "map" (meteo, terrain, mdj) VALUES ('sun', 'sea', '4v4');
INSERT INTO "map" (meteo, terrain, mdj) VALUES ('rain', 'ocean', '3v3');
