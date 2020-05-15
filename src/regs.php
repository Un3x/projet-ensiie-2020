<!DOCTYPE html>
<html>
<head lang="fr">
	<meta charset="UTF-8">
	<title>Location de bateau d'aviron--Inscrption</title>
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
		width: 100%;
		height: 50px;
		background-color: #e1eefa;
	}

	form {
		margin: 40px 210px;
		border: 2px solid #639bbb;
		text-align:center;
	}

	form h3 {
		background-color: #e1eefa;
		padding: 5px 20px;
		color: black;
	}

	form table {
		margin: 50px 200px;
	}

	form table tr td:nth-of-type(1) {
		width: 220px;
		text-align: left;
	}

	form table tr td:nth-of-type(2) .text {
		border: 1px solid #4c8cc6;
		width: 240px;
		height: 20px;
	}

	form table tr td:nth-of-type(2) input[value=立即注册] {
		width: 150px;
		height: 32px;
		border-radius: 5px;
		color: white;
		background-color: #0099cc;
		border-color: #0099cc;
	}

	form table tr {
		display: block;
		margin-bottom: 20px;
	}

	#huoqu {
		width: 64px;
		height: 26px;
		margin-left: 10px;
		font-size: 12px;
	}
	.error{
		color:#FF0000;
	
 			}
	}
	</style>
</head>
<body>
	<div class="main">
		<div>&nbsp;</div>
		<div class="bj"></div>
		<form method="post" action="inscription.php">
			<h3>Inscrivez-vous ici!</h3>
			<table>
				<tr>
					<td>Surnom: </td>
					<td><input class="text" placeholder="Votre surnom" name="name" type="text"></td>
				</tr>
				<tr>
					<td>Mot de passe: </td>
					<td><input class="text" placeholder="Votre mot de passe" name="pwd" type="password"></td>
				</tr>
				<tr>
					<td>Confirmation Mot de passe:</td>
					<td><input class="text" placeholder="Confirmez votre mot de passe" name="repwd" type="password"></td>
				</tr>
				<tr>
					<td>E-mail:</td>
					<td><input class="text" placeholder="Votre E-mail" name="email" type="email"></td>
				</tr>
				<tr>
					<td>Adresse:</td>
					<td><input class="text" placeholder="Votre addresse" name="address" type="text"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Je m'inscris!"></td>
				</tr>
			</table>
		</form>
	</div>
	<div style="text-align: center; padding-top: 10px; color: #919090;">
		<img src="images/end.png" width="27px" style="margin: 0px 10px">©<?php echo date("d-m-y");?>
	</div>
</body>

</html>