<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of AgendaIterator
 *
 * @author CARLOS
 */
class AgendaListIterator {
    protected $agendaList;
    protected $currentAgenda = 0;

    public function __construct(AgendaList $agendaList_in) {
      $this->agendaList = $agendaList_in;
    }
    public function getCurrentAgenda() {
      if (($this->currentAgenda > 0) && 
          ($this->agendaList->getAgendaCount() >= $this->currentAgenda)) {
        return $this->agendaList->getAgenda($this->currentAgenda);
      }
    }
    public function getNextAgenda() {
      if ($this->hasNextAgenda()) {
        return $this->agendaList->getAgenda(++$this->currentAgenda);
      } else {
        return NULL;
      }
    }
    public function hasNextAgenda() {
      if ($this->agendaList->getAgendaCount() > $this->currentAgenda) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
}