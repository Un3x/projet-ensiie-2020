CREATE TABLE "user" (
    userId SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    pwd VARCHAR(50) NOT NULL,
    isAdmin BOOLEAN
);

CREATE TABLE "story" (
    storyId SERIAL PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    author VARCHAR(50) NOT NULL,
    summary TEXT NOT NULL,
    heroSkill INT NOT NULL,
    heroStamina INT NOT NULL,
    heroLuck INT NOT NULL
);

CREATE TABLE "page" (
    pageId SERIAL PRIMARY KEY,
    storyId INT NOT NULL,
    txt TEXT,
    choiceInt1 INT,
    choiceInt2 INT,
    choiceInt3 INT,
    choiceText1 VARCHAR(50),
    choiceText2 VARCHAR(50),
    choiceText3 VARCHAR(50),
    firstPage BOOLEAN,
    lastPage BOOLEAN,
    FOREIGN KEY (storyId) REFERENCES "story" (storyId)
);

CREATE TABLE "comment" (
    commentId SERIAL PRIMARY KEY,
    storyId INT NOT NULL,
    userId INT NOT NULL,
    txt VARCHAR(1000),
    FOREIGN KEY (storyId) REFERENCES "story" (storyId),
    FOREIGN KEY (userId) REFERENCES "user" (userId)
);

CREATE TABLE "rate" (
    rateId SERIAL PRIMARY KEY,
    rate INT CHECK (rate>0 and rate<6),
    userId INT NOT NULL,
    storyId INT NOT NULL,
    FOREIGN KEY (storyId) REFERENCES "story" (storyId),
    FOREIGN KEY (userId) REFERENCES "user" (userId),
    CONSTRAINT ck_user_story UNIQUE (userId, storyId)
);

INSERT INTO "user" (username, email, pwd, isAdmin) VALUES ('gecko', 'gecko@ensiie.fr', 'gecko', false);
INSERT INTO "user" (username, email, pwd, isAdmin) VALUES ('hail', 'hail@ensiie.fr', 'hail', false);
INSERT INTO "user" (username, email, pwd, isAdmin) VALUES ('baboul', 'baboul@ensiie.fr', 'baboul', false);
INSERT INTO "user" (username, email, pwd, isAdmin) VALUES ('spike', 'spike@ensiie.fr', 'spike', false);

INSERT INTO "story" (title, author, summary, heroSkill, heroStamina, heroLuck) VALUES ('La cité des voleurs', 'Ian Livingstone', 'La terreur s''est abattue sur la ville de Silverstone depuis que Zanbar Bone et ses Chiens de Lune assoiffés de sang y exercent leurs méfaits. Parviendrez vous à traverser le Port-du-Sable-Noir pour affronté l''infâme Zanbar Bone retranché dans sa place forte ?', 9, 21, 10);
INSERT INTO "story" (title, author, summary, heroSkill, heroStamina, heroLuck) VALUES ('La sorcière des neiges', 'Ian Livingstone', 'Au sommet des Pics de Glace la Caverne de Crystal renferme le royaume de la terrible Sorcière des Neiges qui a juré de plonger le monde dans une nouvelle ère glacière. Alors que six hommes qui gardaient l''avant poste des Pics de Glace ont été massacrés, vous êtes missioné par un marchant pour vous débarasser de la créature auteur du méfait en échange de 50 pièces d''or. Saurez-vous faire face au monstre et à la sorcière maléfique ?', 11, 20, 7);

INSERT INTO "page" (storyId, txt, choiceInt1, choiceInt2, choiceText1, choiceText2, firstPage, lastPage) VALUES (1, 'Intro text', 2, 3, 'Prendre la ruelle de gauche', 'Pousuivre dans la rue principale', true, false);
INSERT INTO "page" (storyId, txt, choiceInt1, choiceInt2, choiceText1, choiceText2, firstPage, lastPage) VALUES (1, 'Ruelle de gauche\nLorem ipsum', 12, 19, 'Continuer tout droit', 'Entrez dans la boutique miteuse', false, false);
INSERT INTO "page" (storyId, txt, choiceInt1, choiceInt2, choiceText1, choiceText2, firstPage, lastPage) VALUES (1, 'Rue principale', 53, 4, 'Parler au mendiant', 'Aller vers la forteresse', false, false);
INSERT INTO "page" (storyId, txt, firstPage, lastPage) VALUES (1, 'Forteresse\nVictoire !', false, true);

INSERT INTO "rate" (rate, userId, storyId) VALUES (5, 1, 1);
INSERT INTO "rate" (rate, userId, storyId) VALUES (1, 2, 1);
INSERT INTO "rate" (rate, userId, storyId) VALUES (4, 1, 2);
INSERT INTO "rate" (rate, userId, storyId) VALUES (2, 2, 2);
INSERT INTO "rate" (rate, userId, storyId) VALUES (3, 4, 2);