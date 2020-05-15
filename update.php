<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Location de bateau d'aviron--Modifiez votre compte</title>
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
		color: #4d81c0;
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
		margin: 40px 150px;
		border: 2px solid #639bbb;
	}

	.main>form h3 {
		background-color: #e1eefa;
		padding: 5px 20px;
		color: black;
		text-align:center;
	}

	.main>form table {
		margin: 30px 230px 30px 330px;
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
					href="user.php">Informations Personnelles</a>
					</li>
			</ol>
		</div>
		<form class="form1" method="post" action="modifier.php" enctype="multipart/form-data">
			<h3>Modifiez votre compte</h3>
			<table>
				<tr>
					<th>Surnom:</th>
					<td><input type="text" name="name" value="<?php echo ($_SESSION["user"]); ?>"></td>
				</tr>
				<tr>
					<th>Mot de passe:</th>
					<td><input type="password" name="pwd" value="<?php echo ($_SESSION["pwd"]); ?>"></td>
				</tr> 
				<tr>
					<th>Email:</th>
					<td><input type="email" name="email" value="<?php echo ($_SESSION["email"]); ?>">
					</td>
				</tr>
				<tr>
					<th>Adresse:</th>
					<td><textarea rows="5" cols="40" name="address" charset="UTF-8"><?php echo (isset($_SESSION['address']) ? $_SESSION['address'] : " ")?></textarea>
					</td>
				</tr>
				<tr>
					<th></th>
					<td><input class="butt" type="submit"  value="Je modifie!" ></td>
				</tr>
			</table>
		</form>
	</div>
	<div style="text-align: center; padding-top: 10px; color: #919090;">
		<img src="images/end.png" width="27px" style="margin: 0px 10px">©<?php echo date("d-m-y");?>
	</div>
</body>
</html>