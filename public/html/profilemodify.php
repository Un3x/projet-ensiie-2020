<html lang="fr">
	<?php
		$style_file = "/css/".basename(__FILE__, ".php").".css";
		include_once 'head.php'
	?>
	<body>
		<?php include_once 'header.php' ?>
		
		<section class="body-light">
			<div class="content-light">
				<h1>Profil utilisateur</h1>
					<div class="wrapper">
						<form method="post">
							<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
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
							<div class="form-group ">
								<label>Mot de passe actuel</label>
								<input type="password" name="lastpassword" class="form-control" required>
                                <span class="help-block"><?php echo $last_password_err; ?></span>
							</div>
							<div class="form-group ">
								<label>Nouveau mot de passe </label>
								<input type="password" name="newpassword" class="form-control" required>
							</div>
							<div class="form-group">
								<label>Confirmation du nouveau mot de passe</label>
								<input type="password" name="confirm_password" class="form-control" required>
								<span class="help-block"><?php echo $confirm_password_err; ?></span>
							</div>
							<div class="form-group">
								<input type="submit" class="btn btn-primary" value="Valider">
								<input type="reset" class="btn btn-default" value="Réinitialiser">
							</div>
						</form>
					</div> 
			</div>
		</section>
		
		<?php include_once 'footer.php' ?>
	</body>
</html>
