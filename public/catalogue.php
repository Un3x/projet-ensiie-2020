<!DOCTYPE html>
<?php

include '../src/Aliment.php';
include '../src/AlimentRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/panier_class.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$produits = new \Aliment\AlimentRepository($dbAdaper);
$articles = $produits->fetchAll();
$panier= new panier($produits);
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>EpicEvry</title>
    <meta name="description" content="Panier">
    <meta name="author" content="Thomas COMES">
    <?php include "./css_head.html" ?>
	<style>
	  #cata {font-weight : bold; text-align : center; font-size : 50px; color : #26272B; }
	  .table {width:1000px;}
		th {color : #BECFBD; font-weight : bold;}
		td {color : #FFFFFF; font-weight : bold;}
		</style>
</head>

<body style="background-color:#677179">
<?php include "./header.html" ?>
<br /><br /><br />
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1 id="cata">Catalogue</h1><br /><br />
        </div>
        <div class="col-sm-12">
          <table class="table">
                <tr>
                    <th>Nom</th>
                    <th>Photo</th>
                    <th>Prix (€/kg)</th>
                    <th>Stock</th>
                    <th>Saison</th>
                    <th>Type</th>
                    <th>Ajout au panier</th>
                </tr>
		
                <?php 
                $ids=array_keys($_SESSION['panier']);
                $denree=$produits->fetchAll_panier($ids);
                foreach($articles as $article):
		if(isset($_SESSION['panier'][$article->getId_aliment()])): {
		$stock_panier = $_SESSION['panier'][$article->getId_aliment()];
		}
		else:
		$stock_panier = 0;
		endif;
                ?>
                    <tr>
                        <td><?= $article->getNom_aliment() ?></td>
                        <td><img src="images/fruits/<?=$article->getId_aliment(); ?>.jpg" width="125px" height="60" /></td>
                        <td><?= $article->getPrix_aliment() ;  ?></td>
                        <td><?= $article->getStock_aliment() - $stock_panier?></td>
                        <td><?= $article->getSaison_aliment() ?></td>
                        <td><?= $article->getType_aliment() ?></td>
                        <td>
			  <center>
                            <a class="add addPanier" href="addPanier.php?id=<?= $article->getId_aliment(); ?>">
                            <i class="fa fa-cart-arrow-down fa-4x" aria-hidden="true"></i>


                            </a>
			    </center>
                            
                        </td>
                        
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div><br /><br /><br />
<?php include "./footer.html" ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="js/app.js"></script>
</body>
</html>
