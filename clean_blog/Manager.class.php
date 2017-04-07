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

   public function ajouter_article(Article $article)
   {

      $q = $this->_bdd->prepare('INSERT INTO article(auteur_art, date_der_modif_art, titre, chapo, contenu_art ) VALUES(:auteur, now(), :titre, :chapo, :contenu)');

      $q->bindValue(':auteur', $article->auteurArt(), PDO::PARAM_STR);
      $q->bindValue(':titre', $article->titre(),PDO::PARAM_STR);
      $q->bindValue(':chapo', $article->chapo(), PDO::PARAM_STR);
      $q->bindValue(':contenu', $article->contenuArt(), PDO::PARAM_STR);
     
      $q->execute();

   }

   public function lire_article($bdd)
   {
      $id = $_GET['id'];
      
      
      $req = $this->_bdd->prepare('SELECT id_article As idArt, titre, auteur_art AS auteurArt, chapo, contenu_art AS contenuArt, date_der_modif_art AS dateDerModifArt, a_comm AS aComm FROM article WHERE id_article = :id');
      $req->bindValue(':id', $id, PDO::PARAM_INT);

      $req->execute();
      
      return $req;
   } 

}