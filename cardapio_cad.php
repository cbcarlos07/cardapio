
<?php
     session_start();
     if(isset($_POST['url'])){
         $url = $_POST['url'];
         $_SESSION['url'] = $url;
     }else{
         $url = $_SESSION['url'];
     }
     
     
    
    
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
                    <div class="text-center"><h1>CADASTRO DE CARD&Aacute;PIO</h1></div>
                    <div class="container">
                        <div class="col-md-5 col-md-push-3">  
                            <form action="acao/cardapio_action.php" method="post">
                                <input type="hidden" name="url" value="<?php echo $_SESSION['url']; ?>">
                                <input type="hidden" name="acao" value="S">
                                <input type="hidden" name="codigo" value="0">
                                    <div class="form-group">
                                        <label for="data">Data da Refei&ccedil;&atilde;o</label>
                                        <input name="data" id="data" class="form-control" type="date" size="5" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="data">Tipo de Refei&ccedil;&atilde;o</label>
                                        <select name="tipo" class="form-control" required="">
                                            <option value="">Selecione</option>
                                             <?php
                                                    require_once './controller/Tipo_Refeicao_Controller.class.php';
                                                    require_once './servicos/TipoListIterator.class.php';
                                                    $tc = new Tipo_Refeicao_Controller();
                                                    $rs = $tc->lista_tipo("");
                                                    $i = 0;
                                                    $tipoList = new TipoListIterator($rs);
                                                    $tipo = new Tipo_Refeicao();
                                                    while($tipoList->hasNextTipo()){
                                                        $tipo = $tipoList->getNextTipo();
                                                        echo "<option value=".$tipo->getCodigo().">".$tipo->getDescricao()."</option>";
                                                    }    
                                              ?>
                                        </select>
                                    </div>
                                    <div class=" btn-group col-md-push-2">
                                        
                                        <button class="btn btn-primary" type="submit">Salvar</button>
                                        <button class="btn btn-default" type="reset">Limpar Campos </button>
                                        <a href="<?php echo $_SESSION['url']; ?>" class="btn btn-default bottom-right" onclick="return verifica('Tem certeza de que deseja cancelar a opera&ccedil;&atilde;o?');">Cancelar</a> 
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
         <script type="text/javascript">
            function mostra() {
                var comboPratos = document.getElementById("select");
                // note que não é o valor da option e sim o conteúdo
                //if(document.card.prato.selectedIndex==1) {
                //  alert("O valor é: "+comboPratos.options[comboPratos.selectedIndex].value);
                var codigo =  comboPratos.options[comboPratos.selectedIndex].value;
                var formulario = document.getElementById("form_list");
                formulario.submit();
                //alert('Valor: ');
                //}
            }
            
//            document.getElementById("btnInfo").onclick = function() {
//                var comboCidades = document.getElementById("cboCidades");
//                console.log("O indice é: " + comboCidades.selectedIndex);
//                console.log("O texto é: " + comboCidades.options[comboCidades.selectedIndex].text);
//                console.log("A chave é: " + comboCidades.options[comboCidades.selectedIndex].value);
//                alert("O valor é: "+comboCidades.options[comboCidades.selectedIndex].text);
//            }
         </script>
    </body>
</html>
