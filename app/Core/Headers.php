<?php


namespace App\Core;

/**
 * Class Headers
 * @package App\Core
 */
class Headers
{
    /**
     *
     */
    protected const UPPER = '_ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    /**
     *
     */
    protected const LOWER = '-abcdefghijklmnopqrstuvwxyz';

    /**
     * @var array Tableau des headers
     */
    private $headers = [];
    /**
     * @var array Tableau des cookies
     */
    protected $cookies = [];

    /**
     * Headers constructor.
     * @param array $headers
     */
    public function __construct($headers = [])
    {
        $this->headers = $headers;
    }

    /**
     * Permet de définir un header
     * @param $name
     * @param $val
     * @return mixed
     */
    public function set($name, $val){
        $name = strtr($name, self::UPPER, self::LOWER);
        return $this->headers[$name] = $val;
    }

    /**
     * Permet de récupérer un header
     * @param $needle
     * @return mixed
     */
    public function get($needle){
        $needle = strtr($needle, self::UPPER, self::LOWER);
        return $this->headers[$needle];
    }

    /**
     * Permet de supprimer un header
     * @param $needle
     */
    public function remove($needle){
        $needle = strtr($needle, self::UPPER, self::LOWER);
        unset($this->headers[$needle]);
    }

    /**
     * Vérifie si un header est défini
     * @param $needle
     * @return bool
     */
    public function has($needle){
        $needle = strtr($needle, self::UPPER, self::LOWER);
        return array_key_exists($needle, $this->headers);
    }

    /**
     * Renvoie une représentation en string des headers
     * @return string
     */
    public function __toString(){
        $params = [];
        foreach($this->headers as $name => $val){
            $params[] = $name . ': ' . $val;
        }

        return implode("\n", $params);
    }

    /**
     * Renvoie tous les headers
     *
     * @param bool $includeCookies
     * @return array
     */
    public function all($includeCookies = true){
        if($includeCookies){
            foreach ($this->getCookies() as $cookie) {
                $headers['Set-Cookie'][] = (string) $cookie;
            }
        }
        $tmp = [];
        foreach($this->headers as $key => $val){
            $key = strtr($key, self::UPPER, self::LOWER);
            $tmp[$key] = $val;
        }
        return $tmp;
    }
    /**
     * Partie Cookies
     */

    /**
     * Défini un cookie
     * @param Cookie $cookie
     */
    public function setCookie(Cookie $cookie)
    {
        $this->cookies[$cookie->getDomain()][$cookie->getPath()][$cookie->getName()] = $cookie;
    }

    /**
     * Récupère les cookies
     * @return array
     */
    public function getCookies()
    {
        $flattenedCookies = [];
        foreach ($this->cookies as $path) {
            foreach ($path as $cookies) {
                foreach ($cookies as $cookie) {
                    $flattenedCookies[] = $cookie;
                }
            }
        }

        return $flattenedCookies;
    }

    /**
     * Supprime un cookie
     * @param $name
     * @param string $path
     * @param null $domain
     */
    public function removeCookie($name, $path = '/', $domain = null)
    {
        if (null === $path) {
            $path = '/';
        }

        unset($this->cookies[$domain][$path][$name]);

        if (empty($this->cookies[$domain][$path])) {
            unset($this->cookies[$domain][$path]);

            if (empty($this->cookies[$domain])) {
                unset($this->cookies[$domain]);
            }
        }
    }

    /**
     * Efface les cookies
     * @param $name
     * @param string $path
     * @param null $domain
     * @param bool $secure
     * @param bool $httpOnly
     */
    public function clearCookie($name, $path = '/', $domain = null, $secure = false, $httpOnly = true)
    {
        $this->setCookie(new Cookie($name, null, 1, $path, $domain, $secure, $httpOnly, false, null));
    }
}