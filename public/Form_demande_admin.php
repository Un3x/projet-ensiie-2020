
    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="style.css"/>
        <h1> Demande afin de devenir administrateur </h1>
    </head>

    <body>
    <fieldset>
    <legend id="leg1" align="center" > Formulaire </legend> <br />
    <form name="myForm" action="/NewDemande.php" method="post" onsubmit="return validateForm()" >

<!--     Nom <em id="em1">*</em> :
      <input type="text" name="username" value="" id ="username" >  <br />
 -->
    Je souhaite devenir administrateur de :      
      <select name="Nom_assoc" id ="Nom_assoc" size="1">
        <option>BDE </option>
        <option>BDS </option>
        <option>BDA </option>
        <option>I-TV </option>
        <option>Bakaclub </option>
      </select>  </br>

      </fieldset>
    <input type="submit" name="demande_admin" value="Envoyer la demande" id ='bouton_demande_admin' align="center">
    </form>

    </body> 
    </html>