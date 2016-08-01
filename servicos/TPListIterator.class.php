<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of TipoIterator
 *
 * @author CARLOS
 */
class TPListIterator {
    protected $tipoList;
    protected $currentTipo = 0;

    public function __construct(TPList $tipoList_in) {
      $this->tipoList = $tipoList_in;
    }
    public function getCurrentTipo() {
      if (($this->currentTipo > 0) && 
          ($this->tipoList->getTipoCount() >= $this->currentTipo)) {
        return $this->tipoList->getTipo_Prato($this->currentTipo);
      }
    }
    public function getNextTipo() {
      if ($this->hasNextTipo()) {
        return $this->tipoList->getTipo_Prato(++$this->currentTipo);
      } else {
        return NULL;
      }
    }
    public function hasNextTipo() {
      if ($this->tipoList->getTipo_PratoCount() > $this->currentTipo) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
}