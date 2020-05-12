<?php

$dbAdaper = (new DbAdaperFactory())->createService();
$gameRepository = new \src\Model\repository\GameRepository($dbAdaper);
$games = $gameRepository->fetchAll();

?>

<html>
<head>
    <meta charset="utf-8">
    <title>Find A Mate</title>
</head>
    <body>

    <div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>Liste de jeux disponibles</h1>
        </div>
        <div class="col-sm-12">
            <table class="table">
                        <?php if(isset($_SESSION["isAdmin"]) and $_SESSION["isAdmin"]=='TRUE') : ?>
                            <tr>
                            <th>Nom</th>
                            <th>Le jeu est gratuit ?</th>
                            <th>Description</th>
                            </tr>
                                                       
                             <?php foreach($games as $game){ ?>
                                <?php if($game->getIsFree()==1){$free="oui";}else{$free="non";}  ?> 
                            <tr>
                            <td><?= $game->getName(); ?></td>
                            <td><?= $free; ?></td>
                            <td><?= $game->getDescription() ;?></td>
                            <td>
                            <form method="POST" action="deleteGame.php">
                                <input name="game_id" type="hidden" value="<?= $game->getId(); ?>">
                                <button class="button" type="submit">Delete</button>
                            </form>
                            </td>
                            <td>
                                <?php if($gameRepository->isInAcquired($game->getId(),$_SESSION['name'])) : ?>
                                <form method="POST" action="addAcquired.php">
                                <input name="game_id" type="hidden" value="<?= $game->getId();?>">
                                <input name="game_name" type="hidden" value="<?= $game->getName();?>">
                                <input name="user_id" type="hidden" value="<?= $_SESSION['name'];?>">
                                <button class="button" type="submit">Ajouter</button>
                                </form>
                                <?php else: ?>
                                    <div class="acquired"> <img src="signs.png"> Acquired ! </div>
                                <?php endif; ?>
                            </td>
                            <?php if($game->getIsAccepted()==0): ?>
                                <td>
                                <form method="POST" action="validateGame.php">
                                    <input name="game_id" type="hidden" value="<?= $game->getId() ;?>">
                                    <button class="button" type="submit">Validate</button>
                                </form>
                                </td>
                                <td>
                                <form method="POST" action="declineGame.php">
                                    <input name="game_id" type="hidden" value="<?= $game->getId() ;?>">
                                    <button class="button" type="submit">Decline</button>
                                </form>
                                </td>
                            </tr>
                            <?php endif;?>
                            <?php } ?>
                        <?php else : ?>
                            <tr>
                            <th>Nom</th>
                            <th>Le jeu est gratuit ? </th>
                            <th>Description</th>
                            </tr>
                            <?php foreach($games as $game){ ?>
                                <?php if($game->getIsFree()==1){$free="oui";}else{$free="non";}  ?> 
                            <?php if($game->getIsAccepted()==1): ?>
                            <tr>
                            <td><?= $game->getName(); ?></td>
                            <td><?= $free;?></td>
                            <td><?= $game->getDescription(); ?></td>
                            <?php if(isset($_SESSION['name'])): ?>
                                <td>
                                <?php if($gameRepository->isInAcquired($game->getId(),$_SESSION['name'])) : ?>
                                <form method="POST" action="addAcquired.php">
                                <input name="game_id" type="hidden" value="<?= $game->getId();?>">
                                <input name="game_name" type="hidden" value="<?= $game->getName();?>">
                                <input name="user_id" type="hidden" value="<?= $_SESSION['name'];?>">
                                <button class="button" type="submit">Ajouter</button>
                                </form>
                                <?php else: ?>
                                    <div class="acquired"> <img src="signs.png"> Acquired ! </div>
                                <?php endif; ?>
                                </td>
                            </tr>
                            <?php endif;?>
                            <?php endif;?>
                            <?php } ?>
                        <?php endif;?>  
            </table>
        </div>
    </div>
</div>
</body>
</html>
