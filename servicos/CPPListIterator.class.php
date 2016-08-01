<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of CardapioIterator
 *
 * @author CARLOS
 */
class CPPListIterator {
    protected $cardapioList;
    protected $currentCardapio = 0;

    public function __construct(CPPList $cardapioList_in) {
      $this->cardapioList = $cardapioList_in;
    }
    public function getCurrentCardapio() {
      if (($this->currentCardapio > 0) && 
          ($this->cardapioList->getCardapioCount() >= $this->currentCardapio)) {
        return $this->cardapioList->getCardapio($this->currentCardapio);
      }
    }
    public function getNextCardapio() {
      if ($this->hasNextCardapio()) {
        return $this->cardapioList->getCardapio(++$this->currentCardapio);
      } else {
        return NULL;
      }
    }
    public function hasNextCardapio() {
      if ($this->cardapioList->getCardapioCount() > $this->currentCardapio) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
}