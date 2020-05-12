<?php


namespace App\Controllers\API;


use App\Core\App;
use App\Core\Auth;
use App\Core\File;
use App\Core\Redirect;
use App\Core\Request;
use App\Repositories\UserRepository;

class ProfileAPIController
{
    public function handleDelete(Request $req, $uid){
        if(!Auth::isLogged()){
            App::addError("Vous n'êtes pas connecté !");
            return Redirect::back();
        }

        $uRepo = new UserRepository();
        $user = $uRepo->get($uid);
        if($user == null){
            App::addError("Impossible de trouver le user !");
            return Redirect::back();
        }

        if(!Auth::canEdit($user)){
            App::addError("Vous n'avez pas les droits pour cette action !");
            return Redirect::back();
        }

        $res = $uRepo->delete($user->getId());

        if($res){
            App::addSuccess("L'utilisateur a bien été supprimé");
        }else{
            App::addError("Echec de la suppression complète de l'utilisateur");
        }
        return Redirect::name('home');
    }

    public function handleEdit(Request $req, $id){
        $pseudo = $req->input('username');
        $description = $req->input('description');
        $ppPicture = $req->input('profilePicture');
        $bgPicture = $req->input('bgPicture');

        $errorHappened = false;
        if($pseudo == null){
            App::addError("Veuillez entrer un pseudo !");
            $errorHappened = true;
        }
        if($description == null){
            App::addError("Veuillez entrer une description !");
            $errorHappened = true;
        }

        if($errorHappened){
            return $this->processRedirect($req, false);
        }

        $repo = new UserRepository();
        $user = $repo->get($id);
        if($user == null){
            App::addError("L'id donné est invalide !");
            return $this->processRedirect($req, false);
        }
        if(!Auth::canEdit($user)){
            App::addError("Bien tenté, mais tu n'as pas le droit de faire ça ;)");
            return $this->processRedirect($req, false);
        }

        if(strtolower($user->getUsername()) !== strtolower($pseudo) && $repo->isUserAlreadyExists($pseudo)){
            App::addError("Le pseudo est déjà utilisé !");
            return $this->processRedirect($req, false);
        }

        if($errorHappened || ($ppPicture['error'] !== UPLOAD_ERR_NO_FILE && !$this->manageFile($ppPicture, 'pp', $id)) || ($bgPicture['error'] !== UPLOAD_ERR_NO_FILE && !$this->manageFile($bgPicture, 'bg', $id))){
            return $this->processRedirect($req, false);
        }

        $user->setUsername($pseudo);
        $user->setDescription($description);

        $repo->saveUser($user);

        App::addSuccess("Votre profil a bien été enregistré");
        return $this->processRedirect($req, true);
    }

    private function manageFile($file, $dir, $uid){
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

        \imagejpeg($output, File::asset('img/users/' . $dir . '/' . $uid . '.jpg'));
        return true;
    }


    private function processRedirect(Request $req, $isOk){
        if($req->hasInput('redirect_path')){
            return !$isOk ? Redirect::back()->withInput() : Redirect::to(rtrim(Request::baseUrl(), '/') . '/' . ltrim($req->input('redirect_path'), '/'))->withInput();
        }
        return App::jsonPayload($isOk);
    }
}