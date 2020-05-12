<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: text/html; charset=UTF-8");

require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/autoloader.php';

$dbfactory = new Model\Factory\dbFactory();
$dbAdapter = $dbfactory->createService();
$messageHydrator = new Model\Hydrator\MessageHydrator();

$messageRepository = new Model\Repository\MessageRepository($dbAdapter, $messageHydrator);

if ($_GET["visibility"] == "public") $data["messages"] = $messageRepository->lastPublicMessages($_SESSION["id"], $_GET["p"]);
if ($_GET["visibility"] == "followed") $data["messages"] = $messageRepository->lastFollowedMessages($_SESSION["id"], $_GET["p"]);
if ($_GET["visibility"] == "game") $data["messages"] = $messageRepository->lastGameMessages($_SESSION["id"], $_GET["game"], $_GET["p"]);
if ($_GET["visibility"] == "user") $data["messages"] = $messageRepository->lastUserMessages($_SESSION["id"], $_GET["user"], $_GET["p"]);

http_response_code(200);
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/time2str.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/Parsedown.php';
$Parsedown = new Parsedown();
$Parsedown->setSafeMode(true);
foreach ($data["messages"] as $message) { ?>
    <div class="card text-white bg-dark mb-3 message" <?php if ($message->getVisibility() == "deleted") echo "style='opacity: 0.5'" ?>>
        <div class="card-header d-flex" style="align-items: center">
            <a class="post-userlink" href="/user?id=<?php echo $message->getUser()->getId() ?>">
                <img class="avatar" src="/img/user/<?php echo $message->getUser()->getId() ?>.png" style="margin-right: 10px" />
                <?php echo $message->getUser()->getUsername() ?>
            </a>
            <?php if ($message->getUser()->getRole() == "mod") {
                echo '<span class="badge badge-info ml-2"><i class="fas fa-shield-alt"></i></span>';
            }
            if ($message->getUser()->getRole() == "admin") {
                echo '<span class="badge badge-danger ml-2"><i class="fas fa-chess-queen"></i></span>';
            }

            $ml = false;
            if ($message->getUser()->getId() == $_SESSION["id"] || $_SESSION["role"] == "admin") {
                $ml = true;
                echo '<form action="delete-message?id=' . $message->getId() . '" class="ml-auto" method="post"><button class="btn btn-outline-danger" type="submit"><i class="fas fa-trash"></i></button></form>';
            }

            if ($ml) echo '<button class="btn btn-outline-light ml-2" type="button" disabled>';
            else  echo '<button class="btn btn-outline-light ml-auto" type="button" disabled>';
            switch ($message->getVisibility()) {
                case "public":
                    echo '<i class="fas fa-globe"></i>';
                    break;
                case "unlisted":
                    echo '<i class="fas fa-unlock"></i>';
                    break;
                case "private":
                    echo '<i class="fas fa-lock"></i>';
                    break;
                case "deleted":
                    echo '<i class="fas fa-ban "></i>';
                    break;
            }

            echo '</button>'
            ?>
        </div>
        <div class="card-body">
            <?php echo preg_replace_callback(
                '/#(\w|\p{So})+/u',
                function ($matches) {
                    return '<a href="hashtag?h=' . substr($matches[0], 1) . '">' . $matches[0] . "</a>";
                },
                $Parsedown->text($message->getContent())
            ); ?>
        </div>
        <div class="card-footer d-flex">
            <?php if ($message->getReply() > 0) { ?><span class="badge badge-secondary mr-2"><i class="fas fa-reply"></i> <?php echo $message->getReply() ?></span>
            <?php }
            foreach ($message->getReactions() as $emoji => $value) {
                $active = $value["react"] ? 'active' : '';
                echo '<span class="badge badge-secondary mr-2 reaction ' . $active . '">' . $emoji . ' ' . $value["nb"] . '</span>';
            } ?>
            <span class="badge badge-secondary add-react btn-emoji-react"><i class="fas fa-plus"></i> <i class="far fa-laugh-wink"></i></span>
            <div class="small text-muted ml-auto"><?php echo time2str($message->getCreation()) ?></div>
        </div>
    </div>
<?php } ?>