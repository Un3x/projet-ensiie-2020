var email=document.getElementById("email");
var pass1=document.getElementById("pwd1");
var pass2=document.getElementById("pwd2");

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

function validationmdp(form){
    if(form.pwd1.value.length > 5){
        if(form.pwd1.value.match(/\d/)){
            return true;
        }
    }
    else {
        alert("Les mots de passe sont invalides");
        return false;
    }
}


function aff_form(id) {
        document.getElementById(id).style.display = 'block';
}
 
function hide_form(evt,id) {
        document.getElementById(id).style.display = 'none';
        evt.stopPropagation();
}

function confirmation4(){
    if (confirm('Cette action va supprimer définitevement votre compte, Voulez-vous continuer?')) { 
        return true;
    } 
    else { 
        return false; 
    }
}

function confirmation3(){
    if (confirm('Cette action va supprimer définitevement cette annonce, Voulez-vous continuer?')) { 
        return true;
    } 
    else { 
        return false; 
    }
}

function confirmation2(){
    if (confirm('Cette action va supprimer définitevement cette utilisateur et ses annonces , Voulez-vous continuer?')) { 
        return true;
    } 
    else { 
        return false; 
    }
}

function confirmation1(){
    if (confirm('Cette action va supprimer définitevement votre annonce , Voulez-vous continuer?')) { 
        return true;
    } 
    else { 
        return false; 
    }
}


