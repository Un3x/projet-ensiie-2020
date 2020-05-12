-- Si la table existe déjà, la supprimer
DROP TABLE IF EXISTS chanson CASCADE;
DROP TABLE IF EXISTS lien CASCADE;
DROP TABLE IF EXISTS soiree CASCADE;
DROP TABLE IF EXISTS chanson_soiree CASCADE;
DROP TABLE IF EXISTS chanteur CASCADE;
DROP TABLE IF EXISTS utilisateur CASCADE;

CREATE TABLE chanson
(
    id SERIAL PRIMARY KEY,
    nom VARCHAR(64) NOT NULL,
    artiste VARCHAR(64),
    --contient les paroles brutes avec sauts de ligne et éventuellement mise en forme (HTML / Markdown)
    paroles TEXT,
    --utilisateur ayant posté la chanson
    id_utilisateur VARCHAR(32) NOT NULL
    --La contrainte de clé étrangère est écrite en bas du fichier
);

CREATE TABLE utilisateur(
    id VARCHAR(32) PRIMARY KEY,
    pseudo VARCHAR(32),
    prenom VARCHAR(32),
    nom VARCHAR(32),

    --role est réservé SQL
    role_utilisateur VARCHAR(32)
);

CREATE TABLE lien(
    id SERIAL PRIMARY KEY,
    lien VARCHAR(256) NOT NULL,
    --type est un mot réservé par SQL
    type_lien VARCHAR(64),
    id_chanson INTEGER NOT NULL,

    CONSTRAINT fk_lidc FOREIGN KEY(id_chanson) REFERENCES chanson(id) ON DELETE CASCADE
);


CREATE TABLE soiree(
    id SERIAL PRIMARY KEY,
    nom VARCHAR(32),
    theme VARCHAR(32),
    date_soiree DATE NOT NULL,
    publique BOOLEAN
);

CREATE TABLE chanson_soiree(
    id SERIAL PRIMARY KEY,
    id_chanson INTEGER NOT NULL,
    id_soiree INTEGER NOT NULL,

    CONSTRAINT fk_csidc FOREIGN KEY(id_chanson) REFERENCES chanson(id) ON DELETE CASCADE,
    CONSTRAINT fk_csids FOREIGN KEY(id_soiree) REFERENCES soiree(id) ON DELETE CASCADE
);

--cette table fait le lien entre un utilisateur et une chanson à une soirée
CREATE TABLE chanteur(
    id SERIAL PRIMARY KEY,
    id_cs INTEGER NOT NULL,
    id_utilisateur VARCHAR(32) NOT NULL,

    CONSTRAINT fk_chidcs FOREIGN KEY(id_cs) REFERENCES chanson_soiree(id) ON DELETE CASCADE,
    CONSTRAINT fk_chidu FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id) ON DELETE CASCADE
);

--Une contrainte ne peut pas être écrite avant création de la table référencée
ALTER TABLE chanson
    ADD CONSTRAINT fk_cidu FOREIGN KEY(id_utilisateur) REFERENCES utilisateur(id);
