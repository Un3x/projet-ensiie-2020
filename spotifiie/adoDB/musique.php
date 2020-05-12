<?php

class Musique {

    public $id;
    public $titre;
    public $auteur;
    public $date_ajout;
    public $annee_ado;
    public $asso;

    public static function getMusique($dbh, $mot_clef) {
        $query = "SELECT * FROM musiques WHERE titre LIKE ? OR asso LIKE ?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Musique');
        $sth->execute(array("%" . $mot_clef . "%","%" . $mot_clef . "%"));
        $tab = array();
        while ($courant = $sth->fetch()) {
            array_push($tab, $courant);
        }
        $sth->closeCursor();
        return $tab;
    }
    
    public static function getInfoMusique($dbh, $id_musique) {
        $query = "SELECT * FROM musiques WHERE id = ?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Musique');
        $sth->execute(array($id_musique));
        $musique = $sth->fetch();
        return $musique;
    }
    
    public static function ListeMusiquesAsso($dbh, $asso) {
        $query = "SELECT id,titre,auteur,date_ajout,annee_ado,asso FROM musiques WHERE asso = ?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Musique');
        $sth->execute(array($asso));
        $tab = array();
        while ($courant = $sth->fetch()) {
            array_push($tab, $courant);
        }
        $sth->closeCursor();
        return $tab;
    }
    public static function ListeMusiquesNouveautes($dbh) {
        $query = "SELECT id,titre,auteur,date_ajout,annee_ado,asso FROM musiques ORDER BY date_ajout DESC LIMIT 20";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Musique');
        $sth->execute();
        $tab = array();
        while ($courant = $sth->fetch()) {
            array_push($tab, $courant);
        }
        $sth->closeCursor();
        return $tab;
    }
}
