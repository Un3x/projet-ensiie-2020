<?php
include_once '../src/utils/autoloader.php';

use Save\SaveRepository;

$db = (new DbAdaperFactory())->createService();
$saveRepo = new SaveRepository($db);
$data =[];

if (isset($_SESSION['id'])) {
    $saves = $saveRepo->fetchAll($_SESSION['id']);
    $data['saves'] = $saves;

    loadView('saved_stories',$data);
}


?>