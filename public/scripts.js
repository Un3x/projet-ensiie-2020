function deleteuser(username) {
    if (confirm("voulez-vous supprimer l'utilisateur " + username + "?")) {
        const xml = new XMLHttpRequest();
        xml.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                if (this.responseText == '1')
                    document.getElementById("user" + username).innerHTML = "";
            }
        }
        xml.open("GET", "deleteUser.php?username=" + username, true);
        xml.send(null);
    }
}

function showfollowers(username) {
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (document.getElementById("followers" + username).innerHTML === "") {
                document.getElementById("followers" + username).innerHTML = this.responseText;
            } else {
                document.getElementById("followers" + username).innerHTML = "";
            }
        }
    }
    xml.open("GET", "followers.php?username=" + username, true);
    xml.send(null);
}

function showfollowed(username) {
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("followed").innerHTML = this.responseText;
        }
    }
    xml.open("GET", "followed.php?username=" + username, true);
    xml.send(null);
}

function follow(username) {
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("follows" + username).innerHTML = "Followed !";
        }
    }
    xml.open("GET", "followUser.php?username=" + username, true);
    xml.send(null);
}

function unfollow(username) {
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("follows" + username).innerHTML = "Unfollowed !";
        }
    }
    xml.open("GET", "unfollowUser.php?username=" + username, true);
    xml.send(null);
}

function followorunfollow(username) {
    if (document.getElementById("follows" + username).innerHTML === "Followed !") {
        unfollow(username);
    } else {
        follow(username);
    }
    if (document.getElementById("followers" + username).innerHTML !== "") {
        showfollowers(username);
        showfollowers(username);
    }
}

function signin() {
    document.getElementById("textpassword").innerHTML = "";
    document.getElementById("textusername").innerHTML = "";
    document.getElementById("textsubmit").innerHTML = "";
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    if (password === "" || username === "") {
        if (password === "") {
            document.getElementById("textpassword").innerHTML = "veuillez remplir ce champ.";
        }
        if (username === "") {
            document.getElementById("textusername").innerHTML = "veuillez remplir ce champ.";
        }
        return false;
    }
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText === '1') {
                window.location.href = "yourprofile.php";
            } else {
                document.getElementById("textsubmit").innerHTML = "Pseudo ou mot de passe incorrect."
            }
        }
    }
    xml.open("GET", "signin.php?username=" + username + "&password=" + password, true);
    xml.send(null);

}

function register() {
    document.getElementById("textusername").innerHTML = "";
    document.getElementById("textpassword1").innerHTML = "";
    document.getElementById("textpassword2").innerHTML = "";
    document.getElementById("textemail").innerHTML = "";
    document.getElementById("textsubmit").innerHTML = "";

    const username = document.getElementById("username").value;
    const password1 = document.getElementById("password1").value;
    const password2 = document.getElementById("password2").value;
    const email = document.getElementById("email").value;
    if (username == "" || password1 == "" || password2 == "" || email == "" || password1 != password2 || !validateEmail(email)) {
        if (username == "") {
            document.getElementById("textusername").innerHTML = "veuillez remplir ce champ.";
        }
        if (password1 == "") {
            document.getElementById("textpassword1").innerHTML = "veuillez remplir ce champ.";
        }
        if (password2 == "") {
            document.getElementById("textpassword2").innerHTML = "veuillez remplir ce champ.";
        }
        if (email == "") {
            document.getElementById("textemail").innerHTML = "veuillez remplir ce champ.";
        }
        if (password1 != password2) {
            document.getElementById("textsubmit").innerHTML = "Les mots de passe ne correspondent pas."
        }
        if (!validateEmail(email)) {
            document.getElementById("textemail").innerHTML = "Entrez une addresse valide."
        }
        return false;
    }
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText === '1') {
                window.location.href = "yourprofile.php";
            } else {
                document.getElementById("textsubmit").innerHTML = username + " est déjà utilisé."
            }
        }
    }
    xml.open("GET", "register.php?username=" + username + "&password=" + password1 + "&email=" + email, true);
    xml.send(null);

}

function no_user(str, username) {
    if (str === "follow") {
        document.getElementById("follows" + username).innerHTML = "<a href='Authentification.php'>Vous devez vous connecter.</a>";
    }
}

function AddPref(checkbox, Pref) {
    let name = checkbox.value;
    Pref.push(name);
    document.getElementById("listpref").innerHTML = Pref.toString();
}

