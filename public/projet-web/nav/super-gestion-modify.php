<?php

require "../header.php";

?>

<main>
<link rel="stylesheet" href="/projet-web/style/super-gestion-modify.css">

<?php

$id=$_POST["id"];
$mail = $_POST['mail'];

if(isset($_POST['gestion-submit'])){

    require "../includes/dbh.inc.php";

    if($id != null){
        $sql="SELECT * FROM utilisateur WHERE id_utilisateur = ?";
        $stmt = $conn->prepare($sql);
        if($stmt == false){
            echo "sql error";
            exit();
        }else{
            $stmt->execute(array($id));
            $result = $stmt->fetchAll();
            if(count($result) > 0){
                foreach($result as $row){
                if ($mail != null && $row['mail'] != $mail){
                    echo "<p> Erreur : Mail et ID ne matchent pas";
                }
                else{
                ?>
                <div class="container wrapper">
                <form action="/projet-web/includes/super-gestion-modify.inc.php" method="POST">
                <h2>Modification de l'utilisateur</h2>

                    <input type="hidden" name="idHiden" value="<?php echo $row['id_utilisateur'];?>">

                    <label><b>Id</b></label>
                    <input type="text" value="<?php echo $row['id_utilisateur'];?>" name="id" disabled="disabled">

                    <label><b>Droit (1:utilisateur, 2:admin, 3:super-admin)</b></label>
                    <input type="number" value="<?php echo $row['droit'];?>" name="droit"<?php if($_SESSION["userDroit"]===2){echo 'disabled="disabled"';}?>>

                    <label><b>Nom</b></label>
                    <input type="text" value="<?php echo $row['nom'];?>" name="nom">

                    <label><b>Prénom</b></label>
                    <input type="text" value="<?php echo $row['prenom'];?>" name="prenom">

                    <label><b>Mail</b></label>
                    <input type="text" value="<?php echo $row['mail'];?>" name="mail">

                    <label><b>Tel</b></label>
                    <input type="text" value="<?php echo $row['tel'];?>" name="tel">

                    <label><b>Voiture</b></label>
                    <input type="text" value="<?php echo $row['modele_voiture'];?>" name="voiture">

                    <button type="submit" class="btn btn-success" name='modif-submit'>Sauvegarder</button> 
                </form>
                <form action="/projet-web/includes/supprimer-utilisateur.inc.php" method="POST">
                <input type="hidden" name="idHiden" value="<?php echo $row['id_utilisateur'];?>">
                <button type="submit" class="btn btn-warning supprimer" name='supprimer-submit'>Supprimer le compte</button>
                </form>
                </div>

                <?php }}
            }else{
                echo '<p>Aucun utilisateur avec cet ID/mail</p>';
            }
        }
     }else if(isset($mail)){
        $sql="SELECT * FROM utilisateur WHERE mail = ?";
        $stmt = $conn->prepare($sql);
        if($stmt == false){
            echo "sql error";
            exit();
        }else{
            $stmt->execute(array($mail));
            $result = $stmt->fetchAll();
            if(count($result) > 0){
                foreach($result as $row){?>
                <div class="container wrapper">
                <form action="/projet-web/includes/super-gestion-modify.inc.php" method="POST">
                <h2>Modification de l'utilisateur</h2>

                    <input type="hidden" name="idHiden" value="<?php echo $row['id_utilisateur'];?>">

                    <label><b>Id</b></label>
                    <input type="text" value="<?php echo $row['id_utilisateur'];?>" name="id" disabled="disabled">

                    <?php if($_SESSION["userDroits"] === 3){?>
                    <label><b>Droit (1:utilisateur, 2:admin, 3:super-admin)</b></label>
                    <input type="number" value="<?php echo $row['droit'];?>" name="droit">
                    <?php } ?>

                    <label><b>Nom</b></label>
                    <input type="text" value="<?php echo $row['nom'];?>" name="nom">

                    <label><b>Prénom</b></label>
                    <input type="text" value="<?php echo $row['prenom'];?>" name="prenom">

                    <label><b>Mail</b></label>
                    <input type="text" value="<?php echo $row['mail'];?>" name="mail">

                    <label><b>Tel</b></label>
                    <input type="text" value="<?php echo $row['tel'];?>" name="tel">

                    <label><b>Voiture</b></label>
                    <input type="text" value="<?php echo $row['modele_voiture'];?>" name="voiture">

                    <button type="submit" class="btn btn-success" name='modif-submit'>Sauvegarder</button> 
                </form>
                <form action="/projet-web/includes/supprimer-utilisateur.inc.php" method="POST">
                <input type="hidden" name="idHiden" value="<?php echo $row['id_utilisateur'];?>">
                <button type="submit" class="btn btn-warning supprimer" name='supprimer-submit'>Supprimer le compte</button>
                </form>
                </div>

                <?php }
            }else{
                echo '<p>Aucun utilisateur avec cet ID/mail</p>';
            }
        }

     }
} else {
    header("Location: /projet-web/nav/index.php?error");
}

?>