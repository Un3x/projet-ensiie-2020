INSERT INTO utilisateur VALUES ('defaut0000', 'Défaut', 'Foo', 'Bar', 'admin');
\copy chanson(nom, artiste, paroles, id_utilisateur) FROM 'fill_chanson.csv' WITH DELIMITER AS ','
\copy lien(lien, type_lien, id_chanson) FROM 'fill_lien.csv' WITH DELIMITER AS ','
INSERT INTO soiree VALUES(1, 'Test', 'Super thème', '2020-04-18', 'TRUE');
INSERT INTO chanson_soiree(id_chanson, id_soiree) VALUES(2, 1);
INSERT INTO chanson_soiree(id_chanson, id_soiree) VALUES(3, 1);
