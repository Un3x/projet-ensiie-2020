<?php

namespace Suivre;

class SuivreRepository
{
    /**
     * @var \PDO
     */
    private $dbAdaper;

    public function __construct(\PDO $dbAdaper)
    {
        $this->dbAdaper = $dbAdaper;
    }

    public function delete ($suiveur,$suivi)
    {
        $stmt = $this
            ->dbAdaper
            ->prepare('DELETE FROM Suivre where suiveur = :suiveur AND suivi = :suivi');
            
        $stmt->bindParam('suiveur', $suiveur);
        $stmt->bindParam('suivi', $suivi);
        $stmt->execute();
    }

    public function add ($suiveur, $suivi){
        $stmt = $this
            ->dbAdaper
            ->prepare('INSERT INTO Suivre (suiveur,suivi) VALUES (:suiveur,:suivi)');

        $stmt->bindParam('suiveur', $suiveur);
         $stmt->bindParam('suivi', $suivi);
        $stmt->execute();
    }
}