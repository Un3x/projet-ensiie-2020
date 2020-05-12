<html lang="fr">
	<?php
		$style_file = "/css/".basename(__FILE__, ".php").".css";
		include_once 'head.php'
	?>
	<body>
		<?php include_once 'header.php' ?>
		<script>
        function show(a)
        {
            if(a==1)
                document.getElementById("password").style.display="none";
            else
                document.getElementById("password").style.display="block";
        }
        </script>
		<section class="body-light">
			<div class="content-light">
				<h1>Profil utilisateur</h1>
					<div class="wrapper">
						<form method="post">
							<div class="form-group">
								<label>Pseudo</label>
								<input type="text" name="username" class="form-control" required 
									value="<?php echo $current_user->getPseudo(); ?>">
								<span class="help-block"><?php echo $username_err; ?></span>
							</div>    
							<div class="form-group ">
								<label>E-mail</label>
								<input type="email" name="email" class="form-control" required
									value="<?php echo $current_user->getEmail(); ?>">
							</div>
                            <div id="password" style="display: none;" class="form-group ">
								<label>Nouveau mot de passe</label>
								<input type="password" name="newpassword" class="form-control"><br>
								<label>Confirmer le mot de passe</label>
								<input type="password" name="confirm_password" class="form-control">
								<span class="help-block"><?php echo $confirm_password_err; ?></span>
							</div>
                            <button onclick="show(2)">Changer le mot de passe</button>
                            <div class="form-group ">
                            <label>Administrateur</label>
                            <input type="radio" id="Oui" name="admin" value="Oui" required>
                            <label for="Oui">Oui</label>
                            <input type="radio" id="Non" name="admin" value="Non" required>
                            <label for="Non">Non</label><br>
                            </div>
							<div class="form-group">
								<input type="submit" class="btn btn-primary" value="Valider">
							</div>
						</form>
					</div> 
			</div>
		</section>
		
		<?php include_once 'footer.php' ?>
	</body>
</html>
