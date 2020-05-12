<?php function timeline($route, $data)
{
    require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/time2str.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/Parsedown.php';
    $Parsedown = new Parsedown();
    $Parsedown->setSafeMode(true);

    foreach ($data as $message) { ?>
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
                    echo '<form action="delete-message?id='.$message->getId().'" class="ml-auto" method="post"><button class="btn btn-outline-danger" type="submit"><i class="fas fa-trash"></i></button></form>';
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
    <style>
        .post-userlink:hover .avatar {
            box-shadow: -4px 4px 15px #6020a080, 4px -4px 15px #00e7a980;
            transition: .3s;
        }

        .post-userlink {
            color: white
        }

        .post-userlink:hover {
            text-decoration: none;
            color: unset;
        }

        .card-header .fas {
            float: right
        }

        .post-userlink {
            font-weight: 600;
        }

        .message .card-header {
            padding: 0 5px 0 0;
        }

        .message .card-footer {
            padding: .5rem 1.25rem;
        }

        .message .card-body * {
            margin-bottom: 0;
        }

        .message blockquote {
            border-left: 5px solid #6020a0;
            background: #fff2;
            padding-left: 15px;
        }

        .card-footer .badge {
            cursor: pointer;
        }

        .card-footer .add-react {
            opacity: 0;
            transition: .3s;
        }

        .card-footer:hover .add-react {
            opacity: 1;
        }

        .reaction img {
            vertical-align: text-bottom;
        }

        .reaction.active {
            background: #6020a0;
        }
    </style>
    <script>
        let page = 1;
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
                fetch(`<?php echo $route ?>${page}`).then(function(response) {
                    return response.text();
                }).then(function(html) {
                    if (html != "") {
                        $(".messages").append(html);
                        twemoji.parse(document.body);
                        const btnReact = document.querySelectorAll('.btn-emoji-react');
                        const pickerReact = new EmojiButton({
                            style: "twemoji",
                            position: "auto-start",
                            theme: "dark"
                        });
                        pickerReact.on('emoji', emoji => {
                            console.log($(emoji).attr("alt"));
                        });
                        for (btn of btnReact) btn.addEventListener('click', () => {
                            pickerReact.togglePicker(document.querySelector(".navbar"))
                        });
                        page++;
                    } else {
                        $(".messages").append('<button class="btn btn-outline-light ml-2" type="button" disabled style="width: 100%">End of results</button>');
                        $(window).unbind('scroll');
                    }
                }).catch(function(err) {
                    console.warn('Something went wrong.', err);
                });
            }
        });
    </script>
<?php }
