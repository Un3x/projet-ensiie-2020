CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    username VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    password VARCHAR NOT NULL,
    rights INTEGER,
    created_at TIMESTAMP WITH TIME ZONE
);

INSERT INTO "user" (username, email, created_at, password, rights)  VALUES ('unex', 'patati@patata.com', NOW(), '$2y$10$MT8Pw2OhUVnRw5bkOE/jXO00cSvbio5C9zmBUVlA4sCK6thkBUJlK', 1);
INSERT INTO "user" (username, email, created_at, password, rights)  VALUES ('caillou', 'caillou@rocher.com', NOW(), '$2y$10$MT8Pw2OhUVnRw5bkOE/jXO00cSvbio5C9zmBUVlA4sCK6thkBUJlK', 0);
INSERT INTO "user" (username, email, created_at, password, rights)  VALUES ('viteira', 'vivi@taira.com', NOW(), '$2y$10$MT8Pw2OhUVnRw5bkOE/jXO00cSvbio5C9zmBUVlA4sCK6thkBUJlK', 0);
INSERT INTO "user" (username, email, created_at, password, rights)  VALUES ('césar', 'jule@cesar.com', NOW(), '$2y$10$MT8Pw2OhUVnRw5bkOE/jXO00cSvbio5C9zmBUVlA4sCK6thkBUJlK', 0);
INSERT INTO "user" (username, email, created_at, password, rights)  VALUES ('gengis', 'gengis@khan.com', NOW(), '$2y$10$MT8Pw2OhUVnRw5bkOE/jXO00cSvbio5C9zmBUVlA4sCK6thkBUJlK', 1);
INSERT INTO "user" (username, email, created_at, password, rights)  VALUES ('root', 'root@root.com', NOW(), '$2y$10$4FrKplWas8RGMlKL5fWzS.M2uBitwfyvshRY7VZ5Fp.xJnwv2iCQO', 2);

CREATE TABLE IF NOT EXISTS karas (
    id INTEGER PRIMARY KEY,
    song_name   TEXT    NOT NULL,
    source_name TEXT    NOT NULL,
    category    TEXT NOT NULL,
    song_type   TEXT NOT NULL,
    song_number INTEGER NOT NULL CHECK(song_number > 0),
    language    TEXT,
    is_new      INTEGER NOT NULL,
    author_name TEXT
);


INSERT INTO "karas" (id, song_name, source_name, category, song_type, song_number, language, is_new, author_name) VALUES (1,'GUNDAM WING italian','Gundam Wing','OP','va',1,'it',0,'Viieux');
INSERT INTO "karas" (id, song_name, source_name, category, song_type, song_number, language, is_new, author_name) VALUES (2,'Something','Nadia il Mistero della Pietra Azzura','MV','va',1,'it',0,'Viieux');
INSERT INTO "karas" (id, song_name, source_name, category, song_type, song_number, language, is_new, author_name) VALUES (3,'version italienne','Maple Town Un Nido di Simpatia','OP','va',1,'it',0,'Viieux');
INSERT INTO "karas" (id, song_name, source_name, category, song_type, song_number, language, is_new, author_name) VALUES (4,'God Knows (russian)','Suzumiya Haruhi no Yuuutsu','IS','va',1,'ru',0,'Colgate');
INSERT INTO "karas" (id, song_name, source_name, category, song_type, song_number, language, is_new, author_name) VALUES (5,'Wu Ya','Hitori no Shita The Outcast S2','OP','va',1,'ch',0,'Sting');
INSERT INTO "karas" (id, song_name, source_name, category, song_type, song_number, language, is_new, author_name) VALUES (6,'Xin Yang','Quan Zhi Gao Shou','OP','va',1,'ch',0,'Sting');
INSERT INTO "karas" (id, song_name, source_name, category, song_type, song_number, language, is_new, author_name) VALUES (7,'Franklin','Franklin','OP','va',1,'fr',0,'Phoko');
INSERT INTO "karas" (id, song_name, source_name, category, song_type, song_number, language, is_new, author_name) VALUES (8,'Pegasus Fantasy (VF)','Saint Seiya','OP','va',1,'fr',0,'Viieux');
INSERT INTO "karas" (id, song_name, source_name, category, song_type, song_number, language, is_new, author_name) VALUES (9,'Opening','Sailor Moon','OP','va',1,'fr',0,'Viieux');

