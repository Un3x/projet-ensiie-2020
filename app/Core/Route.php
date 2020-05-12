<?php


namespace App\Core;

use App\Utils;
use Closure;

/**
 * Class Route
 * @package App\Core
 */
class Route
{
    /**
     * Liste des méthodes HTTP supportées
     */
    public const SUPPORTED_HTTP_METHODS = array(
        "GET",
        "POST",
        "DELETE",
        "PUT",
        "PATCH",
        "OPTIONS"
    );

    /**
     * @var array|null La liste des méthodes de la route
     */
    private $methods;
    /**
     * @var string Le chemin de la route
     */
    private $path;
    /**
     * @var string Le nom de la route (peut être null)
     */
    private $name = null;
    /**
     * @var Closure La fonction exécutée si la route est choisie
     */
    private $callback;

    /**
     * @var array Les middlewares appliquées à cette route
     */
    private $middlewares = [];

    /*
     * On déclare les routes avec ces fonctions
     */

    /**
     * Défini la route pour toutes les méthodes supportées
     *
     * @param $path
     * @param $callback callable|string Un callable ou 'laclasse' ou 'laclasse@lafonction'
     * @return Route
     */
    public static function & any($path, $callback){
        return self::create(null, $path, $callback);
    }

    /**
     * Définit la route pour les méthodes rangées dans le tableau
     * @param $methods
     * @param $path
     * @param $callback callable|string Un callable ou 'laclasse' ou 'laclasse@lafonction'
     * @return Route
     */
    public static function & match($methods, $path, $callback){
        return self::create(array_map('strtoupper', $methods), $path, $callback);
    }

    /**
     * Définit la route avec la méthode PATCH
     *
     * @param $path
     * @param $callback callable|string Un callable ou 'laclasse' ou 'laclasse@lafonction'
     * @return Route
     */
    public static function & patch($path, $callback){
        return self::create(["PATCH"], $path, $callback);
    }

    /**
     * Définit la route avec la méthode OPTIONS
     *
     * @param $path
     * @param $callback callable|string Un callable ou 'laclasse' ou 'laclasse@lafonction'
     * @return Route
     */
    public static function & options($path, $callback){
        return self::create(["OPTIONS"], $path, $callback);
    }

    /**
     * Définit la route avec la méthode PUT
     *
     * @param $path
     * @param $callback callable|string Un callable ou 'laclasse' ou 'laclasse@lafonction'
     * @return Route
     */
    public static function & put($path, $callback){
        return self::create(["PUT"], $path, $callback);
    }

    /**
     * Définit la route avec la méthode DELETE
     *
     * @param $path
     * @param $callback callable|string Un callable ou 'laclasse' ou 'laclasse@lafonction'
     * @return Route
     */
    public static function & delete($path, $callback){
        return self::create(["DELETE"], $path, $callback);
    }

    /**
     * Définit la route avec la méthode POST
     *
     * @param $path
     * @param $callback callable|string Un callable ou 'laclasse' ou 'laclasse@lafonction'
     * @return Route
     */
    public static function & post($path, $callback){
        return self::create(["POST"], $path, $callback);
    }

    /**
     * Définit la route avec la méthode GET
     *
     * @param $path
     * @param $callback callable|string Un callable ou 'laclasse' ou 'laclasse@lafonction'
     * @return Route
     */
    public static function & get($path, $callback){
        return self::create(["GET"], $path, $callback);
    }

    /**
     * Privé, crée la route statiquement
     *
     * @param $path
     * @param $callback callable|string Un callable ou 'laclasse' ou 'laclasse@lafonction'
     * @return Route
     */
    private static function & create($methods, $path, $callback){
        $route = new Route($methods, $path, $callback);
        App::addRoute($route);
        return $route;
    }

    /**
     * Route constructor.
     * @param $methods
     * @param $path
     * @param $callback callable|string Un callable ou 'laclasse' ou 'laclasse@lafonction'
     */
    private function __construct($methods, $path, $callback)
    {
        $this->methods = is_null($methods) ? null : (is_array($methods) ? $methods : [$methods]);
        if(!is_null($methods)){
            foreach($methods as $met){
                if(!in_array($met, self::SUPPORTED_HTTP_METHODS)) {
                    App::instance()->invalidMethodHandler("La méthode $met n'est pas supportée !");
                }
            }
        }
        $this->callback($callback);
        $this->path($path);
    }

    /*
     * Partie interaction avec App
     */

    /**
     * Vérifie s'il existe une Route avec le nom donné
     * @param $name
     * @return bool
     */
    public static function has($name){
        foreach(App::getRoutes() as $route){
            if($route->getName() == $name){
                return true;
            }
        }

        return false;
    }

    /**
     * Vérifie si la route actuelle a comme nom le string donné
     *
     * @param $name
     * @return bool
     */
    public static function named($name){
        return App::currentRoute()->getName() == $name;
    }

