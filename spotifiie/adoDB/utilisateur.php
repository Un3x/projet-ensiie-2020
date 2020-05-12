<?php

class Utilisateur {

    public $login;
    public $mdp;
    public $nom;
    public $prenom;
    public $promotion;
    public $naissance;
    public $email;

    public function __toString() {
        $tab_date = explode("-", $this->naissance);
        $date = $tab_date[2] . "/" . $tab_date[1] . "/" . $tab_date[0];
        if ($this->promotion == NULL) {
            return "[" . $this->login . "] " . $this->prenom . " " . $this->nom . ", né le " . $date . ", " . $this->email;
        } else {
            return "[" . $this->login . "] " . $this->prenom . " " . $this->nom . ", né le " . $date . ", " . $this->promotion . ", " . $this->email;
        }
    }

    public static function getUtilisateur($dbh, $login) {
        $query = "SELECT * FROM utilisateurs WHERE login = ?";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Utilisateur');
        $sth->execute(array($login));
        $user = $sth->fetch();
        $sth->closeCursor();
        if ($user == false) {
            return NULL;
        }
        return $user;
    }

    public static function insererUtilisateur($dbh, $login, $mdp, $nom, $prenom, $promotion, $naissance, $email) {
        $sth = $dbh->prepare("INSERT INTO utilisateurs (login, mdp, nom, prenom, promotion, naissance, email)
VALUES (?, SHA1(?), ?, ?, ?, ?, ?)");
        if (Utilisateur::getUtilisateur($dbh, $login) == NULL) {
            // Si l'utilisateur n'existe pas deja, je peux l'ajouter
            $sth->execute(array($login, $mdp, $nom, $prenom, $promotion, $naissance, $email));
            $sth = $dbh->prepare("INSERT INTO playlists (titre, auteur, date_creation) VALUES (?, ?, ?);");
            $sth->execute(array("favoris",$login,date('Y-m-d H:i:s', time())));
            return true;
        }
        return false;
    }

    public static function testerMdp($dbh, $login, $mdp) {
        $sha_mdp = sha1($mdp);
        $user = Utilisateur::getUtilisateur($dbh, $login);
        if ($user != NULL && $sha_mdp == $user->mdp) {
            return true;
        }
        return false;
    }

}


