
# Projet Web du groupe 16

Notre rapport est disponible à la racine du répertoire.

## BDD

Pour utiliser ce projet, il faut configurer une base de données PostgreSQL avec l'utilisateur *corsaire* et le mot de passe *corsaire*. Cet utilisateur doit disposer des droits suffisants pour créer et administrer une base de données. Ensuite, le Makefile facilite la construction de la base de données. On peut également changer l'utilisateur et son mot de passe en modifiant `config/config.php` et le Makefile.

## Makefile

Le makefile dispose de 4 commandes :
* make start qui permet de lancer le serveur sur localhost:8080
* make db.init qui initialise la db a partir du fichier `./data/init.sql`
* make db.drop qui détruit la db
* make db.reset qui détruit puis initialise la db
* make doc qui génère une documentation pour le projet avec Doxygen

## Connexion

Pour se connecter avec un compte administrateur, on utilisera l'utilisateur *admin* avec le mot de passe *password*.
