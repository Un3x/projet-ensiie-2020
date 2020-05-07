<!DOCTYPE html>
<html lang="fr">

<?php
    include 'page_fct.php';
    $db = connect();                  //Connexion à la base de données

    $pageid = 1;                      //Numéro de page
    $story = getStory(1, $db);        //Récupération de l'histoire
    $page = getPage($pageid, $db);    //Récupération de la page
?>

<head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" type="text/css" href="cite_des_voleurs.css">
    <title><?php echo $story['title'].' - Tales of Webseria'; ?></title>
</head>

<body>
    <link rel="stylesheet" type="text/css" href="cite_des_voleurs.css">
    <?php echo '<h2>'.$story['title'].'</h2>'; ?>

    <div class="container">
        <img src="cite_des_voleurs.jpg" alt="<?php echo $story['title']; ?>"
        style="width:100%">

        <?php
            include 'disp_page.php';
            ob_start();
            dispPage($page['txt'], $page['choiceint1'],  $page['choiceint2'],
                     $page['choiceint3'],  $page['choicetext1'], $page['choicetext2'],
                     $page['choicetext3']);

            /*Le joueur a cliqué sur le 1er choix.*/
            if (isset($_POST['choice1'])) {
                ob_end_clean();
                $pageid = $_POST['choice1'];
                $page = getPage($pageid, $db);
                dispPage($page['txt'], $page['choiceint1'],  $page['choiceint2'],
                         $page['choiceint3'],  $page['choicetext1'],
                         $page['choicetext2'], $page['choicetext3']);
            }

            /*Le joueur a cliqué sur le 2ème choix.*/
            if (isset($_POST['choice2'])) {
                ob_end_clean();
                $pageid = $_POST['choice2'];
                $page = getPage($pageid, $db);
                dispPage($page['txt'], $page['choiceint1'],  $page['choiceint2'],
                         $page['choiceint3'],  $page['choicetext1'],
                         $page['choicetext2'], $page['choicetext3']);
            }

            /*Le joueur a cliqué sur le 3ème choix.*/
            if (isset($_POST['choice3'])) {
                $pageid = $_POST['choice3'];
                $page = getPage($pageid, $db);
                dispPage($page['txt'], $page['choiceint1'],  $page['choiceint2'],
                         $page['choiceint3'],  $page['choicetext1'],
                         $page['choicetext2'], $page['choicetext3']);
            }
        ?>
        </form>
    </div>
</body>
</html>