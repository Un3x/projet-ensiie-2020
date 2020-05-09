function loadQueue()
{
    var xhr = new XMLHttpRequest();

    xhr.open('GET', 'http://localhost:8080/Forms/getQueue.php?getQueue=42', true); // <--- FIXME : URL

    xhr.addEventListener('readystatechange', function ()
{
    if (xhr.readyState === XMLHttpRequest.DONE && ( xhr.status === 200 || xhr.status === 0 )) { // <-- FIXME Delete the xhr.status === 0 when the site isn't on localhost
        document.getElementById('karaQueue').innerHTML = '<span>' + xhr.responseText + '</span>';
    }
});

    xhr.send(null);
}

function toggleAutoRefreshQueue(i)
{
    if ( timer_isOn === 0 )
    {
        timer_isOn = 1;
        document.getElementById("toggleButton").innerHTML="Toggle Auto Refresh Queue (current : on)";
        loadQueue();
        window.timer = setTimeout(function tick(){
                loadQueue();
                timer = setTimeout(tick,i);},
            i);

    }
    else
    {
        timer_isOn = 0;
        document.getElementById("toggleButton").innerHTML="Toggle Auto Refresh Queue (current : off)";
        clearTimeout(window.timer);
    }
}

var timer_isOn = 0;
loadQueue(); // We load the queue at the start


function deleteKara(i)
{
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://localhost:8080/Forms/deleteKara.php', true); // <--- FIXME : URL

    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {//Call a function when the state changes.
        if(xhr.readyState == XMLHttpRequest.DONE && ( xhr.status === 200 || xhr.status === 0 )) {
            alert(xhr.responseText);
        }
    }
    xhr.send('id=' + i);
}
