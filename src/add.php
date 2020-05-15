<!DOCTYPE html>
<html>
<head lang="fr">
	<meta charset="UTF-8">
	<title>Location de bateau d'aviron--Déposez votre annonce</title>
	<style>
	* {
		margin: 0px;
		padding: 0px;
	}

	.main {
		margin: 30px 120px 0px 120px;
		border-bottom: 2px solid #7a8999;
	}

	.bj {
		border-top: 5px solid #0076c2;
		width: 90%;
		padding: 10px 5%;
		background-color: #e1eefa;
	}

	.bj ol {
		width: 100%;
	}

	.bj ol li {
		display: inline-block;
		font-size: 13px;
		width: 24%;
	}

	.main h2 {
		padding: 8px 5px;
	}

	.main>ul li {
		padding: 20px 5%;
		line-height: 30px;
		display: inline-block;
		width: 90%;
		border-top: 1px solid black;
	}

	.main>ul li p {
		font-size: 13px;
	}

	.main>ul li p a {
		margin-left: 60%;
		color: #000000;
		font-weight: 800;
		text-decoration: none;
	}

	.main>ul li strong {
		color: #4d81c0;
	}

	.main ol li img {
		position: relative;
		top: 3px;
		right: 5px;
	}

	.main ol li a {
		text-decoration: none;
		color: #000000;
		font-weight: 800;
	}

	.main>form {
		margin: 40px 100px;
		border: 2px solid #639bbb;
	}

	.main>form h3 {
		background-color: #e1eefa;
		padding: 5px 20px;
		color: black;
		text-align:center;
	}

	.main>form table {
		margin: 30px 250px 30px 350px;
	}

	.main>form table tr th {
		width: 120px;
		text-align: left;
	}

	.main>form table tr td .text {
		border: 1px solid #4c8cc6;
		width: 240px;
		height: 20px;
	}

	.main>form table tr td b {
		color: #4d81c0;
		margin: 0px 10px;
		position: relative;
		bottom: 8px;
		cursor: pointer;
	}

	.main>form table tr {
		display: block;
		margin-bottom: 20px;

	}
	</style>
</head>
<body>
	<?php session_start();?>
	<div class="main">
		<div>&nbsp;</div>
		<div class="bj">
			<ol>
				<li>Bonjour,<b onclick='document.location="login.php"'><?php echo (isset($_SESSION['user']) ? $_SESSION['user'] : "connectez vous ici")?>
				</b>
				</li>
				<li><img src="images/order.png" height="13">&nbsp;<a
					href="accueil.php">Liste des annonces</a>
					</li>
				<li><img src="images/addition.png" height="13">&nbsp;<a
					href="add.php">Déposez une annonce</a>
					</li>
				<li><img src="images/user.png" height="16">&nbsp;<a
					href="user.php">Information Personnelle</a>
					</li>
			</ol>
		</div>
		<form class="form1" method="post" action="poser.php" enctype="multipart/form-data">
			<h3>Posez votre informations</h3>
			<table>
				<tr>
					<th>Objet:</th>
					<td><input type="radio" name="gender" value="Louer un bateau">Louer un bateau
						<input type="radio" name="gender" value="Chercher un bateau">Chercher un bateau
					</td>
				</tr>
				<tr>
					<th>Un peu description:</th>
					<td><textarea rows="5" cols="40" name="description"></textarea></td>
				</tr>
				<tr>
					<th>Propriétaire:</th>
					<td><input type="text" name="owner" value="<?php echo (isset($_SESSION['user']) ? $_SESSION['user'] : " ") ?>">
					</td>
				</tr>
				<tr>
					<th>Email:</th>
					<td><input type="email" name="email" value="<?php echo (isset($_SESSION['email']) ? $_SESSION['email'] : " ") ?>">
					</td>
				</tr>
				<tr>
					<th>Adresse:</th>
					<td><textarea rows="5" cols="40" name="address" charset="UTF-8"><?php echo (isset($_SESSION['address']) ? $_SESSION['address'] : " ")?></textarea>
					</td>
				</tr>
				<tr>
					<th></th>
					<td><input class="butt" type="submit"  value="Je pose!" ></td>
				</tr>
			</table>
		</form>
	</div>
	<div style="text-align: center; padding-top: 10px; color: #919090;">
		<img src="images/end.png" width="27px" style="margin: 0px 10px">©<?php echo date("d-m-y");?>
	</div>
</body>
<?php
	$status_add = isset($_GET["status_add"]) ? $_GET["status_add"] : "";
	switch ($status_add) {
	case 1:
		echo "<script>alert('Vous avez bien posé votre information !');</script>";
	break;

	case 2:
		echo "<script>alert('Erreur: Ne peut pas poser votre information !');</script>";
	break;

}?> 
</html>