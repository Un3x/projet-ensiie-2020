<html lang="fr">
	<?php
		$style_file = "/css/".basename(__FILE__, ".php").".css";
		include_once 'head.php'
	?>
	<body>
		<?php include_once 'header.php' ?>
		
		<section class="body-light">
			<div class="content-light">
				<h1>Morpiien!</h1>
				<p id="refresh"><a href="/morpiien">Recharger</a></p>
				<table id="morpiien-container">
					<tr class="morpiien-row">
						<th id="cell1" class="morpiien-cell morpiien-cell-empty"></th>
						<th id="cell2" class="morpiien-cell morpiien-cell-empty"></th>
						<th id="cell3" class="morpiien-cell morpiien-cell-empty"></th>
					</tr>
					<tr class="morpiien-row">
						<th id="cell4" class="morpiien-cell morpiien-cell-empty"></th>
						<th id="cell5" class="morpiien-cell morpiien-cell-empty"></th>
						<th id="cell6" class="morpiien-cell morpiien-cell-empty"></th>
					</tr>
					<tr class="morpiien-row">
						<th id="cell7" class="morpiien-cell morpiien-cell-empty"></th>
						<th id="cell8" class="morpiien-cell morpiien-cell-empty"></th>
						<th id="cell9" class="morpiien-cell morpiien-cell-empty"></th>
					</tr>
				</table>
				<p id="error"></p>
				<p id="victory"></p>
			</div>
		</section>
		
		<?php include_once 'footer.php' ?>
		<script src=<?php echo "/js/".basename(__FILE__, ".php").".js" ?>></script>
	</body>
</html>
