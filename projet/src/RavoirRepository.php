<?php

namespace Ravoir;

class RavoirRepository
{
    /**
     * @var \PDO
     */
    private $dbAdaper;

    public function __construct(\PDO $dbAdaper)
    {
        $this->dbAdaper = $dbAdaper;
    }

    public function fetchAll()
    {
        $ravoirsData = $this->dbAdaper->query('SELECT * FROM Ravoir');
        $ravoirs = [];
        foreach ($ravoirsData as $ravoirsDatum) {
            $ravoir = new Ravoir();
            $ravoir
                ->setPseudo($ravoirsDatum['pseudo'])
                ->setIdListe($ravoirsDatum['id_liste']);
            $ravoirs[] = $ravoir;
        }
        return $ravoirs;
    }
    
    // Permet de filtrer les listes d'un utilisateur de pseudo $pseudo
    public function fetch($pseudo)
    {
        $ravoirsData = $this->dbAdaper->prepare('SELECT * FROM Ravoir WHERE pseudo = ?');
        $ravoirsData->execute(array($pseudo));
        $ravoirs = [];
        foreach ($ravoirsData as $ravoirsDatum) {
            $ravoir = new Ravoir();
            $ravoir
                ->setPseudo($ravoirsDatum['pseudo'])
                ->setIdListe($ravoirsDatum['id_liste']);
            $ravoirs[] = $ravoir;
        }
        return $ravoirs;
    }
}