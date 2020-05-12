<?php
include_once '../src/utils/autoloader.php';
$dbfactory = new \Rediite\Model\Factory\DbAdapterFactory();
$dbAdapter = $dbfactory->createService();
$AbonnementRepository = new \Rediite\Model\Repository\AbonnementRepository($dbAdapter);

$PersonneHydrator = new \Rediite\Model\Hydrator\PersonneHydrator();
$PersonneRepository = new \Rediite\Model\Repository\PersonneRepository($dbAdapter, 
                                                                       $PersonneHydrator);

$data=[];
$i=0;
$abonnements = $AbonnementRepository->getAbonnements($_SESSION['n_pers']);
$nbrRow = $abonnements->rowCount();
$data['nbrRow']=$nbrRow;
while($row=$abonnements->fetch()){
    $data[$i]=$row['prenom'];
    $data[$i+1]=$row['nom'];
    $i = $i +2;
}
include_once '../src/view/template.php';
loadView('abonnement', $data);    
?>