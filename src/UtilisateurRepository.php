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
                ->setDateCreation($utilisateursDatum['date_crea']);
            $utilisateurs[] = $utilisateur;
        }
        return $utilisateurs;
    }

    public function login($uNom, $uMdp)
    {
        session_start();
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == True){
            echo("already logged in");
            header("Location: /client.php");
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
                    header("Location: /client.php");
                }
            }
        }
        if($success == False){
            header("Location: /");
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
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "utilisateurs" (pseudo, mdp, mail)  VALUES (:pseudo, :mdp, :mail)');
        $stmt->bindParam('pseudo', $uNom);
        $stmt->bindParam('mdp', $uMdp);
        $stmt->bindParam('mail', $uMail);
        $stmt->execute();
        $utilisateursData = $this->dbAdapter->query('SELECT * FROM "utilisateurs"');
        foreach($utilisateursData as $utilisateursDatum){
            echo($utilisateursDatum['pseudo']);
        }
    }

}