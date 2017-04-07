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

   public function lire_liste_articles($bdd)
   {
      

      // Fonctionnalité de pagination pour lister 5 articles par page
   
      //  Appel à fonction qui me donne le nombre d'articles qu'il y a dans la base puis conversion en entier
      $nArticles = compter_articles($bdd);
    
      // Variable pour stocker le nombre d'articles par page
      $perPage = 5;
    
      // Variable qui contiendra le nombre de pages qu'il y aura en fonction du nombre d'articles et d'articles/page. 
      $nbPages = ceil($nArticles/$perPage);

      if (isset($_GET['p']) && $_GET['p']>0 && $_GET['p'] <= $nbPages) 
      {
         $cPage = $_GET['p'];
      } 
      else 
      {
         $cPage = 1;
      }

      // Création variable pour requête
      $calcul = ($cPage-1)*5;
   
      $requete = "SELECT id_article AS idArt, auteur_art AS auteurArt, date_der_modif_art AS dateDerModifArt, titre, chapo, contenu_art AS contenuArt, a_comm AS aComm  FROM article ORDER BY date_der_modif_art DESC LIMIT $calcul, $perPage";
      $reponse = $bdd->query($requete); 

      return $reponse;
   }

}