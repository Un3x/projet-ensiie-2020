<h1>Create your playlist:</h1>
<form name= "formAddPlaylist" action="Forms/addPlaylist.php" onsubmit="return validCreatePlaylist();" method="POST">
    <ul>
        <li><label for="name">Playlist name: </label>
        <input type="text" name="name" placeholder="name" maxlength="32"></li>
        <li>Public:
        <input type="radio" name="publik" value="TRUE">Yes</input>
        <input type="radio" name="publik" value="FALSE" checked>No</input></li>
        <li><button type="submit">Create playlist</button></li>
    </ul>
</form>

<script type="text/javascript" src="scripts/formulaire.js"></script>
