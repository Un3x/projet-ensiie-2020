<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/time2str.php'; ?>

<div class="card text-white bg-dark mb-3">
    <div class="card-header">
        <div class="media">
            <img src="/img/user/<?php echo $data["user"]->getId() ?>.png" class="align-self-start mr-3" alt="<?php echo $data["user"]->getUsername() ?>" />
            <div class="media-body">
                <h5 class="mt-0"><?php echo $data["user"]->getUsername() ?></h5>
                <p><?php echo date("d/m/Y", $data["user"]->getCreation()) ?></p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        
    </div>
    <div class="col-md-8 messages">
        <?php
        require_once 'components/timeline.php';
        timeline("/api/append-message?visibility=user&user=" . $data["user"]->getId() . "&p=", $data["messages"]);
        ?>
    </div>
</div>
<style>

</style>