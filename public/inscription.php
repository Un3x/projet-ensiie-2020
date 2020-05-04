

    <html>
    <head>
    <link rel="stylesheet" href="style.css"/>
    <title>Inscription</title>
    <script>
    function validateForm() {
      var id = document.forms["myForm"]["id"].value;
      var username = document.forms["myForm"]["username"].value;
      var email = document.forms["myForm"]["email"].value;
      var pass = document.forms["myForm"]["pass"].value;

      if (id == "") {
        alert("Identifiant manquant");
        return false; // envoie un message faux pour empecher la soumission du formulaire
      }
      if(username == ""){
        alert("Nom manquant");
        return false;
      }
      if(email == ""){
        alert("Email manquant");
        return false;
      }
      if(pass== ""){
        alert("Mot de passe manquant");
        return false;
      }
} 
</script>
   </head>

    <body>
    <fieldset>
    <legend id="leg1" align="center" > Inscription à l'espace membre </legend> <br />
    <form name="myForm" action='newUser.php' method="post" onsubmit="return validateForm()" >

    Identifiant  <em id="em1">*</em> :
      <input type="text" name="id" value="" id ="id" >  <br />
    Nom <em id="em1">*</em> :
      <input type="text" name="username" value="" id ="username" >  <br />
    Email <em id="em1" >*</em> :
      <input type="text" name="email" value=""  id ="email">  <br />
    Mot de passe <em id="em1">*</em> : 
      <input type="password" name="pass" value="" id ="pass"> <br />
      </fieldset>
    <input type="submit" name="inscription" value="Inscription" id ='bouton_envoi' align="center">
    </form>

        <!-- Validation du questionnaire en javascript -->
    <!-- Si un champ est vide, le formulaire ne doit pas etre envoye
          + un message d'erreur doit etre affiche la ou la valeur est manquante -->

    </body> 
    </html>

