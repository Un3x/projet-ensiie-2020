start:
	php -S localhost:8080

db.init:
	createdb ensiie -U postgres
	psql -U postgres -d ensiie -a -f data/init.sql

db.drop:
	dropdb -U postgres ensiie

db.reset: db.drop db.init
