<?php
session_start();
include("db_connect.php");

  
if(isset($_SESSION['id'])) {

	if(isset($_GET['id'],$_GET['id_topic']) AND !empty($_GET['id']) AND !empty($_GET['id_topic'])) {
		$get_id=htmlspecialchars($_GET['id']);
		$get_id_topic=htmlspecialchars($_GET['id_topic']);
		$topics = $bdd->prepare("SELECT * FROM f_topics WHERE id=?");
		$topics->execute(array($get_id_topic));
		$topicsexiste = $topics->rowCount();
		if($topicexiste == 0)
		{
			if(isset($_POST['tsubmit'])) {

				$reqtop = $bdd->prepare("SELECT * FROM f_topics WHERE $id=?");
				$reqtop->execute(array($_SESSION['id']));
				$top = $reqtop->fetch();
				if(isset($_POST['newcontenu']) AND !empty($_POST['newcontenu'])){
					$newcontenu = htmlspecialchars($_POST['newcontenu']);
					$insertcontenu = $bdd->prepare("UPDATE f_topics SET contenu = ? WHERE id = ?");
					$insertcontenu->execute(array($newcontenu,$get_id_topic));
					header("Location: /projet/views/topic.php?id=".$get_id_topic);
				}
				if(isset($_POST['newsujet']) AND !empty($_POST['newsujet'])){
					$newsujet = htmlspecialchars($_POST['newsujet']);
					$insertsujet = $bdd->prepare("UPDATE f_topics SET sujet = ? WHERE id = ?");
					$insertsujet->execute(array($newsujet,$get_id_topic));
					header("Location: /projet/views/topic.php?id=".$get_id_topic);
				}
				
			}

		}
		else { 
			$msg = "Cette adresse mail est déjà utilisée !";
		}

	}
	else {
		die("Erreur...");
	}
?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style_MyM.css" />
        <title>MyManager</title>
    </head>
    
    <body>
        <div id="bloc_page">

            <!--Le header de la page-->
            <?php include('header.php'); ?>



			<div align="center">  
				<h1>Edition de mon topic</h1>
				<br /><br />
				<div align="center">
					<table border=8 style="color:white" >
					<tr>
						<td><br />L'ancien sujet<br /><br /></td>
						<td><?php $topics=$topics->fetch();
							echo $topics['sujet']; ?>
						</td>
					</tr>
					<tr>
						<td><br />L'ancien message<br /><br /></td>
						<td><?php echo $topics['contenu']; ?></td>
					</tr>
					</table>
					<br /><br /><br /><br />
					<form method="POST" action ="">
						<label>Le nouveau sujet :</label>
						<textarea name="newsujet" placeholder="Nouveau sujet"></textarea><br /><br />
						<label>Le nouveau message :</label>
						<textarea name="newcontenu" placeholder="Nouveau contenu"></textarea><br /><br />
						<input type="submit" name="tsubmit" value="Mettre à jour le topic" />

					</form>
				</div>

				<?php if(isset($msg)){
				echo $msg;} ?>
			</div>
	    
            <br /><br /><br />
            

            <!--Le footer du site-->
            <?php include('footer.php'); ?>
            
        </div>
    </body>
</html>

<?php
}
else {
	header("Location: connexion.php");
}
?>
