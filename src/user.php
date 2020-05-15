<!DOCTYPE html>
<html>
<head lang="fr">
	<meta charset="UTF-8">
	<title>Location de bateau d'aviron--Information Personnelle</title>
	<style>
	* {
		margin: 0px;
		padding: 0px;
	}

	.main {
		margin: 30px 120px 0px 120px;
		border-bottom: 2px solid #7a8999;
	}

	.bj {
		border-top: 5px solid #0076c2;
		width: 90%;
		padding: 10px 5%;
		background-color: #e1eefa;
	}

	.bj ol {
		width: 100%;
	}

	.bj ol li {
		display: inline-block;
		font-size: 13px;
		width: 24%;
	}

	.main h2 {
		padding: 8px 5px;
	}

	.main>ul li {
		padding: 20px 5%;
		line-height: 30px;
		display: inline-block;
		width: 90%;
		border-top: 1px solid black;
	}

	.main>ul li p {
		font-size: 13px;
	}

	.main>ul li p a {
		margin-left: 30%;
		color: #4d81c0;
		font-weight: 800;
		text-decoration: none;
	}

	.main>ul li strong {
		color: #4d81c0;
	}

	.main ol li img {
		position: relative;
		top: 3px;
		right: 5px;
	}

	.main ol li a {
		text-decoration: none;
		color: #000000;
		font-weight: 800;
	}

	.main .div{
		font-size:14px;
		position: absolute;
		top:20%;
		right:10%;
		cursor: pointer;
	}
	</style>
</head>
<?php
	
?>
<body>
	<?php session_start(); $index=isset($_SESSION['user']) ? $_SESSION['user'] : " ";?>
	<div class="main">
		<div>&nbsp;</div>
		<div class="bj">
			<ol>
				<li>Bonjour,<b onclick='document.location="login.php"'><?php echo (isset($_SESSION['user']) ? $_SESSION['user'] : "connectez vous ici");?>
				</b>
				</li>
				<li><img src="images/order.png" height="13">&nbsp;<a
					href="accueil.php">Liste des annonces</a>
					</li>
				<li><img src="images/addition.png" height="13">&nbsp;<a
					href="add.php">Déposez une annonce</a>
					</li>
				<li><img src="images/user.png" height="16">&nbsp;<a
					href="user.php">Information Personnelle</a>
					</li>
			</ol>
		</div>
		<div style="padding: 60px 240px;line-height: 30px">
				<h3><?php echo (isset($_SESSION['user']) ? $_SESSION['user'] : " ")?></h3>
				<p>Email:&nbsp;<?php echo (isset($_SESSION['email']) ? $_SESSION['email'] : " ")?></p>
				<p>Adresse:&nbsp;<?php echo (isset($_SESSION['address']) ? $_SESSION['address'] : " ")?></p>
				<div class="div">
					<a style="color:blue" onclick='document.location="update.php"'>Modifiez votre compte</a>
				</div>
		</div>
		<ul>
			<?php
				$conn = pg_connect("host=localhost port=5432 dbname=ProjetWeb user=postgres password=qwer1234"); 
				$sql = "select * from bateau where owner = '$index'";
				$ret = pg_query($conn,$sql);?>
				<li>
				<?php
					while($row=pg_fetch_row($ret)){
					echo "<p>".$row[0]."</p>";
					echo "<p>Description: <b>".$row[1]."</b></p>";
					echo "<p>Propriétaire: <b>".$row[2]."</b></p>";
					echo  "<p>Email: <b>".$row[3]."</b></p>";
					echo  "<p>Point de contact: <b>".$row[4]."</b><a>Date de publication: ".$row[5]."</a></p>";
					echo "<div ><a style='color:red' href='delete.php?bid=$row[6]'>Suprrimer</a></div>";
					echo "<HR style='FILTER: alpha(opacity=100,finishopacity=0,style=3)'  color=#987cb9 SIZE=3>";
				}
				?>
				</li>		
		</ul>
	</div>
		<div style="text-align: center; padding-top: 10px; color: #919090;">
		<img src="images/end.png" width="27px" style="margin: 0px 10px">©<?php echo date("d-m-y");?>
	</div>
	 <?php
            $status_user = isset($_GET["status_user"]) ? $_GET["status_user"] : "";
            switch ($status_user) {
            case 1:
                echo "<script>alert('Votre information est bien supprimée !');</script>";
                break;
            }
	?> 
</body>

</html>