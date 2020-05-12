<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);

include_once '../src/Model/repository/UserRepository.php';
include_once '../src/Model/repository/MessageRepository.php';
include_once '../src/Model/repository/GameRepository.php';
include_once '../src/Model/repository/SearchRepository.php';
include_once '../src/Model/Factory/DbAdaperFactory.php';
include_once '../src/Model/entity/User.php';
include_once '../src/Model/entity/Message.php';
include_once '../src/Model/entity/Game.php';
include_once '../src/Model/entity/Search.php';

