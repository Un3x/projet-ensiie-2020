<h1><?php echo $data['title']; ?></h1>

<div class="container">
    <p><?php echo $data['page']->getText(); ?></p>

    <form method="get" action="story.php">
        <input type="hidden" name="storyId" value="<?php echo $data['storyId']; ?>"/>
        <input type="hidden" name="pageId" value="<?php echo $data['page']->getChoice1(); ?>"/>
        <button type="submit" class="btn btn-primary">
            <?php echo $data['page']->getText1(); ?>
        </button>
    </form>
    <form method="get" action="story.php">
        <input type="hidden" name="storyId" value="<?php echo $data['storyId']; ?>"/>
        <input type="hidden" name="pageId" value="<?php echo $data['page']->getChoice2(); ?>"/>
        <button type="submit" class="btn btn-primary">
            <?php echo $data['page']->getText2(); ?>
        </button>
    </form>
    <form method="get" action="story.php">
        <input type="hidden" name="storyId" value="<?php echo $data['storyId']; ?>"/>
        <input type="hidden" name="pageId" value="<?php echo $data['page']->getChoice3(); ?>"/>
        <button type="submit" class="btn btn-primary">
            <?php echo $data['page']->getText3(); ?>
        </button>
    </form>
</div>