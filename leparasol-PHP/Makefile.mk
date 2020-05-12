start:
php -S localhost:8080 -t index.php

db.init:
createdb LeParasol
psql -U postgres -d LeParasol -a -f createtables.sql

db.drop:
	dropdb LeParasol

db.reset: db.drop db.init
