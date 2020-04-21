CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    username VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    password VARCHAR NOT NULL,
    rights INTEGER,
    created_at TIMESTAMP WITH TIME ZONE
);

INSERT INTO "user" (username, email, created_at, rights)  VALUES ('unex', 'patati@patata.com', NOW(), 1);
INSERT INTO "user" (username, email, created_at, rights)  VALUES ('caillou', 'caillou@rocher.com', NOW(), 0);
INSERT INTO "user" (username, email, created_at, rights)  VALUES ('viteira', 'vivi@taira.com', NOW(), 0);
INSERT INTO "user" (username, email, created_at, rights)  VALUES ('césar', 'jule@cesar.com', NOW(), 0);
INSERT INTO "user" (username, email, created_at, rights)  VALUES ('gengis', 'gengis@khan.com', NOW(), 1);

CREATE TABLE IF NOT EXISTS "kara" (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    song_name   TEXT    NOT NULL,
    source_name TEXT    NOT NULL,
    category    INTEGER NOT NULL,
    song_type   INTEGER NOT NULL,
    song_number INTEGER NOT NULL CHECK(song_number > 0),
    language    TEXT,
    file_path   TEXT    NOT NULL UNIQUE,
    is_new      INTEGER NOT NULL,
    author_name TEXT,
    author_year INTEGER CHECK(author_year > 0)
);

CREATE TABLE IF NOT EXISTS "queue" (
    position INTEGER PRIMARY KEY,
    id INTEGER NOT NULL REFERENCES kara
);

CREATE TABLE IF NOT EXISTS "playlist" (
    id INTEGER PRIMARY KEY,
    nom TEXT NOT NULL,
    createur SERIAL REFERENCES user,
    content id[] REFERENCES kara
);


CREATE TABLE IF NOT EXISTS "userCosmetics"(
	id SERIAL PRIMARY KEY,
	IDimage INTEGER,
        IDtitle INTEGER
);

CREATE TABLE IF NOT EXISTS "image"(
	IDimage SERIAL PRIMARY KEY,
	image VARCHAR 
);

CREATE TABLE IF NOT EXISTS "title"(
	IDtitle SERIAL PRIMARY KEY,
	title VARCHAR 
);

