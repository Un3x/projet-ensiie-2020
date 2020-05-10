<?php
include_once '../src/utils/autoloader.php';

$data = [];
$db = (new DbAdaperFactory())->createService();
$urep = new \User\UserRepository($db);
$data['users'] = $urep->fetchall();

loadView('admin_page', $data);
?>
