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

    public function  getAlmocou($data, $chapa, $refeicao){
        require_once './model/Agenda_DAO.class.php';
        $ag = new Agenda_DAO();
        $teste = $ag->getAlmocou($data, $chapa, $refeicao);
        return $teste;
    }

    public function  getEmail($cd){
        require_once '../model/Agenda_DAO.class.php';
        $ag = new Agenda_DAO();
        $teste = $ag->getEmail($cd);
        return $teste;
    }

    public function getEmailFuncionario($cracha){
        require_once '../model/Agenda_DAO.class.php';
        $ag = new Agenda_DAO();
        $teste = $ag->getEmailFuncionario($cracha);
        return $teste;
    }

    public function  getTotalAgendados($cd){
        require_once '../model/Agenda_DAO.class.php';
        $ag = new Agenda_DAO();
        $teste = $ag->getTotalAgendados($cd);
        return $teste;
    }
}