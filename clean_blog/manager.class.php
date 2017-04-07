<?php 

class Manager {
  
   private $_bdd; // Instance de PDO.
   private $_perPage = 5;  //Variable pour la pagination
   private $_page = 1;     // Idem

   public function __construct($bdd)
   {
      $this->setDb($bdd);
   }

   public function setDb(PDO $bdd)
   {
      $this->_bdd = $bdd;
    
   }

}