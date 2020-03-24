CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    username VARCHAR NOT NULL,
    email VARCHAR NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE
);


CREATE TABLE "Association"(
	Id_Assoc VARCHAR PRIMARY KEY,
);

CREATE TABLE "Reunion"(
	Id_Assoc VARCHAR NOT NULL,
	Id_reu VARCHAR PRIMARY KEY,
	Date_reu date NOT NULL,
	Horaire TIMESTAMP
);

CREATE TABLE "Participer"(
	
);





INSERT INTO "user" (username, email, created_at)  VALUES ('unex', 'patati@patata.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('caillou', 'caillou@rocher.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('viteira', 'vivi@taira.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('césar', 'jule@cesar.com', NOW());
INSERT INTO "user" (username, email, created_at)  VALUES ('gengis', 'gengis@khan.com', NOW());