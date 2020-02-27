start:
	php -S localhost:8080 -t public/

db.init:
	createdb ensiie

db.drop:
	dropdb ensiie

db.reset: db.drop db.init
