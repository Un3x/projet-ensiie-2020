<?php

namespace Liste;

class ListeRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    // Permet de filtrer les listes d'un utilisateur de pseudo $pseudo
    public function fetch($pseudo)
    {
        $listesData = $this->dbAdapter->prepare('SELECT * FROM Ravoir JOIN Liste ON Liste.id = Ravoir.id_liste WHERE pseudo = ?');
        $listesData->execute(array($pseudo));
        $listes = [];
        foreach ($listesData as $listesDatum) {
            $liste = new Liste();
            $liste
                ->setId($listesDatum['id'])
                ->setNomListe($listesDatum['nom_liste']);
            $listes[] = $liste;
        }
        return $listes;
    }

    public function fetchAll()
    {
        $listesData = $this->dbAdapter->query('SELECT * FROM Liste');
        $listes = [];
        foreach ($listesData as $listesDatum) {
            $liste = new Liste();
            $liste
                ->setId($listesDatum['id'])
                ->setNomListe($listesDatum['nom_liste']);
            $listes[] = $liste;
        }
        return $listes;
    }

    public function delete ($id_liste)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM Ravoir where id_liste = :id_liste');

        $stmt->bindParam('id_liste', $id_liste);
        $stmt->execute();

        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM EtreDans where id_liste = :id_liste');

        $stmt->bindParam('id_liste', $id_liste);
        $stmt->execute();

        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM Liste where id = :id_liste');

        $stmt->bindParam('id_liste', $id_liste);
        $stmt->execute();
    }

    public function add ($pseudo, $nom_liste){
        //Création de la liste
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO Liste (nom_liste) VALUES (:nom_liste)');

        $stmt->bindParam('nom_liste', $nom_liste);
        $stmt->execute();

        // Récup id de la new list
        $req = $this
            ->dbAdapter
            ->prepare('SELECT MAX(id) FROM Liste ');//On prend l'id le plus grand car c'est forcément celui du dernier élément ajouté

        
        $req->execute();
        $id_liste = $req->fetch();

        // Création du lien Liste/User dans Ravoir
        $stmt2 = $this
            ->dbAdapter
            ->prepare('INSERT INTO Ravoir(pseudo,id_liste) VALUES (:pseudo,:id_liste)');

        $stmt2->bindParam('pseudo', $pseudo);
        $stmt2->bindParam('id_liste', $id_liste[0]);
        $stmt2->execute();
    }
}
