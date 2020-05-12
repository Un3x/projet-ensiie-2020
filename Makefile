start:
	php -S localhost:8080 -t public/

db.init:
	createdb -U corsaire -W corsaire
	psql -U corsaire -W -d corsaire -a -f data/init.sql

db.drop:
	dropdb -U corsaire -W corsaire

db.reset: db.drop db.init

doc:
	doxygen
