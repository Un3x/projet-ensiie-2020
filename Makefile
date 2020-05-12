start:
	php -S localhost:8080 -t projet/views/accueil.php

db.init:
	createdb MyM
	psql -U postgres -d MyM -a -f data/init.sql

db.drop:
	dropdb MyM

db.reset: db.drop db.init
