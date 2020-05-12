function showHint(str) {
  var xhttp;
  if (str.length == 0) { 
    document.getElementById("nameHint").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  //var availableTags = this.responseText.array;
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {// 4 = request finished and response is ready, 200 = "OK"
      $( "#book" ).autocomplete({
        source : this.responseText.split(',')
      });
    }
  };
  xhttp.open("GET","borrowBook.php?search="+str, true);
  xhttp.send();   
}

