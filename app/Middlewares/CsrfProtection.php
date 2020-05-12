<?php


namespace App\Middlewares;

use App\Core\App;
use App\Core\Blade;
use App\Core\Redirect;
use App\Core\Session;
use App\Utils;
use Closure;
use Exception;

/**
 * Class CsrfProtection
 * @package App\Middlewares
 */
class CsrfProtection
{

    /**
     * @var string[] Les noms de route à exclure
     */
    private static $routeNamesToIgnore = [
        'commentsLike',
        'commentsPost',
        'winesLike',
        'searchAPI',
        'domainSearch',
        'typeSearch',
        'yearSearch'
    ];

    /**
     * Gère une requête entrante
     *
     * @param Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle(Closure $next){
        if(!in_array(App::currentRoute()->getName(), self::$routeNamesToIgnore, true)){
            if(App::request()->hasPostParams()){
                $tokenPosted = App::request()->input('_token');
                if(!$tokenPosted){
                    throw new Exception("Vous devez ajouter @csrf dans le formulaire", false);
                }

                if(Utils::getClientIp() . '|' . $tokenPosted !== Session::get('_token', '') ||
                    // Si la durée entre la génération du token et sa validation est supérieure à 1 heure
                    round(abs(time() - Session::get('_token_date', 0)) / 60, 2) >= 60)
                {
                    App::addError('Vérification de l\'authenticité de la requête echouée ou expirée (Protection CSRF) !');
                    return Redirect::back()->withInput();
                }
            }

            Blade::instance()->csrf_token = bin2hex(random_bytes(15));
            Session::set('_token', Utils::getClientIp() . '|' . Blade::instance()->csrf_token);
            Session::set('_token_date', time());
        }

        return $next();
    }
}