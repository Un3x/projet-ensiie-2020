<div class="card bg-dark text-white game mb-3">
    <img src="/img/game/<?php echo $data["game"]->getAbrev() ?>_header.png" class="card-img" alt="<?php echo $data["game"]->getFullname() ?>">
    <div class="card-img-overlay">
        <h5 class="card-title text-overflow"><?php echo $data["game"]->getFullname() ?>
            <span class="badge badge-secondary"><i class="fas fa-users"></i> <?php echo $data["game"]->getPlayers() ?></span>
            <span class="badge badge-<?php
                                        if ($data["game"]->getNote() > 0.66) echo "success";
                                        else if ($data["game"]->getNote() > 0.33) echo "warning";
                                        else echo "danger" ?>">
                <?php
                if ($data["game"]->getNote()) {
                    echo "<i class='fas fa-thumbs-up'></i> " . ((float) $data["game"]->getNote()) * 100;
                    echo "%";
                } else echo "Not rated yet!"
                ?>
            </span>
            <br />
            <?php foreach ($data["game"]->getGenres() as $genre) { ?>
                <span class="badge badge-secondary"><?php echo $genre ?></span>
            <?php } ?>
        </h5>
        <p class="card-text"><?php echo $data["game"]->getDescription() ?></p>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-dark mb-3">
            <div class="card-header">
                <b>Users playing it</b>
            </div>
            <div class="card-body row row-cols-4 row-cols-md-3 row-cols-lg-4">
                <?php foreach ($data["users"] as $user) { ?>
                    <a class="last-el" href="/user?id=<?php echo $user->getId() ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $user->getGamespseudo()[$data["game"]->getAbrev()] ?>"><img class="avatar" src="/img/user/<?php echo $user->getId() ?>.png"><br>
                        <div class="badge badge-secondary el-name text-overflow"><?php echo $user->getUsername() ?></div>
                    </a>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-md-8 messages">
        <?php
        require_once 'components/textarea.php';
        textarea("game?id=" . $data["game"]->getAbrev());
        require_once 'components/timeline.php';
        timeline("/api/append-message?visibility=game&game=" . $data["game"]->getAbrev() . "&p=", $data["messages"]);
        ?>
    </div>
</div>
<style>
    .card-title {
        background: #000a;
        padding: 10px;
        text-shadow: 0 0 5px #fff;
        border-radius: 20px 0;
        display: inline-block;
    }

    .card-title .badge {
        text-shadow: none;
    }

    .game {
        height: 200px;
        overflow: hidden
    }

    .game img {
        position: relative;
        top: 50%;
        transform: translateY(-50%);
    }


    .last-el {
        text-align: center;
    }

    .last-el:hover .avatar {
        box-shadow: -4px 4px 15px #6020a080, 4px -4px 15px #00e7a980;
        transition: .3s;
    }

    .el-name {
        text-shadow: 0 0 5px #000;
    }
</style>
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>