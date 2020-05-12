<!DOCTYPE html>
<?php

include '../src/Aliment.php';
include '../src/AlimentRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/panier_class.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$produits = new \Aliment\AlimentRepository($dbAdaper);

$panier= new panier($produits);


?>

<?php

if(isset($_GET['del'])){
    $panier->del($_GET['del']);
}



?>


<html lang="en">
<head>
    <meta charset="utf-8">
    <title>EpicEvry</title>
    <meta name="description" content="Panier">
    <meta name="author" content="Thomas COMES">
    <?php include "./css_head.html" ?>
    <style>
		#titrerec {color: #26272B; text-align : center;}
		th {color : #BECFBD; }
		td {color : #FFFFFF; }
		#author {font-weight : bold; color : #FFFACD;}
		#bouton {color : #FFFFFF; background-color : #26272B; font-weight : bold; border : none;}
		#dateshow {background-color : #FFFACD; color : #26272B;}
	</style>
</head>
<body style="background-color:#677179">
<?php include "./header.html" ?>

<br /><br /><br />
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1 id="titrerec" >Articles dans votre panier</h1><br /><br />
        </div>
        <div class="col-sm-12">
            <table class="table">
                <tr>
                    <th>Produit</th>
                    <th>Image</th>
                    <th>Saison</th>
		    <th>Type</th>
                    <th>Prix (€/kg)</th>
                    <th>Quantité</th>
                    <th>Prix total</th>
                    <th>Supprimer</th>
                    
                 
                    
                    
                </tr>
                
                <?php 
                $ids=array_keys($_SESSION['panier']);
                $articles=$produits->fetchAll_panier($ids);
                foreach($articles as $article): ?>
                    <tr>
                        <td><?= $article->getNom_aliment() ?></td>
                        <td><img src="images/fruits/<?=$article->getId_aliment(); ?>.jpg" width="125px" height="60" /></td>
                        <td><?= $article->getSaison_aliment() ?></td>
                        <td><?= $article->getType_aliment() ?></td>
                        <td><?= $article->getPrix_aliment() ;  ?></td>
                        <td><?= $_SESSION['panier'][$article->getId_aliment()] ?></td>
                        <td><?= $_SESSION['panier'][$article->getId_aliment()]* $article->getPrix_aliment()?></td>
                        <td>
                        <a class="del" href ="panier.php?del=<?=$article->getId_aliment(); ?>">
                            <img src="images/panier/delete.png" width="40px" height="40" />
                         </a>


                        </td>
                        
                        
                        
                        
                    </tr>
                <?php endforeach; ?>
            </table>
            <table class="table">
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    
                    
                    <th>Grand Total</th>
                
                    
                    
                </tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td><?= $panier->total(); ?> €</td>

            </table>
            
        </div>
    </div>
    <div align="center">
		<h3>Date de livraison et confirmation</h3><br />
		<div align="center">
		  <form id="recette" method="POST" action="addCommande.php">
			<label><Datag>date de livraison :</Datag></label>
			<input id="dateshow" type="date" name="date_livraison" required><br /><br />
			<input type="hidden" name="userID" value=<?= $_SESSION['id'] ?> >
			<input type="hidden" name="prix_total" value=<?= $panier->total()?> >
			<input id="bouton" type="submit" value="Commander" />
        </form>
    </div>
	</div>
</div><br /><br />
<?php include "./footer.html" ?>
</body>
</html>
