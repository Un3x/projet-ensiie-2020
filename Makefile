
export PGPASSWORD=ensiie

start:
	php -S localhost:8080 -t public/

db.init:
	createdb toraux
	psql toraux -h localhost toraux < data/toraux.sql

db.drop:
	dropdb toraux

db.reset:
	dropdb toraux
	createdb toraux
	psql toraux -h localhost  toraux < data/toraux.sql

