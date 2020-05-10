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
        $bet = new Paris();
        $bet
            ->setIdParis($exec_requete[0]['id_paris'])
            ->setPlayer($exec_requete[0]['player'])
            ->setIdReu($exec_requete[0]['id_reu'])
            ->setIdUser($exec_requete[0]['id_user'])
            ->setRetard($exec_requete[0]['retard'])
            ->setMise($exec_requete[0]['mise'])
            ->setDateParis($exec_requete[0]['date']);
        return $bet;
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
                ->setDateParis($bet_row['date_paris']);
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
                    ORDER BY date_paris";
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
                ->setDateParis($bet_row['date_paris']);
            $bets[] = $bet;
        }
        return $bets;
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
        $req = $this->dbAdapter->prepare('INSERT INTO Paris(id_paris, player, id_reu, id_user, retard, mise, date_paris) 
                                          VALUES(:idparis, :idplayer, :idreu, :iduser, :late, :bet, :dateparis)');
        $id_paris=$this->getNewId();
        $now = time();
        $req->bindParam('idparis',$id_paris);
        $req->bindParam('idplayer',$player);
        $req->bindParam('idreu',$id_reu);
        $req->bindParam('iduser',$id_user);
        $req->bindParam('late',$retard);
        $req->bindParam('bet',$mise);
        $req->bindParam('dateparis',$now);

        if (!$req) {
            echo "\nPDO::errorInfo():\n";
            print_r($dbh->errorInfo());
        } 
        $req->execute();
        return $id_paris;
    }

}