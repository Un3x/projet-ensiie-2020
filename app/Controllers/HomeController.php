<?php


namespace App\Controllers;

use App\Core\Blade;
use App\Core\File;
use App\Core\Request;
use App\Repositories\CommentRepository;
use App\Repositories\WineRepository;


class HomeController
{
    function handleHome(Request $req){
        $wrepo = new WineRepository();
        $crepo = new CommentRepository();
        $folder = 'img/pages/home/picsHome';
        $files = File::listFiles(File::asset($folder));

        return Blade::create('pages.home',
            ['tabWines' => $wrepo->getLast(),
            'tabCom' => $crepo->getMostLiked(),
            'allCom' => $crepo->getAllComments(),
            'randomFunc' => function() use ($files, $folder) {
                return $folder . '/' . $files[array_rand($files)];
            }]
        );
    }
}