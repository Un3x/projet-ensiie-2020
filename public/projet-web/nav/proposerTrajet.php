<?php
	require "../header.php";
	require '../includes/dbh.inc.php';
?>



<main>
	<div class="container wrapper">
		<div class="row">
		<div class="wrapperC col-lg">
			<form action="/projet-web/includes/proposerTrajet.inc.php" method="POST">
				<h1>Proposer un trajet</h1>
				
				<!-- fichier css  pour la carte -->
				<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
				<link rel="stylesheet" href="../style/proposerTrajet.css">

				<!-- Adresse départ -->
				<label for="adresse1"><b><span class="left">Départ:</span></b></label><br>

				<input type="text" id="adresse1" name="adresse1" placeholder="Numéro et rue">
				<input type="text" id="cp1" name="cp1" placeholder="Code postal">
				<input type="text" id="ville1" name="ville1" placeholder="Ville de départ">
				
				<!-- Adresse Arrivée -->
				<br><label for="adresse2"><b>Arrivée: </b></label><br>

				<input type="text" id="adresse2" name="adresse2" placeholder="Numéro et rue">
				<input type="text" id="cp2" name="cp2" placeholder="Code postal">
				<input type="text" id="ville2" name="ville2" placeholder="Ville d'arrivée">

				
				
				<!-- Input des logitudes et lattitude obligatoires pour traitement carte js -->
				<input type="hidden" id="lat1" name="lat1" >
				<input type="hidden" id="lon1" name="lon1" >
				<input type="hidden" id="lat2" name="lat2" >
				<input type="hidden" id="lon2" name="lon2" >

				<!--Date du trajet -->

				<label><b>Date du trajet</b></label>
				<br>
				
				<!-- Jour -->
				<?php
				$days = range(1, 31);
				$months = range(1,12);
				$years = range(date('Y'),date('Y')+10);
				?>
				<select type="text" name="jour">
					<?php
					foreach ($days as $day){
						?>
						<option value="<?php echo($day) ?>"><?php echo($day) ?></option>
					<?php
					}
					?>
				</select>
					<span>/</span>
				<!-- mois -->
				<select type="text" name="mois">
					<?php
					foreach ($months as $month){
						?>
						<option value="<?php echo($month) ?>"><?php echo($month) ?></option>
					<?php
					}
					?>
				</select>
				<span>/</span>
				<!-- annee -->
				<select type="text" name="annee">
					<?php
					foreach ($years as $year){
						?>
						<option value="<?php echo($year) ?>">
							<?php echo($year) ?></option>
					<?php
					}
					?>
				</select>

				<!-- Horraire départ -->
				<br>
				<br>
				<label><b>Horaire de départ</b></label><br>
				<select name="heure">
					<option value="00">00</option>
					<option value="01">01</option>
					<option value="02">02</option>
					<option value="03">03</option>
					<option value="04">04</option>
					<option value="05">05</option>
					<option value="06">06</option>
					<option value="07">07</option>
					<option value="08">08</option>
					<option value="09">09</option>
					<?php
					for ($i=10; $i < 24 ; $i++) { 
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
					?>
				</select>
				<span>h</span>
				<select name="minute">
					<option value="00">00</option>
					<option value="05">05</option>
					<?php
					for ($i=10; $i < 60 ; $i=$i+5) { 
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
					?>
				</select>
				<br><br>

				<!-- Nombre de place -->
				<label><b>Nombre de place</b></label><br>
				<select name="nombre">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
				</select>
				<br>
				<!-- Validation des données et envoie dans la bdd -->
				<button type="submit" name="proposerTrajet">Proposer le trajet</button>

				<!-- Fichier JS permettant les animations de la carte -->
 				<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="crossorigin=""></script>
 				<script src="../js/proposerTrajet.js"></script>	

			</form>
	</div>

	<!-- Division pour la carte -->
	<div class="container col-lg carte">
	<div id="detailsMap"></div>
	</div>
	</div>

</div>

</main>

<?php
require "../footer.php"
?>