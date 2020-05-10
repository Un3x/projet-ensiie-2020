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
        a = kara[i].getElementsByTagName('span');
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

async function addKara(i)
{
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://localhost:8080/Forms/addKara.php', true); // <--- FIXME : URL

    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {//Call a function when the state changes.
        if(xhr.readyState == XMLHttpRequest.DONE && ( xhr.status === 200 || xhr.status === 0 ))
        {
            document.getElementById("lastAdd").innerHTML = "Added the kara " + i + " !";
        }
    }
    xhr.send('id=' + i);

    if (typeof loadQueue == 'function')
    {
        await new Promise(r => setTimeout(r, 300));
        loadQueue();
    }
}
