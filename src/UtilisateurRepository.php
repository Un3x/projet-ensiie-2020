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
}