<?php


namespace App\Controllers\API;


use App\Core\App;
use App\Core\Auth;
use App\Core\File;
use App\Core\Redirect;
use App\Core\Request;
use App\Models\User;
use App\Models\Wine;
use App\Repositories\DomainRepository;
use App\Repositories\TypeRepository;
use App\Repositories\WineRepository;
use App\Repositories\YearRepository;

class WineAPIController
{
    public function handleEditAndNew(Request $req, $wid = null){
        $name = $req->input('name');
        $domain = $req->input('domain');
        $type = $req->input('type');
        $year = $req->input('year');
        $tags = $req->input('tags');
        $desc = $req->input('description');
        $winePicture = $req->input('winePicture');

        $errorHappened = false;
        if($name == null){
            App::addError("Veuillez entrer un nom pour le vin");
            $errorHappened = true;
        }
        if($domain == null){
            App::addError("Veuillez entrer un domaine pour le vin");
            $errorHappened = true;
        }
        if($type == null){
            App::addError("Veuillez entrer un type pour le vin");
            $errorHappened = true;
        }
        if($year == null){
            App::addError("Veuillez entrer une année pour le vin");
            $errorHappened = true;
        }
        if($tags === null){
            App::addError("Veuillez entrer des tags pour le vin");
            $errorHappened = true;
        }
        if($desc == null){
            App::addError("Veuillez entrer une description pour le vin");
            $errorHappened = true;
        }
        if($errorHappened){
            return Redirect::back()->withInput();
        }

        $wRepo = new WineRepository();
        if($wid != null){
            $checkedWine = $wRepo->get($wid);

            if($checkedWine == null){
                App::addError('Impossible de trouver le vin demandé');
                return Redirect::back()->withInput();
            }

            if(!$this->canEdit($checkedWine)){
                Redirect::back()->withInput();
            }
        }

        $domain = (new DomainRepository())->getIdOrInsert($domain);
        $type = (new TypeRepository())->getIdOrInsert($type);
        $year = (new YearRepository())->getIdOrInsert($year);

        $randomId = bin2hex(random_bytes(15));
        if($wid == null){
            $wid = $randomId;
        }

        if($errorHappened || ($winePicture['error'] !== UPLOAD_ERR_NO_FILE && !$this->manageFile($winePicture, $wid))){
            return Redirect::back()->withInput();
        }

        $wine = new Wine();
        $wine
            ->setId($wid)
            ->setDomainId($domain)
            ->setTypeId($type)
            ->setYearId($year)
            ->setProposedBy(Auth::loggedUser()->getId())
            ->setTags($tags)
            ->setName($name)
            ->setDescription($desc);

        if($wid == $randomId){
            if($res = $wRepo->addWine($wine)){
                App::addSuccess('Le vin a bien été ajouté');
            }
        }else{
            if($res = $wRepo->saveWine($wine)){
                App::addSuccess('Le vin a bien été mis à jour');
            }
        }
        if(!$res){
            App::addError("Une erreur est survenue !");
        }

        if(File::exists(File::asset("img/wines/$randomId.png"))){
            \rename(File::asset("img/wines/$randomId.png"), File::asset("img/wines/$res.png"));
        }

        return Redirect::name('winePage', ['id' => $res]);
    }

    public function handleDelete(Request $req, $wid){
        $wRepo = new WineRepository();
        $wine = $wRepo->get($wid);
        if(!$this->canEdit($wine)){
            return Redirect::back()->withInput();
        }

        if($wRepo->delete($wid) === null){
            App::addError("Un problème est survenue lors de la suppression du vin");
        }else{
            App::addSuccess('Le vin a bien été supprimé');
        }

        return Redirect::name('home');
    }

    private function manageFile($file, $wid){
        $error = $file['error'];
        if($error !== UPLOAD_ERR_OK ){
            App::addError((isset($file['name']) ? $file['name'] . ' : ' : "") . Request::PHP_FILE_ERRORS[$error]);
            return false;
        }

        $output = File::convertImage($file['tmp_name']);
        if(!$output){
            App::addError("Impossible de convertir l'image");
            return false;
        }

        \imagepng($output, File::asset('img/wines/' . $wid . '.png'));
        return true;
    }

    private function canEdit($wine){
        if(!(Auth::loggedUser()->getRole() & User::ADMIN_ROLE ||
            (Auth::loggedUser()->getRole() & User::VIEWER_ROLE && Auth::loggedUser()->getId() === $wine->getProposedBy()))){
            App::addError('Vous n\'avez pas la permission de faire cette action');
            return false;
        }
        return true;
    }
}