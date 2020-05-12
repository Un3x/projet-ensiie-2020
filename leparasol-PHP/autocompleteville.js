  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    var availableTags = [
      "Sacey",
      "Saint-Malo",
      "Mont-Saint-Michel",
      "Nice",
      "Dijon",
      "Cannes",
      "Marseille",
      "Bordeaux",
      "Paris",
      "Toulouse",
      "Dunkerque"
    ];
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  } );
  
  