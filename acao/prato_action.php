<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tipo_action
 *
 * @author CARLOS
 */
echo "<meta charset='UTF-8'>";
require '../controller/Prato_Controller.class.php';
require '../beans/Prato.class.php';

if(isset($_POST['codigo'])){
    $id        = $_POST['codigo'];
}else{
    $id = $_GET['codigo'];
}
$descricao = "";

if(isset($_POST['acao'])){
    $acao      = $_POST['acao'];
}else{
    $acao = $_GET['acao'];
}

if(isset($_POST['url'])){
    $url       = $_POST['url'];
}else{
    $url = $_GET['url'];
}

if(isset($_POST['tipo'])){
$tipo      = $_POST['tipo'];
}


if(isset($_POST['ingrediente'])){
    $ingrediente = $_POST['ingrediente'];
}



if($acao == 'S' || $acao == 'A'){
    $descricao = $_POST['descricao'];
    duplicidade();
    
}else{
    excluir();
}



function duplicidade(){
    global $descricao;
    global $url;
    
    $dominio = $_SERVER['HTTP_HOST'];
    $tc   = new Prato_Controller();
    $tste = $tc->verificarDulicidade($descricao);
//    if($descricao == ""){
//        echo "<script>alert('O campo para cadastro não pode ficar vazio' );</script>";
//        echo "<script>window.location='$url'</script>";
//    }
//    else if($tste > 0){
//        echo "<script>alert('O nome que você digitou já existe' );</script>";
//        echo "<script>window.location='$url'</script>";
//    }  else {
        //echo "<script>alert('O nome que ainda n&atilde;o existe: $descricao ' );</script>";
        define_acao();
  //  }    

    
    
}

function define_acao(){
    global $acao;
    switch ($acao){
            case 'S':
                 inserir();
                break;
            case 'A':
                alterar();
                break;
    }        
    
}
function inserir(){
    global $descricao;
    global $url;
    global $tipo;
    global $ingrediente;
    $tc   = new Prato_Controller();
    $prato = new Prato();
    $prato->setNome(strtoupper($descricao));
    $prato->setTipo_prato($tipo);
    $prato->setDs_ingrediente(strtoupper($ingrediente));            
    $tste = $tc->insert($prato);
    if($tste){
        $dominio = $_SERVER['HTTP_HOST'];
        $urli    = $_SERVER['REQUEST_URI'];
        header("Location:".$url);
    }
}

function alterar(){
    global $descricao;
    global $id;
    global $url;
    global $tipo;
    global $ingrediente;
   // echo "Url: ".$url;
    $tc   = new Prato_Controller();
    $prato = new Prato();
    $prato->setCodigo($id);
    $prato->setNome($descricao);
    $prato->setTipo_prato($tipo);
    $prato->setDs_ingrediente($ingrediente);       
    $tste = $tc->update($prato);
    if($tste){
        $dominio = $_SERVER['HTTP_HOST'];
        echo "<script>alert('Alterado com sucesso' );</script>";
        echo "<script>window.location='$url'</script>";
        //header("Location:".$url);
    }else{
        echo "<br>Nao Alterou eh pra executar o header";
    }
}

function excluir(){
    
    global $id;
    global $url;
    echo "URl delete: $url";
    $tc   = new Prato_Controller();
    $teste = $tc->verificarCadastro($id);
    if($teste>0){
        header("Location: ../erro.php");
    }else{
        $tste = $tc->delete($id);
        if($tste){
        $dominio = $_SERVER['HTTP_HOST'];
        //$urli    = $_SERVER['REQUEST_URI'];
        header("Location:".$url);
        }
    }
    
    
}


?>
