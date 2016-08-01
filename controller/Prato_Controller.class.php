<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tipo_Controller
 *
 * @author CARLOS
 */

class Prato_Controller {
    
    public function insert (Prato $tp){
        require_once '../model/Prato_DAO.class.php';
        $td = new Prato_DAO();
        $teste = $td->insert($tp);
        return $teste;
    }
    public function update (Prato $tp){
        $td = new Prato_DAO();
        $teste = $td->update($tp);
        return $teste;
    }
    
    public function delete($codigo){
        require_once '../model/Prato_DAO.class.php';
        $td = new Prato_DAO();
        $teste = $td->delete($codigo);
        return $teste;
    }
    
     public function  verificarDulicidade($descricao){
        require '../model/Prato_DAO.class.php';
        $td = new Prato_DAO();
        $teste = $td->verificarDulicidade($descricao);
        return $teste;
     }
     
     public function  lista_prato($desc){
         require 'model/Prato_DAO.class.php';
         $td = new Prato_DAO();
         $teste = $td->lista_prato($desc);
         return $teste;
     }
     
     public function  recuperar_prato($id){
         require_once '/model/Prato_DAO.class.php';
         $td = new Prato_DAO();
         $teste = $td->recuperar_prato($id);
         return $teste;
     }
     
     public function  contarRegistros(){
         $td = new Prato_DAO();
         $teste = $td->contarRegistros($desc);
         return $teste;
     }
     
     public function  verificarCadastro($cd){
         require_once  '../model/Prato_DAO.class.php';
         $td = new Prato_DAO();
         $teste = $td->verificarCadastro($cd);
         return $teste;
     }
}
