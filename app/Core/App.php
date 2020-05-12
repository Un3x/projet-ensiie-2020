<?php

namespace App\Core;

use Closure;
use Exception;

/**
 * Class App
 * @package App\Core
 */
class App
{

    /** @var Request*/
    private $request;
    /** @var Session */
    private $session;

    /**
     * @var array
     */
    private $instanciedClasses = [];
    /**
     * @var array
     */
    private $savedClosures = [];

    /**
     * @var Route[]
     */
    private static $routes = [];

    /**
     * @var Route
     */
    private static $currentRoute;

    /**
     * @var array
     */
    public $globalMiddlewares = [];
    /**
     * @var array
     */
    public $routeMiddlewares = [];

    /**
     * @var array
     */
    private static $errors = [];
    /**
     * @var array
     */
    private static $warnings = [];
    /**
     * @var array
     */
    private static $notifs = [];
    /**
     * @var array
     */
    private static $success = [];

    /** @var App */
    private static $instance;

    /**
     * Constructeur du routeur
     *
     * @param Request $request
     */
    function __construct(Request $request)
    {
        $this->request = $request;
        self::$instance = $this;

        $this->session = new Session;

        set_exception_handler(function($e) {
            $text = file_get_contents(__ROOT__ . '/app/Views/500.html');
            $text = str_replace('{{titreErreur}}', get_class($e) . ': ' . $e->getMessage(), $text);

            $res = new Response($text,
                Response::HTTP_INTERNAL_SERVER_ERROR);
            return $this->send($res);
        });
    }

    /**
     * Récupère l'instance de l'application
     * @return App
     */
    public static function & instance(){
        return self::$instance;
    }

    /**
     * Récupère l'instance de l'objet Request
     * @return Request
     */
    public static function & request(){
        return self::$instance->request;
    }

    /**
     * Récupère l'instance de l'objet Session
     * @return Session
     */
    public static function & session(){
        return self::$instance->session;
    }

    /**
     * Récupère la route actuelle
     * @return Route
     */
    public static function & currentRoute(){
        return self::$currentRoute;
    }

    /**
     * Permet de définir une liste de Middlewares globaux
     * @param $in
     */
    public function setGlobalMiddlewares($in){
        $this->globalMiddlewares = $in;
    }

    /**
     * Récupère l'instance de l'objet Request
     * @param $in
     */
    public function setRouteMiddlewares($in){
        $this->routeMiddlewares = $in;
    }

    /**
     * Partie ServiceProvider
     */

    /**
     * Permet d'enregistrer un singleton, cad un objet qui sera instanciée la première fois par
     * la Closure donnée puis réutilisée ensuite
     * @see App::resolve()
     * @param $nameOrClass mixed L'identifiant
     * @param $closure Closure La fonction génératrice de l'objet
     */
    public static function singleton($nameOrClass, Closure $closure){
        if(!array_key_exists($nameOrClass, self::$instance->savedClosures)){
            self::$instance->savedClosures[$nameOrClass] = $closure;
        }
    }

    /**
     * Permet de résoudre un singleton enregistré par l'identifiant fourni
     *
     * @see App::singleton()
     * @param $nameOrClass mixed L'identifiant
     * @return mixed|null
     */
    public static function resolve($nameOrClass){
        if(!array_key_exists($nameOrClass, self::$instance->savedClosures)){
            return null;
        }
        if(!array_key_exists($nameOrClass, self::$instance->instanciedClasses)){
            self::$instance->instanciedClasses[$nameOrClass] = self::$instance->savedClosures[$nameOrClass]->call(App::instance());
        }
        return self::$instance->instanciedClasses[$nameOrClass];
    }

    /**
     * Partie ROUTER
     */


    /**
     * Fonction créant et renvoyant une Response si une Route déclarée
     * possède une méthode (POST, GET, ...) non supportée
     * @param $error string L'erreur à afficher
     */
    public function invalidMethodHandler($error){
        $res = new Response(
            "<h1>405 Un type de requête est défini mais n\'est pas supporté par le serveur</h1> <br>
                    <h5>Erreur : $error</h5>",
            Response::HTTP_METHOD_NOT_ALLOWED
        );
        $res->forgetMeInLastUrl(true);
        $this->send($res);
        exit;
    }

    /**
     * @param $route
     */
    public static function addRoute(&$route){
        self::$routes[] = &$route;
    }

    /**
     * @return Route[]
     */
    public static function & getRoutes(){
        return self::$routes;
    }

