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

class Tipo_Prato_Controller {
    
    public function insert (Tipo_Prato $tp){
        require_once '../model/Tipo_Prato_DAO.class.php';
        $td = new Tipo_Prato_DAO();
        $teste = $td->insert($tp);
        return $teste;
    }
    public function update (Tipo_Prato $tp){
        $td = new Tipo_Prato_DAO();
        $teste = $td->update($tp);
        return $teste;
    }
    
    public function delete($codigo){
       // require '../model/Tipo_Prato_DAO.class.php';
        $td = new Tipo_Prato_DAO();
        $teste = $td->delete($codigo);
        return $teste;
    }
    
     public function  verificarDulicidade($descricao){
        require '../model/Tipo_Prato_DAO.class.php';
        $td = new Tipo_Prato_DAO();
        $teste = $td->verificarDulicidade($descricao);
        return $teste;
     }
     
     public function  lista_tipo($desc){
         require 'model/Tipo_Prato_DAO.class.php';
         $td = new Tipo_Prato_DAO();
         $teste = $td->lista_tipo($desc);
         return $teste;
     }
     
     public function  recuperar_tipo($id){
         require_once '/model/Tipo_Prato_DAO.class.php';
         $td = new Tipo_Prato_DAO();
         $teste = $td->recuperar_tipo($id);
         return $teste;
     }
     
     public function  contarRegistros(){
         $td = new Tipo_Prato_DAO();
         $teste = $td->contarRegistros($desc);
         return $teste;
     }
     
     public function  verificarCadastro($cd){
          require_once '../model/Tipo_Prato_DAO.class.php';
          $td = new Tipo_Prato_DAO();
          $teste = $td->verificarCadastro($cd);
          return $teste;
     }
}
