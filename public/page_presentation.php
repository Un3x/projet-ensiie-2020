<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
<title> Présentation </title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<meta name="description" content="Projet web Ensiie">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link rel="stylesheet" href="css/header.css">
<link rel="stylesheet" href="css/normalize.css">
<link rel="stylesheet" href="css/footer.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<?php include "css_head.html" ?>
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}

body, html {
height: 100%;
background-color: #677179;
    line-height: 1.8;
    }

p {
color: #ffffff;
}
#copy {
color: #737373;
}
h2 {
color: #fff;
}

/* Full height image header */
.bgimg-1 {
  background-position: center;
    background-size: cover;
      background-image: url("f.jpg");
        min-height: 100%;
	}

.w3-bar .w3-button {
padding: 16px;
  }
</style>
</head>
<?php include "header.html" ?>
<div class="w3-container" style="padding:128px 16px" id="about">
  <h2 class="w3-center">A PROPOS DE EPICEVRY</h2>
  <p class="w3-center w3-large">Pourquoi nous faire confiance</p>
  <div class="w3-row-padding w3-center" style="margin-top:64px">
    <div class="w3-quarter">
      <i class="fa fa-desktop w3-margin-bottom w3-jumbo w3-center"></i>
      <p  class="w3-large">Praticité</p>
      <p >Notre but est de permettre aux étudiants <br />de se procurer des produits frais de saison tout en économisant un temps précieux.</p>
    </div>
    <div class="w3-quarter">
      <i class="fa fa-heart w3-margin-bottom w3-jumbo"></i>
      <p  class="w3-large">Passion</p>
      <p >Ce projet vise à montrer aux jeunes qu'il est facile de manger sainement, en leur proposant des produits de qualité et des recettes à la portée de tous.</p>
    </div>
    <div class="w3-quarter">
      <i class="fa fa-diamond w3-margin-bottom w3-jumbo"></i>
      <p  class="w3-large">Partage</p>
      <p >Favoriser les rapports entre les étudiants de la ville d'Évry et les produits sains est un de nos principaux objectifs.</p>
    </div>
    <div class="w3-quarter">
      <i class="fa fa-cog w3-margin-bottom w3-jumbo"></i>
      <p  class="w3-large">Support</p>
      <p i>Notre équipe est joignable à tout instant afin d'assurer la bon déroulement de vos commandes et gérer le flux des recettes. Nous restons également à votre entière disposition pour toute réclamation.</p>
    </div>
  </div>
</div>

<div class="w3-container w3-light-grey" style="padding:128px 16px">
  <div class="w3-row-padding">
    <div class="w3-col m6">
		<br /><br /><br /><br />
      <h3>Vous satisfaire : notre priorité</h3>
	  <br />
      <h6>Nous vous proposons une sélection des meilleurs fruits et légumes du marché. <br />Laissez-nous vous aider à changer vos habitudes de consommation sans contraindre votre emploi du temps.</h6><br />
      <p ><a href="catalogue_accueil.php" class="w3-button w3-black"><i class="fa fa-th"></i> Consultez nos produits</a></p>
    </div>
    <div class="w3-col m6">
      <img class="w3-image w3-round-large" src="css/2.jpg" alt="Buildings" width="700" height="394">
    </div>
  </div>
</div>

<script>
  // Modal Image Gallery
  function onClick(element) {
  document.getElementById("img01").src = element.src;
  document.getElementById("modal01").style.display = "block";
  var captionText = document.getElementById("caption");
  captionText.innerHTML = element.alt;
  }


  // Toggle between showing and hiding the sidebar when clicking the menu icon
  var mySidebar = document.getElementById("mySidebar");

  function w3_open() {
  if (mySidebar.style.display === 'block') {
  mySidebar.style.display = 'none';
  } else {
  mySidebar.style.display = 'block';
  }
  }

  // Close the sidebar with the close button
  function w3_close() {
  mySidebar.style.display = "none";
  }
</script>
<?php include "./footer.html" ?>
</body>


</html>
