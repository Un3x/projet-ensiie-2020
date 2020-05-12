<?php


namespace App\Core;

use Closure;
use eftec\bladeone\BladeOne;
use Exception;

/**
 * Class Blade
 * @package App\Core
 */
class Blade extends BladeOne
{
    /**
     * @var Blade L'instance de Blade
     */
    private static $instance;

    /**
     * Stocke les vues composées
     * @var array
     */
    private $composedViews = [];

    /**
     * Permet de définir un composer pour une vue
     *
     * @param $view
     * @param $callback
     */
    public static function compose($view, $callback){
        if(is_string($callback)){
            App::singleton($callback, function() use ($callback) {return new $callback;});
            $callback = Closure::fromCallable([App::resolve($callback), "compose"]);
        }
        self::instance()->composedViews[$view] = $callback;
    }

    /**
     * Permet de créer la réponse pour la vue donnée avec les variables données
     * @see Blade::run()
     * @param $view
     * @param array $variables
     * @return string
     * @throws Exception
     */
    public static function create($view, $variables = []){
        return self::instance()->run($view, $variables);
    }

    /**
     * Gère les vues composées
     *
     * @param $view
     * @param $array
     * @return array
     */
    private function handleComposed($view, $array){
        if(\array_key_exists($view, $this->composedViews)){
            $callback = $this->composedViews[$view];
            return \array_merge($array, $callback($view, $array));
        }
        return $array;
    }

    /**
     * Permet de créer la réponse pour la vue donnée avec les variables données
     *
     * @param string $view
     * @param array $variables
     * @return string
     * @throws \Exception
     */
    public function run($view, $variables = []){
        return parent::run($view, $this->handleComposed($view, $variables));
    }

    /**
     * OVERRIDE: Remplace runChild pour gérer les vues composées
     *
     * @param $view
     * @param array $variables
     * @return string
     * @throws \Exception
     */
    public function runChild($view, $variables = []){
        if (\is_array($variables)) {
            return parent::runChild($view, $this->handleComposed($view, \array_merge($this->variables, $variables)));
        } else {
            $this->showError('run/include', "Include/run variables should be defined as array ['idx'=>'value']", true);
            return '';
        }
    }

    /**
     * Renvoie l'instance de Blade
     * @return Blade
     */
    public static function & instance(){
        if(self::$instance === null){
            $views = __ROOT__ . '/app/Views';
            $cache = __ROOT__ . '/cache';
            self::$instance = new Blade($views, $cache,BladeOne::MODE_AUTO);
            self::$instance->setBaseUrl(Request::baseUrl() . 'assets/');
            self::$instance->setCanFunction([Auth::class, 'isLogged']);

            self::$instance->directiveRT('csrfvalue', function () {
                $csrfValue = self::$instance->csrf_token;
                return "<?php echo '$csrfValue'; ?>";
            });
        }

        return self::$instance;
    }
}