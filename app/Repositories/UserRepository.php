<?php

namespace App\Repositories;

use App\Core\App;
use App\Core\File;
use App\Core\Pgsql;
use App\Models\User;
use Exception;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository
{
    /**
     * @var Pgsql
     */
    private $dbAdapter;

    /**
     * UserRepository constructor.
     */
    public function __construct()
    {
        $this->dbAdapter = App::resolve(Pgsql::class);
    }

    /**
     * Vérifie si un user existe déjà dans la bdd
     *
     * @param $usernameOrEmail
     * @param null $email
     * @return bool
     * @throws Exception
     */
    public function isUserAlreadyExists($usernameOrEmail, $email = null){
        $res = $this->dbAdapter->query('SELECT * from users WHERE LOWER(email) = LOWER(?) OR LOWER(username) = LOWER(?)', [
            $email === null ? $usernameOrEmail : $email,
            $usernameOrEmail
        ]);

        if($res === null){
            throw new Exception('Pgsql : Impossible d\'accéder aux users');
        }

        return count($res) !== 0;
    }

    /**
     * Récupère un user à partir de son id
     *
     * @param $userId
     * @return User|bool
     * @throws Exception
     */
    public function get($userId){
        $res = $this->dbAdapter->query('SELECT * from users WHERE uid = ?', [$userId]);
        if($res === null || count($res) == 0){
            return false;
        }

        return User::fromDbRow($res[0]);
    }

    /**
     * Supprime un user de la bdd
     *
     * @param $userId
     * @return bool
     */
    public function delete($userId)
    {
        $res = $this->dbAdapter->query('DELETE FROM users WHERE uid = ?', [$userId]);
        if($res != null){
            return File::delete(File::asset("img/users/pp/$userId.jpg")) && File::delete(File::asset("img/users/bg/$userId.jpg"));
        }

        return false;
    }

    /**
     * Insert un User dans la bdd
     *
     * @param User $user
     * @return array|int|string|null
     */
    public function addUser($user){
        return $this->dbAdapter->insert('users', [
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'pwd' => $user->getHashedPwd(),
            'created_at' => $user->getCreatedAt()->format('Y-m-d H:i:s')
        ], true);
    }

    /**
     * Met à jour un user dans la bdd
     *
     * @param User $user
     * @return array|bool|int|string|null
     */
    public function saveUser(User $user){
        return $this->dbAdapter->update('users', $user->toDbRow(), 'WHERE uid = ?', [$user->getId()]);
    }

    /**
     * /!\ Attention, cette fonction suppose que $usernameOrEmail est unique pour la colonne email et la colonne username !
     *
     * @param $usernameOrEmail
     * @param $plainPwd
     * @return User|bool
     * @throws Exception
     * @see isUserAlreadyExists()
     */
    public function checkUser($usernameOrEmail, $plainPwd) {
        $res = $this->dbAdapter->query('SELECT * from users WHERE LOWER(email) = LOWER(?) OR LOWER(username) = LOWER(?)',[
            $usernameOrEmail,
            $usernameOrEmail
        ]);

        if($res == null || count($res) === 0){
            return false;
        }

        if(count($res) > 1){
            throw new Exception('Unicité non respectée ! (voir UserRepository->isUserAlreadyExists)');
        }
        $user = User::fromDbRow($res[0]);
        return password_verify($plainPwd, $user->getHashedPwd()) ? $user : false;
    }

    /**
     * Recherche un user à partir d'un string donné
     *
     * @param $search
     * @param null $num
     * @param null $offset
     * @return User[]
     * @throws Exception
     */
    public function search($search, $num = null, $offset = null){
        $query = $this->dbAdapter->iterator('
            SELECT u.*,count(w.proposed_by) AS count 
            FROM users AS u
            FULL JOIN wines AS w ON w.proposed_by = u.uid
            WHERE LOWER(u.username) LIKE LOWER(?)
            OR LOWER(u.description) LIKE LOWER(?)
            GROUP BY u.uid 
            ORDER BY count(w.proposed_by) DESC' . (!is_null($num) ? " LIMIT $num" . (!is_null($offset) ? " OFFSET $offset" : '') : ''), [
            '%' . $search . '%',
            '%' . $search . '%'
        ]);
        $res = [];
        foreach($query as $row){
            $type = User::fromDbRow($row);
            $type->{'proposedWines'} = $row['count'];
            $res[] = $type;
        }
        return $res;
    }
}