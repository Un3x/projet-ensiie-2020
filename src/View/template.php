<?php 

function loadView($view,$data)
{
?>
  <!DOCTYPE html>
  <html>
    <head>
      <meta charset="UTF-8" />
      <title>Tales of Webseria</title>
      <!-- Bootstrap -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
      
      <link rel='stylesheet' href='style.css'>
    </head>
    <?php include_once '../src/View/layout/header.php'?>
    <body>
      <div class="container main-container">
        <?php include_once '../src/View/'.$view.'.php' ?>
      </div> 
    </body>
  </html>  
<?php
}


?>
