<?php

namespace Livre;

class LivreRepository
{
    /**
     * @var \PDO
     */
    private $dbAdaper;

    public function __construct(\PDO $dbAdaper)
    {
        $this->dbAdaper = $dbAdaper;
    }

    public function add ($id,$nb_pages,$langue,$genre){
        
        $stmt = $this
            ->dbAdaper
            ->prepare('INSERT INTO Livre(M1_cle,nb_pages,langue,genre) VALUES (:id,:nb_pages,:langue,:genre)');
    
        $stmt->bindParam('M1_cle', $id);
        $stmt->bindParam('nb_pages', $nb_pages);
        $stmt->bindParam('genre', $genre);
        $stmt->bindParam('langue', $langue);
        $stmt->execute();
    }
}