<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/autoloader.php';

$dbfactory = new Model\Factory\dbFactory();
$dbAdapter = $dbfactory->createService();

$searchRepository = new Model\Repository\SearchRepository($dbAdapter);

http_response_code(200);
echo json_encode($searchRepository->search($_GET["q"]));