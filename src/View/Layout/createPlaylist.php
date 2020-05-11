<h1>Create your playlist:</h1>

<?php
if ( isset($_GET['errs']) && $_GET['errs'] === "wrongName" )
    echo '<p class="error">There was an error with your playlist name. The playlist wasn\'t created</p><br>';
?>

<form name= "formAddPlaylist" action="/Forms/addPlaylist.php" onsubmit="return validCreatePlaylist();" method="POST">
    <ul>
        <li><label for="name">Playlist name : </label>
        <input type="text" name="name" placeholder="name" maxlength="32"
        <?php
            if ( isset($_GET['name']) )
                echo ' value=' . $_GET['name'];
        ?>
        ></li>
        <li class ="label">Public :
        <input type="radio" name="publik" value="TRUE"
        <?php
            if ( isset($_GET['publik']) )
            {
                if ( $_GET['publik'] === "TRUE" )
                    echo ' checked';
            }
        ?>
        >Yes</input>
        <input type="radio" name="publik" value="FALSE"
        <?php
            if ( isset($_GET['publik']) )
            {
                if ( $_GET['publik'] === "FALSE" )
                    echo ' checked';
            }
            else
                echo ' checked';
        ?>
        >No</input></li>
        <li><button class = "lebutton" type="submit">Create playlist</button></li>
    </ul>
</form>

<script type="text/javascript" src="scripts/formulairePlaylist.js"></script>
