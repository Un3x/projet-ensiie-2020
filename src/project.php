<?php require 'header.php'?>
<?php
	class TableRows extends RecursiveIteratorIterator {
    	function __construct($it) {
        	parent::__construct($it, self::LEAVES_ONLY);
    	}
	
    	function current() {
        	return "<td style='width:250px;border:1px solid black;'>" . parent::current(). "</td>";
    	}
	
    	function beginChildren() {
        	echo "<tr>";
    	}
	
    	function endChildren() {
        	echo "</tr>" . "\n";
    	}
	}
if(!empty($_POST)){
	if(empty($_POST['searching_project'])){
		$_SESSION['flash']['danger'] = "Aucun nom de projet saisi";

		header('Location: projects.php');

		exit();	
	}

	$stmt = $pdo->prepare('SELECT pseudo, nom, prenom, email FROM users as us JOIN projects as pr ON us.pseudo = pr.nom_chef_de_projet WHERE nom_projet = ?');

	$stmt->execute([$_POST['searching_project']]);

	$row = $stmt->rowCount();
	if( $row  == 0 ) {
		$_SESSION['flash']['danger'] = "Ce projet n'existe pas";

		header('Location: projects.php');

		exit();	
	}
	$res = $stmt->fetch(\PDO::FETCH_OBJ);
}
?>

<?php if(!empty($_POST['searching_project'])): ?>

<h1><? echo $_POST['searching_project'] ?></h1>

<h4>Chef de projet</h4>

<ul id="acc_info">

	<li>Pseudo: <?php echo $res->pseudo;?></li>

	<li>Nom: <?php echo $res->nom;?></li>

	<li>Prénom: <?php echo $res->prenom;?></li>

	<li>Email: <?php echo $res->email;?></li>

</ul>
<?php endif; ?>

<h4>Intervenants</h4>

<?php
if(!empty($_POST)){
	if(empty($_POST['searching_project'])){

		$_SESSION['flash']['danger'] = "Aucun nom de projet saisi";

		header('Location: projects.php');

		exit();	
	}
	$stmt = $pdo->prepare("SELECT pseudo, nom, prenom, email FROM users AS us JOIN (projects AS pr JOIN participants AS pa ON pa.id_projet = pr.id_projet) ON us.id = pa.id WHERE nom_projet = ?");

	$stmt->execute([$_POST['searching_project']]);

	$row = $stmt->rowCount();

	if( $row  != 0 ) {
		echo "<table style='border: solid 1px black;border-collapse: collapse;' id='event'>";

		echo "<tr style='background-color:#4CAF50;'><th>Pseudo</th><th>Nom</th><th>Prénom</th><th>Email</th></tr>";

    		$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    		foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
        		echo $v;
    		}
		echo "</table>";
	} else{
		echo "Aucun intervenant trouvé";
	}
}
?>
<br><br>
<a id="link_projects" href="projects.php">Retour</a>

<?php require 'footer.php'?>
