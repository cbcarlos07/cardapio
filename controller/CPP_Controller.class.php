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

class CPP_Controller {
    
    public function insert (Cardapio_Por_Prato $cpp){
        require_once '../model/Cardapio_Por_Prato_DAO.class.php';
        $td = new Cardapio_Por_Prato_DAO();
        $teste = $td->insert($cpp);
        return $teste;
    }
    public function update (Cardapio $tp){
        $td = new Cardapio_DAO();
        $teste = $td->update($tp);
        return $teste;
    }
    
    public function delete($card, $prato){
        require '../model/Cardapio_Por_Prato_DAO.class.php';
        $td = new Cardapio_Por_Prato_DAO();
        $teste = $td->delete($card, $prato);
        return $teste;
    }
    
     public function  verificarDulicidade($card, $prato){
        require '../model/Cardapio_Por_Prato_DAO.class.php';
        $td = new Cardapio_Por_Prato_DAO();
        $teste = $td->verificarDulicidade($card, $prato);
        return $teste;
     }
     
     public function  lista_pratos($desc, $tipo_prato){
         require_once  '/model/Cardapio_Por_Prato_DAO.class.php';
         $td = new Cardapio_Por_Prato_DAO();
         $teste = $td->lista_pratos($desc, $tipo_prato);
         return $teste;
     }
     
     public function  lista_tipo_pratos($cardapio){
          require_once  '/model/Cardapio_Por_Prato_DAO.class.php';
         $td = new Cardapio_Por_Prato_DAO();
         $teste = $td->lista_tipo_pratos($cardapio);
         return $teste;
     }
             
     
     public function  recuperar_prato($id){
         require_once '/model/Cardapio_DAO.class.php';
         $td = new Cardapio_DAO();
         $teste = $td->recuperar_prato($id);
         return $teste;
     }
     
     public function  getCodigo($codigo){
         require '/model/Cardapio_Por_Prato_DAO.class.php';
         $td = new Cardapio_Por_Prato_DAO();
         $teste = $td->getCodigo($codigo);
         return $teste;
     }
     
     public function  pratos_por_cardapio($cardapio){
         require_once '../model/Cardapio_Por_Prato_DAO.class.php';
         $td = new Cardapio_Por_Prato_DAO();
         $teste = $td->pratos_por_cardapio($cardapio);
         return $teste;
     }
}
