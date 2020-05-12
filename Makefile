all: clearCache start

sass:
	sass public/assets/sass/bootstrap-addons.scss:public/assets/css/bootstrap-addons.css

start:
	php -S localhost:8080 -t public/ ./server.php

db.init:
	createdb ensiie
	psql -U ensiie -d ensiie -a -f data/init.sql

db.drop:
	dropdb ensiie

db.reset: db.drop db.init

clearCache:
	rm -rf ./cache/*
