<form method="GET" action="Forms/searchKara.php">
    <ul>
        <li><input type="text" name="song_name">Song name</input></li>
        <li><input type="text" name="source_name">Source name</input></li>
        <li><input type="text" name="author_name"></input>Author Name</li>
        <li>
            <select name="language">Language
                <option value = "jp">Japanese</option>
                <option value = "fr">French</option>
                <option value = "it">Italian</option>
                <option value = "ru">Russian</option>
            </select>
        </li>
    </ul>
    <button type="submit">Search !</button>
</form>

<div id="resultList">
</div> 
