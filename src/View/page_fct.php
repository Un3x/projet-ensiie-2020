<!-- Fonctions faisant appel à la base de données pour les pages des histoires -->


<?php

    /*Connexion à la base de données 'ensiie'*/
    function connect() {
        try {
        $db = new PDO("pgsql:dbname=ensiie;host=localhost", "ensiie", "ensiie");
        }
        catch(Exception $e) {
            die("Error: ".$e->getMessage());
        }
        return $db;
    }

    /*Récupération d'une histoire*/
    function getStory($storyid, $db) {
        $query = $db->query("SELECT * FROM story WHERE storyid = $storyid");
        $story = $query->fetch();
        return $story;
    }

    /*Récupération d'une page*/
    function getPage($pageid, $db) {
        $query = $db->query("SELECT * FROM page WHERE pageid = $pageid");
        $page = $query->fetch();
        return $page;
    }
?>