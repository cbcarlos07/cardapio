

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
        <link rel="stylesheet" href="css/jquery.datetimepicker.min.css">
        
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
        ?>
        <hr>
        <div id="main1" class="container-fluid">
            <div id="main1" class="row">
                <!-- $_SERVER['HTTP_HOST']  -- dominio
                     $_SERVER['REQUEST_URI']  -- url atual; 
                -->
                <div class="col-md-12">
                    <div class="text-center"><h1>CARD&Aacute;PIOS</h1></div>
                    <div class="container">
                        <div id="main1" class="row">
                            <form action="cardapios.php" method="POST">
                                <?php 
                                   $url = "".$_SERVER['REQUEST_URI']."";
                                ?>
                                <input type="hidden" name="url" value="<?php echo $url; ?>">
                                <input type="hidden" name="codigo" value="0">
                                <input type="hidden" name="acao" value="S">
                                <div class="form-group col-md-8">
                                    <label for="tipo" class="control-label">Descri&ccedil;&atilde;o do Tipo de Refei&ccedil;&atilde;o</label>
                                    <input  id="datepicker" class="form-control" placeholder="Tipo de Refei&ccedil;&atilde;o" name="valor" >
                                    
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
                                        <th class="t-small">Id</th>
                                        <th class="t-small">Data do Card&aacute;pio</th>
                                        <th class="t-small">Tipo de Card&aacute;pio</th>
                                        <th class="t-small">Publicado</th>
                                        <th class="t-small"><center>Qtde Agendados</center></th>
                                        
                                
                                    </tr>                                    
                                </thead>
                                <?php
                                        if(isset($_POST['valor'])){
                                            $valor = $_POST['valor'];
                                            if($valor == '')
                                                $valor = '%';
                                        }else{
                                            $valor = "%";
                                        }
                                        require_once './controller/Cardapio_Controller.class.php';
                                        require_once './servicos/CardapioListIterator.class.php';
                                        require_once './servicos/AgendaListIterator.class.php';
                                        require_once './controller/Agenda_Controller.class.php';
                                        $tc = new Cardapio_Controller();
                                        $rs = $tc->lista_cardapio($valor);
                                        $i = 0;
                                        $tipoList = new CardapioListIterator($rs);
                                        $cardapio = new Cardapio();
                                        while($tipoList->hasNextCardapio()){
                                            $cardapio = $tipoList->getNextCardapio();
                                            $cod_cardapio = $cardapio->getCodigo();
                                            $ac = new Agenda_Controller();
                                            $total = $ac->getCodigo($cod_cardapio);
                                     ?>
                                <tbody>
                                    <div class="example">
                                    <?php 
                                            $var = $cardapio->getCodigo()."|".$url;
                                            $codigo_cardapio = $cardapio->getCodigo();
                                            echo "<tr>";
                                            echo "   <td>".$cod_cardapio."</td>";
                                            echo "   <td>".$cardapio->getData()."</td>";                                            
                                            echo "   <td>".$cardapio->getTipo_Refeicao()->getDescricao()."</td>";                                            
                                            $publish = $cardapio->getPublicado();
                                            if($publish == 'N'){
                                                echo "   <td><img src='img/notpublished.png' class=img-responsive title='Não publicado'></td>";    
                                            }else{
                                                echo "   <td><img src='img/published.png' class=img-responsive title='Publicado'></td>";    
                                            }
                                            echo "   <td align='center'><a href=agenda.php?codigo=$codigo_cardapio>".$total."</a></td>";                                                
                                                                                    
                                            echo "   <td class='actions'>
                                                       <button data-nome='".$codigo_cardapio."' data-id='$codigo_cardapio' class='delete btn  btn-danger' title='Excluir card&aacute;pio'>Excluir</button>";
                                            echo "   <td><form action=car_p.php method=post> <input type='hidden' value=".$cardapio->getCodigo()." name=codigo > <input  type='hidden' value=".$url." name=url > <input type='hidden' value=E name=acao >
                                                        <input type='hidden' value=".$cardapio->getData()." name=data> <input type='hidden' value=".$cardapio->getTipo_Refeicao()->getDescricao()." name=tipo>
                                                        <input type='hidden' value=".$cardapio->getCodigo()." name=codigo>
                                                        <button  type='submit' value='submit' class='btn btn-warning' title='Mostrar os itens adicionados a este card&aacute;pio'>Detalhes</button></form></td>";
                                            echo "   <td><form action=cardapio_copy.php method=post> <input type='hidden' value=".$cardapio->getCodigo()." name=codigo > <input  type='hidden' value=".$url." name=url > <input type='hidden' value=E name=acao >
                                                        <input type='hidden' value=".$cardapio->getData()." name=data> <input type='hidden' value=".$cardapio->getTipo_Refeicao()->getDescricao()." name=tipo>
                                                        <input type='hidden' value=".$cardapio->getCodigo()." name=codigo>
                                                        <input type='hidden' value=".$cardapio->getTipo_Refeicao()->getDescricao()." name=tipo>    
                                                        <input type='hidden' value=".$url." name=url>        
                                                        <button  type='submit' value='submit'  class='btn btn-success' title='Criar novo card&aacute;pio com os mesmos itens associado a esta op&ccedil;&atilde;o'>Copiar</button></form></td>";
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
        <script src="js/jquery.datetimepicker.full.js"></script>
        <script>
            
            $("#datepicker").datetimepicker({
                timepicker: false,
                format: 'd/m/Y',
                
            });
            $.datetimepicker.setLocale('pt-BR');
            
            
        </script>
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
