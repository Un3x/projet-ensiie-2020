<?php


namespace App\Controllers\API;


use App\Core\App;
use App\Core\Request;
use App\Repositories\DomainRepository;
use App\Repositories\TypeRepository;
use App\Repositories\YearRepository;

class SearchAPIController
{
    function handleDomain(Request $req){
        $search = $req->input('q', '');
        $dRepo = new DomainRepository();
        $result = $dRepo->search($search, false, null, null, true);
        $content = [];
        foreach($result as $domain){
            $content[] = $domain->getName();
        }

        return App::jsonPayload(null, $content, true);
    }

    function handleType(Request $req){
        $search = $req->input('q', '');
        $tRepo = new TypeRepository();
        $result = $tRepo->search($search, false, null, null, true);
        $content = [];
        foreach($result as $type){
            $content[] = $type->getName();
        }

        return App::jsonPayload(null, $content, true);
    }

    function handleYear(Request $req){
        $search = $req->input('q', '');
        $yRepo = new YearRepository();
        $result = $yRepo->search($search, false, null, null, true);
        $content = [];
        foreach($result as $year){
            $content[] = $year->getYear();
        }

        return App::jsonPayload(null, $content, true);
    }
}