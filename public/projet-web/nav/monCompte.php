<?php
	require "../header.php";
	require '../includes/dbh.inc.php';

	$id_conducteur = $_SESSION['userId'];


	$sql = "SELECT * FROM trajet WHERE id_conducteur=?";
	$stmt = $conn->prepare($sql);
	if($stmt==false){
		header("Location: /projet-web/index.php?error=sqlerror");
	}
	else{
		$stmt->execute(array($id_conducteur));
		$trajet=$stmt->fetchAll();
	}

	$sql2 = "SELECT profil FROM utilisateur WHERE id_utilisateur=?";
	$stmt2 = $conn->prepare($sql2);
	if($stmt2==false){
		header("Location: /projet-web/index.php?error=sqlerror");
	}
	else{
		$stmt2->execute(array($id_conducteur));
		$profil = $stmt2->fetch();
	}


	$sql3 = "SELECT * FROM reservation_trajet WHERE id_passager=? ";
	$stmt3 = $conn->prepare($sql3);
	if($stmt3==false){
		header("Location: /projet-web/index.php?error=sqlerror");
	}else{
		$stmt3->execute(array($id_conducteur));
	}

?>

<head>
<link rel="stylesheet" href="../style/monCompte.css">
</head>
<body>
	<div>
	<ul class="tabs">
		<li class="active"><a href="#info">Mes Informations</a></li>
		<li><a href="#trajet">Mes Trajets</a></li>
		<li><a href="#confirmer">Trajets à Confirmer</a></li>
		<?php if($_SESSION['userDroit'] === 3 || $_SESSION['userDroit'] === 2 ){
      	echo '<li><a href="#administration">Administration</a></li>'; }?>
		<?php if($_SESSION['userDroit'] === 3){
      	echo '<li><a href="#supergestion">Super Gestion</a></li>'; }?>
	</ul>
	<div class="tabs-content">
		<div class="tab-content active" id="info">
			<div class="container myContainer">
    			<div class="container ulContainer">
					<?php if(isset($_SESSION["userId"])){
					//Si l'utilisateur est connecté 
					?>
            		<h3 class="titre">Mes informations</h3>
            		<table>
                    <tr>
                    <td><span class="catégorie">Nom : </span></td><td><span class="info"><?php echo $_SESSION["userNom"] ?></span></td>
                    </tr>
                    <tr>
                    <td><span class="catégorie">Prénom : </span></td><td><span class="info"><?php echo $_SESSION["userPrenom"] ?></span></td>
                    <?php if($profil['profil'] != "vide"){
                    ?>
                    <img src="../img/membre/<?php echo $profil['profil']; ?>" width="150"/>
                    <?php } ?>
                	</span></td>
                    </tr>
                    <tr>
                    <td><span class="catégorie">Mail : </span></td><td><span class="info"><?php echo $_SESSION["userMail"] ?></span></td>
                    </tr>
                    <tr>
                    <td><span class="catégorie">Tel : </span></td><td><span class="info"><?php echo $_SESSION["userTel"] ?></span></td>
                    </tr>
                    <tr>
                    <td><span class="catégorie">Voiture : </span></td><td><span class="info"><?php echo $_SESSION["userVoiture"] ?></span></td>
                    </tr>
                                            <tr>
                        <td><span class="catégorie">Nombre de Points : </span></td><td><span class="info"><?php 
                        $sql = "SELECT nombre_place_validee FROM trajet WHERE id_conducteur=? ";
                        $stmt = $conn->prepare($sql);
                        if($stmt==false){

                        }else{
                                $stmt->execute(array($_SESSION['userId']));
                                $res=0;
                                while($nombrePlace = $stmt->fetch()){
                                        $res += $nombrePlace['nombre_place_validee'];
                                }
                        }

                        echo $res ?></span></td>
                        </tr>


                    
    				</table>
            		<div class="container buttonContainer">

               			<form action="/projet-web/includes/deconnexion.inc.php" method="POST">
                		<a href="modifier-information.php">

		                <button class="modifierInfos" type="button">Modifier</button></a>
		                <button class="deconnexion" type="submit" value="logout-submit">Deconnexion</button>
            
            			</form>
            		</div>
            		<?php
    				}else{
    					echo '<p>Connectez vous pour avoir accès à vos informations</p>';
    				}

					?>
    			</div>
			</div>
		</div>

		<div class="tab-content" id="trajet">
			<link rel="stylesheet" href="/projet-web/style/mesTrajets.css">
			<div class="container">
			<?php 
				foreach ($trajet as $row) {?>
					<div class="wrapper">
					<h3 style="text-align: center"><?php echo $row["ville_depart"]." - ".$row["ville_arrivee"]; ?></h3>
					<table class="trajetTab">
					<tr class="ligneTrajets">
						<td class="colTrajets"><b>Départ:</b> <?php echo $row['ville_depart'];?></td>
						<td class="colTrajets"><b>Arrivée :</b> <?php echo $row['ville_arrivee'];?></td>
					</tr>
					<tr class="ligneTrajets">
						<td class="colTrajets"><b>Date :</b> <?php echo $row['jour_depart'].' '.$row['mois_depart'].' '.$row['annee_depart']; ?></td>
						<td class="colTrajets"><b>Heure :</b> <?php echo $row['heure_depart'].':'.$row['minute_depart']; ?></td>
					</tr>
					<tr class="ligneTrajets">
						<td class="colTrajets"><b>Nombre de places :</b> <?php echo $row['nombre_place'];?></td>
						<td class="colTrajets">
						</td>
					</tr>
				</table>
				<div class="buttonWrapper">
					<form action="/projet-web/includes/modifierTrajet-Request.inc.php" method="POST">
						<input type="text" name="id_trajet" value="<?php echo $row["id_trajet"]; ?>" hidden="hidden">
						<input type="text" name="id_conducteur" value="<?php echo $row["id_conducteur"]; ?>" hidden="hidden">
						<button name="modifier">Modifier</button><button name="supprimer">Supprimer</button>
					</form>
				</div>
				</div>
				<?php }
			?>
			</div>
		</div>

		<div class="tab-content" id="confirmer">
			<table cellspacing="0" cellpadding="1" border="1" width="100%" >
				<form action="/projet-web/includes/validerTrajet.inc.php" method="POST">
				<?php 
				while ($res = $stmt3->fetch()) {
					if(($res['trajet_key']!=$res['confirm_trajet'])){
					echo "</tr>";
					echo $res['id_trajet']."</td>";
					// echo $res['trajet_key']; ?>
					<input type="text" name="code">
					<button name="validerCode" >Validez</button>
					<input type="hidden" name="trajet_code" value=<?php echo $res["trajet_key"];?>>
					<input type="hidden" name="id_trajet" value=<?php echo $res["id_trajet"] ;?>>
					<input type="hidden" name="place" value=<?php echo $res["nombre_place_reserve"] ;?>>
				<?php echo "</tr>"; }}?>
				</form>
			</table>
		</div>

		<div class="tab-content" id="supergestion">

			<div>
			<link rel="stylesheet" href="/projet-web/style/super-gestion.css">
			<?php
			if ($_SESSION['userDroit'] === 3){
			require '../includes/dbh.inc.php';
			?>

			<div class="container myC">
			<h1>Utilisateurs</h1>
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
			<td>
			<table cellspacing="0" cellpadding="1" border="1" width="100%" >
			<tr style="color:white;background-color:grey; text-align:left;">
			<th>ID</th>
			<th>Droit</th>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Mail</th>
			<th>Tel</th>
			<th>Voiture</th>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td>
			<div style="height:200px; overflow:auto;">
			<table cellspacing="0" cellpadding="1" border="1" width="100%" >

			<?php
			$sql = "SELECT * FROM utilisateur";
			$stmt = $conn->prepare($sql);
			if($stmt == false){
			header("Location: super-gestion.php?error=sqlerro");
			exit();
			}else{
			$stmt->execute(array());
			$result = $stmt->fetchAll();
			if(count($result)>0){
			foreach($result as $row){
			    echo "<tr>";
			    echo "<td>".$row['id_utilisateur']."</td>";
			    echo "<td>".$row['droit']."</td>";
			    echo "<td>".$row['nom']."</td>";
			    echo "<td>".$row['prenom']."</td>";
			    echo "<td>".$row['mail']."</td>";
			    echo "<td>".$row['tel']."</td>";
			    echo "<td>".$row['modele_voiture']."</td>";
			    echo "</tr>";
			}
			}else{
			echo "Aucun résultat";
			}
			}
			?>
			</table>  
			</div>
			</td>
			</tr>
			</table>
			</div>

			<div class="container myC2">
			<h1>Trajets</h1>
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
			<td>
			<table cellspacing="0" cellpadding="1" border="1" width="100%" >
			<tr style="color:white;background-color:grey; text-align:left;">
			<th>ID trajet</th>
			<th>Date</th>
			<th>Départ</th>
			<th>Arrivée</th>
			<th>Nombre place</th>
			<th>Conducteur</th>
			<th>Type</th>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td>
			<div style="height:200px; overflow:auto;">
			<table cellspacing="0" cellpadding="1" border="1" width="100%" >

			<?php
			$sql = "SELECT * FROM trajet,utilisateur WHERE trajet.id_conducteur=utilisateur.id_utilisateur";
			$stmt = $conn->prepare($sql);
			if($stmt == false){
			header("Location: super-gestion.php?error=sqlerro");
			exit();
			}else{
			$stmt->execute(array());
			$result = $stmt->fetchAll();
			if(count($result)>0){
			foreach($result as $row){
			    echo "<tr>";
			    echo "<td>".$row['id_trajet']."</td>";
			    echo "<td>".$row['jour_depart']." ".$row['mois_depart']." ".$row["annee_depart"]."</td>";
			    echo "<td>".$row['ville_depart']."</td>";
			    echo "<td>".$row['ville_arrivee']."</td>";
			    echo "<td>".$row['nombre_place']."</td>";
			    echo "<td>".$row['nom']." ".$row['prenom']."</td>";
			    echo "<td>".$row['type']."</td>";
			    echo "</tr>";
			}
			}else{
			echo "Aucun résultat";
			}
			}
			?>
			</table>  
			</div>
			</td>
			</tr>
			</table>
			</div>
			<div class="container myC3">
			<h1>Les réservations</h1>
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
				<td>
				<table cellspacing="0" cellpadding="1" border="1" width="100%" >
					<tr style="color:white;background-color:grey; text-align:left;">
						<th>ID trajet</th>
						<th>Date</th>
						<th>Départ</th>
						<th>Arrivée</th>
						<th>Nombre place Réstante</th>
						<th>Nombre place réservé</th>
						<th>Conducteur</th>
						<th>Passagers</th>
						<th>Type</th>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td>
				<div style="height:200px; overflow:auto;">
					<table cellspacing="0" cellpadding="1" border="1" width="100%" >

					<?php
					$sql = "SELECT * FROM trajet,utilisateur,reservation_trajet WHERE trajet.id_conducteur=utilisateur.id_utilisateur AND trajet.id_trajet = reservation_trajet.id_trajet";
					$stmt = $conn->prepare($sql);
					if($stmt == false){
						header("Location: super-gestion.php?error=sqlerro");
						exit();
					}else{
						$stmt->execute(array());
						$result = $stmt->fetchAll();
						if(count($result)>0){
							foreach($result as $row){
								echo "<tr>";
								echo "<td>".$row['id_trajet']."</td>";
								echo "<td>".$row['jour_depart']." ".$row['mois_depart']." ".$row["annee_depart"]."</td>";
								echo "<td>".$row['ville_depart']."</td>";
								echo "<td>".$row['ville_arrivee']."</td>";
								echo "<td>".$row['nombre_place']."</td>";
								echo "<td>".$row['nombre_place_reserve']."</td>";
								echo "<td>".$row['nom']." ".$row['prenom']."</td>";
								$id_passager = $row["id_passager"];
								$sql2 = "SELECT nom,prenom FROM utilisateur WHERE id_utilisateur=?";
								$stmt2 = $conn->prepare($sql2);
								if($stmt2 == false){
								header("Location: super-gestion.php?error=sqlerro");
								exit();
								}else{
								$stmt2->execute(array($id_passager));
								$result2 = $stmt2->fetchAll();
								echo "<td>".$result2[0]["nom"]." ".$result2[0]["prenom"]."</td>";
								}
								echo "<td>".$row['type']."</td>";
								echo "</tr>";
							}
						}else{
							echo "Aucun résultat";
						}
					}
							?>
					</table>  
				</div>
				</td>
			</tr>
			</table>

			</div>
						<div class="container gestion">
						<h1>Gestion</h1>
						<p>Sélectionner un utilisateur à l'aide de son id ou de son adresse mail</p>
						<form action="super-gestion-modify.php" method="POST">
						<label><b>ID de l'utilisateur</b></label>
						<input type="number" placeholder="ID" name="id">

						<label><b>Mail de l'utilisateur</b></label>
						<input type="text" placeholder="Mail" name="mail">
						<br>
						<button type="submit" name='gestion-submit'>Gérer</button>
						</form>
						<br>

						<?php
						if(isset($_GET["success"]) && $_GET["success"] === "infomodified"){
						echo "<p class='success'>Informations modifiées avec succès !</p>";
						}else if(isset($_GET["success"]) && $_GET["success"] === "userdeleted"){
						echo "<p class='success'>Utilisateur supprimé avec succès !</p>";
						}
						?>
						</div>


						<?php }else{
						echo "Accès refusé";
						}?>

						</div>
		</div>
		
		<div class="tab-content" id="administration">

			<div>
			<link rel="stylesheet" href="/projet-web/style/super-gestion.css">
			<?php
			if ($_SESSION['userDroit'] === 3 || $_SESSION['userDroit'] === 2 ){
			require '../includes/dbh.inc.php';
			?>

			<div class="container myC">
			<h1>Utilisateurs</h1>
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
			<td>
			<table cellspacing="0" cellpadding="1" border="1" width="100%" >
			<tr style="color:white;background-color:grey; text-align:left;">
			<th>ID</th>
			<th>Droit</th>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Mail</th>
			<th>Tel</th>
			<th>Voiture</th>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td>
			<div style="height:200px; overflow:auto;">
			<table cellspacing="0" cellpadding="1" border="1" width="100%" >

			<?php
			$sql = "SELECT * FROM utilisateur WHERE droit=?";
			$stmt = $conn->prepare($sql);
			if($stmt == false){
			header("Location: super-gestion.php?error=sqlerro");
			exit();
			}else{
			$stmt->execute(array(1));
			$result = $stmt->fetchAll();
			if(count($result)>0){
			foreach($result as $row){
			    echo "<tr>";
			    echo "<td>".$row['id_utilisateur']."</td>";
			    echo "<td>".$row['droit']."</td>";
			    echo "<td>".$row['nom']."</td>";
			    echo "<td>".$row['prenom']."</td>";
			    echo "<td>".$row['mail']."</td>";
			    echo "<td>".$row['tel']."</td>";
			    echo "<td>".$row['modele_voiture']."</td>";
			    echo "</tr>";
			}
			}else{
			echo "Aucun résultat";
			}
			}
			?>
			</table>  
			</div>
			</td>
			</tr>
			</table>
			</div>
			<div class="container gestion">
						<h1>Gestion</h1>
						<p>Sélectionner un utilisateur à l'aide de son id ou de son adresse mail</p>
						<form action="super-gestion-modify.php" method="POST">
						<label><b>ID de l'utilisateur</b></label>
						<input type="number" placeholder="ID" name="id">

						<label><b>Mail de l'utilisateur</b></label>
						<input type="text" placeholder="Mail" name="mail">
						<br>
						<button type="submit" name='gestion-submit'>Gérer</button>
						</form>
						<br>

						<?php
						if(isset($_GET["success"]) && $_GET["success"] === "infomodified"){
						echo "<p class='success'>Informations modifiées avec succès !</p>";
						}else if(isset($_GET["success"]) && $_GET["success"] === "userdeleted"){
						echo "<p class='success'>Utilisateur supprimé avec succès !</p>";
						}
						?>
						</div>
						<hr>
						
			<div class="container myC2">
			<h1>Trajets</h1>
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
			<td>
			<table cellspacing="0" cellpadding="1" border="1" width="100%" >
			<tr style="color:white;background-color:grey; text-align:left;">
			<th>ID trajet</th>
			<th>Date</th>
			<th>Départ</th>
			<th>Arrivée</th>
			<th>Nombre place</th>
			<th>Conducteur</th>
			<th>Type</th>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td>
			<div style="height:200px; overflow:auto;">
			<table cellspacing="0" cellpadding="1" border="1" width="100%" >

			<?php
			$sql = "SELECT * FROM trajet,utilisateur WHERE trajet.id_conducteur=utilisateur.id_utilisateur";
			$stmt = $conn->prepare($sql);
			if($stmt == false){
			header("Location: super-gestion.php?error=sqlerro");
			exit();
			}else{
			$stmt->execute(array());
			$result = $stmt->fetchAll();
			if(count($result)>0){
			foreach($result as $row){
			    echo "<tr>";
			    echo "<td>".$row['id_trajet']."</td>";
			    echo "<td>".$row['jour_depart']." ".$row['mois_depart']." ".$row["annee_depart"]."</td>";
			    echo "<td>".$row['ville_depart']."</td>";
			    echo "<td>".$row['ville_arrivee']."</td>";
			    echo "<td>".$row['nombre_place']."</td>";
			    echo "<td>".$row['nom']." ".$row['prenom']."</td>";
			    echo "<td>".$row['type']."</td>";
			    echo "</tr>";
			}
			}else{
			echo "Aucun résultat";
			}
			}
			?>
			</table>  
			</div>
			</td>
			</tr>
			</table>
			</div>
			<div class="container myC3">
			<h1>Les réservations</h1>
			<table cellspacing="0" cellpadding="0" border="0" width="100%">
			<tr>
				<td>
				<table cellspacing="0" cellpadding="1" border="1" width="100%" >
					<tr style="color:white;background-color:grey; text-align:left;">
						<th>ID trajet</th>
						<th>Date</th>
						<th>Départ</th>
						<th>Arrivée</th>
						<th>Nombre place Réstante</th>
						<th>Nombre place réservé</th>
						<th>Conducteur</th>
						<th>Passagers</th>
						<th>Type</th>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td>
				<div style="height:200px; overflow:auto;">
					<table cellspacing="0" cellpadding="1" border="1" width="100%" >

					<?php
					$sql = "SELECT * FROM trajet,utilisateur,reservation_trajet WHERE trajet.id_conducteur=utilisateur.id_utilisateur AND trajet.id_trajet = reservation_trajet.id_trajet";
					$stmt = $conn->prepare($sql);
					if($stmt == false){
						header("Location: super-gestion.php?error=sqlerro");
						exit();
					}else{
						$stmt->execute(array());
						$result = $stmt->fetchAll();
						if(count($result)>0){
							foreach($result as $row){
								echo "<tr>";
								echo "<td>".$row['id_trajet']."</td>";
								echo "<td>".$row['jour_depart']." ".$row['mois_depart']." ".$row["annee_depart"]."</td>";
								echo "<td>".$row['ville_depart']."</td>";
								echo "<td>".$row['ville_arrivee']."</td>";
								echo "<td>".$row['nombre_place']."</td>";
								echo "<td>".$row['nombre_place_reserve']."</td>";
								echo "<td>".$row['nom']." ".$row['prenom']."</td>";
								$id_passager = $row["id_passager"];
								$sql2 = "SELECT nom,prenom FROM utilisateur WHERE id_utilisateur=?";
								$stmt2 = $conn->prepare($sql2);
								if($stmt2 == false){
								header("Location: super-gestion.php?error=sqlerro");
								exit();
								}else{
								$stmt2->execute(array($id_passager));
								$result2 = $stmt2->fetchAll();
								echo "<td>".$result2[0]["nom"]." ".$result2[0]["prenom"]."</td>";
								}
								echo "<td>".$row['type']."</td>";
								echo "</tr>";
							}
						}else{
							echo "Aucun résultat";
						}
					}
							?>
					</table>  
				</div>
				</td>
			</tr>
			</table>

			</div>
						


						<?php }else{
						echo "Accès refusé";
						}?>

						</div>
		</div>
		
	</div>
<script src="../js/monCompte.js"></script>
<?php
require "../footer.php";
?>
</body>

