

<?php 
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=projetweb;charset=utf8', 'root', '');
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
$req = $bdd->prepare('SELECT adresse_mail, mdp_hachee FROM personne WHERE adresse_mail = ?');
if (isset($_COOKIE['adresse_mail'])&& isset($_COOKIE['pass'])){
    $pass=$_COOKIE['mdp_hachee'];
	$req->execute(array($_COOKIE['adresse_mail']));
	$resultat = $req->fetch();
    if ($pass == $resultat['mdp_hachee']){
	session_start();
		$_SESSION['adresse_mail'] = $_COOKIE['adresse_mail'];
		header("Status: 301 Moved Permanently", false, 301);	
		header("Location: /coroshop/index.php");
	}
	else{
		setcookie('login', '');
            setcookie('pass_hache', ''); 
header("Status: 301 Moved Permanently", false, 301);
header("Location: /coroshop/public/formulaire_connexion.php?p=false");
}
}
else{
	$req->execute(array($_POST['adresse_mail']));
	$resultat = $req->fetch();
	$isPasswordCorrect = password_verify($_POST['password'], $resultat['mdp_hachee']);
	if (!$resultat)
	{
	    	header("Status: 301 Moved Permanently", false, 301);
		header("Location: /coroshop/public/formulaire_connexion.php?p=false"); 
	}
	else
	{
	    if ($isPasswordCorrect) {
		session_start();
		$_SESSION['adresse_mail'] = $_POST['adresse_mail'];
		header("Status: 301 Moved Permanently", false, 301);	
		header("Location: /coroshop/index.php");
	    }
	    else {
		header("Status: 301 Moved Permanently", false, 301);
		header("Location: /coroshop/public/formulaire_connexion.php?p=false"); 
	    }
	}
}
