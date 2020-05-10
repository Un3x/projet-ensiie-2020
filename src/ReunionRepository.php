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
     * @param $meeting une réunion
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

    public function maxIdReu(){
        $IdReu= $this->dbAdapter->query("SELECT id FROM reunion");
        return max($IdReu);
    }

    public function MaxId(){
        $usersData = $this->dbAdapter->query("SELECT Id_reu FROM reunion");
        foreach ($usersData as $users) {
            $nb_id = max($users);
        }
        return $nb_id;
    }

    public function newReunion($Nom_Assoc,$IdReu,$Date_debut_reu,$Date_fin_reu,$Id_MembreA,$Descriptif)
    {
        $requete = "SELECT Id_Assoc FROM Association where nom_assoc = $Nom_Assoc";
        $Id_Asso = $this->dbAdapter->query($requete);
        
        $Id_Asso=(int)$Id_Assoc;

        $req=$this->dbAdapter->prepare('INSERT INTO Reunion(Id_Assoc,Id_reu,Date_debut_reu,Date_fin_reu,Id_MembreA,Descriptif) VALUES(:Id_Assoc,:Id_reu,:Date_debut_reu,:Date_fin_reu,:Id_MembreA,:Descriptif)');

        $req->bindParam('Id_Assoc', $Id_Assoc);    
        $req->bindParam('Id_reu', $Id_reu);
        $req->bindParam('Date_debut_reu', $Date_debut_reu);
        $req->bindParam('Date_fin_reu', $Date_fin_reu);
        $req->bindParam('Id_MembreA', $Id_MembreA);
        $req->bindParam('Descriptif', $Descriptif);

        $req->execute();
    }
}