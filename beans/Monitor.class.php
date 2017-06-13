<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Monitor{
    private $entrada;
    private $saida;
    private $presentes;
    private $satisfacao;
    
    public function getEntrada() {
        return $this->entrada;
    }

    public function getSaida() {
        return $this->saida;
    }

    public function getPresentes() {
        return $this->presentes;
    }

    public function getSatisfacao() {
        return $this->satisfacao;
    }

    public function setEntrada($entrada) {
        $this->entrada = $entrada;
        return $this;
    }

    public function setSaida($saida) {
        $this->saida = $saida;
        return $this;
    }

    public function setPresentes($presentes) {
        $this->presentes = $presentes;
        return $this;
    }

    public function setSatisfacao($satisfacao) {
        $this->satisfacao = $satisfacao;
        return $this;
    }


}