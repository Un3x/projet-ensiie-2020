function validationFormulaire(){
    frm=document.forms['formAddUser'];
    if(frm.elements['username'].value==""){
    alert("Veuillez rentrer un nom d'utilisateur");
    return false;
    }
    if(frm.elements['email'].value==""){
        alert("adresse mail invalide");
        return false;
    }
    if(!(/\S+@\S+/.test(frm.elements['email'].value))){
        alert("adresse mail invalide");
            return false;
    }
    if(frm.elements['password'].value.length < 8){
        alert("le mot de passe doit avoir au moins 8 caractères!");
        return false;
    }
    if(frm.elements['password'].value.localeCompare(frm.elements['checkPassword'].value)!=0){
        alert("erreur d'authentification, les mots de passes ne sont pas les mêmes");
        return false;
    }
    return true;
}

//function used for the login form
function validationFormulaireLogin(){
    frm=document.forms['formLoginUser'];
    if(frm.elements['username'].value==""){
        alert("Veuillez rentrer un nom d'utilisateur");
        return false;
    }
    if(frm.elements['password'].value==""){
        alert("enter passWord");
        return false;
    }
    if(frm.elements['password'].value.length < 8){
        alert("le mot de passe doit avoir au moins 8 caractères!");
        return false;
    }
    return true;
}

function validationFormulaireChangeUser(){
    frm=document.forms['formChangeUser'];
    if(!(/\S+@\S+/.test(frm.elements['newEmail'].value))){
        alert("nouvelle adresse mail invalide");
            return false;
    }
    if(frm.elements['newPassword'].value.localeCompare(frm.elements['newPasswordCheck'].value)!=0){
        alert("erreur d'authentification, les nouveaux mots de passes ne sont pas les mêmes");
        return false;
    }
    return true;
}
