<?php
include_once '../src/utils/autoloader.php';
$dbfactory = new \Rediite\Model\Factory\DbAdapterFactory();
$dbAdapter = $dbfactory->createService();
$AbonnementRepository = new \Rediite\Model\Repository\AbonnementRepository($dbAdapter);

$PersonneHydrator = new \Rediite\Model\Hydrator\PersonneHydrator();
$PersonneRepository = new \Rediite\Model\Repository\PersonneRepository($dbAdapter, 
                                                                       $PersonneHydrator);
?>

<!DOCTYPE html>
<html lang="fr">
<div class="centrer">
<div class="titreConnexion">Abonnements de  <?php echo $_SESSION['prenom'] ?></div>
</div>
<h1> Vous avez <?php echo $data['nbrRow']?> abonnement(s). </h1>
<?php
if(!empty($data)){
for($i = 0; $i<2*$data['nbrRow'];$i=$i+2){?>
    <li class="sansPuces"><div class="titreConnexion">
    <?php echo $data[$i];
    echo " ";
    echo $data[$i+1];
    ?>
    </li></div>
<?php }
}
?>
</html>