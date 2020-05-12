<?php
echo "<h1>Les  plus récentes</h1>";
afficherMusiques(Musique::ListeMusiquesNouveautes($dbh));

