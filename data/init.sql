CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    username VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE
);

CREATE TABLE "utilisateurs" (
    num_id SERIAL PRIMARY KEY,
    pseudo VARCHAR NOT NULL,
    mdp VARCHAR NOT NULL,
    mail VARCHAR,
    date_crea DATE NOT NULL
);

CREATE TABLE "joueurs" (
    num_id SERIAL PRIMARY KEY,
    pseudo VARCHAR NOT NULL,
    mdp VARCHAR NOT NULL,
    mail VARCHAR,
    date_crea DATE NOT NULL,
    role_princ INT,
    role_second INT
);

CREATE TABLE "administrateurs" (
    num_id SERIAL PRIMARY KEY,
    pseudo VARCHAR NOT NULL,
    mdp VARCHAR NOT NULL,
    mail VARCHAR,
    date_crea DATE NOT NULL
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

INSERT INTO "user" (username, email, created_at)  VALUES ('unex', 'patati@patata.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('caillou', 'caillou@rocher.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('viteira', 'vivi@taira.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('césar', 'jule@cesar.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('gengis', 'gengis@khan.com', NOW());

INSERT INTO "utilisateurs" (pseudo, mdp, mail, date_crea) VALUES ('corrian', 'corrian', 'corrian@gmail.com', '2020-07-04');
INSERT INTO "joueurs" (pseudo, mdp, mail, date_crea, role_princ, role_second) VALUES ('corrian', 'corrian', 'corrian@gmail.com', '2020-07-04', 1, 2);
INSERT INTO "administrateurs" (pseudo, mdp, mail, date_crea) VALUES ('corrian', 'corrian', 'corrian@gmail.com', '2020-07-04');
INSERT INTO "partie" (id_partie, duree, condition_win) VALUES (1, '00:30:00', 'win');
INSERT INTO "map" (meteo, terrain, mdj) VALUES (2, 'mountain', '5v5');
INSERT INTO "map" (meteo, terrain, mdj) VALUES (3, 'sea', '4v4');
INSERT INTO "map" (meteo, terrain, mdj) VALUES (2, 'ocean', '3v3');
