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
require '../controller/Cardapio_Controller.class.php';
require '../beans/Cardapio.class.php';
$publicado = "";
$alterado = "";

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

if(isset($_POST['alterado'])){
    $alterado      = $_POST['alterado'];
}

if(isset($_POST['url'])){
    $url       = $_POST['url'];
}else{
    $url = $_GET['url'];
}

if(isset($_POST['descricao'])){
    $descricao = $_POST['descricao'];
}else{
    $descricao =  "";
}


if(isset($_POST['data']))
    $data      = $_POST['data'];

if(isset($_POST['tipo']))
     $tipo      = $_POST['tipo'];

if(isset($_POST['publicado']))
        $publicado = $_POST['publicado'];



if(($acao == 'S' ) || $acao == 'C'){
    //echo "Acao igual  = $acao";
    duplicidade();
    
}else if($acao ==  'E'){
    excluir();
}else if ($acao == 'P'){
    publicar($id, $url, $publicado);
}else if( $acao == 'A'){
    alterar();
}

$codigo_novo = 0;

function duplicidade(){
    global $data;
    global $tipo;
    global $url;
    
    
    $dominio = $_SERVER['HTTP_HOST'];
    $tc   = new Cardapio_Controller();
    //$tste = $tc->verificarDulicidade(date('d/m/Y', strtotime($data)), $tipo);
    $tste = $tc->verificarDulicidade($data, $tipo);
    
     if($tste > 0){
        echo "<script>alert('Informações parecidas com essa já foram adicionadas anteriormente' );</script>";
        echo "<script>window.location='$url'</script>";
    }  else {
        //echo "<script>alert('O nome que ainda n&atilde;o existe: $descricao ' );</script>";
        define_acao();
    }    

    
    
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
            case 'C':
                copiar();
                break;
    }        
    
}
function inserir(){
   
    global $url;
    global $tipo;
    global $data;
    global $descricao;
    global $codigo_novo;
    echo "<script>alert($data)</script>";
    $tc   = new Cardapio_Controller();
    $codigo_novo = $tc->getCodigo();
    $cardapio = new Cardapio();
    $cardapio->setCodigo($codigo_novo);
    $cardapio->setDescricao($descricao);
    $cardapio->setData($data);
    $cardapio->setTipo_Refeicao($tipo);    
    $tste = $tc->insert($cardapio);
    echo "Salvou? $tste";
    echo "<br>Data no action: ".$data;
    if($tste){
        
        header("Location:".$url);
    }
}

function alterar(){
    
    global $id;
    global $url;
    global $tipo;
    global $data;
    global $descricao;
    // echo "Url: ".$url;
    $tc   = new Cardapio_Controller();
    $cardapio = new Cardapio();
    $cardapio->setCodigo($id);
    $cardapio->setData($data);
    $cardapio->setDescricao(strtoupper($descricao));
    $cardapio->setTipo_Refeicao($tipo);    
    $tste = $tc->update($cardapio);
    echo "Tipo refeicao: $tipo";
    if($tste){
        //$dominio = $_SERVER['HTTP_HOST'];
        echo "<script>alert('Alterado com sucesso' );</script>";
        echo "<script>window.location='$url'</script>";
        header("Location:".$url);
    }else{
        echo "<br>Nao Alterou eh pra executar o header";
    }
}

function excluir(){
    
    global $id;
    global $url;
    //echo "URl delete: $url";
    $tc   = new Cardapio_Controller();
    $teste = $tc->verificarCadastro($id);
    if($teste>0){
        //echo "<script>alert('Não é possível deletar este item, verifique se não tem cadastro associado a ele ' );</script>";
        //echo "<script>window.location='$url'</script>";
        echo "Cuidado";
        header("Location: ../erro.php");
    }
    else{
        //echo "Nao existe cadastro: $id";
         $tste = $tc->delete($id);
         echo "Teste excluir: $tste";
        if($tste > 0){
            //$dominio = $_SERVER['HTTP_HOST'];
//            //$urli    = $_SERVER['REQUEST_URI'];
            header("Location:".$url);
            
        }else{
            header("Location: ../erro.php");
        }
    }
   
}

function publicar($id, $url, $publicado){

    require_once '../controller/CPP_Controller.class.php';

    $cpp = new CPP_Controller();
    $tc   = new Cardapio_Controller();        
    $tste = $tc->publicar($id, $publicado);
    $remover = $tc->removeCardapio($id);
    $novo = $cpp->insertTempCardapio($id);
    if($tste){
       echo json_encode(array("retorno" => 1));
    }else{
      //  echo "<br>Nao Alterou eh pra executar o header";
       echo json_encode(array("retorno" => 0));
    }
}


function copiar (){
    global $id;
    global $url;
    global $codigo_novo;
    include '../controller/CPP_Controller.class.php';
    include '../beans/Cardapio_Por_Prato.class.php ';
    include '../servicos/CPPListIterator.class.php';
    
    inserir_copia();
    $cpc = new CPP_Controller();    
    $rs1    = $cpc->pratos_por_cardapio($id);
    $cppListIterator = new CPPListIterator($rs1);
    $cpp   = new Cardapio_Por_Prato();
    $cpp1   = new Cardapio_Por_Prato();
    
    
    while($cppListIterator->hasNextCardapio()){
        $cpp = $cppListIterator->getNextCardapio();
        $cpp1->setCardapio($codigo_novo);
        $cpp1->setPrato($cpp->getPrato());
        $teste = $cpc->insert($cpp1);
        if($teste){
            echo "<script>alert('Cópia realziada com sucesso! ' );</script>";
            echo "<script>window.location='$url'</script>";
        }
        
    }
                                  
                                  
    
    
}

function inserir_copia(){
   
    global $url;
    global $tipo;
    global $data;
    global $descricao;
    global $codigo_novo;
    echo "<script>alert($data)</script>";
    $tc   = new Cardapio_Controller();
    $codigo_novo = $tc->getCodigo();
    $cardapio = new Cardapio();
    $cardapio->setCodigo($codigo_novo);
    $cardapio->setDescricao($descricao);
    $cardapio->setData($data);
    $cardapio->setTipo_Refeicao($tipo);    
    $tste = $tc->insert($cardapio);
    echo "Salvou? $tste";
    echo "<br>Data no action: ".$data;
    if($tste){
        header("Location:".$url);
    }
}



?>
