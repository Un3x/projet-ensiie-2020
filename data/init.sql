CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    username VARCHAR NOT NULL UNIQUE,
    email VARCHAR NOT NULL,
    password VARCHAR NOT NULL,
    mobile INTEGER,
    nom VARCHAR,
    prenom VARCHAR,
    rle VARCHAR NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE
);

INSERT INTO "user" (username, email, password, rle, created_at)  VALUES ('admin','admin@epicevry.fr',  'root', 1,  NOW());
INSERT INTO "user" (username, email, password, rle, created_at)  VALUES ('mathieu', 'mathieutruc5@gmail.com',  'azerty', 0, NOW());
INSERT INTO "user" (username, email, password, rle, created_at)  VALUES ('bryan', 'bryanroy@outlook.fr',  'bryanroy', 0,  NOW());
INSERT INTO "user" (username, email, password, rle, created_at)  VALUES ('manal', 'manal@hotmail.com',  'manalkouri', 0, NOW());
INSERT INTO "user" (username, email, password, rle, created_at)  VALUES ('loic', 'loic@hotmail.com',  'loicmary', 0, NOW());
INSERT INTO "user" (username, email, password, rle, created_at)  VALUES ('cyrillignac', 'cyrilL@hotmail.fr',  'mdp', 0, NOW());

CREATE TYPE saison AS ENUM ('Hiver', 'Eté', 'Automne', 'Printemps');
CREATE TYPE type_al AS ENUM ('Fruit','Légume');

CREATE TABLE "aliment" (
    id_aliment SERIAL PRIMARY KEY,
        nom_aliment VARCHAR NOT NULL,
	    prix_aliment INTEGER NOT NULL,
	        stock_aliment INTEGER NOT NULL,
		    saison_aliment saison,
		        type_aliment type_al 
		    );


INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (1,'Tomates', 4, 50, 'Eté', 'Fruit');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (2,'Carottes', 1, 50, 'Hiver', 'Légume');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (3,'Navets', 2, 50, 'Hiver', 'Légume');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (4,'Oignons', 2, 50, 'Hiver', 'Légume');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (5,'Endives', 2, 50, 'Hiver', 'Légume');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (6,'Kakis', 4, 50, 'Hiver', 'Fruit');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (7,'Kiwis', 3, 50, 'Hiver', 'Fruit');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (8,'Pamplemousses', 3, 50, 'hiver', 'Fruit'); 
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (9,'Poires', 2, 50, 'Hiver', 'Fruit');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (10,'Pommes', 2, 50, 'Hiver', 'Fruit');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (11,'Bettraves', 2, 50, 'Hiver', 'Légume');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (12,'Oranges', 2, 50, 'Hiver', 'Fruit');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (13,'Bananes', 2, 50, 'Hiver', 'Fruit');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (14,'Asperges', 10, 50, 'Automne', 'Légume');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (15,'Radis', 5, 50, 'Automne', 'Légume');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (16,'Petits pois', 7, 50, 'Automne', 'Légume');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (17,'Poireaux', 2, 50, 'Automne', 'Légume');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (18,'Citrons', 6, 50, 'Automne', 'Fruit');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (19,'Aubergines', 3, 50, 'Automne', 'Légume');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (20,'Courgettes', 2, 50, 'Automne', 'Légume');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (21,'Cerises', 9, 50, 'Automne', 'Fruit');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (22,'Fraises', 8, 50, 'Automne', 'Fruit');
INSERT INTO "aliment" (id_aliment,nom_aliment, prix_aliment, stock_aliment, saison_aliment, type_aliment)  VALUES (23,'Goyaves', 10, 50, 'Eté', 'Fruit');



CREATE TABLE "commande" (
    id_commande SERIAL PRIMARY KEY,
        date_livraison DATE NOT NULL,
	    prix_total INTEGER NOT NULL,
	    userid INTEGER NOT NULL,
	    FOREIGN KEY (userID) REFERENCES  "user"(id)
	    );

INSERT INTO "commande" (date_livraison, prix_total, userid)  VALUES ('2020-05-03', 10, 2);
INSERT INTO "commande" (date_livraison, prix_total, userid)  VALUES ('2020-05-22', 12, 3);


