function validationFormulaire(){
    frm=document.forms['formAddUser'];
    if(frm.elements['username'].value==""){
    alert("Veuillez rentrer un nom d'utilisateur");
    return false;
    }
    //else{
        //check in bd if the name is already here
    //}
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

function dynamicSearch()
{
    var input, filter, ul, li, a, i, txtValue;

    input = document.getElementById('karaSearch');
    filter = input.value.toUpperCase();

    ul = document.getElementById("karaList");
    li = ul.getElementsByTagName('form');

    for ( i = 0; i < li.length; i++ )
    {
        a = li[i];
        txtValue = a.textContent || a.innerText;
        if ( txtValue.toUpperCase().indexOf(filter) > -1 )
            li[i].style.display = "";
        else
            li[i].style.display = "none";
    }
}
