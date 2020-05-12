
<!DOCTYPE html>
<html>

    
        <?php 
        if (!(isset($_SESSION['adresse_mail']))){
            ?>  
            <p> Vous n'êtes pas connecté</p>
             <form method="post" action="/coroshop/public/formulaire_connexion.php">
		<input type="submit" value="connection">
            <?php
        }
      else{
            ?>
            

        <form action="/coroshop/src/vente_bd.php" method="post">
        
        <label for="nom">nom :</label>
        <input type="text" name="nom" id="nom" autofocus required/><br />
        
        <label for="categorie">catégorie :</label>
        <select name="categorie" id="categorie" >
            <optgroup label="vêtement">
                <option value="slip" selected>slip</option>
                <option value="robe">robe</option>
                <option value="pantalon">pantalon</option>
            </optgroup>
            <optgroup label="maison">
                <option value="meuble">meuble</option>
                <option value="electromenager">electromenager</option>
            </optgroup>
        </select>
        <br />
        <label for="description">description :</label> 
        <input type="text" name="description" id="description" required />
        <br />
        
        <label for="prix">prix</label>
        <input type="number" name="prix" id="prix" step="0,01" required > 
        <br />
        <input type="submit" value="valider" />
	
    </form>
    <?php
        
        
        }
        ?>

</html>
