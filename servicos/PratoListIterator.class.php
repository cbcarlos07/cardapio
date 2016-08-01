<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of PratoIterator
 *
 * @author CARLOS
 */
class PratoListIterator {
    protected $pratoList;
    protected $currentPrato = 0;

    public function __construct(PratoList $pratoList_in) {
      $this->pratoList = $pratoList_in;
    }
    public function getCurrentPrato() {
      if (($this->currentPrato > 0) && 
          ($this->pratoList->getPratoCount() >= $this->currentPrato)) {
        return $this->pratoList->getPrato($this->currentPrato);
      }
    }
    public function getNextPrato() {
      if ($this->hasNextPrato()) {
        return $this->pratoList->getPrato(++$this->currentPrato);
      } else {
        return NULL;
      }
    }
    public function hasNextPrato() {
      if ($this->pratoList->getPratoCount() > $this->currentPrato) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
}