<?php include('includes/header.php') ;
include('includes/dbh.inc.php');

if(isset($_POST['answer_submit'])){
    $id=$_POST['id'];
    $rep=$_POST['reponse'];

    if(empty($id) || empty($rep)) {
        echo '<p> Veuillez remplir tous les champs.Cliquez <a href="answer.php">ici</a> pour revenir </p>';
        exit(); 
    }
    else {
        $sql='INSERT INTO public."Reponse" (id, réponse,nom,prénom) VALUES (?,?,?,?)';
        $result = $conn->prepare($sql);
        $result->execute(array($id,$rep,$_SESSION['lastname'],$_SESSION['firstname']));

        if ($result){
            echo 'Votre réponse est bien prise en compte!';
            exit();
    }


}}