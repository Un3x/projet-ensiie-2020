<?php

if(isset($_POST["supprimer-submit"])){
    require 'dbh.inc.php';
    $id=$_POST["idHiden"];

    $sql='DELETE FROM utilisateur WHERE id_utilisateur=?';
    $stmt = $conn->prepare($sql);
    if($stmt == false){
        header("Location: ../nav/super-gestion.php?error=sqlerror");
        exit();
    }else{
        $stmt->execute(array($id));
        header("Location: ../nav/super-gestion.php?success=userdeleted");
    }
}else{
    header("Location: ../nav/super-gestion.php");
}