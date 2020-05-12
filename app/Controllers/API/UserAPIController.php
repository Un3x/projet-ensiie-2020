<?php


namespace App\Controllers\API;

use App\Core\App;
use App\Core\Auth;
use App\Core\Pgsql;
use App\Core\Redirect;
use App\Core\Request;
use App\Core\Session;
use App\Models\User;
use App\Repositories\UserRepository;
use Exception;

class UserAPIController
{
    public function handleLogin(Request $req){
        $usernameOrEmail = $req->input('usernameOrEmail');
        $password = $req->input('password');

        if(Auth::isLogged() && (Auth::loggedUser()->getUsername() == $usernameOrEmail || Auth::loggedUser()->getEmail() == $usernameOrEmail )){
            App::addWarning("Vous êtes déjà connecté !");
            return $this->processRedirect($req, true);
        }

        $errorHappened = false;
        if($usernameOrEmail == null){
            App::addError("Veuillez entrer un nom d'utilisateur ou une adresse mail");
            $errorHappened = true;
        }
        if($password == null){
            App::addError("Veuillez entrer un mot de passe");
            $errorHappened = true;
        }

        if($errorHappened){
            return $this->processRedirect($req, false);
        }

        // On récupère les utilisateurs de la bdd
        $dbAdaper = App::resolve(Pgsql::class);
        $userRepository = new UserRepository();

        try{
            $user = $userRepository->checkUser($usernameOrEmail, $password);
            if($user === false){
                App::addError("Mauvais mot de passe ou compte inexistant !");
                return $this->processRedirect($req, false);
            }

            $oldUser = Auth::_loginSession($user->getId());
            App::addSuccess('Vous êtes bien connecté ' . ($oldUser->getLastLogged() !== null ? '(dernière connexion sur cet appareil ' . $oldUser->getLastLogged()->diffForHumans() . ')' : ''));

            //Evite les attaques par fixation de session !
            Session::regenerate(true);

            return $this->processRedirect($req, true);
        }catch (Exception $e){
            App::addError($e->getMessage());
            return $this->processRedirect($req, false);
        }
    }

    public function handleLogout(Request $req){
        if(!Auth::isLogged()){
            App::addWarning("Vous êtes déjà déconnecté !");
            return $this->processRedirect($req, true);
        }

        Auth::_logoutSession();
        App::addSuccess("Vous êtes bien déconnecté");

        //Evite les attaques par fixation de session !
        Session::regenerate(true);

        return $this->processRedirect($req, true);
    }

    public function handleRegister(Request $req){
        $pseudo = $req->input('pseudo');
        $email = $req->input('email');
        $password = $req->input('password');
        $password_confirmation = $req->input('password_confirmation');
        $agreement = $req->input('agreement');

        $errorHappened = false;
        if($pseudo == null){
            App::addError("Veuillez entrer un nom d'utilisateur");
            $errorHappened = true;
        }
        if($email == null){
            App::addError("Veuillez entrer une adresse mail");
            $errorHappened = true;
        }
        if($password == null){
            App::addError("Veuillez entrer un mot de passe");
            $errorHappened = true;
        }
        if($password_confirmation == null){
            App::addError("Veuillez entrer une confirmation de mot de passe");
            $errorHappened = true;
        }
        if($password !== $password_confirmation){
            App::addError("La confirmation du mot de passe n'est pas identique au mot de passe");
            $errorHappened = true;
        }
        if(!$agreement){
            App::addError("Vous devez accepter les termes et conditions");
            $errorHappened = true;
        }

        if($errorHappened){
            return $this->processRedirect($req, false);
        }

        // On récupère les utilisateurs de la bdd
        $dbAdaper = App::resolve(Pgsql::class);
        $userRepository = new UserRepository($dbAdaper);

        if($userRepository->isUserAlreadyExists($pseudo, $email)){
            App::addError("Le pseudo ou l'adresse mail est déjà enregistré");
            return $this->processRedirect($req, false);
        }

        $user = new User($email, $pseudo, App::hashPassword($password), new \DateTime());

        $newId = $userRepository->addUser($user);
        if($newId === null){
            App::addError("Une erreur est survenue lors de l'ajout du compte");
            return $this->processRedirect($req, false);
        }

        App::addSuccess("Votre compte a bien été créé !");

        Auth::_loginSession($newId);

        //Evite les attaques par fixation de session !
        Session::regenerate(true);

        return $this->processRedirect($req, true);
    }

    private function processRedirect(Request $req, $isOk){
        if($req->hasInput('redirect_path')){
            return !$isOk ? Redirect::back()->withInput() : Redirect::to(rtrim(Request::baseUrl(), '/') . '/' . ltrim($req->input('redirect_path'), '/'))->withInput();
        }
        return App::jsonPayload($isOk);
    }
}