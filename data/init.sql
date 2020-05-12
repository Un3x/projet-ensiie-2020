--
--   Schéma de la Bdd, @see ../SchemaBdd.png
--

-- Année des vins
CREATE TABLE years (
	yid serial NOT NULL,
	year integer NOT NULL,
	tags text
);
ALTER TABLE years ADD CONSTRAINT yid_pk PRIMARY KEY(yid);

-- Domaine des vins
CREATE TABLE domains (
	did serial NOT NULL,
	name text NOT NULL,
	tags text
);
ALTER TABLE domains ADD CONSTRAINT did_pk PRIMARY KEY(did);

-- Type des vins
CREATE TABLE types (
	tid serial NOT NULL,
	name text NOT NULL,
	tags text
);
ALTER TABLE types ADD CONSTRAINT tid_pk PRIMARY KEY(tid);

-- Rôles des utilisateurs
CREATE TABLE roles (
	rid bit(10) NOT NULL,
	title text NOT NULL
);
ALTER TABLE roles ADD CONSTRAINT rid_pk PRIMARY KEY(rid);

-- Utilisateurs
CREATE TABLE users (
	uid serial NOT NULL,
	username text NOT NULL,
	email text NOT NULL,
	pwd text NOT NULL,
	created_at timestamp with time zone NOT NULL,
	role bit(10) NOT NULL DEFAULT B'0000000001',
	description text NOT NULL DEFAULT 'Je suis un random iien qui aime le grand vin'
);
ALTER TABLE users ADD CONSTRAINT uid_pk PRIMARY KEY(uid);
CREATE INDEX users_FK1 ON users (role);
ALTER TABLE users ADD CONSTRAINT FK_users_roles FOREIGN KEY (role) REFERENCES roles(rid) ON DELETE NO ACTION ON UPDATE NO ACTION;

-- Vin
CREATE TABLE wines (
	wid serial NOT NULL,
	name text NOT NULL,
	tid integer NOT NULL,
	yid integer NOT NULL,
	did integer NOT NULL,
	proposed_by integer NOT NULL,
	tags text,
	description text NOT NULL DEFAULT 'Ce vin a besoin d''une belle description qui permettra de le décrire avec précision'
);
ALTER TABLE wines ADD CONSTRAINT vid_pk PRIMARY KEY(wid);
CREATE INDEX wine_FK1 ON wines (tid);
CREATE INDEX wine_FK2 ON wines (yid);
CREATE INDEX wine_FK3 ON wines (did);
CREATE INDEX wine_FK4 ON wines (proposed_by);
ALTER TABLE wines ADD CONSTRAINT FK_wine_type FOREIGN KEY (tid) REFERENCES types(tid) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE wines ADD CONSTRAINT FK_wine_years FOREIGN KEY (yid) REFERENCES years(yid) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE wines ADD CONSTRAINT FK_wine_domains FOREIGN KEY (did) REFERENCES domains(did) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE wines ADD CONSTRAINT FK_wine_users FOREIGN KEY (proposed_by) REFERENCES users(uid) ON DELETE CASCADE ON UPDATE NO ACTION;

-- Vins favoris
CREATE TABLE favorites_wines (
	uid integer NOT NULL,
	wid integer NOT NULL
);
CREATE INDEX favorites_wines_FK1 ON favorites_wines (wid);
CREATE INDEX favorites_wines_FK2 ON favorites_wines (uid);
ALTER TABLE favorites_wines ADD CONSTRAINT widuid_pk PRIMARY KEY(uid,wid);
ALTER TABLE favorites_wines ADD CONSTRAINT FK_wines_favoritewines FOREIGN KEY (wid) REFERENCES wines(wid) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE favorites_wines ADD CONSTRAINT FK_users_favoriteswines FOREIGN KEY (uid) REFERENCES users(uid) ON DELETE CASCADE ON UPDATE NO ACTION;

