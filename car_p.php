
<?php
    session_start();


    if(isset($_POST['alterado'])){
        $alter = $_POST['alterado'];
       // echo "<script>alert('recebendo: $alter')</script>";

        $alterado = $alter;

        $_SESSION['alterado'] = $alterado;
    }else{
        if(isset($_SESSION['alterado'])){
            $alterado =  $_SESSION['alterado'] ;
        }

    }


    if(isset($_POST['url'])){
        $url   = $_POST['url'];
        $data  = $_POST['data'];
        $tipo  = $_POST['tipo'];
        $card  = $_POST['codigo'];
        $refresh = $_POST['recarrega'];


        $_SESSION['url']    = $url;
        $_SESSION['data']   = $data;
        $_SESSION['tipo']   = $tipo;
        $_SESSION['codigo'] = $card;
        $_SESSION['refresh'] = $refresh;

    }else{
        $url = $_SESSION['url']  ;
        $data = $_SESSION['data'];
        $tipo = $_SESSION['tipo'];
        $card = $_SESSION['codigo'];
        $refresh = $_SESSION['refresh'];

    }

$is_dev = true;

function debug() {
    global $is_dev;

    if ($is_dev) {
        $debug_arr = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $line = $debug_arr[0]['line'];
        $file = $debug_arr[0]['file'];

        header('Content-Type: text/plain');

        echo "linha: $line\n";
        echo "arquivo: $file\n\n";
        print_r(array('GET' => $_GET, 'POST' => $_POST, 'SERVER' => $_SERVER));
        exit;
    }
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
        <script type="text/javascript" src="js/tooltip.js"></script>
        
        
         <script type="text/javascript">
            /*  function sucesso(msg){
	     	    var mensagem = $('.mensagem');
                var msg = '<b>Sucesso! </b>'+msg;
                mensagem.empty().html('<div class="alert alert-success">'+msg+'</div>').fadeIn("fast");*/
		//setTimeout(function (){location.reload()},1500);
		//window.setTimeout()
		//delay(2000);
	//}
         </script>
         



         
         
    </head>
    <body >
        <?php
        //debug();
         include './include/div_nav.php';
         echo 'Alterado: '.$_SESSION['alterado'];
         echo 'Refresh: '.$refresh;
         if(!$refresh){
            // echo 'Refresh: '.$refresh;
             header("Refresh:0");
             $_SESSION['refresh'] = true;
         }else{
            // echo 'Refresh: falso '.$refresh;
         }

        ?>
        <hr>
        <div id="main1" class="container-fluid">
            <div id="main1" class="row">
                <!-- $_SERVER['HTTP_HOST']  -- dominio
                     $_SERVER['REQUEST_URI']  -- url atual; 
                -->
                <div class="col-md-12">
                    <div class="text-center"><h1>Adicionar Item ao Card&aacute;pio</h1></div>
                    <div class="text-center"><h2><?php echo $_SESSION['data']; ?> | <?php echo $_SESSION['tipo']; ?> | <?php echo $_SESSION['codigo']; ?></h2></div>
                    <div class="container">
                        <div class="col-md-6">
                            <div class="row">
                                <form action="car_p.php" method="post" name="card" id="form_list">
                                                        <div class="form-group ">
                                                          <label for="tipo">Selecione Um Tipo De Prato</label>
                                                          <select id="tipo_prato" name="tipo" required="" class="form-control"  onchange="carregar('combo_pratos')">
                                                              <option value="0">Selecione</option>
                                                              <?php 
                                                                    require_once './controller/Tipo_Prato_Controller.class.php';
                                                                    require_once './servicos/TPListIterator.class.php';
                                                                    $tPratoController = new Tipo_Prato_Controller();
                                                                    $rs0 = $tPratoController->lista_tipo("");
                                                                    $j = 0;
                                                                    $tipoPratoIt = new TPListIterator($rs0);
                                                                    $tPrato = new Tipo_Prato();
                                                                    while($tipoPratoIt->hasNextTipo()){
                                                                        $tPrato = $tipoPratoIt->getNextTipo();
                                                                        echo "<option value=".$tPrato->getCodigo().">".$tPrato->getDescricao()."</option>";
                                                                    }   
                                                              ?>
                                                          </select>
                                                      </div>
                                                      <div class="form-group ">
                                                          <input type="hidden" id="cod-card" name="cod-par" value="<?php echo $_SESSION['codigo']; ?>" />
                                                          <label for="prato">Selecione um prato da lista</label>
                                                          <div id="combo_pratos">
                                                               
                                                                <select id="select" name="prato" required="" class="form-control" onchange="search()" >
                                                                    <option value="">Selecione</option>
                                                                </select>
                                                          </div>    
                                                      </div>
                                    </form>
                             </div>
                            <div class="row" >
                                
                                    
                            <div id="nm_prato">
                                <form action="" method="post" id="cardapio-salvar">
                                    
                                </form>
                            </div>     
                                    
                                <div class="message">
                                    
                                </div>    
                            </div>
                       </div>

                       <div class="col-md-6">

                            <?php

                              include './controller/CPP_Controller.class.php';
                              include './beans/Cardapio_Por_Prato.class.php ';
                              include_once  './beans/Tipo_Prato.class.php ';
                              include './servicos/CPPListIterator.class.php';
                              include_once  './servicos/TPListIterator.class.php';
                              
                              $cpc = new CPP_Controller();
                              //$number = $cpc->getCodigo($_SESSION['codigo']);
                             
                              //if($number > 0){
                                    
                                  //echo "Numero: $number";
                                  
                                  $tipo = new Tipo_Prato();
                                  $rs1    = $cpc->lista_tipo_pratos($_SESSION['codigo']);
                                  $tpList = new TPListIterator($rs1);
                                 // echo "<script>alert('Buscar pratos: ')</script>";
                                  $cpp   = new Cardapio_Por_Prato();
                                  
                                  
                                  
                                ?>
                            <hr />
                            <div class="col-xs-6 col-md-12">
                             <div id="liscardapio">
                                <?php 
            
                                    while($tpList->hasNextTipo()){
                                   
                                        $tipo = $tpList->getNextTipo();
                                        $tipo_cd = $tipo->getCodigo();
                                        
                                            //    echo "Dentro do se";
                                                   
                                 ?>
            
                                <div class="list-group" >
                                        <?php  $prato_desc = $tipo->getDescricao(); ?>          
                                    <a class="list-group-item active col-md-12" data-toggle="collapse" href="#<?php echo $prato_desc; ?>" aria-expanded="false" aria-controls="collapsePrincipal">
                                   <?php echo $prato_desc; ?>
                                    </a>
                                        <?php
                                                $tp = $tipo->getDescricao();
                                                $rs    = $cpc->lista_pratos($_SESSION['codigo'], $tipo_cd);
                                                $cList = new CPPListIterator($rs);
                                       
                                         ?>
                                    <!--<div class="collapse" id="collapseExample">-->
                                    <div  class="collapse in" id="<?php echo $prato_desc; ?>">
                                        <div class=" card-block col-md-offset-1">
                                            
                                            <ul >
                                                
                                                <?php
                                                     while($cList->hasNextCardapio()){
                                                        $cpp = $cList->getNextCardapio();
                                                        $v =  $cpp->getTipo_prato()->getDescricao();
                                                        if($v == $tp){
                                                            $ingredientes = $cpp->getPrato()->getDs_ingrediente();
                                                        ?>
                                                
                                                        <a href="#" class="list-group-item"  onmouseover="toolTip('<b>Ingredientes</b><br><?php echo $ingredientes; ?>', 300, 350)" onmouseout="toolTip()" style="text-transform: uppercase;"><?php echo $cpp->getPrato()->getNome();  ?>

                                                            <a  data-user="<?php echo $_SESSION['usuario']; ?>"
                                                                data-cardapio="<?php echo $_SESSION['codigo']; ?>"
                                                                data-acao="P"
                                                                data-alterado="<?php echo $_SESSION['alterado']; ?>"
                                                                data-prato="<?php echo $cpp->getPrato()->getCodigo(); ?>"
                                                                class="delete close botao" data-dismiss="modal" >&times;</a>

                                                        </a>
                                                        <?php
                                                            } // fim do se
                                                        }// fim enquanto de dentro
                                                     ?>
                                            </ul>
                                        </div>
                                    </div>

                
                
                                </div>
                                
                                <?php
                                    } // fim do primeiro enquanto
                                ?>
                                
                                </div>
                                   

                                    <?php
                                    include './controller/Cardapio_Controller.class.php';
                                    include_once  './beans/Cardapio.class.php';
                                     $cardapio_ = new Cardapio();
                                     $card_controller = new Cardapio_Controller();
                                     //echo "Codigo do cardapio: ".$_SESSION['codigo'];
                                     $cardapio_ = $card_controller->recuperar_cardapio($_SESSION['codigo']);
                                     
                                     $card_rec = $cardapio_->getPublicado();
                                     echo "<input type='hidden' id='publicado' value='$card_rec'>";
                                     if($card_rec == 'N') {
                                         $textoBotao = "Salvar e publicar";
                                         $snpublicar = "S";
                                         $class = "btn-primary";

                                     }
                                       else{
                                             $textoBotao = "Despublicar";
                                             $snpublicar = "N";
                                             $class = "btn-despublicar";
                                             $class = "btn-success";
                                         }
                                    ?>
                                    
                                    
                                    <input type="hidden" name="publicado"value="<?php echo $snpublicar; ?>">
                                <?php echo "Alterado: ".$_SESSION['alterado']; ?>
                                    <a
                                       class="btn <?php echo $class; ?> btn-publicar"
                                       data-acao="P"
                                       data-cardapio="<?php echo $_SESSION['codigo']; ?>"
                                       data-url="<?php echo $_SERVER['REQUEST_URI']; ?>"
                                       data-publicar="<?php echo $snpublicar; ?>"
                                       data-alterado="<?php echo $_SESSION['alterado']; ?>"
                                    ><?php echo $textoBotao; ?></a>
                                   

                                    <a href="<?php echo $_SESSION['url'] ?>" class="btn btn-danger">Cancelar</a>

                            </div>           
                           
                              <div class="row col-md-12 mensagem">
                                <div class="alert  ">
                                  <!--  <strong>Success!</strong> Indicates a successful or positive action.-->
                                 </div>
                           </div> 
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
                <span class="mensagem"></span>
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

         <script type="text/javascript">
            function mostra() {
                //var comboPratos = document.getElementById("select");
              
                //var codigo =  comboPratos.options[comboPratos.selectedIndex].value;
                //var formulario = document.getElementById("form_list");
                //formulario.submit();
                
            }
            

         </script>
         <script type="text/javascript" src="js/tipo_prato.js"></script>
        <script type="text/javascript" src="js/prato.js"></script>
        <script type="text/javascript" src="js/cardapio-salvar.js"></script>
        <script language="javascript">
             $('.delete').on('click', function(){
                var cardapio = $(this).data('cardapio'); // vamos buscar o valor do atributo data-name que temos no botão que foi clicado
                var prato = $(this).data('prato'); // vamos buscar o valor do atributo data-id
                var public = document.getElementById("publicado").value;
                var alterado = $(this).data('alterado');
             //   alert('Click para remover: '+alterado);
                var mensagem;
                 var acao     = $(this).data('acao');
                 var usuario = $(this).data('user');
                //alert('Delete');
                if(public ==  'S'){
                    mensagem = 'Para que você possa realizar qualquer altração é necessário que o cardapio esteja despublicado.<br> Deseja continuar?';


                    $('span.mensagem').html(mensagem); // inserir na o nome na pergunta de confirmação dentro da modal
                    //$('a.delete-yes').attr('href', 'acao/tr_action.php?codigo=' +id+'&acao=E&url=<?php echo $url; ?>'); // mudar dinamicamente o link, href do botão confirmar da modal
                    $('a.delete-yes').on('click', function(){
                     //   alert('Clicado na opcao sim: '+alterado);
                        var url      = "";
                        var publicar = "N";
                        $.ajax({
                            url  : 'acao/cardapio_action.php',
                            type : 'post',
                            dataType : 'json',
                            data : {
                                acao      : acao,
                                codigo    : cardapio,
                                url       : url,
                                publicado : publicar
                            },
                            success : function (data) {
                              //  alert("Retorno da action: "+data.retorno+ ' '+typeof data.retorno);
                                if(data.retorno == 1){
                                    if( publicar === 'S' ){
                                      //  alert('Alterando mensagem: '+alterado);
                                        sucesso('O cardapio foi publicado', alterado);
                                    }else{
                                    //    alert('Não Publicar cardapio '+alterado);
                                        sucesso('O cardapio foi despublicado', alterado)
                                    }
                                }else{
                                  //  alert('Alterando mensagem: falso');
                                }
                                $('#myModal').modal('hide');

                            }
                        });


                    });

                }else{
                    mensagem = 'Deseja mesmo retirar item do cardápio ?';
                    $('span.mensagem').html(mensagem); // inserir na o nome na pergunta de confirmação dentro da modal
                    //$('a.delete-yes').attr('href', 'acao/tr_action.php?codigo=' +id+'&acao=E&url=<?php echo $url; ?>'); // mudar dinamicamente o link, href do botão confirmar da modal
                    $('a.delete-yes').on('click', function(){
                        //alert('Deletar');

                        // alert('Usuario: '+usuario);
                        excluir(cardapio, prato, usuario, 1);


                    });
                }




                $('#myModal').modal('show'); // modal aparece
          });
         </script>
    </body>
</html>
