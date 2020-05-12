<?php

include("db_connect.php");
  
$success = 0;
$err="";

if(isset($_POST['forminscription'])) {
	$pseudo = htmlspecialchars($_POST['pseudo']);
	$mail = htmlspecialchars($_POST['mail']);
	$mail2 = htmlspecialchars($_POST['mail2']);
	$mdp = sha1($_POST['mdp']);
	$mdp2 = sha1($_POST['mdp2']);
	if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
		$pseudolenght = strlen($pseudo);
		if($pseudolenght <= 255) {
			$reqpseudo = $bdd->prepare("SELECT * FROM membre WHERE pseudo=?");
			$reqpseudo->execute(array($pseudo));
			$pseudoexiste = $reqpseudo->rowCount();
			if($pseudoexiste == 0) {
				if($mail==$mail2) {
					if(filter_var($mail,FILTER_VALIDATE_EMAIL)) {
						$reqmail = $bdd->prepare("SELECT * FROM membre WHERE mail=?");
						$reqmail->execute(array($mail));
						$mailexiste = $reqmail->rowCount();
						$idmax = $bdd->query(" SELECT Max(id) FROM membre ");
						$idv = $idmax->fetch()['max']+1;


						
						

						if($mailexiste == 0) {
							if($mdp==$mdp2) {

								$insertmbr = $bdd->prepare("INSERT INTO membre VALUES(?,NULL,NULL,?,?,NULL,NULL,?,0)");
								$insertmbr->execute(array($idv,$pseudo,$mail,$mdp));
								$success=1;
								$err = "<span style='color:green'>Votre compte a bien été créé !";
							}
							else {
								$err = "<span style='color:red'>Vos mots de passe ne correspondent pas !";
							}
						}
						else {
							$err = "<span style='color:red'>Cette adresse mail est déjà utilisée !";
						}
					}
					else {
						$err = "<span style='color:red'>Votre adresse mail n'est pas valide !";
					}
				}
				else {
					$err = "<span style='color:red'>Vos adresses mail ne correspondent pas !";
				}
			}
			else {
				$err = "<span style='color:red'>Ce pseudo est déjà utilisé !";
			}
		}
		else {
			$err = "<span style='color:red'>Votre pseudo ne doit pas dépasser 255 caractères !";
		}
	}
	else {
	  $err = "<span style='color:red'>Tous les champs doivent être complétés !";
	}
}

$res = ["success" => $success, "err" => $err];

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
            

            <div id="banniere_image">
                <div id="banniere_description">
					Football Manager 
				</div>
			</div><br /><br />
			
			<h1 class="titre_accueil">Formulaire d'inscription  </h1>
	    	<div id="container" align="center">  
	      		<form method="POST" action="" id="inscription" class="co_insc">
					<table>
						<tr>
							<td align="right">
								<label for="pseudo"><h2>Pseudo : </h2></label>
							</td>
							<td>		      
								<input type="text" placeholder="votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) {echo $pseudo; } ?>"/>
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="mail"><h2>Mail : </h2></label>
							</td>
							<td>		      
								<input type="email" placeholder="votre mail" id="mail" name="mail" value="<?php if(isset($mail)) {echo $mail; } ?>"/>
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="mail2" color="white"><h2>Confirmation du mail : </h2></label>
							</td>
							<td>		      
								<input type="email" placeholder="Confirmez votre adresse mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) {echo $mail2; } ?>"/>
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="mdp"><h2>Mot de passe : </h2></label>
							</td>
							<td>		      
								<input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
							</td>
						</tr>
						<tr>
							<td align="right">
								<label for="mdp2"><h2>Confirmation du mot de passe : </h2></label>
							</td>
							<td>		      
								<input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />
							</td>
						</tr>
						<tr>
							<td> </td>
							<td>
								<br /><input type="submit" name="forminscription" value="Je m'inscris" />
							</td>
						</tr>
					</table>
	      		</form>
				<p  id="erreur">
					<?php echo $err;
					if ($success==1){ ?>
						<br /><a href="/projet/views/connexion.php">Me connecter</a>
					<?php } ?>
				</p>
	    	</div>
            <br /><br /><br />
            

            <!--Le footer du site-->
            <?php include('footer.php'); ?>
            
        </div>
		<script src="/projet/views/JS/formulaire_validation.js"></script>
    </body>
</html>
