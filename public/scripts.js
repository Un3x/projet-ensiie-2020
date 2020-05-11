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

