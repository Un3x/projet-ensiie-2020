<html lang="fr">
	<?php
		$style_file = "/css/".basename(__FILE__, ".php").".css";
		include_once 'head.php'
	?>
	<body>
		<?php include_once 'header.php' ?>
		<script>
		function validate(form) {
			return confirm('Confirmez-vous la suppression de ce profil?');
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
							<div class="form-group">
								<input type="submit" class="btn btn-primary" value="Valider">
							</div>
							<p><a href="modify">Changer le mot de passe</a>.</p>
						</form>	
						<form onsubmit='return validate(this);' method='post'>
							<input type='submit' name="delete" value='Supprimer ce profil'>
						</form>
					</div> 
			</div>
		</section>
		
		<?php include_once 'footer.php' ?>
	</body>
</html>
