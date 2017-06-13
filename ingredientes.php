<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$_prato = $_GET['busca'];    
$_SESSION['codigo'] = $_GET['card'];
require_once './beans/Prato.class.php';
require_once './controller/Prato_Controller.class.php';
$tc = new Prato_Controller();
$prato = $tc->recuperar_prato($_prato);
if($_prato > 0){
?>
<form action="" method="post" id="cardapio-salvar">
   <input type="hidden" name="url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" >
   <input type="hidden" name="acao" value="S">
   <input type="hidden" id="prato" name="prato" value="<?php echo $_prato; ?>">
   <input type="hidden" id="cardapio" name="cardapio" value="<?php echo $_SESSION['codigo']; ?>">
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
   <button type="submit" class="btn btn-primary" onclick="salvar(1)">Adicionar</button>

</form>
<?php
}
else{
    
}
?>