<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>S. N. D - Servi&ccedil;os de Card&aacute;pio - Erro</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="img/ham.ico" rel="short icon">
    </head>
    <body>
  
        
        <?php
         session_start();
        
         
         include 'include/div_nav.php';
         
         
        ?>
        <br>
        <hr />
            <div class="container">
                <div class="row tela linhaCor">
                        <div class="middle">
                                <div class="media col-md-3">
                                  <figure class="pull-left">
                                      <img class="media-object img-rounded img-responsive "   src="img/erro.png" alt="placehold.it/350x250" >
                                  </figure>
                                </div>
                                <div class="col-md-6 msg">
                                    <h1 class="list-group-item-heading"> <strong>Erro ao excluir </strong></h1>
                                  <p class="list-group-item-text excluir"> Não foi possível excluir o item selecionado.<BR> Por favor, verifique se não há nenhum cadastro vinculado a ele
                                  </p>
                                  <hr />
                                  <a href="<?php echo $_SESSION['url'] ?>" class="btn btn-danger">Cancelar</a>
                                </div>
                            
                        </div>
                    
            </div>  
            </div>    
            
            
        
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
