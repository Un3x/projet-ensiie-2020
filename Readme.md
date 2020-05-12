# Projet web - Vocasiite

Ce projet de web est dédié à la création d'un site web pour l'association VocalIIsE, où nous stockerons par exemple : une liste de chansons les paroles pour chaque chanson, et la liste des chansons pour chaque soirée.

## Prérequis
Vous devez avoir installé sur votre machine `php` (version 7+), `postgresql` et le driver pgsql pour PDO : `php7.X-pgsql`.  
Assure-vous qu'un serveur postgresql est actif sur votre machine (si ce n'est pas le cas : `sudo service postgresql start`).  
Un utilisateur postgresql du nom de `ensiie` et avec le mot de passe `ensiie` doit exister.

## Dossiers
data : contient la base de données  
public : pages affichées sur le navigateur  
src : contient le MVC
