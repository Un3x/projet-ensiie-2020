<?php
include_once '../src/utils/autoloader.php';
$dbfactory = new \Rediite\Model\Factory\DbAdapterFactory();
$dbAdapter = $dbfactory->createService();
$AbonnementRepository = new \Rediite\Model\Repository\AbonnementRepository($dbAdapter);
$dejaAbo = $AbonnementRepository->dejaAbonne($_SESSION['n_pers'],$data['n_pers']);
if(isset($_POST['abonner'])){
	$AbonnementRepository->insertAbonnement($_SESSION['n_pers'],$data['n_pers']);
	$dejaAbo =1;
}
if(isset($_POST['desabonner'])){
	$AbonnementRepository->desabonner($_SESSION['n_pers'],$data['n_pers']);
	$dejaAbo =0;
}
$nbrAbonnements = $AbonnementRepository->getNbrAbonnements($data['n_pers']);
$nbrAbonnes = $AbonnementRepository->getNbrAbonnes($data['n_pers']);
?>


<!DOCTYPE html>
<html lang="fr">
<div class="centrer">
<div class="titreConnexion">Mur de <?php echo $data['prenom'] ?></div>
</div>
<?php if(!($data['n_pers']==$_SESSION['n_pers'] || ($dejaAbo==1))){?>
<form method="POST">
<button type="submit" name="abonner"> S'abonner </button>
</form>
<?php }
if($dejaAbo==1){?>
<form method="POST">
<button type="submit" name="desabonner"> Se désabonner </button>
<?php } ?>
</form>
<p>
<h2>Informations de <?php echo $data['prenom'] ?> :</h2>
<br>
<div class="information">
Nombre d'abonnements : <?php echo $nbrAbonnements?>
<br>
Nombre d'abonnés : <?php echo $nbrAbonnes?>
<br>
<div class="separation"></div>
Nom : <?php echo $data['nom']; ?>
<br>
Prénom : <?php echo $data['prenom']; ?>
<br>
Pseudo : <?php echo $data['pseudo']; ?>
<br>
E-mail : <?php echo $data['mail']; ?>
<br>
Date de naissance : <?php echo $data['birth']; ?>
<br>
Pays : <?php echo $data['pays']; ?>
<br>
</p>
<div class="separation"></div>
Zoubies de <?php echo $data['prenom'] ?> :
</div>
</html>