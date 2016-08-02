<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$usuario = strtoupper($_POST['usuario']);
$acao = $_POST['acao'];
if(isset($_POST['senha'])){
    $senha = $_POST['senha'];
}
require_once './controller/Usuario_Controller.class.php';
$usuario_Controller = new Usuario_Controller();


switch ($acao){
    case 'E':
        recuperarEmpresa();
        break;
    case 'L':
        login();
        break;
}

function recuperarEmpresa(){
    global $usuario;
    global $usuario_Controller;
    
    $empresa = $usuario_Controller->recuperarEmpresa($usuario);
    //echo "Recuperar empresa";
    //echo json_encode(array('response' => 1));
    echo json_encode(array('response' => $empresa));
    
}


function login (){
    global $usuario;
    global $usuario_Controller;
    global $senha;
    
    $pwd = $usuario_Controller->recuperarSenha($usuario);
    //echo "Senha do banco: $pwd Senha do usuario: $senha\n";
    if($pwd == $senha){
        echo 1;
    }else{
        echo 0;
    }
    

}

