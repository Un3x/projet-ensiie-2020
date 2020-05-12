<!DOCTYPE html>
<?php

include '../src/Aliment.php';
include '../src/AlimentRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/panier_class.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$produits = new \Aliment\AlimentRepository($dbAdaper);
$articles = $produits->fetchAll();

session_start();
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>EpicEvry</title>
    <meta name="description" content="Panier">
    <meta name="author" content="Thomas COMES">
    <?php include "./css_head.html" ?>
	<style>
		#cata {font-weight : bold; text-align : center; font-size : 50px; color : #26272B;}
		th {color : #BECFBD; font-weight : bold;}
		td {color : #FFFFFF; font-weight : bold;}
		label {
		display: block;
		font: 1rem 'Fira Sans', sans-serif;
		}

		input,
		label {
		margin: .4rem 0;
		}
		
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
                    
                    <th>Saison</th>
                    <th>Type</th>
                    
                </tr>
                <?php 
                
                foreach($articles as $article): 
                ?>
                    <tr>
                        <td><?= $article->getNom_aliment() ?></td>
                        <td><img src="images/fruits/<?=$article->getId_aliment(); ?>.jpg" width="125px" height="60" /></td>
                        <td><?= $article->getPrix_aliment() ;  ?></td>
                        
                        <td><?= $article->getSaison_aliment() ?></td>
                        <td><?= $article->getType_aliment() ?></td>
                        
                        
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
<?php include "./footer.html" ?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="js/app.js"></script>
</body>
</html>
