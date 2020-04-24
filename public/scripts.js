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
    return true;
}


function dynamicSearch()
{
    var input, filter, karas, kara, a, i, txtValue;

    input = document.getElementById('karaSearch');
    filter = input.value.toUpperCase();

    karas = document.getElementById("karaList");
    kara = karas.getElementsByTagName('form');

    for ( i = 0; i < kara.length; i++ )
    {
        a = kara[i].getElementsByTagName('button');
        txtValue = a[0].textContent;
        if ( txtValue.toUpperCase().indexOf(filter) > -1 )
            kara[i].style.display = "";
        else
            kara[i].style.display = "none";
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
