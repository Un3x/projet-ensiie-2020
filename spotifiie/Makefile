start:
	php -S localhost:8081 -t ./

db.init:
	createdb spotif
	psql -U rachid -d spotif -a -f adoDB/init.sql

db.drop:
	dropdb spotif

db.reset: db.drop db.init
