<?php
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

session_start();

if(isset($_POST['username']) && isset($_POST['password']))
{
    // connexion à la base de données
    $dbAdaper = (new DbAdaperFactory())->createService();
    $userRepository = new \User\UserRepository($dbAdaper);
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if($username !== "" && $password !== "")
    {
      $count = $userRepository->checkUserAuthentification($username, $password);
      if($count!=0) { // nom d'utilisateur et mot de passe corrects
         $count2 = $userRepository->checkAdminAuthentification($username, $password);
         $count3 = $userRepository->checkSuperAdminAuthentification($username, $password);
         if($count2 != 0){
            $_SESSION['user'] = $userRepository->getUser($username);
            $_SESSION['username'] = $_SESSION['user']->getUsername();
            header('Location: home_admin.php'); //si admin, cela renvoie vers la page d'admin
         }
         else if($count3!=0){
            $_SESSION['user'] = $userRepository->getUser($username);
            $_SESSION['username'] = $_SESSION['user']->getUsername();
            header('Location: home_super_admin.php'); //si super_admin, cela renvoie vers la page du super admin
         }
         else{
            $_SESSION['user'] = $userRepository->getUser($username);
            $_SESSION['username'] = $_SESSION['user']->getUsername();
            header('Location: userlist.php'); //si user normal, on est renvoyé vers userlist
         }
      }
      else{
         header('Location: index.php?erreur=1'); // utilisateur ou mot de passe incorrect
      }
  }
  else
  {
     header('Location: index.php?erreur=2'); // utilisateur ou mot de passe vide
  }
}
else
{
 header('Location: index.php');
}

?>