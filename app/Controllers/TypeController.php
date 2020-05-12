<?php


namespace App\Controllers;


use App\Core\App;
use App\Core\Blade;
use App\Core\Redirect;
use App\Core\Request;
use App\Repositories\TypeRepository;

class TypeController
{
    public function handlePage(Request $res, $tid){
        $tRepo = new TypeRepository();
        $type = $tRepo->get($tid);

        if($type == null){
            App::addError('Le type demandé n\'existe pas');
            return Redirect::back();
        }

        return Blade::create('pages.type', [
            'tid' => $tid,
            'type' => $type
        ]);
    }
}