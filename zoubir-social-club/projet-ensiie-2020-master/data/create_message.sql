CREATE TABLE message(
n_mess INTEGER,
content VARCHAR(200),
parution TIMESTAMP WITH TIME ZONE,
nb_like INTEGER
n_pers INTEGER CONSTRAINT nn_pers NOT NULL,
CONSTRAINT pk_mess PRIMARY KEY(n_mess),
CONSTRAINT ek_writer FOREIGN KEY (n_pers) REFERENCES personne(n_pers));