CREATE TABLE "utilisateurs" (
  id SERIAL PRIMARY KEY,
  login VARCHAR NOT NULL,
  mdp VARCHAR NOT NULL,
  nom VARCHAR NOT NULL,
  prenom VARCHAR NOT NULL,
  naissance DATE NOT NULL,
	admin INT DEFAULT NULL,
	promotion INT NOT NULL,
	email VARCHAR NOT NULL
);

INSERT INTO "utilisateurs" (login, mdp, nom, prenom, naissance, admin, promotion, email)  VALUES ('alice', '663194f2b9123a38cd9e2e2811f8d2fd387b765e', 'alice', 'alice', '1999-02-09', 0, 2022, 'alice@gmail.com');
INSERT INTO "utilisateurs" (login, mdp, nom, prenom, naissance, admin, promotion, email)  VALUES ('bob', '9cc140dd813383e134e7e365b203780da9376438', 'bob', 'bob', '2020-02-05', 0, 2021, 'bob@gmail.com');
INSERT INTO "utilisateurs" (login, mdp, nom, prenom, naissance, admin, promotion, email)  VALUES ('rachid', '7c9347785d925939cd541fcccae361d3a536b186', 'rachid', 'rachid', '1998-07-05', 0, 2022, 'rachid.krita@ensiie.fr');
-- --------------------------------------------------------
--
-- Structure de la table "assos"
--

CREATE TABLE "assos" (
	asso VARCHAR NOT NULL
);

--
-- Déchargement des données de la table "assos"
--

INSERT INTO "assos" (asso) VALUES ('Muzzik');
INSERT INTO "assos" (asso) VALUES ('Dansiie');
INSERT INTO "assos" (asso) VALUES ('NightIIE');
INSERT INTO "assos" (asso) VALUES ('HumanIIE');
INSERT INTO "assos" (asso) VALUES ('autre');

-- --------------------------------------------------------
--
-- Structure de la table "commentaires"
--


CREATE TABLE "commentaires" (
	id SERIAL PRIMARY KEY,
	id_musique INT NOT NULL,
  auteur VARCHAR NOT NULL,
  texte VARCHAR NOT NULL,
  date_ajout TIMESTAMP WITH TIME ZONE
); /*ENGINE=InnoDB DEFAULT CHARSET=utf8;*/


-- --------------------------------------------------------
--
-- Structure de la table "musiques"
--

CREATE TABLE "musiques" (
  id SERIAL PRIMARY KEY,
  titre VARCHAR NOT NULL,
  auteur VARCHAR NOT NULL,
  date_ajout TIMESTAMP WITH TIME ZONE,
  annee_ado INT NOT NULL,
  asso VARCHAR NOT NULL
); /*ENGINE=InnoDB DEFAULT CHARSET=utf8;*/

--
-- Déchargement des données de la table "musiques"
--

INSERT INTO "musiques" (id, titre, auteur, date_ajout, annee_ado, asso) VALUES (1, 'Back in Black', 'alice', '2020-04-29 09:53:23', 2020, 'NightIIE');
INSERT INTO "musiques" (id, titre, auteur, date_ajout, annee_ado, asso) VALUES(2, 'Adventure of a Lifetime', 'alice', '2020-04-29 09:53:27', 2020, 'NightIIE');
INSERT INTO "musiques" (id, titre, auteur, date_ajout, annee_ado, asso) VALUES(3, 'Abidjan farot', 'alice', '2020-04-29 09:54:25', 2020, 'HumanIIE');
INSERT INTO "musiques" (id, titre, auteur, date_ajout, annee_ado, asso) VALUES(4, 'Ain t nobody', 'alice', '2020-04-29 09:59:50', 2020, 'NightIIE');
INSERT INTO "musiques" (id, titre, auteur, date_ajout, annee_ado, asso) VALUES(5, '4 saisons', 'alice', '2020-05-04 00:00:00', 2020, 'Muzzik');
INSERT INTO "musiques" (id, titre, auteur, date_ajout, annee_ado, asso) VALUES(6, 'Aimer à perdre la raison', 'alice', '2020-05-04 10:23:45', 2020, 'Muzzik');
INSERT INTO "musiques" (id, titre, auteur, date_ajout, annee_ado, asso) VALUES(7, 'Roxanne', 'alice', '2020-05-05 03:12:09', 2020, 'NightIIE');
INSERT INTO "musiques" (id, titre, auteur, date_ajout, annee_ado, asso) VALUES(8, 'Gum Boy', 'alice', '2020-02-10 00:00:00', 2020, 'Dansiie');
INSERT INTO "musiques" (id, titre, auteur, date_ajout, annee_ado, asso) VALUES(16, '300 Violin Orchestra', 'alice', '2020-05-05 03:12:09', 2020, 'Dansiie');
INSERT INTO "musiques" (id, titre, auteur, date_ajout, annee_ado, asso) VALUES(17, 'Aïcha', 'alice', '2020-05-04 10:23:45', 2020, 'Muzzik');
INSERT INTO "musiques" (id, titre, auteur, date_ajout, annee_ado, asso) VALUES(18, '2001 : A spacee Odyssey', 'alice', '2020-05-05 02:41:32', 2020, 'autre');
INSERT INTO "musiques" (id, titre, auteur, date_ajout, annee_ado, asso) VALUES(19, '#SELFIE', 'alice', '2020-05-05 02:41:50', 2020, 'autre');
INSERT INTO "musiques" (id, titre, auteur, date_ajout, annee_ado, asso) VALUES(20, 'About Today', 'alice', '2020-04-29 09:59:50', 2020, 'NightIIE');
INSERT INTO "musiques" (id, titre, auteur, date_ajout, annee_ado, asso) VALUES(21, 'Ain t your mama', 'alice', '2020-05-04 10:23:45', 2020, 'Dansiie');

