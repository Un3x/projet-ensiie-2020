<?php


namespace App\Core;


/**
 * Class Session
 * @package App\Core
 */
class Session
{

    /**
     * @var bool Est-ce que la session a démarrée
     */
    protected $isStarted = false;

    /**
     * Session constructor.
     */
    public function __construct()
    {
        $this->start();
    }

    /**
     * Renvoie l'instance de l'objet
     * @return Session
     */
    public static function & me(){
        return App::session();
    }

    /**
     * Démarre la session avec le cookie défini ci-dessous
     */
    public function start(){
        if($this->isStarted()){
            return;
        }
        session_start([
            'name' => 'NeTrempePasCeCookieDansTonVin',
            'cookie_secure' => Request::isSecure(),
            'cookie_httponly' => true,
            'cookie_samesite' => 'Lax',
            'cookie_lifetime' => 3600*24*2  //2 jours pour la durée de vie du cookie
        ]);
        $this->isStarted = true;
    }

    /**
     * @return bool
     */
    public function isStarted(){
        return $this->isStarted;
    }

    /**
     * Efface et regénère la session
     */
    public static function clear(){
        session_unset();
        self::regenerate(true);
    }

    /**
     * Renvoie l'id de la session
     * @return string
     */
    public static function getSessionId(){
        return session_id();
    }

    /**
     * Regénère la session
     * @param bool $destroy
     * @return bool
     */
    public static function regenerate($destroy = true){
        return session_regenerate_id($destroy);
    }

    /**
     * Détruis la session
     * @return bool
     */
    public static function destroy(){
        return session_destroy();
    }

    /**
     * Vérifie si la session possède les clés en argument
     * Supporte la notation dot
     *
     * @param $keys
     * @return bool
     */
    public static function has($keys){
        $keys = (array) $keys;

        if ($keys === []) {
            return false;
        }

        foreach ($keys as $key) {
            $subKeyArray = $_SESSION;

            if (array_key_exists($key, $_SESSION)) {
                continue;
            }

            foreach (explode('.', $key) as $segment) {
                if (array_key_exists($segment, $subKeyArray)) {
                    $subKeyArray = $subKeyArray[$segment];
                } else {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Supprime les valeurs et les clés données
     * @param mixed ...$keys
     */
    public static function forget(...$keys){
        self::unset($_SESSION, $keys);
    }

    /**
     * @param $array
     * @param $keys
     */
    private static function unset(&$array, $keys){
        $original = &$array;

        $keys = (array) $keys;

        if (count($keys) === 0) {
            return;
        }

        foreach ($keys as $key) {
            // Si la clé existe, on la vire direct
            if (array_key_exists($key, $array)) {
                unset($array[$key]);

                continue;
            }

            $parts = explode('.', $key);

            // On nettoie un peu x)
            $array = &$original;

            while (count($parts) > 1) {
                $part = array_shift($parts);

                if (isset($array[$part]) && is_array($array[$part])) {
                    $array = &$array[$part];
                } else {
                    // https://www.php.net/manual/fr/control-structures.continue.php
                    continue 2;
                }
            }

            unset($array[array_shift($parts)]);
        }
    }

    /**
     * Définit une valeur associé à la clé dans la session
     * Supporte la notation dot
     *
     * @param $key
     * @param $value
     * @return array|mixed|null
     */
    public static function set($key, $value){
        return self::mySet($key, $value, $_SESSION);
    }

    /**
     * @param $key
     * @param $value
     * @param $array
     * @return array|mixed|null
     */
    private static function mySet($key, $value, &$array){
        if (is_null($key)) {
            return null;
        }

        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if (! isset($array[$key]) || ! is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }

    /**
     * Permet de flasher une variable dans la session
     * cad une fois que la variable est récupérée, elle est automatiquement
     * supprimée
     *
     * @param $key
     * @param $value
     */
    public static function flash($key, $value){
        self::set($key, $value);
        self::set('PRIVATE_REPO.' . $key, true);
    }

    /**
     * Récupère la valeur associée à la clé s'elle existe
     * Supporte la notation dot
     *
     * @param $key
     * @param null $default
     * @param bool $triggerFlashed
     * @return array|mixed|null
     */
    public static function get($key, $default = null, $triggerFlashed = true){
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }

        if (strpos($key, '.') === false) {
            return $_SESSION[$key] ?? $default;
        }

        $array = $_SESSION;
        foreach (explode('.', $key) as $segment) {
            if (array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                return $default instanceof \Closure ? $default->call(App::instance()) : $default;
            }
        }

        if($triggerFlashed && self::has('PRIVATE_REPO.' . $key)){
            self::forget('PRIVATE_REPO.' . $key);
            self::forget($key);
        }

        return $array;
    }
}