
<?php 
$_cardarpio = $_GET['cardapio'];
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
  $rs1    = $cpc->lista_tipo_pratos($_cardarpio);
  $tpList = new TPListIterator($rs1);

  $cpp   = new Cardapio_Por_Prato();




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
                $rs    = $cpc->lista_pratos($_cardarpio, $tipo_cd);
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

                <a href="#" class="list-group-item"  onmouseover="toolTip('<b>Ingredientes</b><br><?php echo $ingredientes; ?>', 300, 350)" onmouseout="toolTip()" style="text-transform: uppercase;">
                 <?php echo $cpp->getPrato()->getNome();  ?>
                                                    
                     <a  data-nome="<?php echo $_cardarpio; ?>"  data-id="<?php echo $cpp->getPrato()->getCodigo(); ?>" class="delete close botao" data-dismiss="modal" >&times;</a>
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
<script>
  $('.delete').on('click',function(){
     alert('Teste'); 
  });
    
</script>
    