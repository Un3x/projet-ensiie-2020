<?php


namespace App\Controllers;


use App\Core\App;
use App\Core\Blade;
use App\Core\Redirect;
use App\Core\Request;
use App\Repositories\DomainRepository;

class DomainController
{
    public function handlePage(Request $res, $did){
        $dRepo = new DomainRepository();
        $domain = $dRepo->get($did);

        if($domain == null){
            App::addError('Le domaine demandé n\'existe pas');
            return Redirect::back();
        }

        return Blade::create('pages.domain', [
            'did' => $did,
            'domain' => $domain
        ]);
    }
}