    /**
     * Resolves a route
     */
    function handle()
    {
        list($foundArgs, $foundRoute) = $this->findRoute();

        if(is_null($foundRoute)) {
            $res = Route::has('404') ? Route::find('404')->getCallback()(self::request()) : new Response('<h1>404 ' . Response::$statusTexts[Response::HTTP_NOT_FOUND] . '</h1>', Response::HTTP_NOT_FOUND);
            $res->forgetMeInLastUrl(true);
        }else{
            // On ajoute la requête comme premier argument
            array_unshift($foundArgs, $this->request);

            self::$currentRoute = &$foundRoute;
            //On exécute les middlewares !
            // On imagine un onion, dont la réponse traitée par les routes est le coeur, et chaque couche est un middleware
            // Sachant qu'un middleware peut faire du traitement avant et après le coeur !
            // (Ca ressemble vraiment à un onion XD)

            //On définit le coeur d'abord
            $onionCore = function() use ($foundArgs, $foundRoute) { return call_user_func_array($foundRoute->getCallback(), $foundArgs); };

            //On construit ensuite un tableau des middlewares (avec priorité)
            $mids = [];

            //D'abord les middlewares globaux (couches externes) (prioritaires)
            foreach($this->globalMiddlewares as $mid){
                $mids[] = Closure::fromCallable([new $mid, 'handle']);
            }

            //Puis les middlewares de route (couches internes)
            foreach($foundRoute->getMiddlewares() as $key){
                if(!array_key_exists($key, $this->routeMiddlewares)){
                    throw new Exception("Le middleware $key est introuvable !");
                }
                $mids[] = Closure::fromCallable([new $this->routeMiddlewares[$key], 'handle']);
            }

            //On inverse le tableau pour avoir les bonnes priorités
            $mids = array_reverse($mids);

            //On réduit le tableau puis on exécute la fonction finale
            //@see https://www.php.net/manual/fr/function.array-reduce.php (fonction équivalente à fold en Ocaml)
            $res = array_reduce($mids, function($next, $currentLayer){
                return function() use ($next, $currentLayer) {return $currentLayer($next);};
            }, $onionCore)();

            if(!($res instanceof Response)){
                $res = new Response($res);
            }
        }

        return $this->send($res);
    }

    /**
     * Permet de trouver une route correspondant à la route actuelle
     * @return array|null
     */
    private function findRoute(){
        foreach(self::$routes as $route){
            $foundArgs = $route->__resolve(self::request()->requestMethod, Request::pathUrl());
            if($foundArgs !== false){
                return [$foundArgs, $route];
            }
        }
        return null;
    }

    /**
     * Permet d'afficher et de renvoyer la réponse fournie en argument
     * @param Response $res La réponse à renvoyer
     * @return Response
     */
    public function send(Response $res){
        if($res->getLastUrlTrigger() && !$res->isClientError() && !$res->isServerError()){
            Session::set(Request::LAST_URL_KEY, new Url(Request::pathUrl(), Request::url(), Request::baseUrl(), Request::fullUrl(), Request::queryString()));
        }

        return $res->send();
    }

    /**
     * Permet de renvoyer facilement un payload JSON pour
     * les appels de type API
     *
     * @param $isOk
     * @param array $content
     * @return Response
     */
    public static function jsonPayload($isOk, $content = [], $ignorePayloadStructure = false){
        if(!$ignorePayloadStructure){
            $res['type'] = $isOk ? 'ok' : 'error';
            $res['content'] = $content;
            if(count(self::$errors) > 0){
                $res['errors'] = self::getErrors();
            }
            if(count(self::$warnings) > 0){
                $res['warnings'] = self::getWarnings();
            }
            if(count(self::$notifs) > 0){
                $res['notifs'] = self::getNotifs();
            }
            if(count(self::$success) > 0){
                $res['success'] = self::getSuccess();
            }
        }else{
            $res = $content;
        }
        
        $resp = Response::create(json_encode($res), Response::HTTP_OK, ['Content-Type' => 'application/json'], false);
        $resp->forgetMeInLastUrl(true);
        return $resp;
    }

    /**
     * Permet de hasher un mot de passe avec la fonction BCRYPT
     * @param $pwd
     * @return false|string|null
     */
    public static function hashPassword($pwd){
        return password_hash($pwd, PASSWORD_BCRYPT, ['cost' => 11]);
    }

    /**
     * Ajoute une erreur à renvoyer
     *
     * @param $msg
     */
    public static function addError($msg){
        self::$errors[] = $msg;
    }

    /**
     * Récupère les erreurs données tout au long de l'exécution de la réponse
     * @return array
     */
    public static function getErrors(){
        return self::$errors;
    }

    /**
     * Ajoute un warning à renvoyer
     *
     * @param $msg
     */
    public static function addWarning($msg){
        self::$warnings[] = $msg;
    }

    /**
     * Récupère les warnings données tout au long de l'exécution de la réponse
     * @return array
     */
    public static function getWarnings(){
        return self::$warnings;
    }

    /**
     * Ajoute une notif à renvoyer
     *
     * @param $msg
     */
    public static function addNotif($msg){
        self::$notifs[] = $msg;
    }

    /**
     * Récupère les notifs données tout au long de l'exécution de la réponse
     * @return array
     */
    public static function getNotifs(){
        return self::$notifs;
    }

    /**
     * Ajoute un succès à renvoyer
     *
     * @param $msg
     */
    public static function addSuccess($msg){
        self::$success[] = $msg;
    }

    /**
     * Récupère les succès données tout au long de l'exécution de la réponse
     * @return array
     */
    public static function getSuccess(){
        return self::$success;
    }
}