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
     * @var int $id un entier correspondant à un utilisateur de la table Membre
     * et $date correspondant à une date
     * @return Reunion[] $meetings la liste des réunions de l'utilisateur d'id $id à la date $date
     */
    public function getMeeting($id,$date)
    {
        $requete = "SELECT * 
                    FROM reunion 
                    natural join appartenir 
                    join membre 
                    on membre.id = appartenir.id_membre
                    where (id = $id
                    and date_debut_reu 
                    between '$date 00:00:01' and '$date 23:59:59')";  
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

}