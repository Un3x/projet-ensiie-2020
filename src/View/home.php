<?php
    $books = $data["books"];
    session_start();
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>Liste des ouvrages empruntables</h1>
        </div>
        <div class="col-sm-12">
            <table class="table">
                <tr>
                    <!--<th>id</th>-->
                    <th>Aperçu</th>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th> Emprunté </th>
                    <th>Libre</th>
                    <?php
                    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true && $_SESSION["adminright"] == true){?>
                    <th>Supprimer</th>
                    <?php } ?>
                </tr>
                
                <?php foreach($books as $book): ?>
                    <tr>
                        
                        <td><img src=<?=$book->getApercu()?> alt=<?= 'Image'.$book->getTitre()?> width=auto height="150" /></td>
                        <td> <a href=<?= "borrowBook.php?descBook=".$book->getId()?>> <?= $book->getTitre() ?> </a> </td>
                        <td><?= $book->getAuteur() ?></td>
                        
                        <td><?php 
                        if($book->getBorrowed()) {echo "Emprunté";} 
                        else {echo "Disponible";} ?></td>
                        <td>
                            <form method="POST" action="/borrowBook.php">
                                <input name="book_id" type="hidden" value="<?= $book->getId() ?>">
                                <?php 
                                if($book->getBorrowed() == FALSE) {echo '<button type="submit">Emprunter</button>';}
                                elseif(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true && $_SESSION["adminright"] == true){?>
                                <a href=<?= "borrowBook.php?rendu=".$book->getId()?>>Rendre</a>
                                <?php }?>
                            </form>
                        </td>
                        <?php
                        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true && $_SESSION["adminright"] == true){?>
                        <td>
                        <a href=<?= "borrowBook.php?delBookId=".$book->getId()?>>Supprimer</a>
                        </td>
                        <?php } ?>
                    </tr>
                <?php endforeach; ?>
                
            </table>
        </div>
    </div>
</div>
<script src="script.js"></script>