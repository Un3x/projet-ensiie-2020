function surligne(champ, erreur)
{
   if(erreur)
      champ.style.backgroundColor = "#fba";
   else
      champ.style.backgroundColor = "";
}

function verifname(champ)
{
   if(champ.value.length < 2 || champ.value.length > 25)
   {
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}

function verifForname(champ)
{
   if(champ.value.length < 2 || champ.value.length > 25)
   {
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}
function verifMail(champ)
{
   var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
   if(!regex.test(champ.value))
   {
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}

function verifmdp(champ)
{
    if (champ.value.length < 8 &&document.formulaire.password_sign != document.formulaire.password2_sign ){
        surligne(champ, true);
        return false;
    }
       else
   {
      surligne(champ, false);
      return true;
   }
}

function verifMdp(champ){
    
    if(champ.value.length < 8)
   {
      surligne(champ, true);
      return false;
      
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}
    
}


function verifForm(f)
{
   var nameOk = verifname(f.name);
   var fornameOk = verifForname(f.forname);
   var mailOk = verifMail(f.email_sign);
   var mdpOk = verifmdp(f.password_sign);
   
   if(nameOk && fornameOk && mdpOk && mailOk)
      return true;
   else
   {
      alert("Veuillez remplir correctement tous les champs");
      return false;
   }
}



