<?php
error_reporting(E_ALL);
ob_implicit_flush();

require_once 'sockets_utils.php';
require_once '../src/Lector.php';
require_once '../src/LectorRepository.php';
include_once '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$lectorRepository = new \Lector\LectorRepository($dbAdaper);
$lectors = $lectorRepository->fetchAll();
$socks = [];

foreach($lectors as $lector){
    $address="";
    $port=0;
    $domain="";

    $address = $lector->getIP();
    $port = $lector->getPort();
    $domain = correctIPDomain($address);
    $sock = socket_create_and_connect($address, $port, $domain);

    echo "Creating socket to connect to lektord on IP " . $address . " at port " . $port . "\n";
    $socks[] = $sock;
}
?>
