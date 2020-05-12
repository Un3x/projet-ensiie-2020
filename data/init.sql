DROP TABLE IF EXISTS "feed";
DROP TABLE IF EXISTS "like";
DROP TABLE IF EXISTS "follow";
DROP TABLE IF EXISTS "tweet";
DROP TABLE IF EXISTS "user";
DROP TABLE IF EXISTS "hashtag";


CREATE TABLE "user" (
    username VARCHAR PRIMARY KEY,
    password VARCHAR(20) NOT NULL,
    email VARCHAR NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE
);

CREATE TABLE "tweet" (
    id_tweet SERIAL PRIMARY KEY,
    content VARCHAR(280),
    written_at TIMESTAMP WITH TIME ZONE,
    is_answer BOOL,
    nblike INT DEFAULT 0,
    author VARCHAR REFERENCES "user" ON DELETE CASCADE
);


CREATE TABLE "follow" (
    followed VARCHAR REFERENCES "user" ON DELETE CASCADE,
    follower VARCHAR REFERENCES "user"ON DELETE CASCADE ,
    PRIMARY KEY (follower, followed)
);


CREATE TABLE "like" (
    id_tweet INT REFERENCES "tweet" ON DELETE CASCADE,
    username VARCHAR REFERENCES "user" ON DELETE CASCADE,
    PRIMARY KEY (username, id_tweet)
);

CREATE TABLE "feed" (
    id_tweet INT REFERENCES "tweet" ON DELETE CASCADE,
    username VARCHAR REFERENCES "user" ON DELETE CASCADE,
    PRIMARY KEY (id_tweet,username)
);

CREATE TABLE "hashtag" (
    id_hashtag SERIAL PRIMARY KEY,
    name VARCHAR NOT NULL
);


INSERT INTO "user" (username, password, email, created_at)  VALUES ('unex', 'mdp', 'patati@patata.com', NOW());
INSERT INTO "user" (username, password, email, created_at)  VALUES ('caillou', 'mdp', 'caillou@rocher.com', NOW());
INSERT INTO "user" (username, password, email, created_at)  VALUES ('viteira', 'mdp', 'vivi@taira.com', NOW());
INSERT INTO "user" (username, password, email, created_at)  VALUES ('césar', 'mdp', 'jule@cesar.com', NOW());
INSERT INTO "user" (username, password, email, created_at)  VALUES ('gengis', 'mdp', 'gengis@khan.com', NOW());

INSERT INTO "follow" VALUES ('unex','viteira');
INSERT INTO "follow" VALUES ('viteira','unex');
INSERT INTO "follow" VALUES ('caillou','unex');

INSERT INTO "tweet" (content,written_at,is_answer,author) VALUES ('Bonjour tour le monde !',NOW(),false,'unex');
INSERT INTO "tweet" (content,written_at,is_answer,author) VALUES ('Ceci est un message de test',NOW(),false,'unex');
INSERT INTO "tweet" (content,written_at,is_answer,author) VALUES ('Bonjour unex !',NOW(),false,'viteira');
