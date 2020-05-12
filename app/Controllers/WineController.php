<?php


namespace App\Controllers;


use App\Core\App;
use App\Core\Auth;
use App\Core\Blade;
use App\Core\Redirect;
use App\Core\Request;
use App\Core\Response;
use App\Models\Domain;
use App\Models\Type;
use App\Models\User;
use App\Models\Wine;
use App\Models\Year;
use App\Repositories\CommentRepository;
use App\Repositories\DomainRepository;
use App\Repositories\TypeRepository;
use App\Repositories\UserRepository;
use App\Repositories\WineRepository;
use App\Repositories\YearRepository;

class WineController
{
    public function handleNewPage(Request $res){
        $wine = new Wine();
        $wine
            ->setId(null)
            ->setName(Response::old('name', 'Joli titre de vin'))
            ->setDescription(Response::old('description', 'Jolie description qui mettra en valeur ce vin !'))
            ->setTags(Response::old('tags', 'Tag'))
            ->setProposedBy(Auth::loggedUser());
        $wine->{'likes'} = 0;
        $wine->{'isLiked'} = false;
        return Blade::create('pages.wine', [
            'wine' => $wine,
            'editMode' => true,
            'canEdit' => true,
            'isCreating' => true,
            'domain' => (new Domain())->setName(Response::old('domain', 'Un domaine')),
            'type' => (new Type())->setName(Response::old('type', 'Un type')),
            'year' => (new Year())->setYear(Response::old('year', 1234))
        ]);
    }

    public function handleExistingPage(Request $res, $wid){
        $res = $this->handleWineDemand($wid);
        if(!is_array($res)){
            return $res;
        }

        $canEdit = Auth::isLogged() && (Auth::loggedUser()->getRole() & User::ADMIN_ROLE || (Auth::loggedUser()->getRole() & User::VIEWER_ROLE && Auth::loggedUser()->getId() === $res['wine']->getProposedBy()->getId()));

        return Blade::create('pages.wine', \array_merge($res, ['isCreating' => false, 'editMode' => false, 'canEdit' => $canEdit]));
    }

    public function handleExistingEditPage(Request $req, $wid){
        $res = $this->handleWineDemand($wid);
        if(!is_array($res)){
            return $res;
        }

        $canEdit = Auth::isLogged() && (Auth::loggedUser()->getRole() & User::ADMIN_ROLE || (Auth::loggedUser()->getRole() & User::VIEWER_ROLE && Auth::loggedUser()->getId() === $res['wine']->getProposedBy()->getId()));
        if(!$canEdit){
            App::addError('Vous n\'avez pas accès à cette page');
            return Redirect::back();
        }

        return Blade::create('pages.wine', \array_merge($res, ['isCreating' => false, 'editMode' => true]));
    }

    public function handleWineLike(Request $req, $wid){
        $liked = $req->input('liked');
        if(!Auth::isLogged()){
            App::addError('Vous devez être connecté !');
            return App::jsonPayload(false);
        }
        if($liked === null){
            App::addError('Il faut décrire si le like est présent ou non !');
            return App::jsonPayload(false);
        }

        $repo = new WineRepository();
        $res = $repo->setFavorite(Auth::loggedUser()->getId(), $wid, $liked);

        return App::jsonPayload(true, ['count' => $repo->getFavoriteCountByWine($wid)]);
    }

    private function handleWineDemand($wid){
        $wRepo = new WineRepository();
        $wine = $wRepo->get($wid);
        if($wine == null){
            App::addError('Le vin demandé n\'existe pas');
            return Redirect::back();
        }

        $wine->{'likes'} = $wRepo->getFavoriteCountByWine($wid);
        $wine->{'isLiked'} = Auth::isLogged() ? $wRepo->isFavorite(Auth::loggedUser()->getId(), $wid) : false;

        $uRepo = new UserRepository();
        $user = $uRepo->get($wine->getProposedBy());
        if($user == null){
            App::addError('Impossible de trouver l\'utilisateur qui a proposé ce vin');
            return Redirect::back();
        }
        $wine->setProposedBy($user);

        $dRepo = new DomainRepository();
        $domain = $dRepo->get($wine->getDomainId());
        if($domain == null){
            App::addError('Le vin n\'a pas un domaine valide');
            return Redirect::back();
        }
        $tRepo = new TypeRepository();
        $type = $tRepo->get($wine->getTypeId());
        if($type == null){
            App::addError('Le vin n\'a pas un type valide');
            return Redirect::back();
        }
        $yRepo = new YearRepository();
        $year = $yRepo->get($wine->getYearId());
        if($year == null){
            App::addError('Le vin n\'a pas une année valide');
            return Redirect::back();
        }

        $cRepo = new CommentRepository();
        $topCom = $cRepo->getMostLiked(1, $wid);

        $topCom = count($topCom) > 0 ? $topCom[0] : null;

        return [
            'wid' => $wid,
            'wine' => $wine,
            'domain' => $domain,
            'topCom' => $topCom,
            'type' => $type,
            'year' => $year
        ];
    }
}