-- Commentaires
CREATE TABLE comments (
	cid serial NOT NULL,
	uid integer NOT NULL,
	wid integer,
	did integer,
	yid integer,
	posted_at timestamp with time zone NOT NULL,
	tid integer,
	msg text NOT NULL,
	in_response_to integer
);
ALTER TABLE comments ADD CONSTRAINT cid_pk PRIMARY KEY(cid);
CREATE INDEX comments_FK1 ON comments (uid);
CREATE INDEX comments_FK2 ON comments (tid);
CREATE INDEX comments_FK3 ON comments (yid);
CREATE INDEX comments_FK4 ON comments (did);
CREATE INDEX comments_FK5 ON comments (wid);
CREATE INDEX comments_FK6 ON comments (in_response_to);
ALTER TABLE comments ADD CONSTRAINT FK_comments_users FOREIGN KEY (uid) REFERENCES users(uid) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE comments ADD CONSTRAINT FK_comments_wine FOREIGN KEY (wid) REFERENCES wines(wid) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE comments ADD CONSTRAINT FK_comments_years FOREIGN KEY (yid) REFERENCES years(yid) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE comments ADD CONSTRAINT FK_comments_domains FOREIGN KEY (did) REFERENCES domains(did) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE comments ADD CONSTRAINT FK_comments_type FOREIGN KEY (tid) REFERENCES types(tid) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE comments ADD CONSTRAINT FK_comments_comments FOREIGN KEY (in_response_to) REFERENCES comments(cid) ON DELETE CASCADE ON UPDATE NO ACTION;

-- On gère les likes pour les commentaires
CREATE TABLE comment_likes (
	cid integer NOT NULL,
	uid integer NOT NULL
);
ALTER TABLE comment_likes ADD CONSTRAINT ciduid_pk PRIMARY KEY(uid,cid);
CREATE INDEX comment_likes_FK1 ON comment_likes (cid);
CREATE INDEX comment_likes_FK2 ON comment_likes (uid);
ALTER TABLE comment_likes ADD CONSTRAINT FK_comments_comment_likes FOREIGN KEY (cid) REFERENCES comments(cid) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE comment_likes ADD CONSTRAINT FK_users_comment_likes FOREIGN KEY (uid) REFERENCES users(uid) ON DELETE CASCADE ON UPDATE NO ACTION;

-- Insertion des différents rôles
INSERT INTO roles (rid, title) VALUES (B'0000000001', 'Utilisateur');
INSERT INTO roles (rid, title) VALUES (B'0000000010', 'Administrateur');

-- Insertion des users de base
INSERT INTO users (username, email, pwd, created_at, role)  VALUES ('nitorac', 'nitorac@oenologiie.iiens.net', '$2y$11$u5/7Ke2OS4d7gO67j7tipuDNzbPvD1UAji0SA.CudGoY8S0eT4rQy', NOW(), B'0000000010');
INSERT INTO users (username, email, pwd, created_at)  VALUES ('bleh', 'bleh@oenologiie.iiens.net', '$2y$11$u5/7Ke2OS4d7gO67j7tipuDNzbPvD1UAji0SA.CudGoY8S0eT4rQy', NOW());
INSERT INTO users (username, email, pwd, created_at)  VALUES ('noctali', 'noctali@oenologiie.iiens.net', '$2y$11$u5/7Ke2OS4d7gO67j7tipuDNzbPvD1UAji0SA.CudGoY8S0eT4rQy', NOW());
INSERT INTO users (username, email, pwd, created_at)  VALUES ('inako', 'inako@oenologiie.iiens.net', '$2y$11$u5/7Ke2OS4d7gO67j7tipuDNzbPvD1UAji0SA.CudGoY8S0eT4rQy', NOW());

-- Insertion des domaines
INSERT INTO domains (name, tags) VALUES ('Domaine inconnu', '');
INSERT INTO domains (name, tags) VALUES ('Cosse Maisonneuve', '');
INSERT INTO domains (name, tags) VALUES ('L''Ancienne Cure', '');
INSERT INTO domains (name, tags) VALUES ('Setubal', '');
INSERT INTO domains (name, tags) VALUES ('Riesling', '');
INSERT INTO domains (name, tags) VALUES ('Médoc', '');
INSERT INTO domains (name, tags) VALUES ('Domaine Guilhem', '');
INSERT INTO domains (name, tags) VALUES ('Poudlard', '');

-- Insertion des années
INSERT INTO years (year, tags) VALUES ('2001', '');
INSERT INTO years (year, tags) VALUES ('2002', '');
INSERT INTO years (year, tags) VALUES ('2003', '');
INSERT INTO years (year, tags) VALUES ('2004', '');
INSERT INTO years (year, tags) VALUES ('2005', '');
INSERT INTO years (year, tags) VALUES ('2006', '');
INSERT INTO years (year, tags) VALUES ('2007', '');
INSERT INTO years (year, tags) VALUES ('2008', '');
INSERT INTO years (year, tags) VALUES ('2009', '');
INSERT INTO years (year, tags) VALUES ('2010', '');
INSERT INTO years (year, tags) VALUES ('2011', '');
INSERT INTO years (year, tags) VALUES ('2012', '');
INSERT INTO years (year, tags) VALUES ('2013', '');
INSERT INTO years (year, tags) VALUES ('2014', '');
INSERT INTO years (year, tags) VALUES ('2015', '');
INSERT INTO years (year, tags) VALUES ('2016', '');
INSERT INTO years (year, tags) VALUES ('2017', '');
INSERT INTO years (year, tags) VALUES ('2018', '');
INSERT INTO years (year, tags) VALUES ('2019', '');
INSERT INTO years (year, tags) VALUES ('2010', '');

