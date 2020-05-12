<?php


namespace App\Core;


use App\Models\LoggedUser;
use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Exception;

/**
 * Class Auth
 * @package App\Core
 */
class Auth
{
    /**
     * Clé contenant l'id du user dans la session
     */
    private const USER_KEY = 'auth_control.userId';

    /**
     * Clé contenant le DateTime de la dernière connexion
     */
    private const LAST_LOGGED_KEY = 'auth_control.lastLogged';

    /**
     * Renvoie vrai si l'utilisateur connecté peut éditer l'utilisateur cible
     * @param User $user L'utilisateur cible
     * @return bool
     * @throws Exception
     */
    public static function canEdit(User $user){
        $me = self::loggedUser();
        if(!$me || !$me->getId()){
            return false;
        }

        if($me->getId() === $user->getId()){
            return true;
        }

        if($me->getRole() & User::ADMIN_ROLE && $user->getRole() & User::VIEWER_ROLE){
            return true;
        }

        return false;
    }

    /**
     * Défini un user loggé (fonction interne)
     * @param $id
     * @return LoggedUser Ancien logged user
     */
    public static function _loginSession($id){
        Session::set(self::USER_KEY, $id);
        $loggedUser = self::loggedUser();

        Session::set(self::LAST_LOGGED_KEY, Carbon::now());

        return $loggedUser;
    }

    /**
     * Retire le user loggé (fonction interne)
     */
    public static function _logoutSession(){
        Session::forget(self::USER_KEY);
    }

    /**
     * On aurait pu ranger cette méthode dans un $app->singleton mais
     * on souhaite la version la plus à jour possible
     *
     * @return LoggedUser|false
     * @throws Exception
     */
    public static function loggedUser(){
        if(!Auth::isLogged()){
            return null;
        }
        $logged = new LoggedUser();

        $userRepo = new UserRepository();
        $user = $userRepo->get(Session::get(Auth::USER_KEY, -1));
        if(!$user){
            Session::clear();
            throw new Exception("Votre session est invalide et a donc été effacée !");
        }

        $logged->fromUser($user);
        $logged->setLastLogged(Session::get(Auth::LAST_LOGGED_KEY));
        return $logged;
    }

    /**
     * Renvoie vrai si l'utilisateur est connecté
     * @return bool
     */
    public static function isLogged(){
        return Session::get(Auth::USER_KEY) !== null;
    }

    /**
     * Renvoie vrai si l'utilisateur est connecté et administrateur
     * @return int
     * @throws Exception
     */
    public static function isAdmin(){
        return self::isLogged() && self::loggedUser()->getRole() & User::ADMIN_ROLE;
    }
}