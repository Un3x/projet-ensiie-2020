<?php
function print_user_header() {
	echo "
	<div class=\"profiles\">
	<table>
	<tr>
		<th>Pseudo</th>
		<th>E-mail</th>
		<th>Admin</th>
		<th>Équipe</th>
		<th>Date d'inscription</th>
		<th>Options</th>
	</tr>";
}

function print_user($pseudo, $email, $admin, $team,$timecreate) {
	if (is_null($pseudo) && is_null($email) && is_null($timecreate) && is_null($admin) && is_null($team)) {
		return;
	}
			echo "
		<tr>
			<td>$pseudo</td>
			<td>$email</td>
			<td>$admin</td>
			<td>$team</td>
			<td>$timecreate</td>
			<td>
				<form method='post'>
				<input type='hidden' name='username_modify' class='form-control' value='$pseudo'>
				<input type='submit' value='Modifier'>
				</form>
				<form onsubmit='return validate(this);' method='post'>
				<input type='hidden' name='username_delete' class='form-control' value='$pseudo'>
				<input type='submit' value='Supprimer'>
				</form>
			</td>
		</tr>";
} 

?>


<html lang="fr">
	<?php
		//include("../src/Controllers/ProfilesController.php");
		$style_file = "/css/".basename(__FILE__, ".php").".css";
		include_once 'head.php'
	?>
	<body>
		<script>
		function validate(form) {
			return confirm('Confirmez-vous la suppression de ce profil?');
		}
		</script>
		<?php include_once 'header.php' ?>
		<section class="body-light">
			<div class="content-light">
				<h1>Tous les profils</h1>
				<div class="client-container">
					<?php 
					print_user_header();
					foreach ($users as $user): 
						//Convert date to string 
						$date = $user->getCreatedAt();
						$string_date = date_format($date, 'd-m-Y H:i:s');

						//Convert admin to string
						if ($user->getAdministrator() == true){
							$admin = "Oui";
						}
						else {$admin = "Non";}
						print_user($user->getPseudo(),$user->getEmail(),
						$admin,$user->getTeam(),$string_date);
					endforeach; ?>
				</div>
			</div>
		</section>
		
	</body>
</html>
