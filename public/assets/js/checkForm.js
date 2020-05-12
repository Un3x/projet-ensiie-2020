//Check si l'élément d'id = id vérifie bien la contrainte data-form-min si il est concerné
let checkFormMin = (id) => {
    let d = document.getElementById(id);
    return (!d.hasAttribute("data-form-min") || d.getAttribute('data-form-min')  <= d.value.length);
}

//Check si l'élément d'id = id vérifie bien la contrainte data-form-max si il est concerné
let checkFormMax = (id) => {
    let d = document.getElementById(id);
    return (!d.hasAttribute("data-form-max") || d.getAttribute('data-form-max')  >= d.value.length);
}

//Check si l'élément d'id = id vérifie bien la contrainte data-form-regex si il est concerné
let checkFormRegex = (id) => {
    let d = document.getElementById(id);
    return (!d.hasAttribute('data-form-regex') || ( d.value.match(d.getAttribute('data-form-regex')) != null ) );
}

//Check si l'elt id vérif la contrainte data-form-match
//On check si un autre elt de la page qui a un data-form-match et le mm attribut ont la mm valeur
let checkFormSame = (id) => {
    let d = document.getElementById(id);
    if (!d.hasAttribute("data-form-match")){
        return true;
    }
    let key = d.getAttribute('data-form-match');
    let bool = true;

    document.querySelectorAll('[data-form-match]').forEach((el) => {
        let key2 = el.getAttribute('data-form-match');
        bool = bool && ( el.value === d.value    ||(key!==key2));
    })
    return bool;
}

//Check si vérif la contrainte checked ou pas
let checkFormChecked = (id) => {
    let d = document.getElementById(id);
    let isCheckable = d.hasAttribute('type') && (d.getAttribute('type') === "checkbox")
    return (!d.hasAttribute("data-form-checked") || !isCheckable || d.checked);
}

//check si l'élement d'id = id vérifie bien toutes ses contraintes (min, max et regex)
let checkAllConstraints = (id) => {
    return (checkFormMin(id) && checkFormMax(id) && checkFormRegex(id) && checkFormSame(id) && checkFormChecked(id));
}

let generateMessage = (id) => {
    let message = "";
    let d = document.getElementById(id);
    if (!checkFormMax(id)){
        message +=  `Trop long (max ${d.getAttribute("data-form-max")} caractères). \n`
    }
    if (!checkFormMin(id)){
        message +=  `Trop court (min ${d.getAttribute("data-form-min")} caractères). \n`
    }
    if (!checkFormSame(id)){
        message += "Champs non identiques. \n"
    }


    if (!checkFormRegex(id)){
        if(d.hasAttribute("data-form-error")){
            message += d.getAttribute("data-form-error") + '\n';
        } else {
            message += "Entrée invalide. \n";
        }
    }

    if (!checkFormChecked(id)){
        message += "Ce champ est requis.\n";
    }

    return message;
}

let listeDismiss = [];

//dico : un dictionnaire a double entrée qui contient des fonctions :
//dico[rootId][fieldId]() -> true si le champ d'id fieldId du form rootId est valide
let dico = [];
$('[data-form-on]').each(function(i, root){
    let rootId = $(root).attr('id') ;
    console.log(rootId);
    dico[rootId]=[];
    listeDismiss[rootId] = [];

    $(root).find('[data-form-field]').each(function(i2,field){
            let fieldId = $(field).attr('id');
            dico[rootId][fieldId]= function(){
                $(field).focus();
                return checkAllConstraints(fieldId);
            }
            listeDismiss[rootId][fieldId] = () => {
                $(field).popover('dispose');
            }

            if ($(field).is(':checkbox')) {

                $(field).change(function(){
                    if (dico[rootId][fieldId]() === false){
                        $(field).popover('dispose');
                        let m = generateMessage(fieldId);
                        console.log(m);
                        $(field).popover({
                            trigger: "manual",
                            content: m,
                            placement: 'right',
                          //  template: '<div class="popover toggle-' + fieldId + '-field" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
                        });
                        $(field).popover('show');
                    } else {
                        $(field).popover('dispose');
                    }
                });
            //      $(this).prop("checked", true);
            //      $(this).prop("checked", false);
                  $(field).popover('show');

            } else {
                $(field).keyup(function(){
                    if (dico[rootId][fieldId]() === false){
                        //$(this).popover('dispose'); // Détruit le popover
                        $(this).popover('dispose');
                        let m = generateMessage(fieldId);
                        $(this).popover({trigger: "manual", content: m, placement: 'top'});
                        $(this).popover('show');
                    } else {
                        $(this).popover('dispose');
                    }
                });/*
                $(this).change(function(){
                    if (dico[rootId][fieldId]() === false){
                        //$(this).popover('dispose'); // Détruit le popover
                        $(this).popover('dispose');
                        let m = generateMessage(fieldId);
                        $(this).popover({trigger: "manual", content: m, placement: 'top'});
                        $(this).popover('show');
                    } else {
                        $(this).popover('dispose');
                    }
                }); */
                $(field).on("click",function(){
                    $(field).popover('dispose');
                });
            }


            $(root).submit(function(event){
                if ($(field).is(':checkbox')){
                    $(field).trigger('change');
                }else{
                    $(field).keyup();
                }
            //Au moment de submit, on checke si tout est ok
                for (let i in dico[rootId]){
                    if (false === dico[rootId][i]()){
                         console.log(i);
                       event.preventDefault();
                    }
                }
            })
    });

    //console.log(dico);


});

