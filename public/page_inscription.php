<?php session_start();
  if(isset($_SESSION['id'])) {
	header("Location: /");
	}
	?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Epicévry</title>
     
    <meta name="description" content="page d'inscription utilisateur">
    <meta name="author" content="Us">
     
    <?php include "./css_head.html" ?>
 	<style>
 		label {color:#FFFFFF; font-weight: bold; }
 		input[type=text] {background: transparent; border-top-style: none; border-left-style: none; border-right-style: none; border-bottom-width: 0.5px; color:#D3D3D3; }
 		input[type=password] {background: transparent; border-top-style: none; border-left-style: none; border-right-style: none; border-bottom-width: 0.5px; color:#D3D3D3; }
		input[type=email] {background: transparent; border-top-style: none; border-left-style: none; border-right-style: none; border-bottom-width: 0.5px; color:#D3D3D3; }
 		input[type=submit] {background: #26272B; border-top-style: none; border-left-style: none; border-right-style: none; border-bottom-style: none; color: #FFFFFF; font-weight: bold; }
 		a {color: #BECFBD; }
 		div[id=inscriptionpara] {text-align: center;}
		.site-footer
		{
		    background-color:#26272b;
		    padding:45px 0 20px;
		    font-size:15px;
		    line-height:24px;
		    color:#737373;
		}
		.site-footer hr
		{
		    border-top-color:#bbb;
		    opacity:0.5
		}
		.site-footer hr.small
		{
		    margin:20px 0
		}
		.site-footer h6
		{
		    color:#fff;
		    font-size:16px;
		    text-transform:uppercase;
		    margin-top:5px;
		    letter-spacing:2px
		}
		.site-footer a
		{
		    color:#737373;
		}
		.site-footer a:hover
		{
		    color:#3366cc;
		    text-decoration:none;
		}
		.footer-links
		{
		    padding-left:0;
		    list-style:none
		}
		.footer-links li
		{
		    display:block
		}
		.footer-links a
		{
		    color:#737373
		}
		.footer-links a:active,.footer-links a:focus,.footer-links a:hover
		{
		    color:#3366cc;
		    text-decoration:none;
		}
		.footer-links.inline li
		{
		    display:inline-block
		}
		.site-footer .social-icons
		{
		    text-align:right
		}
		.site-footer .social-icons a
		{
		    width:40px;
		    height:40px;
		    line-height:40px;
		    margin-left:6px;
		    margin-right:0;
		    border-radius:100%;
		    background-color:#33353d
		}
		.copyright-text
		{
		    margin:0
		}
		@media (max-width:991px)
		{
		    .site-footer [class^=col-]
		    {
			margin-bottom:30px
		    }
		}
		@media (max-width:767px)
		{
		    .site-footer
		    {
			padding-bottom:0
		    }
		    .site-footer .copyright-text,.site-footer .social-icons
		    {
			text-align:center
		    }
		}
		.social-icons
		{
		    padding-left:0;
		    margin-bottom:0;
		    list-style:none
		}
		.social-icons li
		{
		    display:inline-block;
		    margin-bottom:4px
		}
		.social-icons li.title
		{
		    margin-right:15px;
		    text-transform:uppercase;
		    color:#96a2b2;
		    font-weight:700;
		    font-size:13px
		}
		.social-icons a{
		    background-color:#eceeef;
		    color:#818a91;
		    font-size:16px;
		    display:inline-block;
		    line-height:44px;
		    width:44px;
		    padding:10px;
		    text-align:center;
		    margin-right:8px;
		    border-radius:100%;
		    -webkit-transition:all .2s linear;
		    -o-transition:all .2s linear;
		    transition:all .2s linear
		}
		.social-icons a:active,.social-icons a:focus,.social-icons a:hover
		{
		    color:#fff;
		    background-color:#29aafe
		}
		.social-icons.size-sm a
		{
		    line-height:34px;
		    height:34px;
		    width:34px;
		    font-size:14px
		}
		.social-icons a.facebook:hover
		{
		    background-color:#3b5998
		}
		.social-icons a.twitter:hover
		{
		    background-color:#00aced
		}
		.social-icons a.linkedin:hover
		{
		    background-color:#007bb6
		}
		.social-icons a.dribbble:hover
		{
		    background-color:#ea4c89
		}
		@media (max-width:767px)
		{
		    .social-icons li.title
		    {
			display:block;
			margin-right:0;
			font-weight:600
		    }
		}
		
 		</style>
</head>

     
<body style="background-color:#677179">
<?php include "./header.html" ?>     
 <br /><br />
<div id="inscriptionpara" class="container">
  
  <! -- Formulaire d'inscription -- >
     <form action="signup.php" method="post">

       <label for "iusername">Pseudo</label><br />
       <input type="text" id="iusername" name="iusername" required><br /><br />
       
       <label for "iemail">Email</label><br>
       <input type="email" id="iemail" name="iemail" required><br /><br />

      
       <label for "ipassword">Mot de passe</label><br>
       <input type="password" id="ipassword" name="ipassword" required><br /><br />

       <label for "ipasswordconfirm">Confirmation du mot de passe</label><br>
       <input type="password" id="ipasswordconfirm" name="ipasswordconfirm" required><br /><br />
      
       <input type="submit" value="Inscription" /><br /><br />
       
     </form>
     <! -- Fin formulaire d'inscription -->
     
     <!-- Gestion de l'affichage des messages d'erreurs -->
	<?php   if(isset($_GET['erreur'])) {

	       if($_GET['erreur'] == "usernameTaken") {
	       echo "Ce pseudo est déjà utilisé";
		}
		elseif($_GET['erreur'] = "passwordDoNotMatch") {
		echo "Les mots de passe ne correspondent pas";
		}
	       else {
	       echo "Erreur inconnue";
	       }
	       
	       }
	       ?>
</div>
<?php include "./footer.html" ?>
</body>
