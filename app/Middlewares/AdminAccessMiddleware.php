<?php


namespace App\Middlewares;


use App\Core\App;
use App\Core\Auth;
use App\Core\Redirect;
use Closure;

/**
 * Class AdminAccessMiddleware
 * @package App\Middlewares
 */
class AdminAccessMiddleware
{

    /**
     * Renvoie sur l'ancienne url si l'utilisateur n'est pas loggé ou pas admin, sinon continue
     *
     * @param Closure $next
     * @return \App\Core\Response|mixed
     * @throws \Exception
     */
    public function handle(Closure $next){
        if(!Auth::isLogged()){
            App::addError("Vous devez être connecté pour accéder à cette page !");
            return Redirect::to('/');
        }
        if(!Auth::isAdmin()){
            App::addError("Vous devez être administrateur pour accéder à cette page !");
            return Redirect::to('/');
        }
        return $next();
    }
}