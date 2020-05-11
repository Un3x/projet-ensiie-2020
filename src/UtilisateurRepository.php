<?php

namespace Utilisateur;

class UtilisateurRepository
{
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct(\PDO $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function fetchAll()
    {
        $utilisateursData = $this->dbAdapter->query('SELECT * FROM "utilisateurs"');
        $utilisateurs = [];
        foreach ($utilisateursData as $utilisateursDatum) {
            $utilisateur = new Utilisateur();
            $utilisateur
                ->setId($utilisateursDatum['num_id'])
                ->setPseudo($utilisateursDatum['pseudo'])
                ->setMdp($utilisateursDatum['mdp'])
                ->setMail($utilisateursDatum['mail'])
                ->setip($utilisateursDatum['ip']);
            $utilisateurs[] = $utilisateur;
        }
        return $utilisateurs;
    }

    public function login($uNom, $uMdp)
    {
        session_start();
        $isAdmin = False;
        $adminData = $this->dbAdapter->query('SELECT * FROM "administrateurs"');
        foreach($adminData as $adminDatum){
            if($adminDatum['pseudo'] == $uNom) $isAdmin = True;
        }
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == True){
            if($isAdmin == True) header("Location: /admin.php");            
            else header("Location: /client.php");
            return 1;
            exit;
        }
        $success = False;
        $utilisateursData = $this->dbAdapter->query('SELECT num_id, pseudo, mdp FROM "utilisateurs"');
        foreach($utilisateursData as $utilisateursDatum){
            if($utilisateursDatum['pseudo'] == $uNom){
                if($utilisateursDatum['mdp'] == $uMdp){
                    session_start();
                    $_SESSION["loggedin"] = True;
                    $_SESSION["id"] = $utilisateursDatum['num_id'];
                    $_SESSION["username"] = $uNom;
                    echo("Log in successfull");
                    $success = True;
                    if($isAdmin == True) header("Location: /admin.php");            
                    else header("Location: /client.php");
                    return 1;
                }
            }
        }
        if($success == False){
            header("Location: /");
            return 0;
        }
    }

    public function delete ($userId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "utilisateurs" where num_id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
    }

    public function create($uNom, $uMdp, $uMail)
    {
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "utilisateurs" (ip, pseudo, mdp, mail) VALUES (:ip, :pseudo, :mdp, :mail)');
        $stmt->bindParam('ip', $ip);
        $stmt->bindParam('pseudo', $uNom);
        $stmt->bindParam('mdp', $uMdp);
        $stmt->bindParam('mail', $uMail);
        $stmt->execute();

        $stmt2 = $this
            ->dbAdapter
            ->prepare('INSERT INTO "joueurs" (pseudo, role_princ, role_second) VALUES (:pseudo, \'fill\', \'fill\')');
        $stmt2->bindParam('pseudo', $uNom);
        $stmt2->execute();
    }

