start:
	php -S localhost:8080 -t public/

db.init:
	createdb DB
	psql -U DB -d DB -a -f src/init.sql

db.drop:
	dropdb MyM

db.reset: db.drop db.init
