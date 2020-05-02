<h1>Bienvenue sur votre page personnelle <?php echo $_SESSION['username']?> !</h1>
<p>Pour l'instant il n'y a rien, mais bientôt, vous pourrez consulter vos Achievements et modifier vos information de profil !</p>
<p>Vous pouvez également supprimer votre compte :
    <form method="post" action="server.php" onsubmit="return areYouSure();">
    <button type=submit name="delete_account" class="btn btn-danger">/!\ SUPPRIMER MON COMPTE /!\</button>
</p>