<?php
if (isset($_POST['valider']))
{
    $pseudo= htmlspecialchars($_POST['pseudo']);
    $email= htmlspecialchars($_POST['email']);
    $pseudo_discord= htmlspecialchars($_POST['pseudo_discord']);
    $promo= htmlspecialchars($_POST['promo']);
    $mdp1= sha1($_POST['mdp1']);
    $mdp2= sha1($_POST['mdp2']);
    $dbAdapter = (new DbAdaperFactory())->createService();
    $userRepository = new \src\Model\repository\UserRepository($dbAdapter);
    $users = $userRepository->fetchAll();
    
    
    if(!empty($_POST['email']) AND !empty($_POST['pseudo']) AND !empty($_POST['mdp1']) AND !empty($_POST['mdp2']) )
    {
        $pseudolength=strlen($pseudo);
        if($pseudolength <= 16)
        {
            if(filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                if($mdp1==$mdp2)
                {   
                    $err=0;
                    foreach($users as $user)
                    {
                        if($user->getEmail() == $email)
                        {
                            $err=1;
                            $erreur= "Cet email est déjà pris!";
                            header('Location: signup.php?erreur='.$erreur.'&promo='.$promo.'&pseudo='.$pseudo.'&pseudo_discord='.$pseudo_discord);
                        }
                        else if(strtolower($user->getUsername()) == strtolower($pseudo))
                        {
                            $err=2;
                            $erreur= "Ce pseudo est déjà pris!";
                            header('Location: signup.php?erreur='.$erreur.'&email='.$email.'&promo='.$promo.'&pseudo_discord='.$pseudo_discord);
                        }
                            
    
                    }
                    if($err==0)
                    {
                        $userRepository->insert($email,$pseudo,$mdp1,$promo,$pseudo_discord);
                        $users = $userRepository->profil($pseudo);
                        foreach($users as $user)
                        {
                            $id=$user->getId();

                        }
                        $_SESSION["name"] = $pseudo;
                        $_SESSION["isAdmin"] = 'FALSE';
                        $_SESSION['id']=$user->getId();
                        header('Location: index.php'); 
                    }
                }                  
                else
                {
                    $erreur= "Vos mots de passe ne correspondent pas !";
                    header('Location: signup.php?erreur='.$erreur.'&email='.$email.'&pseudo='.$pseudo.'&promo='.$promo.'&pseudo_discord='.$pseudo_discord);
                }
            }
            else 
            {
                $erreur= "Votre adresse mail n'est pas valide !";
                header('Location: signup.php?erreur='.$erreur.'&email='.$email.'&pseudo='.$pseudo.'&promo='.$promo.'&pseudo_discord='.$pseudo_discord);
            }
        }
        else
        {            
            $erreur= "Votre pseudo ne doit pas dépasser 16 caractères !";
            header('Location: signup.php?erreur='.$erreur.'&email='.$email.'&pseudo='.$pseudo.'&promo='.$promo.'&pseudo_discord='.$pseudo_discord);
        }
    }
    else
    {
        $erreur = "Tout les champs obligatoires doivent être remplis !";
        header('Location: signup.php?erreur='.$erreur.'&email='.$email.'&pseudo='.$pseudo.'&promo='.$promo.'&pseudo_discord='.$pseudo_discord);
    }
}

?>