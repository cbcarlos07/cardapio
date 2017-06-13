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
require '../controller/CPP_Controller.class.php';
require '../beans/Cardapio_Por_Prato.class.php';
$card  = $_POST['cardapio'];
$acao      = $_POST['acao'];
//$url       = $_POST['url'];
$prato     = 0;

$nome  = "";


if(isset($_POST['prato']))
{
    $prato = $_POST['prato'];
}



if(isset($_POST['nome'])){
    $nome = $_POST['nome'];
}

switch ($acao){
    case 'S':
        duplicidade();
        break;
    case 'A':
        duplicidade();
        break;
    case 'E': //excluir
        excluir($card, $prato, $nome);
        break;
    case 'B';     //backup
        backup($card);
        break;
}


/*if($acao == 'S' || $acao == 'A'){
    //$descricao = $_POST['descricao'];
    duplicidade();
    
}else{
    excluir($card, $prato, $nome);
}*/



function backup($cardapio){
    $cpp = new CPP_Controller();
    $deletar = $cpp->deleteBackup($cardapio);


    $teste = $cpp->insertBackup($cardapio);

    $cardDelTemp = $cpp->deleteTemp();
    $cardInsertTemp = $cpp->insertTemp($cardapio);

    if($deletar){
        echo json_encode(array("backup" => 1));
    }else{
        echo json_encode(array("backup" => 0));
    }


}

function duplicidade(){
    //global $descricao;
    //global $url;
    global $prato;
    global $card;
    //$dominio = $_SERVER['HTTP_HOST'];
    $tc   = new CPP_Controller();
    $tste = $tc->verificarDulicidade($card, $prato);
     if($tste > 0){
        echo -1; 
        //echo "<script>alert('A opção que você escolheu já existe' );</script>";
        //echo "<script>window.location='$url'</script>";
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
    }        
    
}
function inserir(){
   
    global $url;
    global $prato;
    global $card;
    
    $tc   = new CPP_Controller();
    $cardapio = new Cardapio_Por_Prato();
    $cardapio->setCardapio($card);
    $cardapio->setPrato($prato);
    $tste = $tc->insert($cardapio);
    //echo "Salvou? $tste";
    if($tste){
        //$dominio = $_SERVER['HTTP_HOST'];
        //
       // $urli    = $_SERVER['REQUEST_URI'];
        
       // header("Location:".$url);
        echo $card;
    }else{
        echo 0;
    }
}

function alterar(){
    
    
    global $url;
    global $prato;
    global $cardapio;
   // echo "Url: ".$url;
    $tc   = new Cardapio_Controller();
    $cardapio = new Cardapio();
    $cardapio->setCodigo($car);
    $cardapio->setData($data);
    $cardapio->setTipo_Refeicao($tipo);    
    $tste = $tc->update($cardapio);
    if($tste){
        $dominio = $_SERVER['HTTP_HOST'];
        echo "<script>alert('Alterado com sucesso' );</script>";
        echo "<script>window.location='$url'</script>";
        //header("Location:".$url);
    }else{
        echo "<br>Nao Alterou eh pra executar o header";
    }
}

function excluir($card, $prato, $nome){

    
    //echo "URl delete: $url";
    $tc   = new CPP_Controller();
    
    $tste = $tc->delete($card, $prato, $nome);
    if($tste){
        //$dominio = $_SERVER['HTTP_HOST'];
        //$urli    = $_SERVER['REQUEST_URI'];
        //header("Location:".$url);
        echo 1;
    }else{
        echo 0;
    }
}


?>
