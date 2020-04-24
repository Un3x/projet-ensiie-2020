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
