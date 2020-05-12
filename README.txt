Pour faire tourner lektord et ainsi pouvoir lire des karaokes sur son pc :
    Le repository git est : https://git.iiens.net/martin2018/lektor

Pour fonctionner, il faut aussi avoir la base de karaokes ( ~3000 karaokes ) sur son pc. Posséder seulement une partie de cette base est possible.
On peut obtenir la base à l'adresse https://kurisu.iiens.net/karalist.php (pour télécharger les karaokes un par un), ou bien https://kurisu.iiens.net/kara.tar pour télécharger la base en entier (59.1GB).

Le site communique les karaokes à lire aux lektord à l'aide des ids des karaokes. Cela nécessite donc que les ids des karaokes correspondent entre la base de donnée du site et la base de donnée de chaque user.
Pour le développement du site, seulement 10 karaokes sont dans la base du site. A terme, il faudrait importer les 3000 karaokes depuis le site kurisu.iiens.net afin d'avoir une base de donnée sur le site contenant tout les karaokes.
Cela n'a pas été fait dans le site, car la base de kurisu.iiens.net et en mySQL, alors que celle du site est en Postgresql. Il faudrait donc idéalement changer le système de donnée de l'un des deux, ou bien trouver un moyen de convertir l'un en l'autre.
