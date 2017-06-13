<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
  session_start();
?>

<html>
    <head>
        <title>S. N. D - Servi&ccedil;os de Card&aacute;pio</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="img/ham.ico" rel="short icon">
    </head>
    <body>
  
        
        <?php
         include 'include/div_nav.php';
        ?>
         <br>
        <hr />
       <div id="main" class="container-fluid ">
           <div class="row col-md-12 linhaCor">
               <center>
                   <div class="media">
                        <div class="media-bottom">
                          <a href="#">
                              <img class="media-object" src="img/card.png" alt="..." height="220">
                          </a>
                        </div>
                        <div class="media-body">
                            <br>
                          <h2 class="media-heading">Bem vindo(a)!</h2>
                            <p style="font-size: 22px;">Voc&ecirc; est&aacute; logado no sistema de servi&ccedil;o de gerenciamento de card&aacute;pio</p>
                        </div>
                    </div>
               </center>    
           </div>
       </div>
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
