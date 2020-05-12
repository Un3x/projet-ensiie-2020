CREATE TABLE "book" (
    id SERIAL PRIMARY KEY,
    titre VARCHAR NOT NULL,
    auteur VARCHAR NOT NULL,
    apercu  VARCHAR NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE,
    borrowed BOOLEAN
);

INSERT INTO "book" (titre, auteur, apercu, created_at, borrowed)  VALUES ('One Piece', 'Oda', 'Images/One_Piece.jpg', NOW(), FALSE);
INSERT INTO "book" (titre, auteur, apercu, created_at, borrowed)  VALUES ('Solo Leveling', 'Chu-Gong', 'Images/Solo_Leveling.jpg', NOW(), FALSE);
INSERT INTO "book" (titre, auteur, apercu, created_at, borrowed)  VALUES ('Dragon Ball', 'Toriyama', 'Images/Dragon_Ball.jpeg', NOW(), FALSE);
INSERT INTO "book" (titre, auteur, apercu, created_at, borrowed)  VALUES ('Cendrillon', 'Fisher', 'Images/Cendrillon.jpg', NOW(), FALSE);
INSERT INTO "book" (titre, auteur, apercu, created_at, borrowed)  VALUES ('Naruto', 'Kishimoto', 'Images/Naruto.jpg', NOW(), FALSE );


CREATE TABLE "users" (
    id SERIAL PRIMARY KEY,
    username VARCHAR NOT NULL,
    passwd VARCHAR NOT NULL,
    adminright BOOLEAN
);


CREATE TABLE "summary" (
    id SERIAL PRIMARY KEY,
    id_book INT,
    FOREIGN KEY (id_book) REFERENCES book(id) ON DELETE CASCADE,
    summ VARCHAR,
    likes INT,
    FOREIGN KEY (likes) REFERENCES users(id) ON DELETE CASCADE,
    dislikes INT,
    FOREIGN KEY (dislikes) REFERENCES users(id) ON DELETE CASCADE,
);

INSERT INTO "summary" (id_book, summ) VALUES (1, 'Luffy, un jeune garçon, rêve de devenir le Roi des Pirates en trouvant le One Piece, le trésor ultime rassemblé par Gol D. Roger, le seul pirate à avoir jamais porté le titre de Roi des Pirates.');
INSERT INTO "summary" (id_book, summ) VALUES (2, 'Depuis l`apparition d`un portail reliant notre monde à un monde rempli de monstres et de créatures de toutes sortes, certaines personnes ont acquis des pouvoirs et la capacité de les chasser : on les appelle les «Chasseurs».');
INSERT INTO "summary" (id_book) VALUES (3);
INSERT INTO "summary" (id_book) VALUES (4);
INSERT INTO "summary" (id_book) VALUES (5);
