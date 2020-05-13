CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    username VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    name VARCHAR NOT NULL,
    fname VARCHAR NOT NULL,
    keyWords VARCHAR,
    pwd VARCHAR NOT NULL,
    age INT,
    created_at TIMESTAMP WITH TIME ZONE,
    isAdmin BOOLEAN NOT NULL,
    reportCounter INT
);

INSERT INTO "user" (username, email, name, pwd, fname, created_at,isAdmin,age)  VALUES ('dwatel', 'dimitri@watel.com', 'Watel',md5('watel123') , 'Dimitri', NOW(),'false',30);
INSERT INTO "user" (username, email, name,pwd, fname, created_at,isAdmin,age)  VALUES ('nbrunel', 'nicolas@brunel.com', 'Nicolas',md5('nbrunel123'), 'Brunel', NOW(),'true',30);
INSERT INTO "user" (username, email, name,pwd, fname, created_at,isAdmin, age)  VALUES ('viteira', 'vivi@taira.com','Y',md5('vitera123'), 'Viteira', NOW(),'true',30);
INSERT INTO "user" (username, email, name,pwd, fname, created_at,isAdmin,age)  VALUES ('césar', 'jule@cesar.com', 'CAESAR',md5('cesar123'), 'Julius', NOW(),'false',30);
INSERT INTO "user" (username, email, name,pwd, fname, created_at,isAdmin,age)  VALUES ('gengis', 'gengis@khan.com', 'KHAN',md5('gengis123'),'Gengis' , NOW(),'false',30);

CREATE TABLE "ad" (
    id SERIAL PRIMARY KEY,
    title VARCHAR NOT NULL,
    description VARCHAR NOT NULL,
    likes INT,
    authorId INT,
    keyWords VARCHAR,
    reportCounter INT,
    created_at TIMESTAMP WITH TIME ZONE
);

INSERT INTO "ad" (title, description, created_at, keyWords, authorId)  VALUES ('Durableverse', 'On souhaite coder un jeux de type Trading Cards Game nommé Durableverse. Il s’agit d’un jeu de combat de
cartes à collectionner.
À force de jouer avec le supercalculateur de l’école, les élèves du parcours CIDM ont ouvert une porte vers un
univers parallèle, dévoilant ainsi l’existence d’une seconde école ENSIIE et de tout un tas d’autres écoles d’ingénieur.
Avec effroi, les deux ENSIIE virent leur classement parmi les écoles d’ingénieur les plus investies dans le développement
durable chuter, naturellement englouties sous un flot d’énergie démentiel pour maintenir la porte ouverte
entre les mondes. C’est ainsi que débuta la bataille pour devenir l’école la plus investie de tout le multivers. . .', NOW(), 'C; jeu; developpement', 1);
INSERT INTO "ad" (title, description, created_at,  keyWords,authorId)  VALUES ('Rain in Australia', 'Nous allons analyser les données “Rain in Australia” accessible sur le
site Kaggle : https://www.kaggle.com/jsphyg/weather-dataset-rattle-package.
Les données y sont décrites de manière détaillée et contiennent des informations
météorologiques pendant 10 ans, dans plusieurs villes d’Australia. Les données
sont journalières, et sont par exemple, les températures minimales ou maximales
de la journée, la pression, l’ensoleillement,...
L’objectif de ce jeu de données est de prédire si il pleuvra le lendemain, à
partir des variables disponibles le jour même. Il faut prédire RainTomorrow
(Vrai ou Faux), mais attention il ne faut pas utiliser la variables Risk-MM, qui
est une variable calculée, à partir du futur, donc inaccessible en pratique.', NOW(),'R; statistiques; data',2);
INSERT INTO "ad" (title, description, created_at, keyWords,authorId)  VALUES ('WEB', 'Bonjour je dois faire un site web pour mon école d ingénieur, besoin d aide pour mes requête ajax. Si qulqu un sait faire du ajax, contacter moi!', NOW(), 'HTML, CSS, JS',4);
INSERT INTO "ad" (title, description, created_at, keyWords,authorId)  VALUES ('MOBA games', 'Nous avons pour projet de faire un jeu vidéo. Il sagit dun MOBA qui pourra concurencer LOL. Nous sommes une sociéte qui s appelle ETHEREAL GAME et pour ce projet, nous recherchons des developperus C++', NOW(), 'C++; jeux; vidéo',3);


CREATE TABLE "com" (
    id SERIAL PRIMARY KEY,
    text VARCHAR NOT NULL,
    likes INT,
    authorId INT,
    textId INT,
    reportCounter INT,
    created_at TIMESTAMP WITH TIME ZONE
);


CREATE TABLE "report" (
    id SERIAL PRIMARY KEY,
    text VARCHAR NOT NULL,
    authorId INT,
    textId INT,
    created_at TIMESTAMP WITH TIME ZONE
);
