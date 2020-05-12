<?php

$recherche = $_REQUEST['recherche'];
        afficherMusiques(Musique::getMusique($dbh, $recherche));
        exit(0);