function removePref(checkbox, Pref) {
    let name = checkbox.value;
    for (var i = 0; i < Pref.length; i++) {
        if (Pref[i] === name) {
            Pref.splice(i, 1);
            i--;
        }
    }
    document.getElementById("listpref").innerHTML = Pref.toString();
}

function ChangePref(checkbox, Pref) {
    if (checkbox.checked) {
        AddPref(checkbox, Pref)
    } else {
        removePref(checkbox, Pref);
    }
}

function SubmitPref(Pref) {
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
        document.getElementById("sendpref").innerHTML = "Préférences envoyées";
    }
    xml.open("GET", "Trends.php?pref=" + Pref, true);
    xml.send(null);
}

function disconnect() {
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            window.location.href = "index.php";
        }
    }
    xml.open("GET", "disconnect.php", true);
    xml.send(null);
}

function post() {
    const content = document.getElementById("content").value;
    const theme = document.getElementById("theme").value;
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText == '1') {
            }
        }
    }
    xml.open("GET", "post.php?content=" + content + "&theme=" + theme, true);
    xml.send(null);
}

function show_wall(username) {
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById('wall').innerHTML = this.responseText;
        }
    }
    xml.open("GET", "mur.php?username=" + username, true);
    xml.send(null);

}

function validateEmail(email) {
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function openPost() {
    document.getElementById("mypost").style.display = "block";
}

function closePost() {
    document.getElementById("mypost").style.display = "none";
}

function showProfile(username) {
    window.location.href = "profile.php?username=" + username;
}

function deletepost(id_post) {;
    if (confirm("Voulez-vous supprimer ce poste ?")) {
        const xml = new XMLHttpRequest();
        xml.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                if (this.responseText == '1') {
                }
            }
        }
        xml.open("GET", "deletePost.php?id_post=" + id_post, true);
        xml.send(null);
    }
}

function likePost(id_post, username) {
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText == '1') {
            }
        }
    }
    xml.open("GET", "likePost.php?id_post=" + id_post + "&username=" + username, true);
    xml.send(null);
}

function showPosts(cat) {
    const xml = new XMLHttpRequest();


    if (cat == "theme") {
        xml.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById('wall').innerHTML = this.responseText;
            }
        }
        const theme = document.getElementById("theme").value;
        xml.open("GET", "showPosts.php?theme=" + theme, true);
    }
    else if (cat == "follow"){
        xml.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById('follow').innerHTML = this.responseText;
            }
        }
        const follow = document.getElementById("username").innerHTML;
        xml.open("GET", "showPosts.php?follow=" + follow, true);
    }
    xml.send(null);
}

function gotoComments(id_post) {
    window.location.href = "postComments.php?id_post=" + id_post;
}

function showComments(id_post) {
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById('comments').innerHTML = this.responseText;
        }
    }
    xml.open("GET", "showComments.php?id_post=" + id_post, true);
    xml.send(null);
}

function comment(id_post) {

    const content = document.getElementById("comment").value;
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText == '1') {
            }

        }

    }
    xml.open("GET", "addComment.php?content=" + content + "&id_post=" + id_post, true);
    xml.send(null);
}

function deletecomment(id_comment) {
    if (confirm("Voulez-vous supprimer ce commentaire ?")) {
        const xml = new XMLHttpRequest();
        xml.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
            }
        }
        xml.open("GET", "deleteComment.php?id_comment=" + id_comment, true);
        xml.send(null);
    }
}
function unsub(theme){
    if(confirm("Souhaitez vous vous désabonner de ce thème ?")){
        const xml = new XMLHttpRequest();
        xml.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                window.location.href = "yourprofile.php";
            }
        }
        xml.open("GET", "unsub.php?theme=" + theme, true);
        xml.send(null);
    }
}

function showmessages(username) {
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById('Messages').innerHTML = this.responseText;
        }
    }
    xml.open("GET", "murMessages.php?username=" + username, true);
    xml.send(null);

}

function openMessage() {
    document.getElementById("mymessage").style.display = "block";
}

function closeMessage() {
    document.getElementById("mymessage").style.display = "none";
}
function sendMessage(username) {
    const content = document.getElementById("contentmessage").value;
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText == '1') {
            }
        }
    }
    xml.open("GET", "sendMessage.php?content=" + content + "&username=" + username, true);
    xml.send(null);
}