<?php


namespace App\Controllers;

use App\Core\App;
use App\Core\Blade;
use App\Core\Redirect;
use App\Core\Request;
use App\Repositories\DomainRepository;
use App\Repositories\TypeRepository;
use App\Repositories\UserRepository;
use App\Repositories\WineRepository;
use App\Repositories\YearRepository;

/**
 * Class SearchController
 * @package App\Controllers
 */
class SearchController{

    private static $searchMap = [
        'vins' => [
            'title' => 'Recherche de vins',
            'placeholder' => 'Rechercher dans le nom et la description des vins'
        ],'domaines' => [
            'title' => 'Recherche de domaines',
            'placeholder' => 'Rechercher dans le nom des domaines'
        ],'annees' => [
            'title' => 'Recherche d\'années',
            'placeholder' => 'Rechercher dans les années'
        ],'types' => [
            'title' => 'Recherche de types',
            'placeholder' => 'Rechercher dans le nom des types'
        ],'utilisateurs' => [
            'title' => 'Recherche d\'utilisateurs',
            'placeholder' => 'Rechercher dans le nom et la description des utilisateurs'
        ]
    ];

    public function handleSearch(Request $req, $action){
        if(!array_key_exists($action, self::$searchMap)){
            return Redirect::back();
        }
        return Blade::create('pages.search', [
            'action' => $action,
            'actionDisplay' => self::$searchMap[$action]
        ]);
    }

    public function handleResults(Request $req, $action){
        $str = $req->input('str') ?? '';
        $result = '';
        switch ($action){
            case 'vins':
                $wRepo = new WineRepository();
                $yRepo = new YearRepository();
                $result = $this->processResults($wRepo->search($str), function($wine) use ($yRepo) {
                    $wine->setYearId($yRepo->get($wine->getYearId()));
                    return Blade::create('components.wine.card', ['wine' => $wine]);
                });
                break;
            case 'domaines':
                $dRepo = new DomainRepository();
                $result = $this->processResults($dRepo->search($str), function($domain) {
                    return Blade::create('components.domain.card', ['domain' => $domain]);
                });
                break;
            case 'annees':
                $yRepo = new YearRepository();
                $result = $this->processResults($yRepo->search($str), function($year) {
                    return Blade::create('components.year.card', ['year' => $year]);
                });
                break;
            case 'types':
                $tRepo = new TypeRepository();
                $result = $this->processResults($tRepo->search($str), function($type) {
                    return Blade::create('components.type.card', ['type' => $type]);
                });
                break;
            case 'utilisateurs':
                $uRepo = new UserRepository();
                $result = $this->processResults($uRepo->search($str), function($user) {
                    return Blade::create('components.user.card', ['user' => $user]);
                });
                break;
        }

        return App::jsonPayload(true, [
            'result' => $result
        ]);
    }

    private function processResults($results, $func){
        if($results === null || count($results) == 0){
            return '';
        }
        $result = '<div class="row">';
        foreach($results as $item){
            $result .= '<div class="col-sm-6 col-md-3">';
            $result .= $func($item);
            $result .= '</div>';
        }
        return $result . '</div>';
    }
}