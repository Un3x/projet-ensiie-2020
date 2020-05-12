<?php


namespace App\Controllers;


use App\Core\App;
use App\Core\Blade;
use App\Core\Redirect;
use App\Core\Request;
use App\Repositories\YearRepository;

class YearController
{
    public function handlePage(Request $res, $yid){
        $yRepo = new YearRepository();
        $year = $yRepo->get($yid);

        if($year == null){
            App::addError('L\'année demandée n\'existe pas');
            return Redirect::back();
        }

        return Blade::create('pages.year', [
            'yid' => $yid,
            'year' => $year
        ]);
    }
}