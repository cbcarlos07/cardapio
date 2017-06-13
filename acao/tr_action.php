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
//echo "<meta charset='UTF-8'>";
require '../controller/Tipo_Refeicao_Controller.class.php';
require '../beans/Tipo_Refeicao.class.php';
if(isset($_POST['codigo']))
$id        = $_POST['codigo'];
else
    $id = $_GET['codigo'];


$descricao = "";

if(isset($_POST['acao']))
$acao      = $_POST['acao'];
else{
    $acao      = $_GET['acao'];
}

if(isset($_POST['url']))
$url       = $_POST['url'];
else
    $url       = $_GET['url'];

if(isset($_POST['horainicial'])){
$horai     = $_POST['horainicial'];
$horaf     = $_POST['horafinal'];
$prazo     = $_POST['prazo'];
}


if(isset($_POST['cancelamento'])){
    $cancelar = $_POST['cancelamento'];
}else{
    $cancelar = "";
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
    $tc   = new Tipo_Refeicao_Controller();
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
   // }    

    
    
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
    global $horai;
    global $horaf;
    global $prazo;
    global $cancelar;
    $tc   = new Tipo_Refeicao_Controller();
    $tipo = new Tipo_Refeicao();
    $tipo->setDescricao(strtoupper($descricao));
    $tipo->setHorarioInicial($horai);
    $tipo->setHorarioFinal($horaf);
    $tipo->setPrazo($prazo);
    $tipo->setCancelar($cancelar);
    $tste = $tc->insert($tipo);
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
    global $horai;
    global $horaf;
    global $prazo;
    global $cancelar;
    echo "Url: ".$url;
    echo "<br> Codigo: $id, hora final: $horaf";
    $tc   = new Tipo_Refeicao_Controller();
    $tipo = new Tipo_Refeicao();
    $tipo->setCodigo($id);
    $tipo->setDescricao(strtoupper($descricao));
    $tipo->setHorarioInicial($horai);
    $tipo->setHorarioFinal($horaf);
    $tipo->setPrazo($prazo);
    $tipo->setCancelar($cancelar);
    $tste = $tc->update($tipo);
    if($tste){
        $dominio = $_SERVER['HTTP_HOST'];
        //$urli    = $_SERVER['REQUEST_URI'];
        echo "Alterou eh pra executar o header";
        
        header("Location:".$url);
    }else{
        echo "<br>Nao Alterou eh pra executar o header";
    }
}

function excluir(){
    
    global $id;
    global $url;
    echo "URl delete: $url";
    $tc   = new Tipo_Refeicao_Controller();
    $teste = $tc->verificarCadastro($id);
    
    if($teste){
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
