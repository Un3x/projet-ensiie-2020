<div class="card-columns">
    <?php foreach ($data as $game) { ?>
        <a href="/game?id=<?php echo $game->getAbrev() ?>">
            <div class="card bg-dark text-white game">
                <img src="/img/game/<?php echo $game->getAbrev() ?>.png" class="card-img" alt="<?php echo $game->getFullname() ?>">
                <div class="card-img-overlay">
                    <h5 class="card-title text-overflow"><?php echo $game->getFullname() ?> </h5>
                    <h5><span class="badge badge-secondary"><i class="fas fa-users"></i> <?php echo $game->getPlayers() ?></span>
                        <span class="badge badge-<?php
                                                    if ($game->getNote() > 0.66) echo "success";
                                                    else if ($game->getNote() > 0.33) echo "warning";
                                                    else echo "danger" ?>">
                            <?php
                            if ($game->getNote()) {
                                echo "<i class='fas fa-thumbs-up'></i> " . ((float) $game->getNote()) * 100;
                                echo "%";
                            } else echo "Not rated yet!"
                            ?>
                        </span>
                        <br />
                        <?php foreach ($game->getGenres() as $genre) { ?>
                            <span class="badge badge-secondary"><?php echo $genre ?></span>
                        <?php } ?>
                    </h5>
                </div>
            </div>
        </a>
    <?php } ?>
</div>

<style>
    .card-title {
        background: #000a;
        padding: 10px;
        text-shadow: 0 0 5px #fff;
        border-radius: 20px 0;
        display: inline-block;
    }

    .card-img-overlay,
    .card-title {
        transition: .3s
    }

    .game:hover .card-img-overlay {
        box-shadow: inset -4px 4px 20px #00e7a980, inset 4px -4px 20px #6020a080;
    }

    .game:hover .card-title {
        box-shadow: -1px 1px 2px 0.2rem #6020a080, 1px -1px 2px 0.2rem #00e7a980;
    }
</style>