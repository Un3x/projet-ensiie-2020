<?php

class Playlist {

    public $id;
    public $titre;
    public $auteur;
    public $date_creation;

    public static function mesPlaylists($dbh) {
        $query = "SELECT * FROM playlists WHERE auteur = ? ORDER BY date_creation DESC LIMIT 20";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Playlist');
        $sth->execute(array($_SESSION['Utilisateur']));
        $tab = array();
        while ($courant = $sth->fetch()) {
            array_push($tab, $courant);
        }
        $sth->closeCursor();
        return $tab;
    }
    
    public static function deletePlaylist($dbh,$id_playlist){
        $query = "DELETE FROM playlists WHERE playlists.id = ?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($id_playlist));
        return true;
    }
    
    public static function deleteMusiqueFromPlaylist($dbh,$id_playlist,$id_musique){
        $query = "DELETE FROM musiquesdansplaylist WHERE id_playlist = ? AND id_musique = ?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($id_playlist,$id_musique));
        return true;
    }
    
    

    public static function ListeMusiquesDansPlaylist($dbh, $id_playlist) {
        $query = "SELECT id,titre,auteur,date_ajout,annee_ado,asso FROM musiques JOIN musiquesdansplaylist ON id=id_musique WHERE id_playlist = ? ORDER BY id ASC";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Musique');
        $sth->execute(array($id_playlist));
        $tab = array();
        while ($courant = $sth->fetch()) {
            array_push($tab, $courant);
        }
        $sth->closeCursor();
        return $tab;
    }

    public static function musiqueDansPlaylist($dbh, $id_playlist, $id_musique) {
        $query = "SELECT * FROM musiquesdansplaylist WHERE id_musique = ? AND id_playlist = ?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($id_musique, $id_playlist));
        $existe = $sth->fetch();
        $sth->closeCursor();
        if ($existe == false) {
            return false;
        }
        return true;
    }

    public static function getPlaylist($dbh, $titre) {
        #Verifie si une playlist du meme nom existe pour l'utilisateur actuel et si oui renvoie la liste des musiques
        $query = "SELECT * FROM playlists WHERE titre = ? AND auteur = ?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Playlist');
        $sth->execute(array($titre, $_SESSION['Utilisateur']));
        $playlist = $sth->fetch();
        $sth->closeCursor();
        if ($playlist == false) {
            return NULL;
        }
        return $playlist;
    }
    
    public static function insererPlaylist($dbh, $titre){
        $sth = $dbh->prepare("INSERT INTO playlists (titre, auteur, date_creation) VALUES (?, ?, ?);");
        if (Playlist::getPlaylist($dbh, $titre) == NULL){
            // Si la playlist n'existe pas deja je peux l'ajouter
            $sth->execute(array(htmlspecialchars($titre), $_SESSION['Utilisateur'], date('Y-m-d H:i:s', time())));
            return true;
        }
        return false;
    }

    public static function insererMusiqueDansPlaylist($dbh, $id_playlist, $id_musique) {
        $sth = $dbh->prepare("INSERT INTO musiquesdansplaylist (id_playlist, id_musique,date) VALUES (?, ? ,?);");
        if (Playlist::musiqueDansPlaylist($dbh, $id_playlist, $id_musique) == false) {
            // Si la musique n'est pas dans la playlist, je peux l'ajouter
            $sth->execute(array($id_playlist, $id_musique,date('Y-m-d H:i:s', time())));
            return true;
        }
        return false;
    }
    
    public static function getInfoPlaylist($dbh, $id_playlist) {
        $query = "SELECT * FROM playlists WHERE id = ?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Playlist');
        $sth->execute(array($id_playlist));
        $playlist = $sth->fetch();
        return $playlist;
    }
}
