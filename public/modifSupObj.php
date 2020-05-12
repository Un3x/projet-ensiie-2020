<?php require "header.php" ?>

<?php

// Modification dans la BDD
if (isset($_POST['idModif'])){
	
	$statusMsg = '';
	// File upload path
	$targetDir = "images/objects/";
	$fileName = basename($_FILES["file"]["name"]);
	$targetFilePath = $targetDir . $fileName;
	$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
	
	if (!empty($_POST['nomObjet'])){

		echo '<h1>Objet modifié !</h1>';

		$new = $bdd->prepare('UPDATE Objet SET nom=:nom, Categorie=:Categorie WHERE id_Obj=:id_Obj'); 
		$new->execute(array(
			':nom' => $_POST['nomObjet'],
			':id_Obj' => $_POST['idModif'] 
			':Categorie' => $_POST['categorieObjet'],
		)); 
	}
	
	if(!empty($_FILES["file"]["name"])){
		// Allow certain file formats
		$allowTypes = array('jpg','png','jpeg');
		if(in_array($fileType, $allowTypes)){
			// Upload file to server
			if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
				// Insert image file name into database
				$updateImg = $bdd->query("UPDATE Objet SET image = '".$fileName."' WHERE id_Obj = " . $_POST['idModif']);
				if($updateImg){
					$statusMsg = "Le fichier ".$fileName. " a été chargé";
				}else{
					$statusMsg = "Chargement impossible. Veuillez réessayer.";
				} 
			}else{
				$statusMsg = "Désolé, une erreur lors du chargement est survenue.";
			}
		}else{
			$statusMsg = 'Désolé, seuls les fichiers JPG, JPEG, PNG sont autorisés.';
		}
	}
	echo '<h1>'.$statusMsg.'</h1>';
	
}
elseif (isset($_POST['idSup'])){

	
	$new = $bdd->prepare('DELETE FROM Objet WHERE id_Obj=:id_Obj'); 
	$new->execute(array(':id_Obj' => $_POST['idSup'])); 
	echo '<h1>Objet supprimé !</h1>';
}
?>

//--------------------------------- AFFICHAGE HTML ---------------------------------//

<h1> Formulaire de modification d'objet </h1>

	<form action="" method="post" enctype='multipart/form-data'> 

	<?php  
	if (isset($_POST['objetModif'])){	
		$objet = $bdd->prepare('SELECT * FROM Objet WHERE id_Proprietaire=:id_Proprietaire AND id_Obj=:id_Obj');
		$objet->execute(array('id_Proprietaire'=>$_SESSION['id'],
							  'id_Obj'=>$_POST['objetModif']));
		$donneesObjet = $objet->fetch();
		$objet->closeCursor(); 
	}

	if (isset($_POST['objetModif'])) { ?> 

	<div>
		<label>Nom :</label>
		<input type="text" name="nomObjet" value="<?php echo $donneesObjet['nom'] ?>" />
	</div>
	
	<div>
		<label>Catégorie :</label>
		<input type="text" name="Categorie" value="<?php echo $donneesObjet['Categorie'] ?>" />
	
	</div>
		<div>
				<label>Photo</label>
				<input type='file' name='file' />
			<div>
			<div><label></label>
				<?php
					$query = $bdd->query("SELECT image FROM Objet WHERE id_Obj = " . $_POST['objetModif']);
					if($query->rowCount() > 0){
						while($row = $query->fetch(PDO::FETCH_ASSOC)){
							$imageURL = 'images/objects/'.$row["image"];
				?>
					<div id="profil"><img src="<?php echo $imageURL; ?>" id="profil_image" /><div>
				<?php 	}
					}else{ ?>
					<div id="profil"><image src="images/objects/profil.png" id="profil_image"><div>
				<?php 	} ?>
			</div>
		<p>
			<?php echo '<input type="hidden" name="idModif" value="',$_POST['objetModif'],'">'; ?>
		</br>
		<input type="submit" value="Valider" />
		</br>
		</p>

		<?php 
	}
	else {
		echo '<input type="hidden" name="idSup" value="',$_POST['objetSup'],'">'; 
		echo 'Voulez-vous vraiment supprimer cet objet ?</br>';?>
		<input type="submit" value="Valider" />
	<?php } ?> 
		
	</form> 


<?php require "footer.php" ?>
