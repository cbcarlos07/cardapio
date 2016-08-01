<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class CPPList {
    private $_cardapio = array();
    private $_cardapioCount = 0;
    public function __construct() {
    }
    public function getCardapioCount() {
      return $this->_cardapioCount;
    }
    private function setCardapioCount($newCount) {
      $this->_cardapioCount = $newCount;
    }
    public function getCardapio($_cardapioNumberToGet) {
      if ( (is_numeric($_cardapioNumberToGet)) && 
           ($_cardapioNumberToGet <= $this->getCardapioCount())) {
           return $this->_cardapio[$_cardapioNumberToGet];
         } else {
           return NULL;
         }
    }
    public function addCardapio(Cardapio_Por_Prato $_cardapio_in) {
      $this->setCardapioCount($this->getCardapioCount() + 1);
      $this->_cardapio[$this->getCardapioCount()] = $_cardapio_in;
      return $this->getCardapioCount();
    }
    public function removeCardapio(Cardapio_Por_Prato $_cardapio_in) {
      $counter = 0;
      while (++$counter <= $this->getCardapioCount()) {
        if ($_cardapio_in->getAuthorAndTitle() == 
          $this->_cardapio[$counter]->getAuthorAndTitle())
          {
            for ($x = $counter; $x < $this->getCardapioCount(); $x++) {
              $this->_cardapio[$x] = $this->_cardapio[$x + 1];
          }
          $this->setCardapioCount($this->getCardapioCount() - 1);
        }
      }
      return $this->getCardapioCount();
    }
}
