<?php

namespace Reunion;

class ReunionRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    /**
     * @param $id un entier correspondant à un utilisateur de la table Membre
     * et $date correspondant à une date au format "AAAA/MM/JJ"
     * @return $meetings la liste des réunions de l'utilisateur d'id $id à la date $date
     */
    public function getMeeting($id,$date)
    {
        $requete = "SELECT * 
                    FROM reunion 
                    NATURAL JOIN appartenir 
                    JOIN membre 
                    ON membre.id = appartenir.id_membre
                    WHERE (id = $id
                    AND date_debut_reu 
                    BETWEEN '$date 00:00:01' AND '$date 23:59:59')";  
        $exec_requete = $this->dbAdapter->query($requete);
        $meetings = [];
        foreach ($exec_requete as $meeting_row) {
            $meeting = new Reunion();
            $meeting
                ->setIdAssoc($meeting_row['id_assoc'])
                ->setIdReu($meeting_row['id_reu'])
                ->setIdMembreA($meeting_row['id_membrea'])
                ->setDateDebutReu(new \DateTime($meeting_row['date_debut_reu']))
                ->setDateFinReu(new \DateTime($meeting_row['date_fin_reu']));
            $meetings[] = $meeting;
        }
        return $meetings;     
    }

    /**
     * @param $meeting une réunion
     * @return str le nom de l'association pour le meeting $meeting
     */
    public function getNameAssoc($meeting)
    {
        $requete = "SELECT * FROM reunion NATURAL JOIN association";
        $exec_requete = $this->dbAdapter->query($requete);
        foreach ($exec_requete as $meeting_row) {
            if ($meeting_row['id_reu'] == $meeting->getIdReu()) return $meeting_row['nom_assoc'];
        }
        return "Void";
    }

}