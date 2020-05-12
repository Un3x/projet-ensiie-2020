<?php 
    session_start();

?>

<header>
<P class= "puce" ></P>
<div class = "inp">
<ul><li>
<form method="post" action="/coroshop/index.php">
<input type="submit" value="rechercher un objet">
</form>
</li><li>
<form method="post" action="/coroshop/public/vendre_page_complette.php">
<input type="submit" value="vendre un objet">
</form></li><li>
<?php
if (isset($_SESSION['adresse_mail'])){
    ?>
    <form method="post" action="/coroshop/src/deconnection.php">
<input type="submit" value="deconnection">
</form></li>
<?php
}
else {
    ?>
    <form method="post" action="/coroshop/public/formulaire_connexion.php">
<input type="submit" value="connection">
</form></li>
<?php
}
?>
</ul>
</div>

</header>

