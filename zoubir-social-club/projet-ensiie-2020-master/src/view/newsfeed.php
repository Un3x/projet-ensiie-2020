<?php
include_once '../src/utils/autoloader.php';
include_once '../src/view/message_view.php';
// create the database connection
$dbfactory = new \Rediite\Model\Factory\DbAdapterFactory();
$dbAdapter = $dbfactory->createService();

$AbonnementRepository = new \Rediite\Model\Repository\AbonnementRepository($dbAdapter);

$PersonneHydrator = new \Rediite\Model\Hydrator\PersonneHydrator();
$PersonneRepository = new \Rediite\Model\Repository\PersonneRepository($dbAdapter, 
																	   $PersonneHydrator);

$MessageHydrator = new \Rediite\Model\Hydrator\MessageHydrator();
$MessageRepository = new \Rediite\Model\Repository\MessageRepository($dbAdapter, 
																	 $MessageHydrator);

$LikerRepository = new \Rediite\Model\Repository\LikerRepository($dbAdapter);
$aboMessage = $MessageRepository->selectMessageByAbo($_SESSION['n_pers']);

?>
<div class="centrer">
<div class="titreConnexion">Fil d'actualités de <?php echo $_SESSION['prenom'] ?></div>
</div>
</div>
<?php 
if(!(empty($aboMessage))){ 


	while($row=$aboMessage ->fetch())
	{
		$writer = $MessageRepository->getAuteur($row['n_mess']);
		$parution = $row['parution'];
		$n_mess = $row['n_mess'];
		$nb_likes = $row['nb_like'];
		$user = $_SESSION['n_pers'];
		$nom_prenom = $PersonneRepository->findNameSurnameById($writer);
		$nom = $nom_prenom['nom'];
		$prenom = $nom_prenom['prenom'];
		$isLiked = $LikerRepository->isAlreadyLiked($user,$n_mess);

		print_message_header($nom,$prenom);
		print_content($row['content']);
		print_message_closer($parution,
							 $n_mess,
							 $writer,
							 $nb_likes,
							 $isLiked,
							 $writer
	);
						 /*
			?>
    			<li><?php echo $row['content'];?></li>
				<?php }?>
				</ul>
				<?php  ?>*/
	}
}
?>