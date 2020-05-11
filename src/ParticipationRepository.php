<?php

namespace Participation;

class ParticipationRepository
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
     * @param $id_membre l'id d'un membre et $statut un entier entre 0 et 3
     * @return $participations la liste des participations de $id_membre dont le statut est $statut
     */
    public function getParticipationsMembre($id_membre,$statut)
    {
        $requete = "SELECT * 
                    FROM participations
                    WHERE id_membre = $id_membre
                    AND statut = $statut";
        $exec_requete = $this->dbAdapter->query($requete);  
        if (empty($exec_requete)) return [];  
        $participations = [];
        foreach ($exec_requete as $p_row) {
            $participation = new Participation();
            $participation
                ->setIdReu($p_row['id_reu'])
                ->setIdMembre($p_row['id_membre'])
                ->setStatut($p_row['statut'])
                ->setRetard($p_row['retard']);
            $participations[] = $participation;
        }
        return $participations;             
    }

    /**
     * @param $id_reu l'id d'une reu et $statut un entier entre 0 et 3
     * @return $participations la liste des participations à $id_reu dont le statut est $statut
     */
    public function getParticipationsReu($id_reu,$statut)
    {
        $requete = "SELECT * 
                    FROM participations
                    WHERE id_reu = '$id_reu'
                    AND statut = $statut";
        $exec_requete = $this->dbAdapter->query($requete);  
        if (empty($exec_requete)) return [];
        $participations = [];
        foreach ($exec_requete as $p_row) {
            $participation = new Participation();
            $participation
                ->setIdReu($p_row['id_reu'])
                ->setIdMembre($p_row['id_membre'])
                ->setStatut($p_row['statut'])
                ->setRetard($p_row['retard']);
            $participations[] = $participation;
        }
        return $participations;             
    }

    /**
     * @param $id_reu l'id d'une réunion et $id_membre l'id d'un membre
     * @return $res = true si le statut de la participation du membre d'id $id_membre
     *         à la réunion d'id $id_reu est En_Attente et false sinon
     */
    public function isEnCours($id_reu,$id_membre)
    {
        $participations = $this->getParticipationsMembre($id_membre,2);
        foreach ($participations as $p) {
            if ($p->getIdReu() == $id_reu) return true;
        }
        return false;
    }

    /**
     * @param $id_reu l'id d'une réunion et $id_membre l'id d'un membre
     * @return $res = true si le statut de la participation du membre d'id $id_membre
     *         à la réunion d'id $id_reu est Oui et false sinon
     */
    public function isOui($id_reu,$id_membre)
    {
        $participations = $this->getParticipationsMembre($id_membre,0);
        foreach ($participations as $p) {
            if ($p->getIdReu() == $id_reu) return true;
        }
        return false;
    }

    /**
     * @param $id_reu l'id d'une réunion et $id_membre l'id d'un membre
     * @return $res = true si le statut de la participation du membre d'id $id_membre
     *         à la réunion d'id $id_reu est Non et false sinon
     */
    public function isNon($id_reu,$id_membre)
    {
        $participations = $this->getParticipationsMembre($id_membre,1);
        foreach ($participations as $p) {
            if ($p->getIdReu() == $id_reu) return true;
        }
        return false;
    }

    /**
     * @param $id_reu l'id d'une réunion, $id_membre l'id d'un membre et $statut un entier entre 0 et 3
     * @return void update le statut de la participation de $id_membre à $id_reu dans la base de données
     */
    public function updateStatus($id_reu,$id_membre,$statut)
    {
        $req=$this->dbAdapter->prepare('UPDATE Participations 
                                        SET statut = :newstatut 
                                        WHERE id_reu = :idreu 
                                        AND id_membre = :idmembre');

        $req->bindParam('newstatut',$statut);
        $req->bindParam('idreu',$id_reu);
        $req->bindParam('idmembre',$id_membre);

        if (!$req) {
        echo "\nPDO::errorInfo():\n";
        print_r($dbh->errorInfo());
        } 
        $req->execute();
    }


    /** 
     * @param $id_membre l'id d'un membre
     * @retun $delay le retard moyen du membre d'id $id_membre
     */
    public function getAverageDelay($id_membre)
    {
        $allParticipations = $this->getParticipationsMembre($id_membre,3);
        $delay = 0;
        if (empty($allParticipations)) return "00:00";
        $sumDelay = 0;
        foreach ($allParticipations as $participation) {
            $sumDelay += strtotime($participation->getRetard());
        }
        $delay = date('H:i',intdiv($sumDelay,count($allParticipations)));
        return $delay;
    }

    /** 
     * @param $id_membre l'id d'un membre et $id_asso l'id d'une asso
     * @retun $delay le retard moyen du membre d'id $id_membre pour l'asso d'id $id_asso
     */
    public function getAverageDelayAsso($id_membre,$id_asso)
    {
        
        $requete = "SELECT * 
                    FROM participations
                    NATURAL JOIN reunion
                    WHERE id_membre = $id_membre
                    AND statut = 3
                    AND id_assoc = '$id_asso'";
        $exec_requete = $this->dbAdapter->query($requete);  

        $delay = 0;
        if (empty($exec_requete)) return "00:00";
        $nbEntries = 0;
        $sumDelay = 0;
        foreach ($exec_requete as $participation) {
            $sumDelay += strtotime($participation['retard']);
            $nbEntries++;
        }
        if ($nbEntries==0) return "00:00";
        $delay = date('H:i',intdiv($sumDelay,$nbEntries));
        return $delay;
    }

    public function fetch_Reu_passees($userid, $today){

        //on selectionne la liste des date_fin_reu  et id_reu d'un adminsitrateur donné pour pouvoir voir si elle est passée ou non
        $req = $this->dbAdapter->query("SELECT Reunion.id_reu, Reunion.Date_fin_reu from Reunion where Reunion.Id_MembreA = '$userid'");
                                           
        foreach($req as $row){
                $date_fin_reu = $row['date_fin_reu'];
                if($today > $date_fin_reu){
                    //on recupere la liste des participants par id_reu
                    $id_reu = $row['id_reu'];
                   // echo "id_reu = ".$id_reu;
                    $req2 = $this->dbAdapter->query("SELECT Id_Membre from Participations where id_reu = '$id_reu'");

                    //on met à jour la table des participations (statut = 3) afin de pouvoir rentrer le retard
                    foreach($req2 as $row2){
                        $id_membre = $row2['id_membre'];
                       // echo "</br>id_membre = ".$id_membre;
                        $statut = 3;
                        $this->updateStatus($id_reu,$id_membre,$statut);
                }
            }
        }
        
        //On veut
        //Asso 1 
        //Reunion passée numero 1
        // Participant 1 : retard -> ... 
        // Participant 2 : retard -> ... 

        //Reunion passée numero 2
        // Participant 1 : retard -> ... 
        // Participant 2 : retard -> ... 

        //Asso 2 
        //..

        //afficher reunion passees avec liste des participants pour un administrateur donné
        $data = $this->dbAdapter->query("SELECT * 
                                        from Reunion    
                                        where Id_MembreA = '$userid' 
                                        group by id_assoc");

        $meetings = [];                           
        foreach($data as $row){
                $date_fin_reu = $row['date_fin_reu'];

                if($today > $date_fin_reu){
                    $id_reu = $row['id_reu'];
                    $statut = 3;
                    $meeting = new Reunion();
                    $meeting
                        ->setIdAssoc($row['id_assoc'])
                        ->setIdReu($row['id_reu'])
                        ->setDateDebutReu(new \DateTime($row['date_debut_reu']))
                        ->setDateFinReu(new \DateTime($row['date_fin_reu']));
                    $meetings[] = $meeting;
                }
                //on veut la liste des participants pour l'id reu donnée
                $this->getParticipationsReu($id_reu,$statut);
            }

    }

    public function ajout_retard($idReu, $id_membre, $retard){
        $req=$this->dbAdapter->prepare("UPDATE Participations 
                                        set retard = '$retard' where id_reu = '$idReu' and id_membre = '$id_membre'");
        
        $req->bindParam('id_reu', $idReu);
        $req->bindParam('id_membre', $id_membre);
        $req->bindParam('retard', $retard);
        $req->execute();
    }


    foreach($){
        $sql = $this->dbAdapter->query("SELECT * from Participations where id_reu = '$idReu' and statut = 2 ");
    
    }



}
?>