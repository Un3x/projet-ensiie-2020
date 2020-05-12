<?php


namespace App\Composers;


use App\Repositories\WineRepository;
use App\Repositories\YearRepository;

class FavoriteWinesComposer
{
    public function compose($view, $vars){
        $wRepo = new WineRepository();
        $wines = [];

        $yRepo = new YearRepository();
        foreach($wRepo->getAllFavorites(array_key_exists('uid', $vars) ? $vars['uid'] : null, 4, null) as $wine){
            $wines[] = $wine->setYearId($yRepo->get($wine->getYearId()));
        }

        return \array_merge($vars, ['favWines' => $wines]);
    }
}