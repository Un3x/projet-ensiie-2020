<?php   

namespace Paris;

class ParisRepository
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
     * @param $id_paris l'id d'un paris
     * @return $bet le paris d'id id_paris
     */
    public function getParisByIdParis($id_paris)
    {
        $requete = "SELECT *
                    FROM paris
                    WHERE id_paris = $id_paris";
        $exec_requete = $this->dbAdapter->query($requete);  

        foreach ($exec_requete as $bet_row) {
            $bet = new Paris();
            $bet
                ->setIdParis($bet_row['id_paris'])
                ->setPlayer($bet_row['player'])
                ->setIdReu($bet_row['id_reu'])
                ->setIdUser($bet_row['id_user'])
                ->setRetard($bet_row['retard'])
                ->setMise($bet_row['mise'])
                ->setDateParis($bet_row['date_paris'])
                ->setStatut($bet_row['statut']);
            return $bet;
        }
    }

    /**
     * @param $id_reu l'id d'une réunion
     * @return $bets la liste des paris d'id_reu $id_reu
     */
    public function getParisByIdReu($id_reu)
    {
        $requete = "SELECT *
                    FROM paris
                    WHERE id_reu = '$id_reu'";
        $exec_requete = $this->dbAdapter->query($requete);  
        if (empty($exec_requete)) return [];
        $bets = [];
        foreach ($exec_requete as $bet_row) {
            $bet = new Paris();
            $bet
                ->setIdParis($bet_row['id_paris'])
                ->setPlayer($bet_row['player'])
                ->setIdReu($bet_row['id_reu'])
                ->setIdUser($bet_row['id_user'])
                ->setRetard($bet_row['retard'])
                ->setMise($bet_row['mise'])
                ->setDateParis($bet_row['date_paris'])
                ->setStatut($bet_row['statut']);
            $bets[] = $bet;
        }
        return $bets;
    }

    /**
     * @param $player l'id d'un joueur
     * @return $bets la liste des paris du joueur d'id $player 
     */
    public function getParisByPlayer($player)
    {
        $requete = "SELECT *
                    FROM paris
                    WHERE player = $player
                    ORDER BY date_paris DESC";
        $exec_requete = $this->dbAdapter->query($requete);  
        if (empty($exec_requete)) return [];
        $bets = [];
        foreach ($exec_requete as $bet_row) {
            $bet = new Paris();
            $bet
                ->setIdParis($bet_row['id_paris'])
                ->setPlayer($bet_row['player'])
                ->setIdReu($bet_row['id_reu'])
                ->setIdUser($bet_row['id_user'])
                ->setRetard($bet_row['retard'])
                ->setMise($bet_row['mise'])
                ->setDateParis($bet_row['date_paris'])
                ->setStatut($bet_row['statut']);
            $bets[] = $bet;
        }
        return $bets;
    }

    /**
     * @param $id_reu l'id d'une réunion, $id_membre l'id d'un membre et $statut un entier entre 0 et 3
     * @return void update le statut de la participation de $id_membre à $id_reu dans la base de données
     */
    public function updateStatus($id_paris,$statut)
    {
        $req=$this->dbAdapter->prepare('UPDATE Paris 
                                        SET statut = :newstatut 
                                        WHERE id_paris = :idparis ');

        $req->bindParam('newstatut',$statut);
        $req->bindParam('idparis',$id_paris);

        if (!$req) {
        echo "\nPDO::errorInfo():\n";
        print_r($dbh->errorInfo());
        } 
        $req->execute();
    }

    /**
     * @param void
     * @return $id un id non attribué
     */
    public function getNewId()
    {
        $requete = "SELECT * FROM paris";
        $exec_requete = $this->dbAdapter->query($requete); 
        $id = 0;
        if (empty($exec_requete)) return 0;
        foreach ($exec_requete as $bet){
            if ($bet['id_paris']>$id) $id=$bet['id_paris'];
        }
        $id++;
        return $id;
    }

    /**
     * @param $player l'id du jouer pariant
     *        $id_reu l'id de la reu pariée
     *        $id_user l'id du joueur parié
     *        $retard le retard parié
     *        $mise la mise pariée
     * @return void ajoute un paris à la base de donnée
     */
    public function Bet($player,$id_reu,$id_user,$retard,$mise)
    {
        $req = $this->dbAdapter->prepare('INSERT INTO Paris(id_paris, player, id_reu, id_user, retard, mise, date_paris, statut) 
                                          VALUES(:idparis, :idplayer, :idreu, :iduser, :late, :bet, NOW(), 0)');
        $id_paris=$this->getNewId();
        $id_reu = intval($id_reu);
        $id_user = intval($id_user);
        $mise = intval($mise);
        $retard=$retard.":00";

        $req->bindParam('idparis',$id_paris);
        $req->bindParam('idplayer',$player);
        $req->bindParam('idreu',$id_reu);
        $req->bindParam('iduser',$id_user);
        $req->bindParam('late',$retard);
        $req->bindParam('bet',$mise);

        if (!$req) {
            echo "\nPDO::errorInfo():\n";
            print_r($dbh->errorInfo());
        } 
        $req->execute();
        return $id_paris;
    }

}