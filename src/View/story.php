<!-- Display the pages of a story -->



<!-- Keep the reader's scroll position -->
<head>
    <script type="text/javascript">
        function readCookie(name) {
            return (document.cookie.match('(^|; )' + name + '=([^;]*)') || 0)[2]
        }
    </script>
</head>

<!-- The reader does not have to scroll down every time the page refreshes. -->
<body onScroll="document.cookie='ypos='+window.pageYOffset" onLoad="window.scrollTo(0,readCookie('ypos'))">


<!-- Title of the story -->
<element id="story-title"><center><?php echo $data['title']; ?></center></element>


<!-- Page of the story -->
<div class="container story-container">
    <img src="<?php echo $data['storyId']; ?>.jpg" alt="<?php echo $data['title']; ?>"
    style="width:100%">

    <!-- Text of the page -->
    <div class="content">
        <strong style="font-size:28px"><?php echo $data['page']->getText(); ?></strong>
    </div>

    <!-- Choices for the reader to make -->
    <?php

        /*Choice 1*/
        if ($data['page']->getChoice1() != NULL)
            echo
            '<form method="get" action="story.php">
                <input type="hidden" name="storyId" value="'.$data['storyId'].'"/>
                <input type="hidden" name="pageId" value="
                '.$data['page']->getChoice1().'"/>
                <button type="submit" class="btn btn-primary top-btn">
                    '.$data['page']->getText1().'
                </button>
            </form>';

        /*Choice 2*/
        if ($data['page']->getChoice2() != NULL)
            echo
            '<form method="get" action="story.php">
                <input type="hidden" name="storyId" value="'.$data['storyId'].'"/>
                <input type="hidden" name="pageId" value="
                '.$data['page']->getChoice2().'"/>
                <button type="submit" class="btn btn-primary mid-btn">
                    '.$data['page']->getText2().'
                </button>
            </form>';

        /*Choice 3*/
        if ($data['page']->getChoice3() != NULL)
            echo
            '<form method="get" action="story.php">
                <input type="hidden" name="storyId" value="'.$data['storyId'].'"/>
                <input type="hidden" name="pageId" value="
                '.$data['page']->getChoice3().'"/>
                <button type="submit" class="btn btn-primary">
                    '.$data['page']->getText3().'
                </button>
            </form>';

        /*End of the story*/
        if ($data['page']->getLast())
            echo
            '<div class="text-block">
                <h4>Félicitations, vous avez terminé &thinsp;<strong>'.$data['title'].'
                </strong> !</h4>
                <p>Vous pouvez maintenant aller découvrir d\'autres histoires parmi
                nos propositions, ou bien rejouer celle-ci ! Après tout, il vous reste
                encore de nombreux choix à faire. Et qui dit que vous n\'obtiendrez
                pas une fin différente ?</p>
            </div>
            
            <form method="get" action="story_page.php">
                <input type="hidden" name="storyId" value="'.$data['storyId'].'"/>
                <button type="submit" class="btn btn-primary bot-btn">
                    Retourner au sommaire de <strong>'.$data['title'].'</strong>.
                </button>
            </form>';
    ?>

</div>
</body>