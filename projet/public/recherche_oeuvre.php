<?php

	session_start();

	include '../src/Factory/DbAdaperFactory.php';

	$dbAdapter = (new DbAdaperFactory())->createService();


	if(isset($_GET['oeuvre'])){

		$oeuvre = (String) trim($_GET['oeuvre']);

		$req = $dpAdapter->query("SELECT * FROM Oeuvre WHERE titre LIKE ? LIMIT 10",array("%$oeuvre%"));

		$req = $req->fetchAll();

		foreach($req as $r){
		?>
			<div style="margin-top: 20px 0; border-bottom: 2px solid #ccc">
				<?= $r['titre'] ?>
			</div>
		<?php
		}
	}

?>