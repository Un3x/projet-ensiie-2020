CREATE TABLE "user" (
    username VARCHAR PRIMARY KEY NOT NULL,
    user_password VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE,
    is_admin BOOLEAN DEFAULT FALSE
);

CREATE TABLE "Interest"(
    theme VARCHAR PRIMARY KEY NOT NULL,
    subscribers INTEGER
);

CREATE TABLE "Interested"(
    username VARCHAR,
    theme VARCHAR,
    FOREIGN KEY (username) REFERENCES "user"(username),
    FOREIGN KEY (theme) REFERENCES "Interest"(theme)
);
CREATE TABLE "Events"(
    id_events SERIAL PRIMARY KEY,
    id_interest INTEGER,
    time_event TIMESTAMP WITH TIME ZONE
);

CREATE TABLE "Group"(
    id_group SERIAL PRIMARY KEY,
    group_owner INTEGER,
    id INTEGER,
    name_group VARCHAR NOT NULL,
    number_member INTEGER
);

CREATE TABLE "Follow"(
    user_followed VARCHAR,
    user_following VARCHAR,
    FOREIGN KEY (user_followed) REFERENCES "user"(username),
    FOREIGN KEY (user_following) REFERENCES "user"(username)
);

CREATE TABLE "Post"(
    id_post SERIAL PRIMARY KEY,
    author VARCHAR NOT NULL,
    post_content VARCHAR NOT NULL,
    theme VARCHAR NOT NULL DEFAULT 'Aucun',
    created_at TIMESTAMP WITH TIME ZONE,
    FOREIGN KEY (author) REFERENCES "user"(username),
    FOREIGN KEY (theme) REFERENCES "Interest"(theme)
);

CREATE TABLE "Like"(
    username VARCHAR NOT NULL,
    id_post INT NOT NULL,
    FOREIGN KEY (username) REFERENCES "user"(username),
    FOREIGN KEY (id_post) REFERENCES "Post"(id_post)
);

CREATE TABLE "Comment" (
    id_comment SERIAL PRIMARY KEY,
    id_post INT NOT NULL,
    author VARCHAR NOT NULL,
    content VARCHAR NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE,
    FOREIGN KEY (id_post) REFERENCES "Post"(id_post),
    FOREIGN KEY (author) REFERENCES "user"(username)
);

CREATE TABLE "Message" (
    id_message SERIAL PRIMARY KEY,
    sender VARCHAR NOT NULL,
    receiver VARCHAR NOT NULL,
    content VARCHAR NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE,
    FOREIGN KEY (sender) REFERENCES "user"(username),
    FOREIGN KEY (receiver) REFERENCES "user"(username)
);

INSERT INTO "user" (username, user_password, email, created_at)  VALUES ('unex','unex', 'patati@patata.com', clock_timestamp());
INSERT INTO "user" (username, user_password, email, created_at)  VALUES ('caillou','caillou', 'caillou@rocher.com', clock_timestamp());
INSERT INTO "user" (username, user_password, email, created_at)  VALUES ('viteira','viteira', 'vivi@taira.com', clock_timestamp());
INSERT INTO "user" (username, user_password, email, created_at)  VALUES ('césar','césar', 'jule@cesar.com', clock_timestamp());
INSERT INTO "user" (username, user_password, email, created_at)  VALUES ('gengis','gengis', 'gengis@khan.com', clock_timestamp());
INSERT INTO "user" (username, user_password, email, created_at, is_admin)  VALUES ('admin','admin', 'admin@admin.com', clock_timestamp(),TRUE);
INSERT INTO "Interest" (Subscribers,theme) VALUES (0,'Développement');
INSERT INTO "Interest" (Subscribers,theme) VALUES (0,'Sport');
INSERT INTO "Interest" (Subscribers,theme) VALUES (0,'Politique et société');
INSERT INTO "Interest" (Subscribers,theme) VALUES (0,'Jeux de société');
INSERT INTO "Interest" (Subscribers,theme) VALUES (0,'Jeux vidéos');
INSERT INTO "Interest" (Subscribers,theme) VALUES (0,'Cinéma');
INSERT INTO "Interest" (Subscribers,theme) VALUES (0,'Art');
INSERT INTO "Interest" (Subscribers,theme) VALUES (0,'Musique');
INSERT INTO "Interest" (Subscribers,theme) VALUES (0,'Littérature');
INSERT INTO "Interest" (Subscribers,theme) VALUES (0,'Sciences et technologie');
INSERT INTO "Interest" (Subscribers,theme) VALUES (0,'Théâtre et comédie');
INSERT INTO "Interest" (Subscribers,theme) VALUES (0,'Divers');
INSERT INTO "Interest" (Subscribers,theme) VALUES (0,'Aucun');