CREATE TABLE personne(
n_pers INTEGER SERIAL PRIMARY KEY,
mail VARCHAR(50),
nom VARCHAR(30),
prenom VARCHAR(30),
pseudo VARCHAR(30),
d_inscri TIMESTAMP WITH TIME ZONE,
birth DATE,
password VARCHAR(20),
pays VARCHAR(20)
);

INSERT INTO "personne" (mail,nom,prenom,pseudo,d_inscri,birth,password,pays) VALUES ("tochon.martin@gmail.com","TOCHON","Martin","MTN",NOW(),"1999-02-27","martin68720","France") ;


INSERT INTO "personne" (mail,nom,prenom,pseudo,d_inscri,birth,password,pays) VALUES ("benoitgeendre@outlook.fr","GENDRE","Benoît","Vendri",NOW(),"2000-01-13","bigshaq","France") ;

