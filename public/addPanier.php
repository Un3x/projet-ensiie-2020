<?php

require '../src/Aliment.php';
require '../src/AlimentRepository.php';
require '../src/Factory/DbAdaperFactory.php';
require '../src/panier_class.php';


$dbAdaper = (new DbAdaperFactory())->createService();
$produits= new \Aliment\AlimentRepository($dbAdaper);
$panier= new panier($produits);
$json = array('error' => true);


if(isset($_GET['id'])){
    $product = $produits->add($_GET['id']);
    }
    if(empty($product)){
        $json['message'] = "Ce produit n'existe pas";
    }
    $panier->add($product[0]->getId_aliment());
    $json['error']=false;
    $json['message'] ='Le produit a été ajouté au panier ';
    echo json_encode($json);

      




