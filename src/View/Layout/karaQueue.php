<button type="button" class="lebutton" onclick="loadQueue()">Refresh Queue</button>
<button id="toggleButton" type="button" class="lebutton2" onclick="toggleAutoRefreshQueue(2000)">Toggle Auto Refresh Queue (current : off)</button>
<div id=lastAdd></div>

<?php
if ( isset($_GET['errs']) && $_GET['errs'] == "tooManyRequest" )
    echo '<span id="tooManyRequests"><p>Yamete kudasai ! Please calm down a little bit</p></br></span>'
?>

<div id="karaQueue">
</div>
<script src="/scripts/karaQueue.js"></script>
