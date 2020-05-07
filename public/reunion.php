<?php 
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/Asso.php';
include '../src/AssoRepository.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
session_start();
$userid=$_SESSION['user']->getId();
echo "useer".$userid;
$sql="SELECT * FROM administrateur where id_membrea='$userid'";
$SuperUserOf=$dbAdapter->query($sql);

if(is_null($SuperUserOf)){ 
echo "<div class='connection_id nav-link' id='idco' >";
echo "$user";
echo "</div>"; 
}
else{
	echo "dsl";
}