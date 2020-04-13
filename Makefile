start:
	php -S localhost:8080 -t public/

db.init:
	createdb ensiie
	psql -U ensiie -h 127.0.0.1 -a -f data/init.sql

db.drop:
	dropdb ensiie

db.reset: db.drop db.init
