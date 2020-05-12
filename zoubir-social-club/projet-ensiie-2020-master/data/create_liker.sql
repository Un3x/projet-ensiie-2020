
CREATE TABLE liker(
n_pers INTEGER PRIMARY KEY,
n_mess INTEGER PRIMARY KEY,
CONSTRAINT nn_pers FOREIGN KEY (n_pers) REFERENCES personne(n_pers),
CONSTRAINT nn_mess FOREIGN KEY (n_mess) REFERENCES message(n_mess));

