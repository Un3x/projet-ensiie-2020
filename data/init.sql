CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    username VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    xp INTEGER,
    password VARCHAR NOT NULL,
    rights INTEGER,
    port INTEGER DEFAULT 6600,
    created_at TIMESTAMP WITH TIME ZONE
);

INSERT INTO "user" (username, email, created_at, xp, password, rights)  VALUES ('unex', 'patati@patata.com', NOW(), 0, '$2y$10$MT8Pw2OhUVnRw5bkOE/jXO00cSvbio5C9zmBUVlA4sCK6thkBUJlK', 1);
INSERT INTO "user" (username, email, created_at, xp, password, rights)  VALUES ('caillou', 'caillou@rocher.com', NOW(), 10, '$2y$10$MT8Pw2OhUVnRw5bkOE/jXO00cSvbio5C9zmBUVlA4sCK6thkBUJlK', 0);
INSERT INTO "user" (username, email, created_at, xp, password, rights)  VALUES ('viteira', 'vivi@taira.com', NOW(), 15, '$2y$10$MT8Pw2OhUVnRw5bkOE/jXO00cSvbio5C9zmBUVlA4sCK6thkBUJlK', 0);
INSERT INTO "user" (username, email, created_at, xp, password, rights)  VALUES ('césar', 'jule@cesar.com', NOW(), 35, '$2y$10$MT8Pw2OhUVnRw5bkOE/jXO00cSvbio5C9zmBUVlA4sCK6thkBUJlK', 0);
INSERT INTO "user" (username, email, created_at, xp, password, rights)  VALUES ('gengis', 'gengis@khan.com', NOW(), 45, '$2y$10$MT8Pw2OhUVnRw5bkOE/jXO00cSvbio5C9zmBUVlA4sCK6thkBUJlK', 1);
INSERT INTO "user" (username, email, created_at, xp, password, rights)  VALUES ('root', 'root@root.com', NOW(), 1000, '$2y$10$4FrKplWas8RGMlKL5fWzS.M2uBitwfyvshRY7VZ5Fp.xJnwv2iCQO', 2);


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

--INSERT INTO queue (id, added_by) VALUES (1,1);
--INSERT INTO queue (id, added_by) VALUES (2,2);



CREATE TABLE IF NOT EXISTS playlist (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    creator INTEGER REFERENCES "user",
    content INT[],
    publik BOOLEAN
);



CREATE TABLE IF NOT EXISTS image (
    IDimage SERIAL PRIMARY KEY,
    image VARCHAR,
    xpNeeded INTEGER
);

INSERT INTO "image" (IDimage, image, xpNeeded) VALUES (0,'waifu0.png', 0);
INSERT INTO "image" (IDimage, image, xpNeeded) VALUES (1,'waifu1.png', 0);
INSERT INTO "image" (IDimage, image, xpNeeded) VALUES (2,'waifu2.png', 0);
INSERT INTO "image" (IDimage, image, xpNeeded) VALUES (3,'waifu3.png', 0);
INSERT INTO "image" (IDimage, image, xpNeeded) VALUES (4,'waifu4.png', 0);
INSERT INTO "image" (IDimage, image, xpNeeded) VALUES (5,'waifu5.png', 10);
INSERT INTO "image" (IDimage, image, xpNeeded) VALUES (6,'waifu6.png', 10);
INSERT INTO "image" (IDimage, image, xpNeeded) VALUES (7,'waifu7.png', 15);
INSERT INTO "image" (IDimage, image, xpNeeded) VALUES (8,'waifu8.png', 20);
INSERT INTO "image" (IDimage, image, xpNeeded) VALUES (9,'waifu9.png', 30);
INSERT INTO "image" (IDimage, image, xpNeeded) VALUES (10,'waifu10.png', 30);
INSERT INTO "image" (IDimage, image, xpNeeded) VALUES (11,'waifu11.png', 50);
INSERT INTO "image" (IDimage, image, xpNeeded) VALUES (12,'waifu12.png', 50);
INSERT INTO "image" (IDimage, image, xpNeeded) VALUES (13,'waifu13.png', 50);
INSERT INTO "image" (IDimage, image, xpNeeded) VALUES (14,'waifu14.png', 100);
INSERT INTO "image" (IDimage, image, xpNeeded) VALUES (15,'waifu15.png', 300);
INSERT INTO "image" (IDimage, image, xpNeeded) VALUES (16,'waifu16.png', 1000);



CREATE TABLE IF NOT EXISTS titles (
    IDtitle SERIAL PRIMARY KEY,
    title VARCHAR,
    xpNeeded INTEGER
);

INSERT INTO "titles" (IDtitle,title, xpNeeded) VALUES (0,'Weeblet', 0);
INSERT INTO "titles" (IDtitle,title, xpNeeded) VALUES (1,'Titre défectueux', 0);
INSERT INTO "titles" (IDtitle,title, xpNeeded) VALUES (2,'Karamaker', 0);
INSERT INTO "titles" (IDtitle,title, xpNeeded) VALUES (3,'Kara-pas-maker', 3);
INSERT INTO "titles" (IDtitle,title, xpNeeded) VALUES (4,'DJ weeb', 5);
INSERT INTO "titles" (IDtitle,title, xpNeeded) VALUES (5,'Weeb-Developer', 10);
INSERT INTO "titles" (IDtitle,title, xpNeeded) VALUES (6,'JINBUN WO', 25);
INSERT INTO "titles" (IDtitle,title, xpNeeded) VALUES (7,'Lolicon', 30);
INSERT INTO "titles" (IDtitle,title, xpNeeded) VALUES (8,'Brocon', 60);
INSERT INTO "titles" (IDtitle,title, xpNeeded) VALUES (9,'Siscon', 100);



CREATE TABLE IF NOT EXISTS userCosmetics (
    id INTEGER PRIMARY KEY REFERENCES "user",
    IDimage INTEGER REFERENCES image,
    IDtitle INTEGER REFERENCES titles
);

INSERT INTO userCosmetics (id, IDimage, IDtitle) VALUES (1,1,1);
INSERT INTO userCosmetics (id, IDimage, IDtitle) VALUES (2,2,2);
INSERT INTO userCosmetics (id, IDimage, IDtitle) VALUES (3,3,3);
INSERT INTO userCosmetics (id, IDimage, IDtitle) VALUES (4,4,4);
INSERT INTO userCosmetics (id, IDimage, IDtitle) VALUES (5,5,5);
INSERT INTO userCosmetics (id, IDimage, IDtitle) VALUES (6,6,6);



CREATE TABLE IF NOT EXISTS lector (
    id INTEGER PRIMARY KEY REFERENCES "user",
    ip VARCHAR,
    port INTEGER
);

--INSERT INTO "lector" (id, ip, port)  VALUES (1, '127.0.0.1', 6600);
INSERT INTO "lector" (id, ip, port)  VALUES (1, '::1', 6600);
--INSERT INTO "lector" (id, ip, port)  VALUES (2, '12.2.3.4', 1234);

