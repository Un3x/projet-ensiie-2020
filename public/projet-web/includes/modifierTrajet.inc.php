<?php 

if(isset($_POST["confirmer"])){
    require 'dbh.inc.php';

    $newNombre = $_POST["nombrePlace"];
    $id_trajet = $_POST["id_trajet"];

    echo $newNombre.$id_trajet;

    $sql='UPDATE trajet SET nombre_place=? WHERE id_trajet=?';
    $stmt = $conn->prepare($sql);
    if($stmt == false){
        header("Location: ../nav/monCompte.php?error=sqlerror");
        exit();
    }else{
        $stmt->execute(array($newNombre,$id_trajet)); //On change les infos
        header("Location:/projet-web/nav/monCompte.php?success=trajetmodifie");
        exit();
    }


}else{
    header("Location: /projet-web/index.php");
}


?>