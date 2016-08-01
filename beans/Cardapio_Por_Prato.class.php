<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Cardapio_Por_Prato{
   private $cardapio;
   private $prato;
   private $tipo_prato;
   
   
   public function getTipo_prato() {
       return $this->tipo_prato;
   }

   public function setTipo_prato($tipo_prato) {
       $this->tipo_prato = $tipo_prato;
       return $this;
   }

      public function getCardapio() {
       return $this->cardapio;
   }

   public function getPrato() {
       return $this->prato;
   }

   public function setCardapio($cardapio) {
       $this->cardapio = $cardapio;
       return $this;
   }

   public function setPrato($prato) {
       $this->prato = $prato;
       return $this;
   }


   
}
