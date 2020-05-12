<?php

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Commande.php';
include '../src/CommandeRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$commandeRepository = new \Commande\CommandeRepository($dbAdaper);
$commandes = $commandeRepository->fetchall();
session_start();

?>
<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Gestion des commandes</title>

    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Us">

    <?php include "./css_head.html" ?>

</head>


	<style>
		h1 {color: #26272B; text-align : center;}
		th {color : #BECFBD; text-align: center;}
		td {color : #FFFFFF; text-align: center; }
		#author {font-weight : bold; color : #FFFACD;}
		.bouton {color : #FFFFFF; background-color : #26272B; font-weight : bold; border : none;}
	</style> 

<body style="background-color: #677179">x


<?php include "./header.html" ?>

<!-- Verification que le visiteur est bien un administrateur -->
<?php if (!isset($_SESSION['id']) || !($_SESSION['role'] == 1)):
$erreur="notConnected";
header("Location: /?erreur={$erreur}");
endif ?>

<div class="container"><br /><br />
    <div class="row">
        <div class="col-sm-12">
            <h1>Commandes en cours</h1><br />
        </div>
        <div class="col-sm-12">
            <table class="table">
                <tr>
                    <th>Numéro de commande</th>
		    <th>Date de livraison</th>
                    <th>Prix total de la commande</th>
		    <th>Client</th>
		    <th>Action</th>
                </tr>
		<!-- Boucle sur toutes les commandes de la base de données -->
                <?php foreach($commandes as $commande): ?> 
                    <tr>
			<!-- Récupération des attributs des commandes via les objets php des commandes -->
                        <td><?= $commande->getId() ?></td>
                        <td><?= $commande->getDateLivraison() ?></td>
			<td><?= $commande->getPrixTotal() ?></td>
			<td><?= $commandeRepository->associatedClient($commande->getId()) ?></td>
                        <td>
				<!-- Supression d'une commande -->
                            <form method="POST" action="/deleteCommande.php">
                                <input name="commande_id" type="hidden" value="<?= $commande->getId() ?>">
                                <button class="bouton" type="submit">Supprimer</button>
                            </form><br />

			    <!-- Détails d'une commande -->
			    <form method="POST" action="/detailsCommande.php">
			    	   <input name="commande_id" type="hidden" value="<?= $commande->getId() ?>">
                                <button class="bouton" type="submit">Détails</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>					
<?php include "./footer.html" ?>
</body>
</html>
