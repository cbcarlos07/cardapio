<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Agenda_Controller{
    public function  getCodigo($codigo){
        require_once './model/Agenda_DAO.class.php';
        $ag = new Agenda_DAO();
        $teste = $ag->getCodigo($codigo);
        return $teste;
    }
    
    public function  getLista($codigo, $nome){
        require_once './model/Agenda_DAO.class.php';
        $ag = new Agenda_DAO();
        $teste = $ag->getLista($codigo, $nome);
        return $teste;
    }
    
}