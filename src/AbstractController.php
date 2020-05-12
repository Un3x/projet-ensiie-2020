<?php

include_once '../src/Factory/DbAdaperFactory.php';
include_once '../src/Service/Security.php';

/*
 * Classe abstraite qui apporte des fonctionnalités évoluées pour la
 * réalisation de contrôlleurs.
 */
abstract class AbstractController
{
    protected $dbAdapter;
    
    /*
     * @var Security
     * 
     * Un objet Security est associée au contrôlleur
     */
    protected $security;
    
    /*
     * Listes des paramètres de la requête
     */
    protected $params = [];
    
    protected $method = null; 
    
    /*
     * @var String array
     * 
     * Tableau contenant les méthodes HTTP autorisées dans l'application
     */
    private $supportedHttpMethods = array(
        "get",
        "post"
    );
    
    /*
     * Constructeur
     */
    function __construct()
    {
        $this->dbAdapter = (new DbAdaperFactory())->createService();
        $this->security = new Security($this->dbAdapter);
    }
        
    /**
     * Génère le rendu associé à la vue $view spécifiée en utilisant les
     * données $data.
     * 
     * @param $view le nom de la vue à utiliser
     * @param $data les variables à utiliser dans la vue
     */
    public function render($view, $data)
    {
        include_once '../src/View/' . $view . '.php';
    }
    
    /**
     * Réalise une redirection vers le chemin $path.
     * 
     * @param $path le chemin de la redirection
     */
    public function redirect($path)
    {
        header('Location: ' . $path);
    }
    
    /**
     * Permet d'appeler la bonne méthode instanciée par le développeur 
     * en fonction du type de la requête.
     */
    private function resolve()
    {
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        
        if (method_exists($this, $this->method) && in_array($this->method, $this->supportedHttpMethods)) {
            if ($this->method === 'get') {
                $this->get();
            }
            else if ($this->method === 'post') {
                $this->post();
            }
        } else {
            $this->renderError(
                "Méthode non autorisée !"
            );
        }
    }
    
    /*
     * Permet de vérifier la présence de paramètres dans la requête, puis
     * de les rendre accessibles via l'attribut params.
     */
    public function requireParams($array, $params)
    {
        foreach($params as $param) {
            if ( ! isset($array[$param])) {
                return false;
            }
            $this->params[$param] = $array[$param];
        }
        return true;
    }
    
    public function need ($name)
    {
        // Paramètre d'une requête GET
        if ($this->method === 'get' && isset($_GET[$name])) {
            return $_GET[$name];
        }
        
        // Paramètre d'une requête POST
        else if ($this->method === 'post' && isset($_POST[$name])) {
            return $_POST[$name];
        }
        
        // En cas d'erreur
        $this->renderError('Paramètre manquant');
    }
    
    /*
     * Fonction pour rendre plus facilement une erreur.
     */
    public function renderError($message)
    {
        $this->render('error', [
            'message' => $message
        ]);
    }
    
    /**
     * Applique la logique du contrôlleur au moment de sa destruction.
     */
    function __destruct()
    {
        $this->resolve();
    }
}
