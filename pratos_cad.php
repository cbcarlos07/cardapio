
<?php
  $url = $_POST['url'];
?>
<html>
    <head>
        <title>Menu de Cadastro de Card&aacute;pio</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="img/ham.ico" rel="short icon">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
        
        <link href="css/example.css" media="screen" rel="stylesheet" type="text/css" />
        <script src="lib/jquery.js" type="text/javascript"></script>
        <script src="src/facebox.js" type="text/javascript"></script>
        <script type="text/javascript">
          jQuery(document).ready(function($) {
            $('a[rel*=facebox]').facebox({
              loadingImage : 'src/loading.gif',
              closeImage   : 'src/closelabel.png'
            })
          })
        </script>

    </head>
    <body>
        <?php 
         include './include/div_nav.php';
        ?>
        <hr>
        <div id="main1" class="container-fluid">
            <div id="main1" class="row">
                <!-- $_SERVER['HTTP_HOST']  -- dominio
                     $_SERVER['REQUEST_URI']  -- url atual; 
                -->
                <div class="col-md-12">
                    <div class="text-center"><h1>CADASTRO DE PRATOS</h1></div>
                    <div class="container">
                        <div id="main">
                            <form action="acao/prato_action.php" method="post">
                                <input type="hidden" value="S" name="acao">
                                <input type="hidden" value="<?php echo $url; ?>" name="url">
                                <input type="hidden" value="0" name="codigo">
                                <div class="form-group col-md-12">
                                    <label for="nome">Nome do Prato</label>
                                    <input name="descricao" id="nome" class="form-control" placeholder="Nome do prato" required title="Este campo n&atilde;o pode ficar em branco">
                                    
                                </div>
                               
                                <div class="form-group col-md-5">
                                    <label for="tipo">Tipo de Prato</label>
                                    <select name="tipo" class="form-control" required >
                                        <option value="">Selecione</option>
                                         <?php
                                                require_once './controller/Tipo_Prato_Controller.class.php';
                                                require_once './servicos/TPListIterator.class.php';
                                                $tc = new Tipo_Prato_Controller();
                                                $rs = $tc->lista_tipo("");                                               
                                                $tipoList = new TPListIterator($rs);
                                                $tipo = new Tipo_Prato();
                                                while($tipoList->hasNextTipo()){
                                                    $tipo = $tipoList->getNextTipo();
                                                    echo "<option value=".$tipo->getCodigo().">".$tipo->getDescricao()."</option>";
                                                }    
                                          ?>
                                        
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="ingrediente">Ingredientes</label>
                                    <textarea required="" class="form-control" rows="10" cols="40" maxlength="500" name="ingrediente" placeholder="Ingedientes"></textarea>
                                </div>
                                <hr>
                                <div class="form-group col-md-8" >
                                    <button type="submit" class="btn btn-primary btn-block">Salvar</button>
                                </div>
                                <div class="form-group col-md-4" >
                                    <a href="<?php echo $url; ?>" class="btn btn-default btn-block" onclick="return verifica('Tem certeza de que deseja cancelar a opera&ccedil;&atilde;o?');">Cancelar</a>
                                </div>
                            </form>
                        </div>          
                    </div>
                </div>  
            </div>
        </div>
        <script src="js/jquery.min.js"></script>
        
        <script src="js/bootstrap.min.js"></script>
         <script language=javascript>
            function verifica(Msg)
               {
                  return confirm(Msg) ;
               }
         </script>
    </body>
</html>
