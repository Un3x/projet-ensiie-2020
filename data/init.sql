
/*
CREATE DATABASE 'joueurs';
CREATE USER 'groupe12' WITH ENCRYPTED PASSWORD 'Pw8f87mvkeoFHBxuRqMpkNvFTrMDE';
GRANT ALL PRIVILEGES ON DATABASE 'joueurs' TO 'groupe12';*/


CREATE TABLE League (
    name VARCHAR PRIMARY KEY
);

CREATE TABLE Users (
    pseudo VARCHAR PRIMARY KEY,
    password VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    administrator BOOLEAN,
    created_at TIMESTAMP WITH TIME ZONE,
    team VARCHAR,
    CONSTRAINT fk_team FOREIGN KEY (team) REFERENCES League(name) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO Users (pseudo, password, email, administrator, created_at, team)
VALUES ('bgdu91','$2y$10$ZC32rTQAxFFK2XhJAqgRG.kxVpjQOQ605Xw1GG5wmFVByFMYJxh2O', 'gengis@khan.com',true, NOW(),null);


CREATE TABLE Game (
    id SERIAL PRIMARY KEY,
    winner VARCHAR,
    played_at TIMESTAMP WITH TIME ZONE NOT NULL,
    player VARCHAR,
    CONSTRAINT check_winner CHECK(winner = 'oui' OR winner = 'non' OR winner = 'nul'),
    CONSTRAINT fk_p1 FOREIGN KEY (player) REFERENCES Users(pseudo) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Tournament (
    id SERIAL PRIMARY KEY,
    name VARCHAR NOT NULL,
    organisateur VARCHAR NOT NULL,
    CONSTRAINT fk_orga FOREIGN KEY (organisateur) REFERENCES Users(pseudo) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Participate (
    game INTEGER,
    player VARCHAR,
    CONSTRAINT fk_partie FOREIGN KEY (game) REFERENCES Game(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_user FOREIGN KEY (player) REFERENCES Users(pseudo) ON DELETE CASCADE ON UPDATE CASCADE
);
