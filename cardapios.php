<?php
  session_start();

if(isset($_POST['valor'])){
    $valor = $_POST['valor'];
    if($valor == '')
        $valor = '%';
}else{
    $valor = "%";
}

$pagina = (isset($_POST['pagina'])) ? $_POST['pagina'] : 1;

require_once './controller/Cardapio_Controller.class.php';
require_once './servicos/CardapioListIterator.class.php';
require_once './servicos/AgendaListIterator.class.php';
require_once './controller/Agenda_Controller.class.php';
$tc = new Cardapio_Controller();

$total = $tc->contarRegistros();

//seta a quantidade de itens por pagina
$registros = 20;

//calcula o número de páginas arredondando o resultado para cima
$numPaginas = ceil($total  / $registros);

//variavel para calcular o início da visualização com base na página atual
$inicio = ($registros*$pagina)-$registros;

$limite = $pagina *  $registros;
$rs = $tc->lista_cardapio($valor, $inicio, $limite);




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
        <link rel="stylesheet" href="css/jquery.datetimepicker.min.css">
        <link rel="stylesheet" href="css/agenda.css">
        
        <link href="css/example.css" media="screen" rel="stylesheet" type="text/css" />
        <script src="lib/jquery.js" type="text/javascript"></script>
        <script src="js/busca.js" type="text/javascript"></script>
        
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
                                    <label for="tipo" class="control-label">Data da Refei&ccedil;&atilde;o</label>
                                    <input  type="text" id="datepicker" class="form-control" placeholder="Data da Refei&ccedil;&atilde;o" name="valor" >
                                    
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
                                        <th class="t-small">Data</th>
                                        <th class="t-small">Descri&ccedil;&atilde;o</th>
                                        <th class="t-small">Tipo de Card&aacute;pio</th>
                                        <th class="t-small">Publicado</th>
                                        <th class="t-small"><center>Qtde Agendados</center></th>
                                        
                                
                                    </tr>                                    
                                </thead>
                             
                                <tbody id="resultado">
                                    
                                    <?php 

                                        $i = 0;
                                        $tipoList = new CardapioListIterator($rs);
                                        $cardapio = new Cardapio();
                                        while($tipoList->hasNextCardapio()){
                                            $cardapio = $tipoList->getNextCardapio();
                                            $cod_cardapio = $cardapio->getCodigo();
                                            $ac = new Agenda_Controller();
                                            $total = $ac->getCodigo($cod_cardapio);
                                            $var = $cardapio->getCodigo()."|".$url;
                                            $codigo_cardapio = $cardapio->getCodigo();
                                            //$data = date('d/m/Y',strtotime($cardapio->getData()));
                                            $data = $cardapio->getData();
                                            echo "<tr>";
                                            echo "   <td>".$cod_cardapio."</td>";
                                            echo "   <td>".$data."</td>";  
                                            echo "   <td>".$cardapio->getDescricao()."</td>";  
                                            echo "   <td>".$cardapio->getTipo_Refeicao()->getDescricao()."</td>";                                            
                                            $publish = $cardapio->getPublicado();
                                            if($publish == 'N'){
                                                echo "   <td><img src='img/notpublished.png' class=img-responsive title='Não publicado'></td>";    
                                            }else{
                                                echo "   <td><img src='img/published.png' class=img-responsive title='Publicado'></td>";    
                                            }
                                            echo "   <td align='center'><a href=agenda.php?codigo=$codigo_cardapio&data=$data&ref=".$cardapio->getTipo_Refeicao()->getCodigo().">".$total."</a></td>";                                                
                                            echo "   <td>
                                                        <form action=cardapio_alt.php method=post> <input type='hidden' value=".$cardapio->getCodigo()." name=codigo > <input  type='hidden' value=".$url." name=url > <input type='hidden' value=E name=acao >                                                            
                                                            <input type='hidden' value=".$_SERVER['REQUEST_URI']." name=url>
                                                            <input type='hidden' value=".$cardapio->getCodigo()." name=cardapio>
                                                            <button  type='submit' value='submit' class='btn btn-default' title='Mostrar os itens adicionados a este card&aacute;pio'>Alterar</button>
                                                        </form>
                                                     </td>";                                        
                                            echo "   <td class='actions'>
                                                       <button data-nome='".$codigo_cardapio."' data-id='$codigo_cardapio' class='delete btn  btn-danger' title='Excluir card&aacute;pio'>Excluir</button>";
                                            echo "   <td><form action=car_p.php method=post > 
                                                        <input type='hidden' value=".$cardapio->getCodigo()." name=codigo > <input  type='hidden' value=".$url." name=url > <input type='hidden' value=E name=acao >
                                                        <input type='hidden' value=".$cardapio->getData()." name=data> <input type='hidden' value=".$cardapio->getTipo_Refeicao()->getDescricao()." name=tipo>
                                                        <input type='hidden' value=".$cardapio->getCodigo()." name=codigo>
                                                        <input type='hidden' value='".false."' name=recarrega>
                                                        <input type='hidden' value='0' name=alterado>
                                                        <button  type='submit' value='submit' data-id='$codigo_cardapio'  class='btn btn-warning btn-detail' title='Mostrar os itens adicionados a este card&aacute;pio'>Detalhes</button></form>
                                                        </td>";
                                            echo "   <td><form action=cardapio_copy.php method=post> <input type='hidden' value=".$cardapio->getCodigo()." name=codigo > <input  type='hidden' value=".$url." name=url > <input type='hidden' value=E name=acao >
                                                        <input type='hidden' value=".$cardapio->getData()." name=data> <input type='hidden' value=".$cardapio->getTipo_Refeicao()->getDescricao()." name=tipo>
                                                        <input type='hidden' value=".$cardapio->getCodigo()." name=codigo>
                                                        <input type='hidden' value=".$cardapio->getTipo_Refeicao()->getDescricao()." name=tipo>    
                                                        <input type='hidden' value=".$url." name=url>        
                                                        <button  type='submit' value='submit'  class='btn btn-success' title='Criar novo card&aacute;pio com os mesmos itens associado a esta op&ccedil;&atilde;o'>Copiar</button></form></td>";
                                            echo "</tr>";
                                        }
                                    ?>
                                       
                                </tbody>
                            </table>
                        </div>
                                
                    </div>


                    <!-- INICIO DA PAGINAÇÃO -->
                    <div class="footer" style="text-align: center;">
                            <div id="buttom" >
                                <div class="col-md-12">
                                    <ul class="pagination">
                                        <?php

                                        if($pagina == 1){
                                            ?>
                                            <li class="disabled">
                                                <a href="#"
                                                   data-url="<?php echo $_SERVER['PHP_SELF']; ?>"
                                                   data-page="">&lt; Anterior</a>
                                            </li>
                                            <?php
                                        }else{
                                            ?>
                                            <li class="page-item">  <a href="#"
                                                                       data-url="<?php echo $_SERVER['PHP_SELF']; ?>"
                                                                       data-page="<?php echo $pagina-1; ?>"
                                                                       class="btn-page">&lt; Anterior</a>
                                            </li>
                                            <?php
                                        }

                                        for($i = 1; $i < $numPaginas + 1; $i++){
                                            $disabled = "";

                                            if($pagina == $i){
                                                $disabled = "active";
                                            }
                                            ?>

                                            <li class="<?php echo $disabled; ?>">
                                                <a href="#"
                                                   data-url="<?php echo $_SERVER['PHP_SELF']; ?>"
                                                   data-page="<?php echo $i; ?>"
                                                   class="btn-page"
                                                ><?php echo $i; ?>
                                                </a>
                                            </li>

                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if($numPaginas > 1){
                                            ?>
                                            <?php
                                            if($pagina == $numPaginas){
                                                ?>
                                                <li class="disabled"><a href="#"
                                                                        data-url="<?php echo $_SERVER['PHP_SELF']; ?>"
                                                                        data-page="<?php echo $pagina + 1; ?>"
                                                    >Pr&oacute;ximo &gt; </a>
                                                </li>
                                                <?php
                                            }else {
                                                ?>
                                                <li class="next"><a href="#"
                                                                    data-url="<?php echo $_SERVER['PHP_SELF']; ?>"
                                                                    data-page="<?php echo $pagina + 1; ?>"
                                                                    class="btn-page">Pr&oacute;ximo &gt; </a>
                                                </li>
                                                <?php
                                            }
                                        }
                                        ?>

                                    </ul>
                                </div>


                            </div>
                    </div>
                    <!-- FIM DA PAGINAÇÃO -->


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

        <script>


            $('.btn-page').on('click', function(){
                //alert('Pagina');
                var url      = $(this).data('url');
                var pagina   = $(this).data('page');
                var form     = $('<form action="'+url+'" method="post">'+
                    '<input type="hidden" name="pagina" value="'+pagina+'">'+
                    '</form>');
                $('body').append(form);
                form.submit();

            });
        </script>


        <script>
            $('.btn-detail').on('click',function(){

               // alert('enviar');
                var id = $(this).data('id');
                $.ajax({
                    url : 'acao/cpp_action.php',
                    type: 'post',
                    dataType: 'json',
                    data :{
                        cardapio : id,
                        acao     : 'B'
                    },
                    success : function (data) {
                       // alert('Retorno: '+data.backup);
                        console.log("Backup: "+data.backup);
                        if(data.backup === 1){
                           // alert('Backup realizado: '+data.backup);
                            //$('#form-detalhes').submit(); //enviar os valores.
                        }else{
                           // alert('problema no backup: '+data.backup);
                        }
                    }
                });
               // return false;
                
            });
        </script>
         
         
    </body>
</html>
