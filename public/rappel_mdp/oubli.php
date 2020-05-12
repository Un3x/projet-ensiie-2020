
<!DOCTYPE html>
<html>
<body>

<?php
session_start();

if (! isset( $_POST['username'])){
 header('Location: rappel.php?erreur=1');
 exit();
}
  $username = $_POST['username'];

  
  
   // connexion à la base de données
   $db = pg_connect("host=localhost user=toraux dbname=toraux password=ensiie")
   or die('Erreur de connexion  la base de données');

  // Verification d'existence du pseudo
   $existe = "Select count(*) from utilisateur where user_id = '$username' ; ";
   $valeur = "Select * from utilisateur where user_id = '$username' ; ";
   $number_same_tab = pg_query($existe) or die('Erreur commande existe');
   $number_same = pg_fetch_row($number_same_tab);
   if (0 == $number_same[0]){
      header('Location: rappel.php?erreur=1');
      }
   else{
	$val = pg_query($valeur) or die('Erreur commande existe');
	$row = pg_fetch_row($val);}

?>

<form name="myform" method="post" action="reponse.php">
<input type="hidden" name="user" value="<?php echo $row[0]  ?>">
<input type="text" name="password" value="<?php echo $row[1] ?>">
<input type="hidden" name="question" value="<?php echo $row[2] ?>">
<input type="hidden" name="answer" value="<?php echo $row[3] ?>">
</form>
<script>
document.forms["myform"].submit();
</script>


<?php
   pg_close($db); 
   exit();
   ?>

  </body>
</html>
