<?php
//****
//allow to delete a user from de database
//will be placed in the inc folder, will wait for my colleagues's approval :^)
//obviously only admins have acces to this
//****
use User\UserRepository;

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$userId = $_POST['user_id'] ?? null;
if ($userId) {
    $userRepository = new UserRepository($dbAdaper);
    $userRepository->delete($userId);
}

header('Location: /');

?>
