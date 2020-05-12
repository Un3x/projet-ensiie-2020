<?php

class Commentaire {

    public $id;
    public $id_musique;
    public $auteur;
    public $texte;
    public $date_ajout;

    public static function getCommentaires($dbh, $id_musique) {
        $query = "SELECT id,id_musique,auteur,texte,date_ajout FROM commentaires WHERE id_musique = ? ORDER BY date_ajout DESC";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Commentaire');
        $sth->execute(array($id_musique));
        $tab = array();
        while ($courant = $sth->fetch()) {
            array_push($tab, $courant);
        }
        $sth->closeCursor();
        return $tab;
    }

    public static function insererCommentaire($dbh, $id_musique, $texte) {
        $sth = $dbh->prepare("INSERT INTO commentaires (id_musique, auteur, texte, date_ajout) VALUES (?, ?, ?, ?);");
        // Si la playlist n'existe pas deja je peux l'ajouter
        $sth->execute(array($id_musique, $_SESSION['Utilisateur'], htmlspecialchars($texte), date('Y-m-d H:i:s', time())));
        return true;
    }

}