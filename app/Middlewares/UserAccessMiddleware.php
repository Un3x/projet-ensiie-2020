<?php


namespace App\Middlewares;


use App\Core\App;
use App\Core\Auth;
use App\Core\Redirect;
use Closure;

/**
 * Class UserAccessMiddleware
 * @package App\Middlewares
 */
class UserAccessMiddleware
{

    /**
     * Redirige si le user n'est pas connecté, sinon continue
     * @param Closure $next
     * @return \App\Core\Response|mixed
     */
    public function handle(Closure $next){
        if(!Auth::isLogged()){
            App::addError("Vous devez être connecté pour accéder à cette page !");
            return Redirect::to('/');
        }
        return $next();
    }
}