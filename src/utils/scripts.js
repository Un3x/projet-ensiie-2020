<script>
function checkRegisterForm(){
  if (! document.register.username.value){
    alert("Veuillez spécifier un nom d'utilisateur.")
    return false
  }
  if (! (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.register.email.value))){
    alert ("Veuillez entrer une adresse email valide.")
    return false
  }
  if (! document.register.passwd.value){
    alert("Veuillez spécifier un mot de passe.")
    return false
  }
  if (! document.register.passwd.value == document.register.confpasswd.value){
    alert("Les mots de passe ne concordent pas.")
    return false
  }
  return true
}

function checkLoginForm()
{
  if (! document.login.username.value){
    alert("Veuillez spécifier un nom d'utilisateur.")
    return false
  }
  if (! document.login.passwd.value){
    alert("Veuillez spécifier un mot de passe.")
    return false
  }
  return true
}

function areYouSure()
{
  if(confirm("Êtes-vous sûr ? Cette action est irréversible.")){
    return true
  }
  return false
}

</script>