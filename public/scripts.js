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
    var input, filter, karas, kara, a, i, txtValue, j, hide;

    input = document.getElementById('karaSearch');
    filter = input.value.toUpperCase();
    filter = filter.split(' ');

    karas = document.getElementById("karaList");
    kara = karas.getElementsByTagName('form');

    for ( i = 0; i < kara.length; i++ )
    {
        hide = false;
        a = kara[i].getElementsByTagName('button');
        txtValue = a[0].textContent;
        search_loop:
        for (j=0; j<filter.length; j++)
        {
            if ( txtValue.toUpperCase().search(filter[j]) <= -1 )
            {
                hide = true;
                break search_loop;
            }

        }
        if ( hide )
            kara[i].style.display = "none";
        else
            kara[i].style.display = "";
    }
}

function toggleKaraInfo(i)
{
    var div;

    div = document.getElementById("KaraInfo_" + i);
    if ( div.style.display === "none" )
        div.style.display = "block";
    else
        div.style.display = "none";
}

function loadQueue()
{
    var xhr = new XMLHttpRequest()

    xhr.open('GET', 'http://localhost:8080/getQueue.php?getQueue=42', true)

    xhr.addEventListener('readystatechange', function ()
{
    if (xhr.readyState === XMLHttpRequest.DONE && ( xhr.status === 200 || xhr.status === 0 )) { // <-- FIXME Delete the xhr.status === 0 if the site isn't on localhost
        document.getElementById('karaQueue').innerHTML = '<span>' + xhr.responseText + '</span>';
    }
});

    xhr.send(null);
}
