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

class Cardapio_Controller {
    
    public function insert (Cardapio $tp){
        require_once '../model/Cardapio_DAO.class.php';
        $td = new Cardapio_DAO();
        $teste = $td->insert($tp);
        return $teste;
    }
    public function update (Cardapio $tp){
        require_once '../model/Cardapio_DAO.class.php';
        $td = new Cardapio_DAO();
        $teste = $td->update($tp);
        return $teste;
    }
    
    public function delete($codigo){
        require_once '../model/Cardapio_DAO.class.php';
        $td = new Cardapio_DAO();
        $teste = $td->delete($codigo);
        return $teste;
    }
    
    public function  verificarCadastro($cd){
        require_once '../model/Cardapio_DAO.class.php';
        $td = new Cardapio_DAO();
        $teste = $td->verificarCadastro($cd);
        return $teste;        
    }
     public function  verificarDulicidade($data, $cd){
        require '../model/Cardapio_DAO.class.php';
        $td = new Cardapio_DAO();
        $teste = $td->verificarDulicidade($data, $cd);
        return $teste;
     }
     
     public function  lista_Cardapio($desc,$inicio, $fim){
         require_once 'model/Cardapio_DAO.class.php';
         $td = new Cardapio_DAO();
         $teste = $td->lista_cardapio($desc, $inicio, $fim);
         return $teste;
     }
     
     public function  recuperar_prato($id){
         require_once '/model/Cardapio_DAO.class.php';
         $td = new Cardapio_DAO();
         $teste = $td->recuperar_prato($id);
         return $teste;
     }
      public function  recuperar_cardapio($id){
         require_once '/model/Cardapio_DAO.class.php';
         $td = new Cardapio_DAO();
         $teste = $td->recuperar_cardapio($id);
         return $teste; 
      }
     public function  contarRegistros(){
         require_once '/model/Cardapio_DAO.class.php';
         $td = new Cardapio_DAO();
         $teste = $td->contarRegistros();
         return $teste;
     }
     
     public function publicar ($cardapio, $opcao){
         require_once '../model/Cardapio_DAO.class.php';
          $td = new Cardapio_DAO();
         $teste = $td->publicar($cardapio, $opcao);
         return $teste;
     }
     
     public function  getCodigo(){
          require_once '../model/Cardapio_DAO.class.php';
          $td = new Cardapio_DAO();
          $teste = $td->getCodigo();
          return $teste;
     }

    public function removeCardapio ($cardapio){
        require_once '../model/Cardapio_DAO.class.php';
        $td = new Cardapio_DAO();
        $teste = $td->removeCardapio($cardapio);
        return $teste;
    }

}
