

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
         session_start();
         $_SESSION['url'] = $_SERVER['REQUEST_URI'];
          if($_GET['codigo']){
          $valor = $_GET['codigo'];
          $_SESSION['codigo'] = $valor;
          }else{
             $valor = $_SESSION['codigo'];
             $_SESSION['codigo'] = $valor;
          }
        ?>
        <hr>
        <div id="main1" class="container-fluid">
            <div id="main1" class="row">
                <!-- $_SERVER['HTTP_HOST']  -- dominio
                     $_SERVER['REQUEST_URI']  -- url atual; 
                -->
                <div class="col-md-12">
                    <div class="text-center"><h1>Lista de Pessoas Agendadas</h1></div>
                    <div class="container">
                        <div id="main1" class="row">
                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="GET">
                                <?php 
                                   $url = "".$_SERVER['REQUEST_URI']."";
                                ?>
                                <input type="hidden" name="url" value="<?php echo $url; ?>">
                                <input type="hidden" name="codigo" value="0">
                                <input type="hidden" name="acao" value="S">
                                <div class="form-group col-md-8">
                                    <label for="tipo" class="control-label">Pesquisar Nome</label>
                                    <input id="tipo" class="form-control" placeholder="" name="nome" >
                                    
                                </div>
                                <div class="form-group col-md-2">
                                    
                                    <input type="submit" class="btn btn-primary" value="Pesquisar">
                                </div>
                                
                            </form>
                            <div class="form-group col-md-2">
                                <form action="cardapio_cad.php" method="post">
                                    <input type="hidden" name="url" value="<?php echo $url; ?>">
                                    <button type="submit" class="btn btn-default" >Novo</button></form>
                                </form>    
                                    
                             </div>
                        </div>
                        <div class="table-responsive row">
                            
                            <table class="table table-action">
                                <thead>
                                    <tr>
                                        <th class="t-small">Crach&aacute;</th>
                                        <th class="t-small">Nome</th>
                                        
                                        
                                
                                    </tr>                                    
                                </thead>
                                <?php
                                            
                                            
                                            if(isset($_GET['nome'])){
                                                $nome = '%'.$_GET['nome'].'%';
                                            }else{
                                                $nome = '%';
                                            }
                                           
                                            $_SESSION['nome'] = $nome;
                                        require_once './beans/Agenda.class.php';
                                        require_once './servicos/AgendaListIterator.class.php';
                                        require_once './controller/Agenda_Controller.class.php';
                                        $ac = new Agenda_Controller();
                                        $rs = $ac->getLista($_SESSION['codigo'], $_SESSION['nome']);
                                        
                                        $agendaList = new AgendaListIterator($rs);
                                        $agenda = new Agenda();
                                        while($agendaList->hasNextAgenda()){
                                            $agenda = $agendaList->getNextAgenda();
                                            
                                     ?>
                                <tbody>
                                    <div class="example">
                                    <?php 
                                           
                                            echo "<tr>";
                                            echo "   <td>".$agenda->getCod_Funcionario()."</td>";
                                            echo "   <td>".$agenda->getNm_Funcionario()."</td>";                                            
                                            
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
                $('a.delete-yes').attr('href', 'acao/cardapio_action.php?codigo=' +id+'&acao=E&url=<?php echo $url; ?>'); // mudar dinamicamente o link, href do botão confirmar da modal
                $('#myModal').modal('show'); // modal aparece
          });
         </script>
         
         
    </body>
</html>