CREATE TABLE IF NOT EXISTS queue (
    position SERIAL PRIMARY KEY,
    id INTEGER NOT NULL REFERENCES karas,
    added_by INTEGER REFERENCES "user"
);

CREATE TABLE IF NOT EXISTS playlist (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    creator INTEGER REFERENCES "user",
    content INT[],
    publik BOOLEAN
);


CREATE TABLE IF NOT EXISTS userCosmetics (
    id INTEGER PRIMARY KEY REFERENCES "user",
    IDimage INTEGER REFERENCES image,
    IDtitle INTEGER REFERENCES title
);

CREATE TABLE IF NOT EXISTS image (
    IDimage SERIAL PRIMARY KEY,
    image VARCHAR
);

INSERT INTO "image" (IDimage, image) VALUES (1,'waifu1.png');
INSERT INTO "image" (IDimage, image) VALUES (2,'waifu2.png');
INSERT INTO "image" (IDimage, image) VALUES (3,'waifu3.png');
INSERT INTO "image" (IDimage, image) VALUES (4,'waifu4.png');
INSERT INTO "image" (IDimage, image) VALUES (5,'waifu5.png');
INSERT INTO "image" (IDimage, image) VALUES (6,'waifu6.png');
INSERT INTO "image" (IDimage, image) VALUES (7,'waifu7.png');
INSERT INTO "image" (IDimage, image) VALUES (8,'waifu8.png');
INSERT INTO "image" (IDimage, image) VALUES (9,'waifu9.png');
INSERT INTO "image" (IDimage, image) VALUES (10,'waifu10.png');
INSERT INTO "image" (IDimage, image) VALUES (11,'waifu11.png');
INSERT INTO "image" (IDimage, image) VALUES (12,'waifu12.png');
INSERT INTO "image" (IDimage, image) VALUES (13,'waifu13.png');
INSERT INTO "image" (IDimage, image) VALUES (14,'waifu14.png');
INSERT INTO "image" (IDimage, image) VALUES (15,'waifu15.png');
INSERT INTO "image" (IDimage, image) VALUES (16,'waifu16.png');

CREATE TABLE IF NOT EXISTS title (
    IDtitle SERIAL PRIMARY KEY,
    title VARCHAR
);

INSERT INTO "title" (IDtitle,title) VALUES (1,'Titre défectueux');
INSERT INTO "title" (IDtitle,title) VALUES (2,'Karamaker');
INSERT INTO "title" (IDtitle,title) VALUES (3,'Kara-pas-maker');
INSERT INTO "title" (IDtitle,title) VALUES (4,'DJ weeb');
INSERT INTO "title" (IDtitle,title) VALUES (5,'Weeb-Developer');
INSERT INTO "title" (IDtitle,title) VALUES (6,'JINBUN WO');
INSERT INTO "title" (IDtitle,title) VALUES (7,'Lolicon');
INSERT INTO "title" (IDtitle,title) VALUES (8,'Brocon');
INSERT INTO "title" (IDtitle,title) VALUES (9,'Siscon');


CREATE TABLE IF NOT EXISTS lector (
    id INTEGER PRIMARY KEY REFERENCES "user",
    ip VARCHAR,
    port INTEGER
);

--INSERT INTO "lector" (id, ip, port)  VALUES (1, '127.0.0.1', 6600);
INSERT INTO "lector" (id, ip, port)  VALUES (1, '::1', 6600);
INSERT INTO "lector" (id, ip, port)  VALUES (2, '12.2.3.4', 1234);

