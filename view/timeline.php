<div class="row">
  <div class="col-md-4">
    <?php $call = "home";
    require_once 'components/card_games.php';
    require_once 'components/card_users.php';
    cardGames("Your games", $data["games"]);
    cardUsers("Your following", $data["users"]);
    ?>
  </div>
  <div class="col-md-8 messages">
    <?php
    require_once 'components/textarea.php';
    textarea("timeline");
    require_once 'components/timeline.php';
    timeline("/api/append-message?visibility=followed&p=", $data["messages"]);
    ?>
  </div>
</div>