<?php
session_start();

set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

include_once 'Lectors/Lector.php';
include_once 'Lectors/LectorRepository.php';
include_once 'Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$lectorRepository = new \Lector\LectorRepository($dbAdaper);
$lectors = $lectorRepository->fetchAll();
?>

<div class="col-sm-12">
    <h1>Lector List</h1>
</div>
<div class="col-sm-12">
    <table class="table">
        <tr id="tab-legend">
            <th>ID</th>
            <th>IP</th>
            <th>Port</th>
            <th>Action</th>
        </tr>
        <?php foreach($lectors as $lector): ?>
            <tr>
                <td><?= $lector->getId() ?></td>
                <td><?= $lector->getIP() ?></td>
                <td><?= $lector->getPort() ?></td>
                <td>
                    <form method="POST" action="Forms/deleteLector.php">
                        <input name="lector_id" type="hidden" value="<?= $lector->getId() ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
