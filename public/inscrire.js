var email=document.getElementById("email");
var pass1=document.getElementById("pwd1");
var pass2=document.getElementById("pwd2");
var age=document.getElementById("age");
var pseudo=document.getElementById("pseudo");
var nom=document.getElementById("nom");
var prenom=document.getElementById("prenom");



age.addEventListener("blur", function () {
    if (isNaN(age.value)){
        document.getElementById("wrongAge").textContent="Age invalide";
    }
    else{
        document.getElementById("wrongAge").textContent="";
    }
        
});

pseudo.addEventListener("blur", function () {
    if (pseudo.value==""){
        document.getElementById("wrongPseudo").textContent="Pseudo non rempli";
    }
    else{
        document.getElementById("wrongPseudo").textContent="";
    }
});


prenom.addEventListener("blur", function () {
    if (prenom.value==""){
        document.getElementById("wrongPrenom").textContent="Prénom non rempli";
    }
    else{
        document.getElementById("wrongPrenom").textContent="";
    }
});

nom.addEventListener("blur", function () {
    if (nom.value==""){
        document.getElementById("wrongNom").textContent="Nom non rempli";
    }
    else{
        document.getElementById("wrongNom").textContent="";
    }
});

email.addEventListener("blur", function () {
    if (email.value.indexOf("@") == -1){
        document.getElementById("wrongEmail").textContent="Adresse invalide";
    }
    else{
        document.getElementById("wrongEmail").textContent="";
    }
});

pass1.addEventListener("input", function () {
    if(pass1.value.length < 6){
    	if(!(pass1.value.match(/\d/))){
        	document.getElementById("wrongPwd1").textContent="mot de passe invalide";
            document.getElementById("wrongPwd1").style.color="red";
        }
        else{
        	document.getElementById("wrongPwd1").textContent="longueur insuffisante";
            document.getElementById("wrongPwd1").style.color="red";
        }
    }
    else{
    if(!(pass1.value.match(/\d/))){
            document.getElementById("wrongPwd1").textContent="mot de passe invalide";
            document.getElementById("wrongPwd1").style.color="red";
        }
        else{
            document.getElementById("wrongPwd1").textContent="Bon mot de passe";
        	document.getElementById("wrongPwd1").style.color="green";
        }
    }
});

pass2.addEventListener("input", function(){
    if(pass1.value != pass2.value){
        document.getElementById("wrongPwd2").textContent="les deux mots de passe ne correspondent pas";
    }
    else{
        document.getElementById("wrongPwd2").textContent="";
    }
        
});

function validation(form){
    if(form.pwd1.value.length > 5){
        if(form.pwd1.value.match(/\d/)){
            if(form.email.value.indexOf("@") != -1){
                if (strcmp(form.pwd1.value,form.pwd2.value)!=0){
                    if (!(isNaN(form.age.value))){
                        return true;
                    }
                }
            }
        }
    }
    else {
        alert("un des champ est invalide");
        return false;
    }
}


