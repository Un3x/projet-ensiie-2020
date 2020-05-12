<?php
session_start();
include("db_connect.php");

  
if(isset($_SESSION['id'])) {
	$pseudo = $bdd->prepare('SELECT * FROM membre WHERE id=?');
	$pseudo->execute(array($_SESSION['id']));
	$pseudo=$pseudo->fetch();
	$reqpseudo = $bdd->prepare("SELECT * FROM membre WHERE pseudo=?");
	$reqpseudo->execute(array($pseudo));
	$pseudoexiste = $reqpseudo->rowCount();
	if($pseudoexiste == 0) {
		if(isset($_POST['tsubmit'])) {
			$reqmail = $bdd->prepare("SELECT * FROM membre WHERE mail=?");
			$reqmail->execute(array($mail));
			$mailexiste = $reqmail->rowCount();
			if($mailexiste == 0) {
				$requser = $bdd->prepare("SELECT * FROM membre WHERE id=?");
				$requser->execute(array($_SESSION['id']));
				$user = $requser->fetch();

				if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo']!=$user['pseudo']) {
					$newpseudo = htmlspecialchars($_POST['newpseudo']);
					$insertpseudo = $bdd->prepare("UPDATE membre SET pseudo = ? WHERE id = ?");
					$insertpseudo->execute(array($newpseudo,$_SESSION['id']));
					
				}
				if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail']!=$user['mail']) {
					$newmail = htmlspecialchars($_POST['newmail']);
					$insertmail = $bdd->prepare("UPDATE membre SET mail = ? WHERE id = ?");
					$insertmail->execute(array($newmail,$_SESSION['id']));
					
				}
				if(isset($_POST['newprenom']) AND !empty($_POST['newprenom']) AND $_POST['newprenom']!=$user['prenom']) {
					$newprenom = htmlspecialchars($_POST['newprenom']);
					$insertprenom = $bdd->prepare("UPDATE membre SET prenom = ? WHERE id = ?");
					$insertprenom->execute(array($newprenom,$_SESSION['id']));
					
				}
				if(isset($_POST['newnom']) AND !empty($_POST['newnom']) AND $_POST['newnom']!=$user['nom']) {
					$newnom = htmlspecialchars($_POST['newnom']);
					$insertnom = $bdd->prepare("UPDATE membre SET nom = ? WHERE id = ?");
					$insertnom->execute(array($newnom,$_SESSION['id']));
					
				}
				if(isset($_POST['newclub']) AND !empty($_POST['newclub']) AND $_POST['newclub']!=$user['club']) {
					$newclub = htmlspecialchars($_POST['newclub']);
					$insertclub = $bdd->prepare("UPDATE membre SET club = ? WHERE id = ?");
					$insertclub->execute(array($newclub,$_SESSION['id']));
					
				}
				if(isset($_POST['newversion']) AND !empty($_POST['newversion']) AND $_POST['newversion']!=$user['version']) {
					$newversion = htmlspecialchars($_POST['newversion']);
					$insertversion = $bdd->prepare("UPDATE membre SET m_version = ? WHERE id = ?");
					$insertversion->execute(array($newversion,$_SESSION['id']));
					
				}
				if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
					$newmdp1 = sha1($_POST['newmdp1']);
					$newmdp2 = sha1($_POST['newmdp2']);
					if($newmdp1 == $newmdp2){
						$insertmdp = $bdd->prepare("UPDATE membre SET motdepasse = ? WHERE id = ?");
						$insertmdp->execute(array($newmdp1,$_SESSION['id']));
						
					}
					else {
						$msg = "<span style='color:red'>Vos mots de passe ne correspondent pas !</span>";
					}
					
				}
				header("Location: profil.php?id=".$_SESSION['id']);
			}
			else { 
				$msg = "<span style='color:red'>Cette adresse mail est déjà utilisée !</span>";
			}
		}
	}
	else {
		$msg = "<span style='color:red'>Ce pseudo est déjà utilisé !</span>";
	}

	
?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style_MyM.css" />
        <title>MyManager</title>
    </head>
    
    <body>
        <div id="bloc_page">

            <!--Le header de la page-->
            <?php include('header.php'); ?>


			<div align="center">  
				<h1>Edition de mon profil</h1>
				<br /><br /><br />
				<div align="center">
				<form method="POST" action ="">
				<label>Prénom : </label>
				<input type="text" name="newprenom" placeholder="Prénom"/><br /><br />
				<label>Nom :</label>
				<input type="text" name="newnom" placeholder="Nom"/><br /><br />
				<label>Pseudo :</label>
				<input type="text" name="newpseudo" placeholder="Pseudo"/><br /><br />
				<label>Club de coeur:</label>
				<input type="text" name="newclub" placeholder="Club préféré"/><br /><br />
				<label>Version :</label>
				<input type="text" name="newversion" placeholder="Version"/><br /><br />
				<label>Mail :</label>
				<input type="email" name="newmail" placeholder="Mail"/><br /><br />
				<label>Nouveau mot de passe :</label>
				<input type="password" name="newmdp1" placeholder="Mot de passe" /><br /><br />
				<label>Confirmation du nouveau mot de passe :</label>
				<input type="password" name="newmdp2" placeholder="Confirmation du mot de passe" /><br /><br />					
				<input type="submit" name="tsubmit" value="Mettre à jour le profil" /><br /><br />
				</form>
				</div>


				<?php if(isset($msg)){
				echo $msg;} ?>
			</div>
	    
            <br /><br /><br />
            

            <!--Le footer du site-->
            <?php include('footer.php'); ?>
            
        </div>
    </body>
</html>

<?php
}
else {
	header("Location: connexion.php");
}
?>
