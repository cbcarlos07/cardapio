<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Agenda {
    private $cardapio;
    private $cod_Funcionario;
    private $nm_Funcionario;
    
    public function getCardapio() {
        return $this->cardapio;
    }

    public function getCod_Funcionario() {
        return $this->cod_Funcionario;
    }

    public function getNm_Funcionario() {
        return $this->nm_Funcionario;
    }

    public function setCardapio($cardapio) {
        $this->cardapio = $cardapio;
        return $this;
    }

    public function setCod_Funcionario($cod_Funcionario) {
        $this->cod_Funcionario = $cod_Funcionario;
        return $this;
    }

    public function setNm_Funcionario($nm_Funcionario) {
        $this->nm_Funcionario = $nm_Funcionario;
        return $this;
    }


    
}