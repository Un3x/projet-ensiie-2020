
CREATE TABLE personne(
n_pers SERIAL PRIMARY KEY,
mail VARCHAR(50),
nom VARCHAR(30),
prenom VARCHAR(30),
pseudo VARCHAR(30),
d_inscri TIMESTAMP WITH TIME ZONE,
birth DATE,
password VARCHAR(20),
pays VARCHAR(20),
is_admin INTEGER
);

CREATE TABLE message(
n_mess SERIAL PRIMARY KEY,
content VARCHAR(200),
parution TIMESTAMP WITH TIME ZONE,
nb_like INTEGER,
n_pers INTEGER, CONSTRAINT pk_writer FOREIGN KEY (n_pers) 
                                    REFERENCES personne(n_pers) ON DELETE CASCADE,
is_comment INTEGER );

CREATE TABLE abonnement(
n_abo SERIAL PRIMARY KEY,
n_pers1 INTEGER,
n_pers2 INTEGER
);

CREATE TABLE liker(
n_like SERIAL PRIMARY KEY,
n_pers INTEGER,
n_mess INTEGER, 
FOREIGN KEY (n_pers) REFERENCES personne(n_pers) ON DELETE CASCADE,
FOREIGN KEY (n_mess) REFERENCES message(n_mess) ON DELETE CASCADE );


INSERT INTO "personne" (mail,
                        nom,
                        prenom,
                        pseudo,
                        d_inscri,
                        birth,
                        password,
                        pays,
                        is_admin) 
                        VALUES ('tochon.martin@gmail.com',
                                'TOCHON',
                                'Martin',
                                'MTN',
                                NOW(),
                                '1999-02-27',
                                'martin68720'
                                ,'Alsace'
                                , 1) ;


INSERT INTO "personne" (mail,
                        nom,
                        prenom,
                        pseudo,
                        d_inscri,
                        birth,
                        password,
                        pays,
                        is_admin) 
                VALUES ('benoitgeendre@outlook.fr',
                        'GENDRE',
                        'Benoît',
                        'Vendri',
                        NOW(),
                        '2000-01-13',
                        'bigshaq',
                        'France',
                        1) ;
                        

INSERT INTO "message" (content, parution , nb_like , n_pers , is_comment) 
               VALUES ('Bonjour à tous, je vous souhaite bonheur et prospérité',
                       NOW(),
                       0,
                       2,
                       0) ;
