<?php


$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \src\Model\repository\UserRepository($dbAdaper);

if (isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    $userRepository->delete($userId);
    
}

header('Location: deconnection.php');

?>