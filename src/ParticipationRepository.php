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

}
?>