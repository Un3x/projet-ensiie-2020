<?php


namespace App\Controllers;

use App\Core\App;
use App\Core\Auth;
use App\Core\Blade;
use App\Core\Redirect;
use App\Core\Request;
use App\Core\Response;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use App\Repositories\WineRepository;
use Exception;

class ProfileController
{

    /**
     * @param Request $req
     * @param bool $id
     * @return Response|string
     * @throws Exception
     */
    public function handle(Request $req, $id = false){
        if($id === false){
            $user = Auth::loggedUser();
        }else{
            $user = (new UserRepository())->get($id);
        }

        if(!$user){
            App::addError("L'utilisateur demandé est introuvable !");
            return Redirect::back();
        }
        $cRepo = new CommentRepository();
        $wRepo = new WineRepository();

        return Blade::create('pages.profile', [
            'user' => $user,
            'canEdit' => Auth::canEdit($user),
            'comPosted' => $cRepo->getCountPostedByUser($user->getId()),
            'favWines' => $wRepo->getFavoriteWinesByUser($user->getId()),
            'wineProposed' => $wRepo->getProposedCountByUser($user->getId())
        ]);
    }
}