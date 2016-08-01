

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
         include ('include/div_nav.php');
         session_start();
         $_SESSION['url'] = $_SERVER['REQUEST_URI'];
       ?>
        <hr>
        <div id="main1" class="container-fluid">
            <div id="main1" class="row">
                <!-- $_SERVER['HTTP_HOST']  -- dominio
                     $_SERVER['REQUEST_URI']  -- url atual; 
                -->
                <div class="col-md-12">
                    <div class="text-center"><h1>TIPOS DE PRATO</h1></div>
                    <div class="container">
                        <div id="main1" class="row">
                            <form action="acao/tp_action.php" method="POST">
                                <?php 
                                   $url = "".$_SERVER['REQUEST_URI']."";
                                ?>
                                <input type="hidden" name="url" value="<?php echo $url; ?>">
                                <input type="hidden" name="codigo" value="0">
                                <input type="hidden" name="acao" value="S">
                                <div class="form-group col-md-8">
                                    <label for="tipo" class="control-label">Descri&ccedil;&atilde;o do Tipo de Refei&ccedil;&atilde;o</label>
                                    <input id="tipo" class="form-control" placeholder="Tipo de Refei&ccedil;&atilde;o" name="descricao" required="">
                                    
                                </div>
                                <div class="form-group col-md-4">
                                    
                                    <input type="submit" class="btn btn-primary" value="Salvar">
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive row">
                            
                            <table class="table table-action">
                                <thead>
                                    <tr>
                                        <th class="t-small">Id</th>
                                        <th class="t-small">Descri&ccedil;&atilde;o</th>
                                
                                    </tr>                                    
                                </thead>
                                <?php
                                        require_once './controller/Tipo_Prato_Controller.class.php';
                                        require_once './servicos/TPListIterator.class.php';
                                        $tc = new Tipo_Prato_Controller();
                                        $rs = $tc->lista_tipo("");
                                        $i = 0;
                                        $tipoList = new TPListIterator($rs);
                                        $tipo = new Tipo_Prato();
                                        while($tipoList->hasNextTipo()){
                                            $tipo = $tipoList->getNextTipo();
                                        
                                     ?>
                                <tbody>
                                    <div class="example">
                                    <?php 
                                            $var = $tipo->getCodigo()."|".$url;
                                            echo "<tr>";
                                            echo "   <td>".$tipo->getCodigo()."</td>";
                                            echo "   <td><a href='tp_alterar.php?codigo=$var' rel='facebox[.bolder]' >".$tipo->getDescricao()."</a></td>";                                            
                                            echo "   <td class='actions'><button data-nome='".$tipo->getDescricao()."' data-id='".$tipo->getCodigo()."' class='delete btn btn-danger'>Excluir</button>
                                                     <a href='tp_alterar.php?codigo=$var' rel='facebox[.bolder]' class='btn btn-warning'>Alterar</a></td>";
                                            echo "</tr>";
                                        }
                                    ?>
                                        </div>
                                </tbody>
                            </table>
                        </div>
                                
                    </div>
                </div>  
            </div>
        </div>
        
        
          
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Confirmar Exclus&atilde;o</h4>
            </div>
            <div class="modal-body">
              Deseja mesmo apagar ?
            </div>
            <div class="modal-footer">
              <a href="#" type="button" class="btn btn-primary delete-yes">Sim</a>
              <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
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
         
         
         
         <script language="javascript">
             $('.delete').on('click', function(){
                var nome = $(this).data('nome'); // vamos buscar o valor do atributo data-name que temos no botão que foi clicado
                var id = $(this).data('id'); // vamos buscar o valor do atributo data-id
                $('span.nome').text(nome+ ' (id = ' +id+ ')'); // inserir na o nome na pergunta de confirmação dentro da modal
                $('a.delete-yes').attr('href', 'acao/tp_action.php?codigo=' +id+'&acao=E&url=<?php echo $url; ?>'); // mudar dinamicamente o link, href do botão confirmar da modal
                $('#myModal').modal('show'); // modal aparece
          });
         </script>
    </body>
</html>
