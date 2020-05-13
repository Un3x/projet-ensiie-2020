<?php

require "../header.php";

?>

<main>
<link rel="stylesheet" href="/projet-web/style/super-gestion.css">
<?php
if ($_SESSION['userDroit'] === 3){
    require '../includes/dbh.inc.php';
    ?>

<div class="container myC">
    <h1>Utilisateurs</h1>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
  <tr>
    <td>
       <table cellspacing="0" cellpadding="1" border="1" width="100%" >
         <tr style="color:white;background-color:grey; text-align:left;">
            <th>ID</th>
            <th>Droit</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Mail</th>
            <th>Tel</th>
            <th>Voiture</th>
         </tr>
       </table>
    </td>
  </tr>
  <tr>
    <td>
       <div style="height:200px; overflow:auto;">
         <table cellspacing="0" cellpadding="1" border="1" width="100%" >

        <?php
        $sql = "SELECT * FROM utilisateur";
        $stmt = $conn->prepare($sql);
        if($stmt == false){
            header("Location: super-gestion.php?error=sqlerro");
            exit();
        }else{
            $stmt->execute(array());
            $result = $stmt->fetchAll();
            if(count($result)>0){
                foreach($result as $row){
                    echo "<tr>";
                    echo "<td>".$row['id_utilisateur']."</td>";
                    echo "<td>".$row['droit']."</td>";
                    echo "<td>".$row['nom']."</td>";
                    echo "<td>".$row['prenom']."</td>";
                    echo "<td>".$row['mail']."</td>";
                    echo "<td>".$row['tel']."</td>";
                    echo "<td>".$row['modele_voiture']."</td>";
                    echo "</tr>";
                }
            }else{
                echo "erreur";
            }
        }
                ?>
         </table>  
       </div>
    </td>
  </tr>
</table>
</div>

<div class="container myC2">
    <h1>Trajets proposés</h1>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
  <tr>
    <td>
       <table cellspacing="0" cellpadding="1" border="1" width="100%" >
         <tr style="color:white;background-color:grey; text-align:left;">
            <th>ID trajet</th>
            <th>Date</th>
            <th>Départ</th>
            <th>Arrivée</th>
            <th>Nombre place</th>
            <th>Conducteur</th>
            <th>Type</th>
         </tr>
       </table>
    </td>
  </tr>
  <tr>
    <td>
       <div style="height:200px; overflow:auto;">
         <table cellspacing="0" cellpadding="1" border="1" width="100%" >

        <?php
        $sql = "SELECT * FROM trajet,utilisateur WHERE trajet.id_conducteur=utilisateur.id_utilisateur";
        $stmt = $conn->prepare($sql);
        if($stmt == false){
            header("Location: super-gestion.php?error=sqlerro");
            exit();
        }else{
            $stmt->execute(array());
            $result = $stmt->fetchAll();
            if(count($result)>0){
                foreach($result as $row){
                    echo "<tr>";
                    echo "<td>".$row['id_trajet']."</td>";
                    echo "<td>".$row['jour_depart']." ".$row['mois_depart']." ".$row["annee_depart"]."</td>";
                    echo "<td>".$row['ville_depart']."</td>";
                    echo "<td>".$row['ville_arrivee']."</td>";
                    echo "<td>".$row['nombre_place']."</td>";
                    echo "<td>".$row['nom']." ".$row['prenom']."</td>";
                    echo "<td>".$row['type']."</td>";
                    echo "</tr>";
                }
            }else{
                echo "erreur";
            }
        }
                ?>
         </table>  
       </div>
    </td>
  </tr>
</table>
</div>

<div class="container myC3">
  <h1>Les réservations</h1>
  <table cellspacing="0" cellpadding="0" border="0" width="100%">
  <tr>
    <td>
       <table cellspacing="0" cellpadding="1" border="1" width="100%" >
         <tr style="color:white;background-color:grey; text-align:left;">
            <th>ID trajet</th>
            <th>Date</th>
            <th>Départ</th>
            <th>Arrivée</th>
            <th>Nombre place Réstante</th>
            <th>Nombre place réservé</th>
            <th>Conducteur</th>
            <th>Passagers</th>
            <th>Type</th>
         </tr>
       </table>
    </td>
  </tr>
  <tr>
    <td>
       <div style="height:200px; overflow:auto;">
         <table cellspacing="0" cellpadding="1" border="1" width="100%" >

        <?php
        $sql = "SELECT * FROM trajet,utilisateur,reservation_trajet WHERE trajet.id_conducteur=utilisateur.id_utilisateur AND trajet.id_trajet = reservation_trajet.id_trajet";
        $stmt = $conn->prepare($sql);
        if($stmt == false){
            header("Location: super-gestion.php?error=sqlerro");
            exit();
        }else{
            $stmt->execute(array());
            $result = $stmt->fetchAll();
            if(count($result)>0){
                foreach($result as $row){
                    echo "<tr>";
                    echo "<td>".$row['id_trajet']."</td>";
                    echo "<td>".$row['jour_depart']." ".$row['mois_depart']." ".$row["annee_depart"]."</td>";
                    echo "<td>".$row['ville_depart']."</td>";
                    echo "<td>".$row['ville_arrivee']."</td>";
                    echo "<td>".$row['nombre_place']."</td>";
                    echo "<td>".$row['nombre_place_reserve']."</td>";
                    echo "<td>".$row['nom']." ".$row['prenom']."</td>";
                    $id_passager = $row["id_passager"];
                    $sql2 = "SELECT nom,prenom FROM utilisateur WHERE id_utilisateur=?";
                    $stmt2 = $conn->prepare($sql2);
                    if($stmt2 == false){
                      header("Location: super-gestion.php?error=sqlerro");
                      exit();
                    }else{
                      $stmt2->execute(array($id_passager));
                      $result2 = $stmt2->fetchAll();
                      echo "<td>".$result2[0]["nom"]." ".$result2[0]["prenom"]."</td>";
                    }
                    echo "<td>".$row['type']."</td>";
                    echo "</tr>";
                }
            }else{
                echo "erreur";
            }
        }
                ?>
         </table>  
       </div>
    </td>
  </tr>
</table>

</div>

<div class="container gestion">
    <h1>Gestion</h1>
    <p>Sélectionner un utilisateur à l'aide de son id ou de son adresse mail</p>
    <form action="super-gestion-modify.php" method="POST">
    <label><b>ID de l'utilisateur</b></label>
    <input type="number" placeholder="ID" name="id">

    <label><b>Mail de l'utilisateur</b></label>
    <input type="text" placeholder="Mail" name="mail">
    <br>
    <button type="submit" name='gestion-submit'>Gérer</button>
    </form>
    <br>

    <?php
    if(isset($_GET["success"]) && $_GET["success"] === "infomodified"){
        echo "<p class='success'>Informations modifiées avec succès !</p>";
    }else if(isset($_GET["success"]) && $_GET["success"] === "userdeleted"){
        echo "<p class='success'>Utilisateur supprimé avec succès !</p>";
    }
    ?>
</div>


<?php }else{
    echo "Accès refusé";
}?>

</main>

<?php
require "../footer.php";
?>