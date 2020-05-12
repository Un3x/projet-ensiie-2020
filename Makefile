host := 127.0.0.1
port := 8080
dbname := joueurs
user := groupe12
password := "Pw8f87mvkeoFHBxuRqMpkNvFTrMDE"

psqlconnect := -h $(host)

socket_server.start:
	php src/Server/socket_server.php

start:
	php -S $(host):$(port) -t public

db.init:
	PGPASSWORD=$(password) createdb $(psqlconnect) $(dbname) -U $(user)
	PGPASSWORD=$(password) psql $(psqlconnect) -U $(user) -d $(dbname) -a -f data/init.sql

db.drop:
	PGPASSWORD=$(password) dropdb $(psqlconnect) $(dbname) -U $(user)

db.reset: db.drop db.init

user.drop:
	dropuser $(psqlconnect) groupe12 -U postgres

user.init:
	psql $(psqlconnect) -U postgres -a -f data/user-init.sql

user.reset: db.drop user.drop user.init db.init
