CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    username VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE
);

INSERT INTO "user" (username, email, created_at)  VALUES ('unex', 'patati@patata.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('caillou', 'caillou@rocher.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('viteira', 'vivi@taira.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('césar', 'jule@cesar.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('gengis', 'gengis@khan.com', NOW());

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