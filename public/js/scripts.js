/* Brief: vérifie si un email est valide
   paramétre: un e-mail (en chaine de caractére)
   return: un message d'alerte si l'email n'est pas valide*/
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
     if (!re.test(String(email).toLowerCase())){
         alert("l'email que vous proposez n'est pas valide ")
     }
}

/* Bief: vérifie si il s'agit d'un mot de passe
   paramétre: une chaine de caractére
   return: un message pour valider la robustesse du mot de passe*/
   function validatePassWord(str) { 
        if (str.match( /[0-9]/g) && 
            str.match( /[A-Z]/g) && 
            str.match(/[a-z]/g) && 
            str.match( /[^a-zA-Z\d]/g) &&
            str.length >= 12) 
            msg = "<p style='color:green'>Votre mot de passe est robuste</p>"; 
        else 
            msg = "<p style='color:red'> Votre mot de passe n'est pas suffisament robuste.\n Nous vous conseillons de le modifier. </p>";
} 