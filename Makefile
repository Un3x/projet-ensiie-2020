start:
	php -S localhost:8080 -t public/

db.init:
	createdb vocasiite
	psql -d vocasiite -c '\cd data' -f create_base.sql -f fill.sql \
	-c 'GRANT ALL PRIVILEGES ON DATABASE vocasiite TO ensiie;' \
	-c 'GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO ensiie;' \
	-c 'GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO ensiie;'

db.drop:
	dropdb vocasiite

db.reset: db.drop db.init

db.backup:
	dropdb vocasiite
	createdb vocasiite
	psql vocasiite < data/vocasiite.bak
