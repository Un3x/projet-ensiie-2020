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


