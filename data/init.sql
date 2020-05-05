CREATE TABLE "nb_online" (
    ip VARCHAR(15) NOT NULL,
    ti BIGINT NOT NULL
);

CREATE TABLE "in_game" (
    pseudo VARCHAR NOT NULL,
    id_game INT NOT NULL,
    team INT NOT NULL
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
    id_carte SERIAL PRIMARY KEY,
    meteo INT,
    terrain VARCHAR,
    mdj VARCHAR
);

INSERT INTO "utilisateurs" (ip, pseudo, mdp, mail) VALUES ('127.0.0.1', 'corrian', 'corrian', 'corrian@gmail.com');
INSERT INTO "administrateurs" (pseudo) VALUES ('corrian');
INSERT INTO "joueurs" (pseudo, role_princ, role_second) VALUES ('corrian', 0, 0);
INSERT INTO "partie" (id_partie, duree, condition_win) VALUES (1, '00:30:00', 'win');
INSERT INTO "map" (meteo, terrain, mdj) VALUES (2, 'mountain', '5v5');
INSERT INTO "map" (meteo, terrain, mdj) VALUES (3, 'sea', '4v4');
INSERT INTO "map" (meteo, terrain, mdj) VALUES (2, 'ocean', '3v3');
