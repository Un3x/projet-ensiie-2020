<html>
    <head>
        <title>Page d'inscription FindAMAte</title>
        <meta charset="utf-8">

    </head>
    <body>
        <div align="center">
            <h2>Inscription</h2>
            <br /><br />


<form action="adduser.php" method="POST">
<table>
    <tr>
        <td align="right">
            <label>Email:</label>
        </td>
        <td align="right">
            <input type="email" placeholder="Champ obligatoire" name="email" value="<?php if(isset($_GET['email'])) { echo htmlspecialchars($_GET['email']); } ?>" required />
        </td>
    </tr>
    <tr>
        <td align="right">
            <label>Pseudo:</label>
        </td>
        <td align="right">
            <input type="text" placeholder="Champ obligatoire" name="pseudo" value="<?php if(isset($_GET['pseudo'])) { echo htmlspecialchars($_GET['pseudo']); } ?>" required />
        </td>
    </tr>
    <tr>
        <td align="right">
            <label>Promo:</label>
        </td>
        <td>
            <input type="int" placeholder="Champ optionnel ex:2022" name="promo" value="<?php if(isset($_GET['promo'])) { echo htmlspecialchars($_GET['promo']); } ?>" />
        </td>
    </tr>
    <tr>
        <td align="right">
            <label>Pseudo Discord:</label>
        </td>
        <td align="right">
            <input type="text" placeholder="Champ optionnel ex:abc#1234" name="pseudo_discord" value="<?php if(isset($_GET['pseudo_discord'])) { echo htmlspecialchars($_GET['pseudo_discord']); } ?>" />
        </td>
    </tr>
    <tr>
        <td align="right">
            <label>Mot de passe:</label>
        </td>
         <td align="right">
            <input type="password" placeholder="Champ obligatoire" name="mdp1" required />
        </td>
    </tr>
    <tr>
        <td align="right">
            <label>Confirmez le mot de passe:</label>
        </td>
        <td align="right">
            <input type="password" placeholder="Champ obligatoire" name="mdp2" required />
        </td>
    </tr>
 </table>
 <br />
<button type="submit" name=valider>Valider</button>
</form>
<?php

    if(isset($_GET['erreur']))
    {

        echo "<font color='red'>".$_GET['erreur']."</font color>";
    }
?>
</div>
</body>
</html>
