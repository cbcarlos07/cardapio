<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cardapio
 *
 * @author CARLOS
 */
class Cardapio {
    private $codigo;
    private $data;
    private $tipo_Refeicao;
    private $publicado;
    
    public function getPublicado() {
        return $this->publicado;
    }

    public function setPublicado($publicado) {
        $this->publicado = $publicado;
        return $this;
    }

    
    public function getCodigo() {
        return $this->codigo;
    }

    public function getData() {
        return $this->data;
    }

    public function getTipo_Refeicao() {
        return $this->tipo_Refeicao;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
        return $this;
    }

    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    public function setTipo_Refeicao($tipo_Refeicao) {
        $this->tipo_Refeicao = $tipo_Refeicao;
        return $this;
    }




}
