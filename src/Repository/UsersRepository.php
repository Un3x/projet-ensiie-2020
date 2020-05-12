<?php

include_once '../src/Entity/Users.php';

class UsersRepository
{
  /*
   * Classe pour séparer les contrôlleurs du modéle par rapport aux utilisateurs.
   *
   */
    /**
     * @var \PDO
     */
    private $dbAdapter;

    public function __construct ($dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
    /**
     *  Permet de remplir les attribut de l'objet $user
     *
     *
     * @param $userDatum Tableau de données
     * @param $user un objet
     */
    public function hydrate ($userDatum, $user)
    {
        $user
        ->setId($userDatum['id'])
        ->setFirstName($userDatum['firstname'])
        ->setLastName($userDatum['lastname'])
        ->setPseudo($userDatum['pseudo'])
        ->setPassword($userDatum['password'])
        ->setSuspendedAccount($userDatum['suspendedaccount'])
        ->setIsAdmin($userDatum['isadmin']);
    }

    /**
     *  Récupére les données des utilisateurs à partir de la base de donnée.
     *
     *
     */
    public function fetchAll ()
    {
        $usersData = $this->dbAdapter->query('SELECT * FROM "Users"');
        $users = [];
        foreach ($usersData as $userDatum) {
            $user = new Users();
            $this->hydrate($userDatum, $user);
            $users[] = $user;
        }
        return $users;
    }

    /**
     *  Récupére les données de l'utilisateur avec l'id $userId  à partir de la base de donnée.
     *
     *
     * @param $userId
     *
     */
    public function fetchOne ($userId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('SELECT * FROM "Users" WHERE id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();

        $user = new Users();
        $this->hydrate($stmt->fetch(), $user);

        return $user;
    }

    /**
     *  Supprime de la base de donnée l'utilisateur avec l'id $userId.
     *
     *
     * @param $userId
     *
     */

    public function delete ($userId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('DELETE FROM "Users" where id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
    }

    /**
     *  Enléve la suspension de l'utilisateur avec l'id $userId de la base de donnée.
     *
     *
     * @param $userId
     *
     */

    public function removeSuspension ($userId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE "Users" SET suspendedAccount = false  where id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
    }

    /**
     *  Donne les droits d'administration à  l'utilisateur avec l'id $userId .
     *
     *
     * @param $userId
     *
     */

    public function makeAdministrator ($userId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE "Users" SET isAdmin = true  where id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
    }

    /**
     *  Enlève les droits d'administration à  l'utilisateur avec l'id $userId .
     *
     *
     * @param $userId
     *
     */

    public function removeAdministrator ($userId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE "Users" SET isAdmin = false  where id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
    }

    /**
     *  Vérifie si le pseudo existe dans la base de donnée  .
     *
     *
     * @param $pseudo
     *
     */
    public function exists($pseudo)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('SELECT * FROM "Users" WHERE pseudo = :pseudo');

        $stmt->bindParam('pseudo', $pseudo);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     *  Suspend  l'utilisateur avec l'id $userId .
     *
     *
     * @param $userId
     *
     */
    public function suspend ($userId)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE "Users" SET suspendedAccount = true where id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->execute();
    }

    /**
     *  Insérer un utilisateur avec comme donnée $data dans la base de donnée  .
     *
     *
     * @param $data
     *
     */
    public function create($data)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('INSERT INTO "Users" (firstName, lastName, pseudo, password) VALUES (:firstname, :lastname, :pseudo, :password)');
        $stmt->bindValue(':firstname', $data['firstname']);
        $stmt->bindValue(':lastname', $data['lastname']);
        $stmt->bindValue(':pseudo', $data['pseudo']);
        $stmt->bindValue(':password', $data['password']);
        $stmt->execute();
    }

    public function modifyProfile ($userId ,$pseudo,$password)
    {
        $stmt = $this
            ->dbAdapter
            ->prepare('UPDATE "Users" SET pseudo =:pseudo, password=:password where id = :userId');
        $stmt->bindParam('userId', $userId);
        $stmt->bindValue(':pseudo', $pseudo);
        $stmt->bindValue(':password', $password);
        $stmt->execute();
    }

}
