<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class AgendaList {
    private $_agenda = array();
    private $_agendaCount = 0;
    public function __construct() {
    }
    public function getAgendaCount() {
      return $this->_agendaCount;
    }
    private function setAgendaCount($newCount) {
      $this->_agendaCount = $newCount;
    }
    public function getAgenda($_agendaNumberToGet) {
      if ( (is_numeric($_agendaNumberToGet)) && 
           ($_agendaNumberToGet <= $this->getAgendaCount())) {
           return $this->_agenda[$_agendaNumberToGet];
         } else {
           return NULL;
         }
    }
    public function addAgenda(Agenda $_agenda_in) {
      $this->setAgendaCount($this->getAgendaCount() + 1);
      $this->_agenda[$this->getAgendaCount()] = $_agenda_in;
      return $this->getAgendaCount();
    }
    public function removeAgenda(Agenda $_agenda_in) {
      $counter = 0;
      while (++$counter <= $this->getAgendaCount()) {
        if ($_agenda_in->getAuthorAndTitle() == 
          $this->_agenda[$counter]->getAuthorAndTitle())
          {
            for ($x = $counter; $x < $this->getAgendaCount(); $x++) {
              $this->_agenda[$x] = $this->_agenda[$x + 1];
          }
          $this->setAgendaCount($this->getAgendaCount() - 1);
        }
      }
      return $this->getAgendaCount();
    }
}
