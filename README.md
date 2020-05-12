# T’Oraux

Le but est de faire un site de partage de sujets d’oraux pour la CPGE. Ce site a été développé par les **Moutons du Purgatoire.** Ses fonctionnalités ont été décrites dans la soutenance.


## Compte-rendu du projet

Il s’agit du document `projet.pdf`. Vous le trouverez à la racine.


## Initialisation du site

Il faut d’abord initialiser la base de données. Il est nécessaire que PostgreSQL soit installé sur votre ordinateur. Vous devez ensuite créer un utilisateur `toraux` auquel vous attribuerez le mot de passe `ensiie`:
```
createuser -d -P toraux
```

Puis, initialisez la base de donnée avec la commande:
```
createdb -O toraux toraux
```

Vous lancerez le site en tapant `make` à la racine, et en chargeant le site `http://localhost:8080`.