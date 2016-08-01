
<?php
    session_start();
    if(isset($_POST['url'])){
        $url   = $_POST['url'];
        $data  = $_POST['data'];
        $tipo  = $_POST['tipo'];
        $card  = $_POST['codigo'];
        $_SESSION['url']    = $url;
        $_SESSION['data']   = $data;
        $_SESSION['tipo']   = $tipo;
        $_SESSION['codigo'] = $card;
        
        
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
              function sucesso(msg){
		var mensagem = $('.mensagem');
                var msg = '<b>Sucesso! </b>'+msg;
		mensagem.empty().html('<div class="alert alert-success">'+msg+'</div>').fadeIn("fast");                
		//setTimeout(function (){location.reload()},1500);
		//window.setTimeout()
		//delay(2000);
	}
         </script>
         
         <script type="text/javascript">
            function demorar(){
                 setTimeout(function(){
                document.form1.submit();
                },1000)
             }
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
                    <div class="text-center"><h1>Adicionar Item ao Card&aacute;pio</h1></div>
                    <div class="text-center"><h2><?php echo $_SESSION['data']; ?> | <?php echo $_SESSION['tipo']; ?></h2></div>
                    <div class="container">
                        <div class="col-md-6">
                            <div class="row">
                                <form action="car_p.php" method="post" name="card" id="form_list">
                                                      <div class="form-group ">
                                                          <label for="prato">Selecione um prato da lista</label>
                                                          <select id="select" name="prato" required="" class="form-control" onchange="mostra()" >
                                                              <option value="">Selecione</option>
                                                              <?php 
                                                                    require_once './controller/Prato_Controller.class.php';
                                                                    require_once './servicos/PratoListIterator.class.php';
                                                                    $tc = new Prato_Controller();
                                                                    $rs = $tc->lista_prato(strtoupper($valor));
                                                                    $i = 0;
                                                                    $tipoList = new PratoListIterator($rs);
                                                                    $prato = new Prato();
                                                                    while($tipoList->hasNextPrato()){
                                                                        $prato = $tipoList->getNextPrato();
                                                                        echo "<option value=".$prato->getCodigo().">".$prato->getNome()."</option>";
                                                                    }    
                                                              ?>
                                                          </select>
                                                      </div>
                                    </form>
                             </div>
                            <div class="row">
                                <?php 
                                  if(isset($_POST['prato'])){
                                     $codigo =  $_POST['prato'];
                                     $prato = $tc->recuperar_prato($codigo);
                                ?>
                                <form action="acao/cpp_action.php" method="post">
                                    <input type="hidden" name="url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" >
                                    <input type="hidden" name="acao" value="S">
                                    <input type="hidden" name="prato" value="<?php echo $codigo; ?>">
                                    <input type="hidden" name="cardapio" value="<?php echo $_SESSION['codigo']; ?>">
                                    <div class="form-group">
                                         <label for="tipo">Tipo de Prato:</label>
                                         <input class="form-control" type="text" name="tipo" id="tipo" value="<?php echo $prato->getTipo_prato()->getDescricao(); ?>">
                                    </div>
                                    <div class="form-group">
                                         <label for="nome">Nome do Prato:</label>
                                         <input class="form-control" type="text" name="nome" id="tipo" value="<?php echo $prato->getNome(); ?>">
                                    </div> 
                                    <div class="form-group">
                                         <label for="ingrediente">Ingrediente:</label>
                                         <textarea rows="5" class="form-control" type="text" name="ingrediente" id="ingrediente" ><?php echo $prato->getDs_ingrediente(); ?></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Adicionar</button>
                                </form>
                                <?php     
                                  }
                                ?>
                            </div>
                       </div>  
                        <div class="col-md-6">
                            
                            <?php 
                              include './controller/CPP_Controller.class.php';
                              include './beans/Cardapio_Por_Prato.class.php ';
                              include_once  './beans/Tipo_Prato.class.php ';
                              include './servicos/CPPListIterator.class.php';
                              include './servicos/TPListIterator.class.php';
                              
                              $cpc = new CPP_Controller();
                              //$number = $cpc->getCodigo($_SESSION['codigo']);
                             
                              //if($number > 0){
                                    
                                  //echo "Numero: $number";
                                  
                                  $tipo = new Tipo_Prato();
                                  $rs1    = $cpc->lista_tipo_pratos($_SESSION['codigo']);
                                  $tpList = new TPListIterator($rs1);
                                  
                                  $cpp   = new Cardapio_Por_Prato();
                                  
                                  
                                  
                                ?>
                            <hr />
                            <div class="col-xs-6 col-md-6">
                               <?php 
            
                                    while($tpList->hasNextTipo()){
                                   
                                        $tipo = $tpList->getNextTipo();
                                        $tipo_cd = $tipo->getCodigo();
                                        
                                            //    echo "Dentro do se";
                                                   
                                 ?>
            
                                <div class="list-group">
                                        <?php  $prato_desc = $tipo->getDescricao(); ?>          
                                    <a class="list-group-item active" data-toggle="collapse" href="#<?php echo $prato_desc; ?>" aria-expanded="false" aria-controls="collapsePrincipal">
                                   <?php echo $prato_desc; ?>
                                    </a>
                                        <?php
                                                $tp = $tipo->getDescricao();
                                                $rs    = $cpc->lista_pratos($_SESSION['codigo'], $tipo_cd);
                                                $cList = new CPPListIterator($rs);
                                       
                                         ?>
                                    <!--<div class="collapse" id="collapseExample">-->
                                    <div  class="collapse in" id="<?php echo $prato_desc; ?>">
                                        <div class="card card-block col-md-offset-1">
                                            
                                            <ul >
                                                
                                                <?php
                                                     while($cList->hasNextCardapio()){
                                                        $cpp = $cList->getNextCardapio();
                                                        $v =  $cpp->getTipo_prato()->getDescricao();
                                                        if($v == $tp){
                                                            $ingredientes = $cpp->getPrato()->getDs_ingrediente();
                                                ?>
                                                
                                                <a href="#" class="list-group-item"  onmouseover="toolTip('<b>Ingredientes</b><br><?php echo $ingredientes; ?>', 300, 350)" onmouseout="toolTip()"><?php echo $cpp->getPrato()->getNome();  ?>
                                                    <form action=acao/cpp_action.php method=post> 
                                                            <input type='hidden' value="<?php echo $cpp->getPrato()->getCodigo(); ?>" name=prato > 
                                                            <input type='hidden' value="<?php echo $_SESSION['codigo']; ?>" name=cardapio > 
                                                            <input type='hidden' value="<?php echo $_SERVER['REQUEST_URI']; ?>" name=url > 
                                                            <input type='hidden' value=E name=acao > 
                                                            <button type="submit" class="close botao" data-dismiss="modal" onclick="return verifica('Tem certeza de que deseja excluir o item selecionado?');">&times;</button>
                                                        </form>
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
                                
                                
                                   
                                <form action="acao/cardapio_action.php" method="post" name="form1" id="form1" >
                                    <input type="hidden" name="acao" value="P">
                                    <input type="hidden" name="codigo" value="<?php echo $_SESSION['codigo']; ?>"> 
                                    <input type="hidden" name="url" value="<?php echo $_SERVER['REQUEST_URI'];; ?>">
                                    <?php
                                    include './controller/Cardapio_Controller.class.php';
                                    include_once  './beans/Cardapio.class.php';
                                     $cardapio_ = new Cardapio();
                                     $card_controller = new Cardapio_Controller();
                                     $cardapio_ = $card_controller->recuperar_cardapio($_SESSION['codigo']);
                                     
                                     $card_rec = $cardapio_->getPublicado();
                                     if($card_rec == 'N'){
                                    ?>
                                    
                                    
                                    <input type="hidden" name="publicado" value="S">
                                    
                                    <a id="btn-success" type="submit" class="btn btn-primary" onclick="sucesso('O cardapio foi publicado!'); demorar()">Publicar</a>
                                   
                                    <?php 
                                     }
                                     else{
                                    ?>
                                    <input type="hidden" name="publicado" value="N">
                                    <a id="btn-success" type="submit" class="btn btn-success" onclick="sucesso('O cardapio foi despublicado!');demorar()">Despublicar</a>
                                    <?php
                                     }
                                    ?>
                                    <a href="<?php echo $_SESSION['url'] ?>" class="btn btn-danger">Cancelar</a>
                                </form> 
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
