<?php

namespace App;

/**
 * Class Utils
 * @package App
 */
class Utils
{
    /**
     * Formatte un string en camelCase
     *
     * @param $str
     * @return string
     */
    public static function toCamelCase($str){
        $result = strtolower($str);
        preg_match_all('/_[a-z]/', $result, $matches);

        foreach($matches[0] as $match)
        {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }

        return $result;
    }

    /**
     * Vérifie si une chaîne de caractère commence par un motif
     *
     * @param $haystack string La botte de foin
     * @param $needle string L'aiguille
     * @return bool
     */
    public static function startsWith($haystack, $needle){
        return $haystack[0] !== $needle[0] ? false : substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
    }

    /**
     * Vérifie si une chaîne de caractère termine par un motif
     *
     * @param $haystack string La botte de foin
     * @param $needle string L'aiguille
     * @return bool
     */
    public static function endsWith($haystack, $needle){
        return substr_compare($haystack, $needle, -strlen($needle)) === 0;
    }

    /**
     * On supprime les / en trop à la fin de la route et on oblige le premier / à être présent
     *
     * @param string Le path de la route
     * @return string
     */
    public static function formatRoute($route){
        $result = rtrim($route, '/');
        if ($result === ''){
            return '/';
        }
        return '/' . ltrim($route, '/');
    }

    /**
     * Limite le nombre de caractères d'un string
     *
     * @param  string  $value
     * @param  int  $limit
     * @param  string  $end
     * @return string
     */
    public static function limit($value, $limit = 100, $end = '...')
    {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }

        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')).$end;
    }

    /**
     * Récupère l'adresse IP du client effectuant la requête en passant par
     * les variables globales PHP
     *
     * @return mixed|string
     */
    public static function getClientIp(){
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            if (\preg_match("/^([d]{1,3}).([d]{1,3}).([d]{1,3}).([d]{1,3})$/", $_SERVER['HTTP_X_FORWARDED_FOR'])) {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    }
}