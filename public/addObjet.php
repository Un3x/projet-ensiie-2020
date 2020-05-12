<?php 
	/*
	*	Page traitement d'ajout objet + affichage résultat
	*/
?>

<?php require "header.php" ?>

<?php

if($_POST){
		// Insertion dans DB
        $dbAdapter = (new DbAdaperFactory())->createService();
		$insertQuery = $dbAdapter->prepare('INSERT INTO Objet(nom, id_Proprietaire, Categorie) VALUES(:nom, :id_Proprietaire, :Categorie)'); 
		$insertQuery->execute(array(
			':nom' => $_POST['nomObjet'],
			':id_Proprietaire' => $_SESSION['id'],
			':Categorie' => $_POST['categorieObjet']
			
		));
		//récupère le dernier id de la table objet
		$id = $dbAdapter->lastInsertId();
		
		$statusMsg = '';
		// File upload path
		//$targetDir = $_SERVER["DOCUMENT_ROOT"] . "/images/objects/";
		$targetDir = "../images/objects/";
		$fileName = basename($_FILES["file"]["name"]);
		$targetFilePath = $targetDir . $fileName;
		$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
		if(!empty($_FILES["file"]["name"])){
			// Allow certain file formats
			$allowTypes = array('jpg','png','jpeg');
			if(in_array($fileType, $allowTypes)){
				// Upload file to server
				if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
					// Insert image file name into database
					//$updateImg = $dbAdapter->query("UPDATE Objet SET image = '".$fileName."' WHERE id_obj = " . $id);
					
                    $updateImg = $dbAdapter->prepare('UPDATE Objet SET image = :img where id_obj = :objId');
					$updateImg->bindParam('objId', $id);
					$updateImg->bindValue(':img', $fileName, \PDO::PARAM_STR);
					$b=$updateImg->execute();
					if(!$b){
						$statusMsg = "Chargement impossible. Veuillez réessayer.";
					} 
				}else{
					$statusMsg = "Désolé, une erreur lors du chargement est survenue.";
				}
			}else{
				$statusMsg = 'Désolé, seuls les fichiers JPG, JPEG, PNG sont autorisés.';
			}
		}
		
		echo '<h1>L\'Objet a été ajouté !</h1>';
		echo '<h1>'.$statusMsg.'</h1>';
		echo "<a href ='voirObjet.php?id=". $id ."'> Voir l'objet </a>";
		}
?>

<?php 
if ($_SESSION['id']==0){
	echo "<section><p><a href='connexion.php'>Se connecter</a> pour ajouter un objet.</p></section>";
    $mode="display:none";
}
else{
	//echo "<section><p>Vous avez été banni, vous ne pouvez plus ajouter d'objet.</p></section>",$_SESSION['id'];
    $mode="display:block";
}

?>
<section>
	<form id="Form" name="Form" action="" method="post" onsubmit="return validateForm()" enctype='multipart/form-data' style="<?= $mode ?>" > 
		<fieldset>
			<legend><h1>Ajouter un objet</h1></legend>
			<div>
				<label>Nom :</label>
				<input type="text" name="nomObjet" required/>
			</div>
			<div>
				<label>Catégorie :</label>
				<input type="text" name="categorieObjet" required/>
			
			</div>
			<br />
			<div>
				<label>Photo</label>
				<input type='file' name='file' />
			<div>
		</fieldset>
		<div>
			<input type="submit" value="Valider" />
		</div>
	</form> 
</section>

<script type="text/javascript">
	// script vérification champ nom n'est pas vide avant validation du formulaire
	function validateForm(){
		var nom = document.forms["Form"]["nomObjet"].value;
		if(nom == null || nom == ""){
			alert("Veuillez saisir le nom de l'objet!");
			return false;
		}
		/*
		if(<?php//$_SESSION['id'] ?>==0){
			alert("Veuillez vous connecter");
			return false;
		}
		*/
	}
</script>

<?php
/*
if ($_SESSION['id']==0){
	echo "<section><p><a href='connexion.php'>Se connecter</a> pour ajouter un objet.</p></section>";
	//document.getElementById('Form').style.display='none';
}
else{
	//echo "<section><p>Vous avez été banni, vous ne pouvez plus ajouter d'objet.</p></section>",$_SESSION['id'];
	//document.getElementById('Form').style.display='block';
}*/
require "footer.php" ?>
