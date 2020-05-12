<?php

if ($_POST){
    $choixMenu =  $_POST['choix'] ?? null;
    $id =  $_POST['id'] ?? 0;

    $user=$userRepository->select($id);

    // problème en choisissant le menu
    if (null == $choixMenu || 0 == $id) {
        header('Location: index.php'); 
    }
    else{
        if($choixMenu == "Informations personnelles"){
            //include_once '../public/template.php';
            //loadView('usercnt', $id);
            header('Location: usercnt.php'); 
        }
        if($choixMenu == "Autres utilisateurs"){
            //include_once '../public/template.php';
            if($user->getRole()=="Membre")
            {
                //loadView('test', $id);
                header('Location: OtherUsrM.php'); 
            }
            if($user->getRole()=="Administrateur")
            {
                //loadView('testadm', $id);
                header('Location: OtherUsrA.php');
            }
        }
        if($choixMenu == "Messages"){
            /*
            if($user->getRole()=="Membre")
            {
                header('Location: msgUser.php');     
            }
            if($user->getRole()=="Administrateur")
            {
                header('Location: msgUserA.php');   
            } 
            */
            header('Location: msgUser.php');     
        }
    }
}
?>
<form action="" method="post">
  <input name="id" type="hidden" value="<?= $id ?>">
  <fieldset>
  <legend>Menu :</legend>
    <input type="submit" id="prs" value="Informations personnelles" name="choix">
    <input type="submit" id="ous" value="Autres utilisateurs" name="choix">
    <input type="submit" id="mus" value="Messages" name="choix"><br>
  </fieldset>
  <br>
</form>
