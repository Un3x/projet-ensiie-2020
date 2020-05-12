<style type="text/css">
    .hidden {
        display: none;
    }
</style>


<?php
// Pour cacher des liens pour les non-admin
if ($_SESSION["admin"]==false) {
    $hide = "hidden";
} else {
    $hide = "";
}
?>

<header class="header-green">
	<ul class="main-menu">
		<li><a href="/">Accueil</a></li>
		<li><a href="/morpiien">Morpiien</a></li>
		<li><a href="/scores">Scores</a></li>
		<li><a href="/tournoi">Tournoi</a></li>
		<li><a href="/historique">Historique de parties</a></li>
		<li class="<?=$hide?>" ><a href="/profils">Gestion des profils</a></li>
		<li><a href="/profil">Mon profil</a></li>
		<li><a href="/logout">Déconnexion</a></li>
	</ul>
</header>
