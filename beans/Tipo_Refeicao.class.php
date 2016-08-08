<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Tipo_Refeicao {
    private $codigo;
    private $descricao;
    private $horarioInicial;
    private $horarioFinal;
    private $prazo;
    
    public function getPrazo() {
        return $this->prazo;
    }

    public function setPrazo($prazo) {
        $this->prazo = $prazo;
        return $this;
    }

        public function getHorarioInicial() {
        return $this->horarioInicial;
    }

    public function getHorarioFinal() {
        return $this->horarioFinal;
    }

    public function setHorarioInicial($horarioInicial) {
        $this->horarioInicial = $horarioInicial;
        return $this;
    }

    public function setHorarioFinal($horarioFinal) {
        $this->horarioFinal = $horarioFinal;
        return $this;
    }

       
        public function getCodigo() {
        return $this->codigo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
        return $this;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
        return $this;
    }


}