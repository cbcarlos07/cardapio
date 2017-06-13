<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$_tipo = $_GET['busca'];


require_once './controller/Prato_Controller.class.php';
require_once './servicos/PratoListIterator.class.php';
$tc = new Prato_Controller();
$rs = $tc->lista_prato_combo($_tipo);
$i = 0;
$tipoList = new PratoListIterator($rs);
$prato = new Prato();
?>

<select id="select" name="prato" required="" class="form-control" onchange="search()" >
    <option value="0">Selecione</option>
<?php
while($tipoList->hasNextPrato()){
    $prato = $tipoList->getNextPrato();
    
    echo "<option value=".$prato->getCodigo().">".$prato->getNome()."</option>";
}
?>
</select> 