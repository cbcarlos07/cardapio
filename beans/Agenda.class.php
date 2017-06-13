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
    private $ds_Email;
    private $refeicao;

    /**
     * @return mixed
     */
    public function getRefeicao()
    {
        return $this->refeicao;
    }

    /**
     * @param mixed $refeicao
     * @return Agenda
     */
    public function setRefeicao($refeicao)
    {
        $this->refeicao = $refeicao;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getDsEmail()
    {
        return $this->ds_Email;
    }

    /**
     * @param mixed $ds_Email
     * @return Agenda
     */
    public function setDsEmail($ds_Email)
    {
        $this->ds_Email = $ds_Email;
        return $this;
    }



    
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