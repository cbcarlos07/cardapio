

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
        <link href="css/bootstrap.min.css" rel="stylesheet">
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
                    <div class="text-center"><h1>PRATOS</h1></div>
                    <div class="container">
                        <div id="main1" class="row">
                            <form action="pratos.php" method="POST">
                                <?php 
                                   $url = "".$_SERVER['REQUEST_URI']."";
                                   session_start();
                                   $_SESSION['url'] = $url;
                                ?>
                                <input type="hidden" name="url" value="<?php echo $url; ?>">
                                <input type="hidden" name="codigo" value="0">
                                <input type="hidden" name="acao" value="S">
                                <div class="form-group col-md-8">
                                    <label for="tipo" class="control-label">Descri&ccedil;&atilde;o do Tipo de Refei&ccedil;&atilde;o</label>
                                    <input id="tipo" class="form-control" placeholder="Tipo de Refei&ccedil;&atilde;o" name="valor" >
                                    
                                </div>
                                <div class="form-group col-md-2">
                                    
                                    <input type="submit" class="btn btn-primary" value="Pesquisar">
                                </div>
                                
                            </form>
                            <div class="form-group col-md-2">
                                <form action="pratos_cad.php" method="post">
                                    <input type="hidden" name="url" value="<?php echo $url; ?>">
                                    <button type="submit" class="btn btn-default" >Novo</button></form>
                                </form>    
                                    
                             </div>
                        </div>
                        <div class="table-responsive row">
                            
                            <table class="table table-action">
                                <thead>
                                    <tr>
                                        <th class="t-small">Id</th>
                                        <th class="t-small">Descri&ccedil;&atilde;o</th>
                                        <th class="t-small">TIPO DE PRATO</th>
                                        
                                
                                    </tr>                                    
                                </thead>
                                <?php
                                        if(isset($_POST['valor'])){
                                            $valor = $_POST['valor'];
                                        }else{
                                            $valor = "";
                                        }
                                        require_once './controller/Prato_Controller.class.php';
                                        require_once './servicos/PratoListIterator.class.php';
                                        $tc = new Prato_Controller();
                                        $rs = $tc->lista_prato(strtoupper($valor));
                                        $i = 0;
                                        $tipoList = new PratoListIterator($rs);
                                        $prato = new Prato();
                                        while($tipoList->hasNextPrato()){
                                            $prato = $tipoList->getNextPrato();
                                        
                                     ?>
                                <tbody>
                                    <div class="example">
                                        
                                    <?php
                                            
                                            $var = $prato->getCodigo()."|".$url;
                                            $codigo_prato = $prato->getCodigo();
                                            echo "<tr>";
                                            echo "   <td>".$prato->getCodigo()."</td>";
                                            echo "   <td><a href='pratos_alt.php?codigo=$var' rel='facebox[.bolder]' >".$prato->getNome()."</a></td>";                                            
                                            echo "   <td>".$prato->getTipo_prato()->getDescricao()."</td>";                                            
                                            echo "   <td class='actions'>
                                                       <button data-nome='".$prato->getTipo_prato()->getDescricao()."' data-id='$codigo_prato' class='delete btn btn-danger'>Excluir</button>
                                                       <a href='pratos_alt.php?codigo=$var' rel='facebox[.bolder]' class='btn  btn-success'>Editar</button>";
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
        
        
              <!-- Modal -->
<form action="acao/prato_action.php" method="post">
    
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
 </form>                 
        
        
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
                $('a.delete-yes').attr('href', 'acao/prato_action.php?codigo=' +id+'&acao=E&url=<?php echo $url; ?>'); // mudar dinamicamente o link, href do botão confirmar da modal
                $('#myModal').modal('show'); // modal aparece
          });
         </script>
    </body>
</html>
