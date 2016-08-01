<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class TipoRefeicaoList {
    private $_tipo = array();
    private $_tipoCount = 0;
    public function __construct() {
    }
    public function getTipo_RefeicaoCount() {
      return $this->_tipoCount;
    }
    private function setTipo_RefeicaoCount($newCount) {
      $this->_tipoCount = $newCount;
    }
    public function getTipo_Refeicao($_tipoNumberToGet) {
      if ( (is_numeric($_tipoNumberToGet)) && 
           ($_tipoNumberToGet <= $this->getTipo_RefeicaoCount())) {
           return $this->_tipo[$_tipoNumberToGet];
         } else {
           return NULL;
         }
    }
    public function addTipo_Refeicao(Tipo_Refeicao $_tipo_in) {
      $this->setTipo_RefeicaoCount($this->getTipo_RefeicaoCount() + 1);
      $this->_tipo[$this->getTipo_RefeicaoCount()] = $_tipo_in;
      return $this->getTipo_RefeicaoCount();
    }
    public function removeTipo_Refeicao(Tipo_Refeicao $_tipo_in) {
      $counter = 0;
      while (++$counter <= $this->getTipo_RefeicaoCount()) {
        if ($_tipo_in->getAuthorAndTitle() == 
          $this->_tipo[$counter]->getAuthorAndTitle())
          {
            for ($x = $counter; $x < $this->getTipo_RefeicaoCount(); $x++) {
              $this->_tipo[$x] = $this->_tipo[$x + 1];
          }
          $this->setTipo_RefeicaoCount($this->getTipo_RefeicaoCount() - 1);
        }
      }
      return $this->getTipo_RefeicaoCount();
    }
}