-- Insertion des types
INSERT INTO types (name, tags) VALUES ('Rouge', '');
INSERT INTO types (name, tags) VALUES ('Blanc', '');
INSERT INTO types (name, tags) VALUES ('Rosé', '');

-- Insertion des vins

INSERT INTO wines (name, tid, yid, did, proposed_by, tags) VALUES ('Moscatel de Setubal', 2, 16, 4, 4, 'Tendre, fin');
INSERT INTO wines (name, tid, yid, did, proposed_by, tags) VALUES ('Riesling Blanc', 2, 16, 5, 3, 'Agréable');
INSERT INTO wines (name, tid, yid, did, proposed_by, tags, description) VALUES ('Marquis de Riba', 1, 16, 6, 2, '', 'bio c bon');
INSERT INTO wines (name, tid, yid, did, proposed_by, tags, description) VALUES ('Pot de Vin', 1, 17, 7, 1, '', 'bio c bon');
INSERT INTO wines (name, tid, yid, did, proposed_by, tags, description) VALUES ('Sang Mêlé', 1, 15, 8, 4, '', 'Dobby est un elfe ivre');
INSERT INTO wines (name, tid, yid, did, proposed_by, tags) VALUES ('Villa de Cocagne', 1, 15, 1, 3, '');
INSERT INTO wines (name, tid, yid, did, proposed_by, tags) VALUES ('Château de Nalys', 1, 17, 1, 2, '');
INSERT INTO wines (name, tid, yid, did, proposed_by, tags) VALUES ('Mirabeau en Provence', 1, 15, 1, 4, '');
INSERT INTO wines (name, tid, yid, did, proposed_by, tags) VALUES ('Vaison la Romaine', 1, 15, 1, 1, '');
INSERT INTO wines (name, tid, yid, did, proposed_by, tags) VALUES ('Eloge', 2, 16, 1, 1, '');
INSERT INTO wines (name, tid, yid, did, proposed_by, tags, description) VALUES ('Tentation de Parazols', 1, 16, 1, 3, '', 'Soyez coquins');
INSERT INTO wines (name, tid, yid, did, proposed_by, tags) VALUES ('Grand Marrenon', 2, 18, 1, 2, '');
INSERT INTO wines (name, tid, yid, did, proposed_by, tags) VALUES ('Chateau Romanin', 1, 18, 1, 2, '');

-- Insertion de commentaires
INSERT INTO comments (uid, wid, did, yid, tid, posted_at, msg, in_response_to) VALUES (1, 1, null, null, null, '2020-05-01 20:30:05', 'J''adore ce vin !', null);
INSERT INTO comments (uid, wid, did, yid, tid, posted_at, msg, in_response_to) VALUES (1, 1, null, null, null, '2020-05-01 20:33:05', 'J''adore vraiment ce vin !', null);
INSERT INTO comments (uid, wid, did, yid, tid, posted_at, msg, in_response_to) VALUES (2, 2, null, null, null, '2020-04-25 09:15:58', 'Ca va toi ?', null);
INSERT INTO comments (uid, wid, did, yid, tid, posted_at, msg, in_response_to) VALUES (3, 2, null, null, null, '2020-04-30 09:16:04', 'Nikel et toi ?', 3);
INSERT INTO comments (uid, wid, did, yid, tid, posted_at, msg, in_response_to) VALUES (1, 2, null, null, null, '2020-04-26 16:16:04', 'Et moi aussi !', 3);
INSERT INTO comments (uid, wid, did, yid, tid, posted_at, msg, in_response_to) VALUES (4, 2, null, null, null, '2020-04-26 16:16:04', 'Ce vin est bon !', null);

-- Insertion de likes
INSERT INTO comment_likes (cid, uid) VALUES (5, 1);
INSERT INTO comment_likes (cid, uid) VALUES (5, 2);
INSERT INTO comment_likes (cid, uid) VALUES (5, 3);
INSERT INTO comment_likes (cid, uid) VALUES (6, 4);