CREATE TABLE "commande_contient" (
       id_commande INTEGER,
       id_aliment INTEGER,
       quantite INTEGER,
       PRIMARY KEY (id_commande, id_aliment),
       FOREIGN KEY (id_commande) REFERENCES "commande"(id_commande),
       FOREIGN KEY (id_aliment) REFERENCES "aliment"(id_aliment)
);

INSERT INTO "commande_contient" (id_commande, id_aliment, quantite) VALUES (1, 1, 3);
INSERT INTO "commande_contient" (id_commande, id_aliment, quantite) VALUES (1, 2, 5);
INSERT INTO "commande_contient" (id_commande, id_aliment, quantite) VALUES (1, 5, 1);
INSERT INTO "commande_contient" (id_commande, id_aliment, quantite) VALUES (2, 2, 2);


CREATE TYPE difficulte AS ENUM ('Facile','Intermédiaire','Difficile');

CREATE TABLE "recette" (
       id_recette SERIAL PRIMARY KEY,
       titre_recette VARCHAR NOT NULL,
       difficulte difficulte,
       tps_prep INTEGER NOT NULL,
       nb_pers INTEGER NOT NULL,
       preparation VARCHAR,
       id_auteur INTEGER NOT NULL,
       FOREIGN KEY (id_auteur) REFERENCES  "user"(id)
       );


INSERT INTO "recette" (titre_recette, difficulte, tps_prep, nb_pers, preparatIon, id_auteur) VALUES ('Salade composée', 'Facile',5,4,'1. Couper en dés la mozarella, les tomates, le jambon, les croutons, et ajoutez la mâche </br> 2. Ajoutez une vinaigrette à base dhuile de colza et de vin rouge', 2);
INSERT INTO "recette" (titre_recette, difficulte, tps_prep, nb_pers, preparatIon, id_auteur) VALUES ('Salade de tomate','Facile',5,4,'1.Laver la salade, couper les tomates,les oignons et la pomme 2.Egouttez la mozzarella <br> 3. Mélangez les ingrédients et assaisonnez avec de la vinaigrette <br>', 4);
INSERT INTO "recette" (titre_recette, difficulte, tps_prep, nb_pers, preparatIon, id_auteur) VALUES ('Gaspacho', 'Facile',15,4,'1. Rincer, sécher puis détailler les tomates en petits cubes et les verser dans un saladier. </br> 2. Assaisonner avec le sel, lhuile dolive, loignon ciselé et 3 feuilles de basilic. </br>3. Mixer au mixeur plongeant dans un récipient haut et profond (type verre doseur) pour éviter les projections de liquide ou idéalement au blender. </br> 4. Ciseler les 3 feuilles de basilic restantes. </br> 5. Répartir le gaspacho dans des verrines et décorer de basilic ciselé avant de servir.', 4);
INSERT INTO "recette" (titre_recette, difficulte, tps_prep, nb_pers, preparatIon, id_auteur) VALUES ('Pommes de terre au pesto rosso', 'Facile',30,2,'1. Préchauffez le four à 180°C. </br> 2. Lavez puis épluchez les pommes de terre. </br> 3. Coupez-les en rondelles pas trop fines. </br> 4. Dans un petit saladier, mélangez huile et pesto et ajoutez les rondelles de pommes de terre. </br> 5. Enrobez bien les pommes de terre puis déposez-les sur une plaque de cuisson. </br> 6. Faites cuire 20 à 25 minutes environ. Les pommes de terre doivent être bien tendres. ', 4);
INSERT INTO "recette" (titre_recette, difficulte, tps_prep, nb_pers, preparatIon, id_auteur) VALUES ('Gaspacho vert au concombre', 'Facile',10,2,'1. Rincez le concombre et coupez-le en morceaux. </br> 2. Mixez le concombre avec tous les ingrédients en ajoutant un peu de glaçons si besoin. </br> 3. Salez à votre goût.', 4);
INSERT INTO "recette" (titre_recette, difficulte, tps_prep, nb_pers, preparatIon, id_auteur) VALUES ('Brochettes de courgettes', 'Intermédiaire',20,4,'1. Dans un saladier, mélangez sirop , huile de sésame, sésame noir, sel et poivre. </br> 2. Sans les éplucher, coupez les courgettes dans la longueur puis dans la largeur en 4 parties de façon à obtenir des tronçons arrondis. </br> 3. Déposez les morceaux de courgettes dans le saladier, enrobez-les bien de la marinade et laissez mariner au moins 2 heures au réfrigérateur. </br> 4. Coupez les citrons confits en deux parties. </br> 5. Fabriquez les brochettes. Mettez un tronçon de courgette marinée puis un demi citron confit et continuez jusquà épuisement des ingrédients. 6. Disposez les brochettes sur le barbecue et laissez cuire une vingtaine de minutes. Vous pouvez également réaliser cette recette en faisant cuire les brochettes une dizaine de minutes dans un four préchauffé à 200°C.', 4);
INSERT INTO "recette" (titre_recette, difficulte, tps_prep, nb_pers, preparatIon, id_auteur) VALUES ('Crème de bettrave', 'Facile',15,4,'1. Dans un blender, mettez les betteraves, les noix de cajou trempées, rincées et égouttées, et le jus de citron. Mixez jusqu’à obtenir une texture crémeuse. </br> 2. Lavez le concombre et les pommes. Les couper en dés. </br>3. Dans des verrines, placez au fond des dès de concombre et de pomme. Ajoutez ensuite la crème de betterave. </br> 4. Coupez des lamelles de pomme verte pour les disposer au dessus. </br> 5. C’est prêt ! Bonne dégustation.', 4);
INSERT INTO "recette" (titre_recette, difficulte, tps_prep, nb_pers, preparatIon, id_auteur) VALUES ('Salade de fruits', 'Facile',15,8,'1. Pelez et coupez tous les fruits en morceaux et mettez-les dans un grand saladier. </br> 2. Faites votre jus en mélangeant dans un pichet sirop, sucre et eau. </br> 3. Versez ce mélange sur vos fruits, ajoutez les bâtons de cannelle et de vanille. </br> 4. Mettez au réfrigérateur minimum 2 h (plus vous la laisserez au frais, meilleure sera votre salade de fruits frais!). </br> 5. Bonne dégustation!', 4);





