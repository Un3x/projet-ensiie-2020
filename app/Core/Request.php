<?php

namespace App\Core;

use App\Utils;

/**
 * Class Request
 * @package App\Core
 *
 * @property string requestMethod
 * @property string serverProtocol
 * @property string httpHost
 * @property string https
 * @property string requestUri
 */
class Request
{
    /**
     * Renvoie des messages d'erreurs correspondant aux code d'erreur de l'upload en PHP
     */
    public const PHP_FILE_ERRORS = array(
            1 => 'Le fichier a dépassé la taille limite du php.ini (directive upload_max_filesize)',
            2 => 'Le fichier a dépassé la taille limite MAX_FILE_SIZE du formulaire HTML',
            3 => 'Le fichier n\'a pas été totalement transféré',
            4 => 'Aucun fichier n\'a été uploadé',
            6 => 'Le dossier temporaire n\'existe pas',
            7 => 'Impossible d\'écrire dans le stockage',
            8 => 'Une extension PHP a stoppé l\'upload du fichier',
        );

    /**
     * Clé pour la définition de la dernière URL en session
     */
    public const LAST_URL_KEY = 'lastUrl';

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var bool
     */
    protected $hasGetParams = false;
    /**
     * @var bool
     */
    protected $hasPostParams = false;
    /**
     * @var bool
     */
    protected $hasFileParams = false;

    /**
     * @var Url
     */
    protected $url;

    /**
     * Request constructor.
     */
    function __construct()
    {
        $this->init();
        $this->url = new Url();
    }

    /**
     * Renvoie si la requête est sécurisée (HTTPS)
     * @return bool
     */
    public static function isSecure(){
        return isset(App::request()->https);
    }

    /**
     * Renvoie la base de l'url
     * Exemple: Requête : https://localhost:8080/vin/2?test=46 --> renvoie https://localhost:8080
     *
     * @return string
     */
    public static function baseUrl()
    {
        if(App::request()->url->baseUrl !== null){
            return App::request()->url->baseUrl;
        }
        $baseUrl = rtrim((isset(App::request()->https) ? 'https' : 'http')
            . '://'
            . htmlentities(filter_var(App::request()->httpHost, FILTER_SANITIZE_URL)), '/') . '/';
        return App::request()->url->baseUrl = $baseUrl;
    }

    /**
     * Renvoie l'url sans les queryString
     * Exemple: Requête : https://localhost:8080/vin/2?test=46 --> renvoie https://localhost:8080/vin/2
     * @return string
     */
    public static function url()
    {
        if(App::request()->url->url !== null){
            return App::request()->url->url;
        }

        return App::request()->url->url = Request::baseUrl() . Request::pathUrl();
    }

    /**
     * Renvoie l'url complète
     * Exemple: Requête : https://localhost:8080/vin/2?test=46 --> renvoie https://localhost:8080/vin/2?test=46
     *
     * @return string
     */
    public static function fullUrl(){
        if(App::request()->url->fullUrl !== null){
            return App::request()->url->fullUrl;
        }

        $url = Request::baseUrl()
            . ltrim(htmlentities(filter_var(App::request()->requestUri, FILTER_SANITIZE_URL)), '/');
        return App::request()->url->fullUrl = $url;
    }

    /**
     * Renvoie le chemin demandé
     * Exemple: Requête : https://localhost:8080/vin/2?test=46 --> renvoie vin/2
     *
     * @return string
     */
    public static function pathUrl(){
        if(App::request()->url->pathUrl !== null){
            return App::request()->url->pathUrl;
        }
        return App::request()->url->pathUrl = empty($res = ltrim(parse_url(App::request()->fullUrl(), PHP_URL_PATH), '/')) ? '/' : $res;
    }


    /**
     * Renvoie l'url de la requête précédente si elle existe
     *
     * @return Url|false
     */
    public static function previousUrl(){
        $res = Session::get(self::LAST_URL_KEY, false);
        if(!$res){
            return false;
        }
        return $res;
    }

    /**
     * Renvoie la chaîne des caractères correspondant aux argument passés en GET
     * Exemple: Requête : https://localhost:8080/vin/2?test=46 --> renvoie ?test=46
     *
     * @return string
     */
    public static function queryString(){
        if(App::request()->url->queryString !== null){
            return App::request()->url->queryString;
        }

        $params = [];
        $url = '';
        App::request()->handleGet($params);

        if(!empty($params)){
            $url .= '?';

            $prepared = [];
            foreach ($params as $key => $val){
                $prepared[] = $key . '=' . $val;
            }
            $url .= implode('&', $prepared);
        }
        return App::request()->url->queryString = $url;
    }


    /**
     * Fonction qui initialise la Request
     */
    private function init()
    {
        foreach($_SERVER as $key => $value)
        {
            $this->{Utils::toCamelCase($key)} = $value;
        }

        $this->methodWorkaround();

        switch ($this->requestMethod){
            case "DELETE":
            case "GET":
                $this->handleGet($this->params);
                break;
            default:
                $this->handleGet($this->params);
                $this->handlePost($this->params);
                $this->handleFile($this->params);
                break;
        }
    }

    /**
     * Permet de résoudre le problème posé par les formulaire HTML incapable de poster des données autrement
     * qu'en GET et POST
     */
    protected function methodWorkaround(){
        if($this->requestMethod == 'POST') {
            if(isset($_POST['_method']) && in_array(strtoupper($_POST['_method']), Route::SUPPORTED_HTTP_METHODS)){
                $this->requestMethod = $_POST['_method'];
            }
        }
    }

    /**
     * @param $body
     */
    protected function handleGet(&$body){
        if($_GET == null || !is_array($_GET)){
            return;
        }
        foreach($_GET as $key => $value)
        {
            $body[$key] = trim(filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS));
            $this->hasGetParams = true;
        }
    }

    /**
     * @param $body
     */
    protected function handlePost(&$body){
        if($_POST == null || !is_array($_POST)){
            return;
        }
        foreach($_POST as $key => $value)
        {
            $body[$key] = trim(filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS));
            $this->hasPostParams = true;
        }
    }

    /**
     * @param $body
     */
    protected function handleFile(&$body){
        if($_FILES == null || !is_array($_FILES)){
            return;
        }
        foreach($_FILES as $key => $value)
        {
            $body[$key] = $value;
            $this->hasPostParams = true;
        }
    }

    /**
     * @return array|void
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return bool
     */
    public function hasGetParams(){
        return $this->hasGetParams;
    }

    /**
     * @return bool
     */
    public function hasPostParams(){
        return $this->hasPostParams;
    }

    /**
     * @return bool
     */
    public function hasFileParams(){
        return $this->hasFileParams;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function input($key, $default = null){
        return $this->hasInput($key) ? $this->params[$key] : $default;
    }

    /**
     * @param $key
     * @return bool
     */
    public function hasInput($key){
        return array_key_exists($key, $this->params);
    }
}