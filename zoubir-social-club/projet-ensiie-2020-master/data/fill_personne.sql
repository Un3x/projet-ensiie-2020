
\copy personne FROM '/zoubir-social-club/projet-ensiie-2020-master/data/create_epersonne.sql' 

INSERT INTO "personne" (mail,nom,prenom,pseudo,d_inscri,birth,password,pays) VALUES ("tochon.martin@gmail.com","TOCHON","Martin","MTN",NOW(),"2020-03-31","martin68720","France") ;


INSERT INTO "personne" (mail,nom,prenom,pseudo,d_inscri,birth,password,pays) VALUES ("benoitgeendre@outlook.fr","GENDRE","Benoît","Vendri",NOW(),"2020-03-31","bigshaq","France") ;
