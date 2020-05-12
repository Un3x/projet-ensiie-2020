<?php
    $books = $data["books"];
    session_start();
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
                <?php foreach($books as $book): ?>
                    <p class=apercu><img class=image src=<?=$book->getApercu()?> alt=<?= 'Image'.$book->getTitre()?>/></p>
                    <div class=texte>
                        <p class=titre><span>Titre :</span> <?= $book->getTitre() ?></p>
                        <p class=auteur><span>Auteur :</span> <?= $book->getAuteur() ?></p>
                        <p class=resume><span>Résumé :</span> <?= $book->getSummary() ?></p>
                        <p> Likes : <?= $book->getLikes() ?> </p>
                        <p class=emprunte><?php if($book->getBorrowed()) {echo "Emprunté";} else {echo "Disponible";} ?></p>
                        <p class=bouton><form method="POST" action="/borrowBook.php">
                            <input name="book_id" type="hidden" value="<?= $book->getId() ?>">
                            <?php if($book->getBorrowed() == FALSE) {echo '<button name="fct_id" type="submit" value="b">Emprunter</button>';}?>
                        </form></p>
                    <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true ) { ?>
                    <p class=likes>
                        <form method="POST" action="/borrowBook.php">
                            <input name="id_book" type="hidden" value="<?= $book->getId() ?>">
                            <input name="likes" type="hidden" value="<?= $_SESSION["id"]; ?>">
                            <button type="submit">Like it</button>
                        </form>
                    </p>
                    <p class=dislikes>
                        <form method="POST" action="/borrowBook.php">
                            <input name="id_book" type="hidden" value="<?= $book->getId() ?>">
                            <input name="dislikes" type="hidden" value="<?= $_SESSION["id"]; ?>">
                            <button type="submit">Dislike it</button>
                        </form>
                    </p>
                    </div>
                <?php }endforeach; ?>
        </div>
    </div>
</div>
<script src="script.js"></script>