const paragrapheErreurEmail = document.getElementById("erreurEmail");
const paragrapheErreurMdp = document.getElementById("erreurMdp");
const paragrapheErreurPasComplet = document.getElementById("erreurPasComplet");
var nom = document.getElementById("nom");
var prenom = document.getElementById("prenom");
var pseudo = document.getElementById("pseudo");
var email = document.getElementById("email");
var mdp1 = document.getElementById("mdp1");
var mdp2 = document.getElementById("mdp2");

document.getElementById("inscription").addEventListener("submit", function(error)
{
    if(nom.value=="" || prenom.value=="" || pseudo.value=="" || email.value=="" || mdp1.value=="" || mdp2.value==""){
        error.preventDefault()
        paragrapheErreurPasComplet.textContent="Veuillez remplir toutes les informations."
        paragrapheErreurPasComplet.style.color="red"
    }
});

document.getElementById("mdp2").addEventListener("input", function(e){
    if(e.target.value!=mdp1.value){
        paragrapheErreurMdp.textContent="Vous n'avez pas rentré deux fois le même mot de passe"
        paragrapheErreurMdp.style.color="red"
    }
    else{
        paragrapheErreurMdp.textContent="✔"
        paragrapheErreurMdp.style.color="Green"
    }
});