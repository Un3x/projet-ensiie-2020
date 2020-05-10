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


    public function MaxId(){
        $usersData = $this->dbAdapter->query("SELECT id_reu FROM reunion");
        foreach ($usersData as $users) {
            $nb_id = max($users);
        }
        return $nb_id;
    }

    public function newReunion($Nom_Assoc, $IdReu, $Date_debut_reu, $Date_fin_reu, $Id_MembreA, $Descriptif)
    {

        //echo gettype($Date_debut_reu);
        //AJOUT de la reunion dans la table REUNION
        //on recupere l'id de l'asso grace a la table assocation
        $sql = "SELECT association.id_assoc FROM association where association.nom_assoc = '$Nom_Assoc'";
        $result = $this->dbAdapter->query($sql);
        $donnees = $result->fetch();
        $Id_Assoc = $donnees['id_assoc'];

        $req=$this->dbAdapter->prepare("INSERT INTO Reunion(Id_Assoc,Id_reu, Date_debut_reu,Date_fin_reu, Id_MembreA, Descriptif) VALUES(:id_assoc,:id_reu, :date_debut_reu, :date_fin_reu, :id_membrea, :descriptif)");

        $req->bindParam(':id_assoc', $Id_Assoc);    
        $req->bindParam(':id_reu', $IdReu);
        $req->bindParam('date_debut_reu', $Date_debut_reu);
        $req->bindParam('date_fin_reu',  $Date_fin_reu);
        $req->bindParam('id_membrea', $Id_MembreA);
        $req->bindParam('descriptif', $Descriptif);

        $req->execute();

        //On veut la liste de tous les id_membre de Apartenir pour une association donnée
        $statut = 2; //on met les status à 2 car statut en attente (pas encore de reponse du user)
        
        $usersData = $this->dbAdapter->query("SELECT Appartenir.Id_Membre from Appartenir 
                                    join Association on Appartenir.Id_Assoc = Association.Id_Assoc
                                    where Association.Id_Assoc = '$Id_Assoc'");

        //une fois qu'on a la liste de tous les id_membre, on remplit la table PARTICIPATIONS
        foreach($usersData as $row){
            $id = $row['id_membre'];
            $reqt = $this->dbAdapter->prepare('INSERT INTO Participations(Id_reu, Id_Membre, statut) VALUES(:Id_reu,:Id_Membre,:statut)');
            
            $reqt->bindParam('Id_reu', $IdReu);    
            $reqt->bindParam('Id_Membre', $id);
            $reqt->bindParam('statut', $statut);
            //$req->bindParam('retard', $Date_fin_reu);
            $reqt->execute();
        }
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
}