CREATE TABLE "utiliser" (
       id_recette INTEGER,
       id_aliment INTEGER,
       quantite INTEGER,
       PRIMARY KEY (id_recette , id_aliment),
       FOREIGN KEY (id_recette) REFERENCES "recette"(id_recette),
       FOREIGN KEY (id_aliment) REFERENCES "aliment"(id_aliment)     
);


INSERT INTO "utiliser" (id_recette, id_aliment, quantite) VALUES (1, 1, 100);
INSERT INTO "utiliser" (id_recette, id_aliment, quantite) VALUES (2, 1, 100);
INSERT INTO "utiliser" (id_recette, id_aliment, quantite) VALUES (2, 4, 100);
INSERT INTO "utiliser" (id_recette, id_aliment, quantite) VALUES (2, 10, 100);
INSERT INTO "utiliser" (id_recette, id_aliment, quantite) VALUES (3, 1, 800);
INSERT INTO "utiliser" (id_recette, id_aliment, quantite) VALUES (3, 4, 200);
INSERT INTO "utiliser" (id_recette, id_aliment, quantite) VALUES (6, 20, 600);
INSERT INTO "utiliser" (id_recette, id_aliment, quantite) VALUES (6, 18, 200);
INSERT INTO "utiliser" (id_recette, id_aliment, quantite) VALUES (7, 18, 100);
INSERT INTO "utiliser" (id_recette, id_aliment, quantite) VALUES (7, 10, 200);
INSERT INTO "utiliser" (id_recette, id_aliment, quantite) VALUES (7, 11, 500);
INSERT INTO "utiliser" (id_recette, id_aliment, quantite) VALUES (8, 13, 400);
INSERT INTO "utiliser" (id_recette, id_aliment, quantite) VALUES (8, 22, 250);
INSERT INTO "utiliser" (id_recette, id_aliment, quantite) VALUES (8, 7, 200);
INSERT INTO "utiliser" (id_recette, id_aliment, quantite) VALUES (8, 10, 300);
INSERT INTO "utiliser" (id_recette, id_aliment, quantite) VALUES (8, 12, 200);
