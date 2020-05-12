<?php

if(isset($_SESSION['name']) AND !empty($_SESSION['id']))

{
    
    if($_SESSION['id']==$_GET['id'])
    {
        $dbAdapter = (new DbAdaperFactory())->createService();
        $userRepository = new \src\Model\repository\UserRepository($dbAdapter);
        $users=$userRepository->profil($_SESSION['name']);
        $allusers = $userRepository->fetchAll();
        foreach($users as $user)
        {
            $username=!empty($_POST['newpseudo'])? ($_POST['newpseudo']):$user->getUsername();
            $email=!empty($_POST['newemail'])? ($_POST['newemail']):$user->getEmail();
            $promo=!empty($_POST['newpromo'])? ($_POST['newpromo']):$user->getPromo();
            $discord=!empty($_POST['newds'])? ($_POST['newds']):$user->getPseudoDiscord();
        }
        $err=0;
        
        foreach($allusers as $alluser)
        {
            if(empty($_POST['newpseudo']))
            {
                break;
            }
            else if(strtolower($alluser->getUsername()) == strtolower($username))
            {
                $err=2;
                header('Location: profil.php?action=modifier&err='.$err.'&id='.$_GET['id']);
            }
        }
        echo $err;
        if($err==0)
        {
            
            if(isset($_POST['newmdp1'])&& isset($_POST['newmdp2']) AND !empty($_POST['newmdp2']) AND !empty($_POST['newmdp1']) )
            {
                if($_POST['newmdp1']==$_POST['newmdp2'])
                {
                    $userRepository->update($_SESSION['id'],$username,$_POST['newmdp1'],$promo,$discord);
                    $_SESSION['name']=$username;
                    header('location: profil.php?pseudo='.$username);
                }
                else
                {
                    $erreur=1;
                    header('location: profil.php?action=modifier&err='.$erreur);
                }
            }
            else
            {
                $userRepository->update2($_SESSION['id'],$username,$promo,$discord);
                $_SESSION['name']=$username;
                header('location: profil.php?pseudo='.$username);
            }
        }
    }
    else
    {
        header("location: profil.php");
    }

}
else
{
    header('location:login.php');
}
?>