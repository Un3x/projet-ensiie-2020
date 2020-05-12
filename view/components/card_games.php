<?php function cardGames($title, $data)
{ ?>
    <div class="card text-white bg-dark mb-3">
        <div class="card-header">
            <b><?php echo $title ?></b>
        </div>
        <div class="card-body row row-cols-4 row-cols-md-3 row-cols-lg-4">
            <?php foreach ($data as $game) { ?>
                <a class="last-el" href="/game?id=<?php echo $game->getAbrev() ?>"><img class="avatar" src="/img/game/<?php echo $game->getAbrev() ?>.png"><br>
                    <div class="badge badge-secondary el-name text-overflow"><?php echo $game->getFullname() ?></div>
                </a>
            <?php } ?>
        </div>
    </div>
    <style>
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
<?php }