    /**
     * Cherche la route associée au nom donné
     * @param $name
     * @param null $fallback La valeur par défaut
     * @return Route|null
     */
    public static function & find($name, $fallback = null){
        foreach (App::getRoutes() as &$route) {
            if($route->getName() == $name){
                return $route;
            }
        }
        return $fallback;
    }

    /**
     * Récupère l'url d'une route de nom donné
     *
     * @param $name
     * @param array $pathArgs
     * @return string
     */
    public static function getUrl($name, $pathArgs = []){
        $handle = self::_handleArgsInNamedRoute($name, $pathArgs);
        return Request::baseUrl() . $handle[0] . $handle[1];
    }

    /**
     * @param $name
     * @param $pathArgs
     * @return array|bool
     */
    public static function _handleArgsInNamedRoute($name, $pathArgs)
    {
        foreach (App::getRoutes() as $route) {
            if (!is_null($route->getName()) && $route->getName() == $name) {
                return self::_handleArgsInRoute($route, $pathArgs);
            }
        }
        return false;
    }

    public static function _handleArgsInRoute($route, $pathArgs){
        $path = ltrim($route->getPath(), '/');
        $queryArgs = [];
        foreach ($pathArgs as $key => $value) {
            $test = str_replace('{' . $key . '}', $value, $path);
            if ($test !== $path) {
                $path = $test;
            } else {
                $queryArgs[] = urlencode($key) . '=' . urlencode($value);
            }
        }

        return [$path, (!empty($queryArgs) ? '?' . implode(',', $queryArgs) : '')];
    }

    /*
     * Partie objet
     */

    /**
     * Définit la fonction callback
     * @param $callback
     * @return $this
     */
    public function callback($callback){
        $this->callback = $callback;
        return $this;
    }

    /**
     * Définit le nom de la route
     * @param $name
     * @return $this
     */
    public function name($name){
        $this->name = $name;
        return $this;
    }

    /**
     * Ajoute des middlewares à la route
     * @param mixed ...$mids
     * @return $this
     */
    public function middleware(...$mids){
        $mids = is_array($mids) ? $mids : [$mids];
        $this->middlewares = array_merge($mids, $this->middlewares);
        return $this;
    }

    /**
     * Définit le chemin de la route
     * @param $path
     * @return $this
     */
    public function path($path){
        $this->path = Utils::formatRoute($path);
        return $this;
    }

    /**
     * Récupère le callback de la route
     * @return Closure
     */
    public function getCallback(){
        $res = $this->callback;
        if(is_string($res)){
            $class = $res;
            $func = "handle";
            if(strpos($res, "@") !== false){
                list($class, $func) = explode("@", $res);
            }
            App::singleton($class, function() use ($class) {return new $class;});
            $res = Closure::fromCallable([App::resolve($class), $func]);
        }else{
            $res = Closure::fromCallable($this->callback);
        }
        return $res;
    }

    /**
     * Renvoie les méthodes de la route
     * @return array|null
     */
    public function getMethods(){
        return $this->methods;
    }

    /**
     * Renvoie les middlewares de la route
     * @return array
     */
    public function getMiddlewares(){
        return $this->middlewares;
    }

    /**
     * Renvoie le chemin de la route
     * @param array $pathArgs
     * @return string
     */
    public function getPath($pathArgs = []){
        if(!empty($pathArgs)){
            $handle = self::_handleArgsInRoute($this, $pathArgs);
            $res = $handle[0] . $handle[1];
        }else{
            $res = $this->path;
        }

        return $res;
    }

    /**
     * Renvoie le nom de la route
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /*
     *  Partie traitement des routes
     */

    /**
     * Résoud la route
     * @param $reqMethod
     * @param $reqPath
     * @return array|bool
     */
    public function __resolve($reqMethod, $reqPath){
        if(!is_null($this->methods) && !in_array(strtoupper($reqMethod), $this->methods, true)){
            return false;
        }
        return self::checkAndFindArgsInPath(Utils::formatRoute($reqPath), $this->getPath());
    }

    /*
     * Fonctions utilitaires
     */

    /**
     * Trouve les arguments dans le chemin d'une route
     *
     * @param $currentPath
     * @param $tempPath
     * @return array|bool
     */
    private static function checkAndFindArgsInPath($currentPath, $tempPath){
        $currentPath = explode('/', $currentPath);
        $tempPath = explode('/', $tempPath);

        if(count($currentPath) != count($tempPath)){
            return false;
        }
        $foundArgs = [];
        for($i = 0; $i < count($tempPath); $i++){
            $tempItem = $tempPath[$i];
            if($tempItem === $currentPath[$i]){
                continue;
            }

            if(!preg_match('/{([a-z0-9]+)}/m', $tempItem, $matches)){
                return false;
            }

            if($matches != null && array_key_exists(1, $matches) && $matches[1] !== null){
                $foundArgs[] = $currentPath[$i];
                continue;
            }

            return false;
        }
        return $foundArgs;
    }
}