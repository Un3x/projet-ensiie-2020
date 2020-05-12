
      /* Quand l'utilisateur clique sur le bouton,
      le contenu du menu dropdown est affiché */
      function navbarDropdown() {  document.getElementById("navbarDropdown").classList.toggle("show");
      }

      //Surligne le champ correspondant lorsqu'il y a une erreur
      function surligne(champ, erreur)
      {
         if(erreur)
            champ.style.backgroundColor = "#fba";
         else
            champ.style.backgroundColor = "";
      }

      //Vérifie que le pseudo est valide
      function verifPseudo(champ)
      {
         if(champ.value.length < 2 || champ.value.length > 20)
         {
            surligne(champ, true);
            return false;
         }
         else
         {
            surligne(champ, false);
            return true;
         }
      }

      //Vérifie que le prénom est valide
      function verifFirstname(champ)
      {
         if(champ.value.length < 2)
         {
            surligne(champ, true);
            return false;
         }
         else
         {
            surligne(champ, false);
            return true;
         }
      }

      //Vérifie que le nom de famille est valide
      function verifLastname(champ)
      {
         if(champ.value.length < 2)
         {
            surligne(champ, true);
            return false;
         }
         else
         {
            surligne(champ, false);
            return true;
         }
      }

      //Vérifie que le mail est valide
      function verifMail(champ)
      {
         var regex = /^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$/;
         if(!regex.test(champ.value))
         {
            surligne(champ, true);
            return false;
         }
         else
         {
            surligne(champ, false);
            return true;
         }
      }

      //On vérifie que le mot de passe est valide
      function verifMdp(champ)
      {
        if(champ.value.length < 4 || champ.value.length > 20)
        {
          surligne(champ,true);
          return false;
        }
        else
        {
          surligne(champ,false);
          return true;
        }
      }

      //On vérifie que tout le formulaire est valide
      function verifForm(f)
      {
         var pseudoOk = verifPseudo(f.username);
         var mailOk = verifMail(f.mail);
         var nomOk = verifLastname(f.lastname);
         var prenomOk = verifFirstname(f.firstname);
         var mdpOk = verifMdp(f.password);
         var confMdpOk = verifMdp(f.password2);

         if (mdpOk != confMdpOk)
         {
          return false;
         }
         
         else if(pseudoOk && mailOk && nomOk && prenomOk && mdpOk){
            return true;
         }
         else
         {
            alert("Veuillez remplir correctement tous les champs");
            return false;
         }
      }

      function showHint(str) {
        var xhttp;
        if (str.length == 0) { 
          document.getElementById("txtHint").innerHTML = "";
          return;
        }
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("txtHint").innerHTML = this.responseText;
          }
        };
        xhttp.open("GET", "recherche.php?titre="+str, true);
        xhttp.send();   
      }

      function showHint2(str,target) {
        var xhttp;
        if (str.length == 0) { 
          document.getElementById(target).innerHTML = "";
          return;
        }
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById(target).innerHTML = this.responseText;
          }
        };
        xhttp.open("GET", "recherche.php?titre="+str, true);
        xhttp.send();   
      }


      // Ferme le menu dropdown si l'utilisateur clique en dehors
      window.onclick = function(event) {
        if (!event.target.matches('.dropdown-toggle')) {
          var navDropdown = document.getElementsByClassName("dropdown-menu");
          var i;
          for (i = 0; i < navDropdown.length; i++) {
            var openDropdown = navDropdown[i];
            if (openDropdown.classList.contains('show')) {
              openDropdown.classList.remove('show');
            }
          }
        }
      }
      function sendDSL() {
        var scriptElement = document.createElement('script');
        scriptElement.src = 'dsl_script.js';

        document.body.appendChild(scriptElement);
    }

    function receiveMessage(message) {
        alert(message);
    }

