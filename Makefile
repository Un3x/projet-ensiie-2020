clstart:
	php -S localhost:8080 -t public/

db.init:
	createdb allez-retour
	psql -U postgres -d allez-retour -a -f data/init.sql

db.drop:
	dropdb allez-retour

db.reset: db.drop db.init