-- --------------------------------------------------------

--
-- Structure de la table "musiquesdansplaylist"
--

CREATE TABLE "musiquesdansplaylist" (
  id_playlist INT NOT NULL,
  id_musique INT NOT NULL,
  date TIMESTAMP WITH TIME ZONE
); /*ENGINE=InnoDB DEFAULT CHARSET=utf8;*/

--
-- Déchargement des données de la table "musiquesdansplaylist"
--

INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (2, 8, '2020-02-25 02:29:08');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (2, 7, '2020-02-25 02:29:25');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (2, 3, '2020-02-25 02:29:29');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (1, 2, '2020-02-25 02:37:46');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (9, 3, '2020-02-25 03:08:53');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (9, 6, '2020-02-25 03:08:57');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (9, 16, '2020-02-25 03:09:02');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (8, 3, '2020-02-25 03:09:15');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (8, 7, '2020-02-25 03:09:21');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (8, 16, '2020-02-25 03:09:27');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (7, 8, '2020-02-25 03:12:06');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (7, 17, '2020-02-25 03:12:11');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (6, 19, '2020-02-25 03:12:21');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (6, 21, '2020-02-25 03:12:27');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (5, 1, '2020-02-25 03:12:44');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (5, 5, '2020-02-25 03:12:51');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (4, 1, '2020-02-25 03:13:00');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (4, 6, '2020-02-25 03:13:04');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (4, 8, '2020-02-25 03:13:09');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (4, 17, '2020-02-25 03:13:14');
INSERT INTO "musiquesdansplaylist" (id_playlist, id_musique, date) VALUES (4, 20, '2020-02-25 03:13:20');


-- --------------------------------------------------------

--
-- Structure de la table "playlists"
--

CREATE TABLE "playlists" (
  id SERIAL PRIMARY KEY,
  titre VARCHAR NOT NULL,
  auteur VARCHAR NOT NULL,
  date_creation TIMESTAMP WITH TIME ZONE
); /*ENGINE=InnoDB DEFAULT CHARSET=utf8;*/

--
-- Déchargement des données de la table "playlists"
--

INSERT INTO "playlists" ( titre, auteur, date_creation) VALUES ( 'favoris', 'bob', '2020-04-25 02:25:56');
INSERT INTO "playlists" ( titre, auteur, date_creation) VALUES ( 'Playlist du matin', 'bob', '2020-04-25 02:28:52');
INSERT INTO "playlists" ( titre, auteur, date_creation) VALUES ( 'Playlist du soir', 'bob', '2020-04-25 02:42:09');
INSERT INTO "playlists" ( titre, auteur, date_creation) VALUES ( 'favoris', 'alice', '2020-04-25 03:05:11');
INSERT INTO "playlists" ( titre, auteur, date_creation) VALUES ( 'Playlist douche', 'alice', '2020-04-25 03:05:44');
INSERT INTO "playlists" ( titre, auteur, date_creation) VALUES ( 'Playlist yoga', 'alice', '2020-04-25 03:07:41');
INSERT INTO "playlists" ( titre, auteur, date_creation) VALUES ( 'Playlist rock', 'alice', '2020-04-25 03:08:00');
INSERT INTO "playlists" ( titre, auteur, date_creation) VALUES ( 'Playlist fête', 'alice', '2020-04-25 03:08:28');
INSERT INTO "playlists" ( titre, auteur, date_creation) VALUES ( 'Playlist voiture', 'alice', '2020-04-25 03:08:44');




