<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../src/Model/Factory/DbAdapterFactory.php';
include_once '../src/Model/Hydrator/PersonneHydrator.php';
include_once '../src/Model/Entity/Personne.php';
include_once '../src/Model/Repository/PersonneRepository.php';


include_once '../src/Model/Hydrator/MessageHydrator.php';
include_once '../src/Model/Entity/Message.php';
include_once '../src/Model/Repository/MessageRepository.php';


include_once '../src/Model/Entity/Abonnement.php';
include_once '../src/Model/Repository/AbonnementRepository.php';

include_once '../src/Model/Entity/Liker.php';
include_once '../src/Model/Repository/LikerRepository.php';
