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
    is_new      INTEGER NOT NULL,
    author_name TEXT
);

1|GUNDAM WING italian|Gundam Wing|OP|va|1|it|/home/kara/va/it/Viieux/Gundam Wing - OP1 - GUNDAM WING italian.mkv|0|Viieux|1580673686
2|Something|Nadia il Mistero della Pietra Azzurra|MV|va|1|it|/home/kara/va/it/Viieux/Nadia il Mistero della Pietra Azzurra - MV - Something.mkv|0|Viieux|1580673686
3|version italienne|Maple Town Un Nido di Simpatia|OP|va|1|it|/home/kara/va/it/Viieux/Maple Town Un Nido di Simpatia - OP1 - version italienne.mkv|0|Viieux|1580673686
4|God Knows (russian)|Suzumiya Haruhi no Yuuutsu|IS|va|1|ru|/home/kara/va/ru/Colgate/Suzumiya Haruhi no Yuuutsu - IS - God Knows (russian).mkv|0|Colgate|1580673686
5|Wu Ya|Hitori no Shita The Outcast S2|OP|va|1|ch|/home/kara/va/ch/Sting/Hitori no Shita The Outcast S2 - OP1 - Wu Ya.mkv|0|Sting|1580673686
6|Xin Yang|Quan Zhi Gao Shou|OP|va|1|ch|/home/kara/va/ch/Sting/Quan Zhi Gao Shou - OP1 - Xin Yang.mkv|0|Sting|1580673686
7|Franklin|Franklin|OP|va|1|fr|/home/kara/va/fr/Phoko/Franklin - OP1 - Franklin.mkv|0|Phoko|1580673686
8|Pegasus Fantasy (VF)|Saint Seiya|OP|va|1|fr|/home/kara/va/fr/Viieux/Saint Seiya - OP1 - Pegasus Fantasy (VF).mkv|0|Viieux|1580673686
9|Opening|Sailor Moon|OP|va|1|fr|/home/kara/va/fr/Viieux/Sailor Moon - OP1 - Opening.mkv|0|Viieux|1580673686

INSERT INTO "kara" (id, song_name, source_name, category, song_type, song_number, language, file_path, is_new, author_name, author_year) VALUES (1,'GUNDAM WING italian','Gundam Wing','OP','va',1,'it',0,'Viieux');
INSERT INTO "kara" (id, song_name, source_name, category, song_type, song_number, language, file_path, is_new, author_name, author_year) VALUES (2,'Something','Nadia il Mistero della Pietra Azzura','MV','va',1,'it',0,'Viieux');
INSERT INTO "kara" (id, song_name, source_name, category, song_type, song_number, language, file_path, is_new, author_name, author_year) VALUES (3,'version italienne','Maple Town Un Nido di Simpatia','OP','va',1,'it',0,'Viieux');
INSERT INTO "kara" (id, song_name, source_name, category, song_type, song_number, language, file_path, is_new, author_name, author_year) VALUES (4,'God Knows (russian)','Suzumiya Haruhi no Yuuutsu','IS','va',1,'ru',0,'Colgate');
INSERT INTO "kara" (id, song_name, source_name, category, song_type, song_number, language, file_path, is_new, author_name, author_year) VALUES (5,'Wu Ya','Hitori no Shita The Outcast S2','OP','va',1,'ch',0,'Sting');
INSERT INTO "kara" (id, song_name, source_name, category, song_type, song_number, language, file_path, is_new, author_name, author_year) VALUES (6,'Xin Yang','Quan Zhi Gao Shou','OP','va',1,'ch',0,'Sting');
INSERT INTO "kara" (id, song_name, source_name, category, song_type, song_number, language, file_path, is_new, author_name, author_year) VALUES (7,'Franklin','Franklin','OP','va',1,'fr',0,'Phoko');
INSERT INTO "kara" (id, song_name, source_name, category, song_type, song_number, language, file_path, is_new, author_name, author_year) VALUES (8,'Pegasus Fantasy (VF)','Saint Seiya','OP','va',1,'fr',0,'Viieux');
INSERT INTO "kara" (id, song_name, source_name, category, song_type, song_number, language, file_path, is_new, author_name, author_year) VALUES (9,'Opening','Sailor Moon','OP','va',1,'fr',0,'Viieux');

CREATE TABLE IF NOT EXISTS "queue" (
    position INTEGER PRIMARY KEY,
    id INTEGER NOT NULL REFERENCES kara
);
