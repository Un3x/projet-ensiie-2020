<?php

use Interest\InterestRepository;
use User\UserRepository;


include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/InterestRepository.php';

session_start();
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
$username = $_REQUEST['username'];
$interestRepository = new InterestRepository($dbAdaper);
$interestsAll = $interestRepository->fetchAll();
$interestsUser = $userRepository->fetchInterests($username);
$messages = $userRepository->fetchMessagesSent($username);
echo "<h1 style='text-align: center; font-weight: 700'>Messages Envoyés </h1>";
foreach ($messages as $message) {
    echo "<div class=\"shadow p-3 mb-5 bg-white rounded\" > <p>{$message->getContent()}</p>
                <footer class=\"blockquote-footer\">{$message->getReceiver()}, {$message->getCreatedAt()->format('g:ia \o\n l jS F Y')}</footer>
                <div style='padding: 10px'> ";
    echo " </div>
            </div>";

}

$messages = $userRepository->fetchMessagesReceived($username);
echo "<h1 style='text-align: center; font-weight: 700'>Messages Reçus </h1>";
foreach ($messages as $message) {
    echo "<div class=\"shadow p-3 mb-5 bg-white rounded\" > <p>{$message->getContent()}</p>
                <footer class=\"blockquote-footer\">{$message->getReceiver()}, {$message->getCreatedAt()->format('g:ia \o\n l jS F Y')}</footer>
                <div style='padding: 10px'> ";
    echo " </div>
            </div>";

}