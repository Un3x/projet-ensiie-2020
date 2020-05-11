function login_validation(){
    if(document.login.nom_utilisateur.value == ""){
        alert("Empty field : username");
        return false;
    }
    if(document.login.mdp_utilisateur.value == ""){
        alert("Empty field : password");
        return false;
    }
    return true;
}

function signin_validation(){
    if(document.signin.nom_utilisateur.value == ""){
        alert("Empty field : username");
        return false;
    }
    if(document.signin.mdp_utilisateur.value == ""){
        alert("Empty field : password");
        return false;
    }
    if(document.signin.mail_utilisateur.value == "" || !document.signin.mail_utilisateur.value.includes("@")){
        alert("Incorrect field : email");
        return false;
    }
    return true;
}

function update_online_members(){
    var nbr_online = document.getElementById("nbr_online");
}

var modal = document.getElementById("RoleModal");
var btn = document.getElementById("Roles_button");
var span = document.getElementsByClassName("close_pan")[0];

function is_queueing(){
    var circle = document.getElementById("queue");
    var confirm_circle = document.getElementById("queueing");
    if(queueing == 3 || queueing == '3'){
        circle.style.display = "block";
    }
}

btn.onclick = function() {
    modal.style.display = "block";
}
span.onclick = function() {
    modal.style.display = "none";
}
window.onclick = function(event) {
    if(event.target == modal) {
        modal.style.display = "none";
    }
}
