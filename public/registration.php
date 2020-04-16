<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="scripts.js"></script>
</head>
<body>
<!-- cette page donne le choix à l'utilisateur, se connecter ou creer un compte -->

<!--creer un compte -->
<h1>Inserez vos identifiants:</h1>
<form name= "formAddUser" action="addUser.php" onsubmit="return validationFormulaire();" method="post">
<label for="username"> Nom de compte :</label></br>
	<input type="text" name="username"></br>
<label for="email">votre adresse mail:</label></br>
	<input type="text" name="email"></br>
<button type="submit">Creer un compte</button>

</body>
</html>
