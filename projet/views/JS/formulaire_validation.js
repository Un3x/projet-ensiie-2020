document.getElementById("inscription").addEventListener("submit", function(e) {

  var data = new FormData(this);
  var xhr = new XMLHttpRequest();

  xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      var res = this.response;
      if (res.success) {
        alert("Votre compte a bien été créé !");
      } else {
        alert(res.$err);
      }
    } else if (this.readyState == 4) {
      alert("Une erreur est survenue...");
    }
  };

  xhr.open("POST", "/projet/views/inscription.php", true);
  xhr.responseType = "json";
  // xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(data);

  return true;
});