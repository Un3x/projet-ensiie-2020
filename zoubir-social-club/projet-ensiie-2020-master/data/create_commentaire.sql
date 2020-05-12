
CREATE TABLE commentaire(
n_comm INTEGER PRIMARY KEY,
n_mess INTEGER PRIMARY KEY,
content VARCHAR,
CONSTRAINT nn_mess FOREIGN KEY (n_mess) REFERENCES message(n_mess));
