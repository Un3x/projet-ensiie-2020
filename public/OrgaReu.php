<?php 
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/Asso.php';
include '../src/AssoRepository.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);

//session_start();
$userid=$_SESSION['user']->getId();
echo "useer".$userid;


if($userRepository->IsAdmin($userid)){ 
echo "<div class='connection_id nav-link' id='idco' >";
echo "user".$userid;
echo "</div>"; 
}
else{
	echo "dsl";
}