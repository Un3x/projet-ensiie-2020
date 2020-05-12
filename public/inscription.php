<?php require_once("header.php"); ?>
<?php
if ($_POST){
    $pseudo= $_POST['pseudo'] ?? null;
    $password= $_POST['password'] ?? null;

    $unchosen_ps=true;
    foreach ($users as $user)
    {
        if($user->getPseudo()==$pseudo)
        {
            $unchosen_ps=false;
        }
    }
    if ($unchosen_ps)
    {
        if ($pseudo&&$password)
        {
            //$userRepository = new UserRepository($dbAdaper);
            $userRepository->insert($pseudo,$password);
            $user = $userRepository->select_ps($pseudo);
            //include_once '../public/template.php';
            //loadView('test',$id);
            if ($user){
                $_SESSION['id']=$user->getId();
            }
            header('Location: usercnt.php');
        }
    }
    else 
    {
        //afficher erreur    
        //header('Location: home.php');
		echo '<h1>Pseudo déjà pris</h1>';  
        //include_once '../public/template.php';
        //loadView('home',0);
    }
}

?>

<form method="POST" action="">
    <label for="ps">Pseudo:</label>
    <input type="text" id="ps" name="pseudo"></br>
    <label for="pw">Password:</label>
    <input type="password" id="pw" name="password"></br>
    <button type="submit">Submit</button>
</form>

<?php require_once("footer.php"); ?>
