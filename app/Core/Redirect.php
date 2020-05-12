<?php


namespace App\Core;


/**
 * Class Redirect
 * @package App\Core
 */
class Redirect extends Response
{
    /**
     * Permet de rediriger vers une URL
     * @param $url
     * @return Response
     */
    public static function to($url){
        return Response::create('', Response::HTTP_SEE_OTHER, [
            'Location' => $url
        ]);
    }

    /**
     * Permet de rediriger vers la dernière URL
     * @return Response
     */
    public static function back(){
        return self::to(!Request::previousUrl() ? '/' : rtrim(Request::previousUrl()->url, '/'));
    }

    /**
     *  Permet de rediriger vers une route nommée
     *
     * @param string $name Le nom de la route
     * @param array $pathArgs Les arguments à remplacer dans le nom de la route,
     *  Si l'argument existe dans le chemin, alors le chemin est patché avec l'argument,
     *    sinon l'argument est ajouté comme query dans la requête
     *
     * Exemple: Une route de path='/user/{id}' et d'arguments ['id' => 5, 'test' => 'bouh']
     *  redirigera vers l'url  http://..../user/5?test=bouh
     *
     * @return Response Le réponse à renvoyer
     */
    public static function name($name, $pathArgs = []){
        $res = Request::baseUrl();
        $handled = Route::_handleArgsInNamedRoute($name, $pathArgs);
        if(!$handled){
            App::addError("La route demandée est introuvable ($name)");
            return self::to($res);
        }else{
            return self::to(Request::baseUrl() . $handled[0] . $handled[1]);
        }
    }
}