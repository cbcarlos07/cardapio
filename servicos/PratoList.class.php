<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class PratoList {
    private $_prato = array();
    private $_pratoCount = 0;
    public function __construct() {
    }
    public function getPratoCount() {
      return $this->_pratoCount;
    }
    private function setPratoCount($newCount) {
      $this->_pratoCount = $newCount;
    }
    public function getPrato($_pratoNumberToGet) {
      if ( (is_numeric($_pratoNumberToGet)) && 
           ($_pratoNumberToGet <= $this->getPratoCount())) {
           return $this->_prato[$_pratoNumberToGet];
         } else {
           return NULL;
         }
    }
    public function addPrato(Prato $_prato_in) {
      $this->setPratoCount($this->getPratoCount() + 1);
      $this->_prato[$this->getPratoCount()] = $_prato_in;
      return $this->getPratoCount();
    }
    public function removePrato(Prato $_prato_in) {
      $counter = 0;
      while (++$counter <= $this->getPratoCount()) {
        if ($_prato_in->getAuthorAndTitle() == 
          $this->_prato[$counter]->getAuthorAndTitle())
          {
            for ($x = $counter; $x < $this->getPratoCount(); $x++) {
              $this->_prato[$x] = $this->_prato[$x + 1];
          }
          $this->setPratoCount($this->getPratoCount() - 1);
        }
      }
      return $this->getPratoCount();
    }
}
