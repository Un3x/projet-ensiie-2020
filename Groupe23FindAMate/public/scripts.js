function verifOnDelete(form) {
    var verif = prompt("Rentrez 'Je désire supprimer mon compte' pour confirmer la suppression");
    if (verif == "Je désire supprimer mon compte") {
            document.getElementById('id1').submit();
        }


}