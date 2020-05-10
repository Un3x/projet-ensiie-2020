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
                ->setDateFinReu(new \DateTime($meeting_row['date_fin_reu']))
                ->setDescriptif($meeting_row['descriptif']);
            $meetings[] = $meeting;
        }
        return $meetings;     
    }

     /**
     * @param $id_asso un id d'asso et $date une date
     * @return $meetings la liste des meetings pour l'asso $id_asso 
     *         suivant la date $date trié par ordre chronologique
     */
    public function getMeetingForBetList($id_asso,$date)
    {
        $requete = "SELECT * 
                    FROM reunion
                    WHERE id_assoc = '$id_asso'
                    AND Date_debut_reu > '$date'
                    ORDER BY Date_debut_reu";  
        $exec_requete = $this->dbAdapter->query($requete);
        $meetings = [];
        if (empty($exec_requete)) return [];
        foreach ($exec_requete as $meeting_row) {
            $meeting = new Reunion();
            $meeting
                ->setIdAssoc($meeting_row['id_assoc'])
                ->setIdReu($meeting_row['id_reu'])
                ->setIdMembreA($meeting_row['id_membrea'])
                ->setDateDebutReu(new \DateTime($meeting_row['date_debut_reu']))
                ->setDateFinReu(new \DateTime($meeting_row['date_fin_reu']))
                ->setDescriptif($meeting_row['descriptif']);
            $meetings[] = $meeting;
        }
        return $meetings;     
    }



    /**
     * @param $meeting un id de réunion
     * @return $reunion la reunion
     */
    public function getReunion($meeting)
    {
        $requete = "SELECT * FROM reunion";
        $exec_requete = $this->dbAdapter->query($requete);
        foreach ($exec_requete as $meeting_row) {
            $reunion = new Reunion();
            if ($meeting_row['id_reu'] == $meeting) {
                $reunion
                    ->setIdAssoc($meeting_row['id_assoc'])
                    ->setIdReu($meeting_row['id_reu'])
                    ->setIdMembreA($meeting_row['id_membrea'])
                    ->setDateDebutReu(new \DateTime($meeting_row['date_debut_reu']))
                    ->setDateFinReu(new \DateTime($meeting_row['date_fin_reu']))
                    ->setDescriptif($meeting_row['descriptif']);
                return $reunion;
            }
        }
        return NULL;
    }

    /**
     * @param $meeting un id de réunion et $id l'id d'un membre
     * @return $meetings la liste des réunions auxquelles $id participe qui chevauchent la réunion $meeting
     */
    public function getOverlaping($id_reu,$id)
    {
        $requete = "SELECT * 
                    FROM reunion 
                    NATURAL JOIN appartenir 
                    JOIN membre 
                    ON membre.id = appartenir.id_membre
                    WHERE id = $id";  
        $exec_requete = $this->dbAdapter->query($requete);
        $meetings = [];
        foreach ($exec_requete as $meeting_row) {
            $meeting = new Reunion();
            $meeting
                ->setIdAssoc($meeting_row['id_assoc'])
                ->setIdReu($meeting_row['id_reu'])
                ->setIdMembreA($meeting_row['id_membrea'])
                ->setDateDebutReu(new \DateTime($meeting_row['date_debut_reu']))
                ->setDateFinReu(new \DateTime($meeting_row['date_fin_reu']))
                ->setDescriptif($meeting_row['descriptif']);
            if ($meeting_row['id_reu'] !=$id_reu) $meetings[] = $meeting;
            else $reu = $meeting;
        }
        $start = $reu->getDateDebutReu()->getTimestamp();
        $end = $reu->getDateFinReu()->getTimestamp();
        $overlapingmeetings = [];
        foreach ($meetings as $fm) {
            $fstart = $fm->getDateDebutReu()->getTimestamp();
            $fend = $fm->getDateFinReu()->getTimestamp();
            if (($fstart>=$start && $fstart<$end) or ($start>=$fstart && $start<$fend)) $overlapingmeetings[] = $fm;
        }
        return $overlapingmeetings;     
    }


    /**
     * @param $meeting l'id d'une réunion
     * @return str le nom de l'association pour le meeting $meeting
     */
    public function getNameAssoc($meeting)
    {
        $requete = "SELECT * FROM reunion NATURAL JOIN association";
        $exec_requete = $this->dbAdapter->query($requete);
        foreach ($exec_requete as $meeting_row) {
            if ($meeting_row['id_reu'] == $meeting) return $meeting_row['nom_assoc'];
        }
        return "Void";
    }

}