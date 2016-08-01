<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Prato {
    private $codigo;
    private $nome;
    private $tipo_prato;
    private $ds_ingrediente;
    public function getCodigo() {
        return $this->codigo;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getTipo_prato() {
        return $this->tipo_prato;
    }

    public function getDs_ingrediente() {
        return $this->ds_ingrediente;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
        return $this;
    }

    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    public function setTipo_prato($tipo_prato) {
        $this->tipo_prato = $tipo_prato;
        return $this;
    }

    public function setDs_ingrediente($ds_ingrediente) {
        $this->ds_ingrediente = $ds_ingrediente;
        return $this;
    }




}