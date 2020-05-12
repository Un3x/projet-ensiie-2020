<?php

if(isset($_POST['Login']))
{
    $dbAdaper = (new DbAdaperFactory())->createService();
    $userRepository = new \src\Model\repository\UserRepository($dbAdaper);
    $users = $userRepository->fetchAll();
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $bool = false;
    $err = 2;
    foreach($users as $user){
        if ($user->getEmail() == $email)
        {
            if($user->getPasswd() == sha1($password))
            {
                $bool = true;
                $_SESSION['name'] = $user->getUsername();
                $_SESSION['isAdmin'] = $user->getIsAdmin();
                $_SESSION['id']=$user->getId();
            }
            else
            {
                $err=1;
            }
        }
    }
    if ($bool == true)
    {
        header('Location: home.php');
    }
    else
    {
        header('Location: login.php?erreur='.$err);
    }
}
else
{
    header('Location: login.php');
}
?>