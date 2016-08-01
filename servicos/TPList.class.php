<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class TPList {
    private $_tipo = array();
    private $_tipoCount = 0;
    public function __construct() {
    }
    public function getTipo_PratoCount() {
      return $this->_tipoCount;
    }
    private function setTipo_PratoCount($newCount) {
      $this->_tipoCount = $newCount;
    }
    public function getTipo_Prato($_tipoNumberToGet) {
      if ( (is_numeric($_tipoNumberToGet)) && 
           ($_tipoNumberToGet <= $this->getTipo_PratoCount())) {
           return $this->_tipo[$_tipoNumberToGet];
         } else {
           return NULL;
         }
    }
    public function addTipo_Prato(Tipo_Prato $_tipo_in) {
      $this->setTipo_PratoCount($this->getTipo_PratoCount() + 1);
      $this->_tipo[$this->getTipo_PratoCount()] = $_tipo_in;
      return $this->getTipo_PratoCount();
    }
    public function removeTipo_Prato(Tipo_Prato $_tipo_in) {
      $counter = 0;
      while (++$counter <= $this->getTipo_PratoCount()) {
        if ($_tipo_in->getAuthorAndTitle() == 
          $this->_tipo[$counter]->getAuthorAndTitle())
          {
            for ($x = $counter; $x < $this->getTipo_PratoCount(); $x++) {
              $this->_tipo[$x] = $this->_tipo[$x + 1];
          }
          $this->setTipo_PratoCount($this->getTipo_PratoCount() - 1);
        }
      }
      return $this->getTipo_PratoCount();
    }
}
