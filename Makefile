start:
	php -S localhost:8080 -t projet/views/accueil.php

db.init:
	createdb ensiie
	psql -U ensiie -d ensiie -a -f data/init.sql

db.drop:
	dropdb MyM

db.reset: db.drop db.init
