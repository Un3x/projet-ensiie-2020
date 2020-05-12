<?php require_once("header.php"); ?>
<?php
$pseudo= $_POST['pseudo'] ?? null;
$password= $_POST['password'] ?? null;

if ($_POST){
    $is_us=false;
    foreach ($users as $user)
    {
        if($user->getPseudo()==$pseudo&&$user->getPassword()==$password)
        {
            $is_us=true;
            //include_once '../public/template.php';
            //loadView('usercnt',$user->getId());
            $_SESSION['id']=$user->getId();
            header('Location: usercnt.php');
        }
    }

    if (!$is_us)
    {
        //afficher erreur
        //header('Location: home.php');
		echo '<h1>Mot de passe ou pseudo incorrect</h1>'; 
    }
}
?>
<form method="POST" action="" >
    <label for="ps">Pseudo:</label>
    <input type="text" id="ps" name="pseudo"></br>
    <label for="pw">Password:</label>
    <input type="password" id="pw" name="password"></br>
    <button type="submit">Submit</button>
</form>
<?php require_once("footer.php"); ?>