    public function create_admin($uNom)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "administrateurs" (pseudo) VALUES (:pseudo)');
        $stmt->bindParam('pseudo', $uNom);
        $stmt->execute();
    }

    public function connected_players()
    {
        $utilisateursData = $this->dbAdapter->query('SELECT * FROM "utilisateurs" NATURAL JOIN "nb_online"');
        $utilisateurs = [];
        foreach ($utilisateursData as $utilisateursDatum) {
            $utilisateur = new Utilisateur();
            $utilisateur
                ->setId($utilisateursDatum['num_id'])
                ->setPseudo($utilisateursDatum['pseudo'])
                ->setMdp($utilisateursDatum['mdp'])
                ->setMail($utilisateursDatum['mail'])
                ->setip($utilisateursDatum['ip']);
            $utilisateurs[] = $utilisateur;
        }
        return $utilisateurs;
    }

    public function update_username($uNom)
    {
        session_start();
        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE "utilisateurs" SET pseudo=:pseudo where num_id=:id');
        $stmt->bindParam('pseudo', $uNom);
        $stmt->bindParam('id', $_SESSION["id"]);
        $stmt->execute();
        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE "joueurs" SET pseudo=:pseudo where num_id=:id');
        $stmt->bindParam('pseudo', $uNom);
        $stmt->bindParam('id', $_SESSION["id"]);
        $stmt->execute();
        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE "administrateurs" SET pseudo=:pseudo where num_id=:id');
        $stmt->bindParam('pseudo', $uNom);
        $stmt->bindParam('id', $_SESSION["id"]);
        $stmt->execute();
        $_SESSION["username"] = $uNom;
    }

    public function update_mail($uMail)
    {
        session_start();
        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE "utilisateurs" SET mail=:mail where num_id=:id');
        $stmt->bindParam('mail', $uMail);
        $stmt->bindParam('id', $_SESSION["id"]);
        $stmt->execute();
    }

    public function update_password($newPass)
    {
        session_start();
        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE "utilisateurs" SET mdp=:newmdp where num_id=:id');
        $stmt->bindParam('newmdp', $newPass);
        $stmt->bindParam('id', $_SESSION["id"]);
        $stmt->execute();
    }

    public function update_roles($role_princ)
    {
        session_start();
        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE "joueurs" SET role_princ=:role_princ where pseudo=:pseudo');
        $stmt->bindParam('role_princ', $role_princ);
        $stmt->bindParam('pseudo', $_SESSION['username']);
        $stmt->execute();
    }

    public function isGameReady()
    {
        session_start();
        $players = $this->dbAdapter->query('SELECT * FROM in_game');
        foreach($players as $player){
            if($player['pseudo'] == $_SESSION['username']){
                if(!empty($player['id_game'])){
                    return $player['id_game'];
                }
            }
        }
        return -1;
    }

    public function countTeam($mdj, $team)
    {
        $sql = $this->dbAdapter->query('SELECT * FROM in_game');
        $players = [];
        foreach($sql as $s){
            $player = new InGame();
            $player->setPseudo($s['pseudo']);
            if(isset($s['team'])) $player->setTeam($s['team']);
            if(isset($s['id_game'])) $player->setId($s['id_game']);
            $player->setMdj($s['mdj']);
            $players[] = $player;
        }
        $count = 0;
        foreach($players as $player){
            if($player->getTeam() == $team && $player->getMdj() == $mdj){
                $count++;
            }
        }
        return $count;
    }

    public function matchmaking($game_type)
    {
        $mdj = strval($game_type) . "v" . strval($game_type);
        session_start();
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "in_game" (pseudo, mdj) VALUES (:pseudo, :mdj)');
        $stmt->bindParam('pseudo', $_SESSION['username']);
        $stmt->bindParam('mdj', $mdj);
        $stmt->execute();
        $players = $this->dbAdapter->query('SELECT * FROM "in_game"');
        $players_tab = [];
        foreach($players as $player){
            $joueur = new InGame();
            $joueur->setPseudo($player['pseudo']);
            $players_tab[] = $joueur;
        }
        $players_copy = $players_tab;
        $games = $this->dbAdapter-> query('SELECT id_partie FROM partie');
        $last_id = 0;
        foreach($games as $game){
            $last_id = $game['id_partie'];
        }
        $last_id += 1;
        $found_match = False;
        if($game_type == '1'){
            foreach($players_tab as $player){
                if(empty($player->getId())){
                    foreach($players_copy as $mate){
                        if(empty($mate->getId()) && $player->getMdj() == $mate->getMdj() && $player->getPseudo() != $mate->getPseudo()){
                            //GAME FOUND
                            $game_date = "00:00:00";
                            $stmt2 = $this  
                                ->dbAdapter
                                ->prepare('UPDATE "in_game" SET id_game=:id_partie where mdj=:mdj and id_game IS NULL');
                            $stmt2->bindParam('id_partie', $last_id);
                            $stmt2->bindParam('mdj', $mdj);
                            $stmt2->execute();
                            $stmt3 = $this
                                ->dbAdapter
                                ->prepare('INSERT INTO "partie" (duree) VALUES (:duree)');
                            $stmt3->bindParam('duree', $game_date);
                            $stmt3->execute();
                            $found_match = True;
                            break;
                        }
                    }
                    if($found_match == True) break;
                }
            }
        }else {
            foreach($players_tab as $player){
                if(empty($player->getId())){
                    //FILL TEAM
                    $pseudo = $player->getPseudo();
                    if($this->countTeam($mdj, 1) < (int)$game_type){
                        $team_number = 1;
                    } else {
                        $team_number = 2;
                    }
                    $update = $this
                        ->dbAdapter
                        ->prepare('UPDATE "in_game" SET team=:team where pseudo=:pseudo');
                    $update->bindParam('team', $team_number);
                    $update->bindParam('pseudo', $pseudo);
                    $update->execute();
                }
            }
            if($this->countTeam($mdj, 1) == (int)$game_type && $this->countTeam($mdj, 2) == (int)$game_type){
                $find_team = $this
                    ->dbAdapter
                    ->prepare('UPDATE "in_game" SET id_game=:id_game where mdj=:mdj');
                $find_team->bindParam('id_game', $last_id);
                $find_team->bindParam('mdj', $mdj);
                $find_team->execute();
            }
        }
    }
}