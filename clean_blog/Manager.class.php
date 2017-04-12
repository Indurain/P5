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
      $type = "art";
      $id_clean = control_get_id($id, $type);
    
      $req = $this->_bdd->prepare('SELECT id_article As idArt, titre, auteur_art AS auteurArt, chapo, contenu_art AS contenuArt, date_der_modif_art AS dateDerModifArt, a_comm AS aComm FROM article WHERE id_article = :id');
      $req->bindValue(':id', $id_clean, PDO::PARAM_INT);

      $req->execute();

      return $req;
   } 

   public function lire_commentaire($bdd)
   {
      $id = $_GET['idComm'];
      $type = "comm";
      $id_clean = control_get_id_comm($id, $type);
    
      $req = $this->_bdd->prepare('SELECT id_comm As idComm, auteur_comm AS auteurComm, contenu_comm AS contenuComm, date_der_modif_comm AS dateDerModifComm FROM commentaire WHERE id_comm = :id');
      
      $req->bindValue(':id', $id_clean, PDO::PARAM_INT);

      $req->execute();

      return $req;
   }

   public function modifier_article(Article $narticle)
   {
      
      $q = $this->_bdd->prepare('UPDATE article 
      SET titre = :titre, auteur_art = :auteur, chapo = :chapo, contenu_art = :contenu, date_der_modif_art = now()
      WHERE id_article = :id');

      $q->bindValue(':titre', $narticle->titre(),PDO::PARAM_STR);
      $q->bindValue(':auteur', $narticle->auteurArt(), PDO::PARAM_STR);
      $q->bindValue(':chapo', $narticle->chapo(), PDO::PARAM_STR);
      $q->bindValue(':contenu', $narticle->contenuArt(), PDO::PARAM_STR);
      $q->bindValue(':id', $narticle->idArt(), PDO::PARAM_INT);
      $q->execute();

   }

   public function changer_comm_exists($comm_exists) 
   {
      $q = $this->_bdd->prepare('UPDATE article
      SET a_comm = :comm_exists
      WHERE id_article = :id');

      $q->bindValue(':comm_exists', $comm_exists, PDO::PARAM_INT);
      $q->bindValue(':id', $_GET['id'], PDO::PARAM_INT);

      $q->execute();
   }

   public function lister_commentaires()
   {
      $req = $this->_bdd->prepare('SELECT id_comm AS idComm, auteur_comm AS auteurComm, contenu_comm AS contenuComm, date_der_modif_comm AS dateDerModifComm FROM commentaire WHERE article_id = ?');
      $req->execute(array($_GET['id']));
      
      return $req;
   }

   public function ajouter_commentaire(Commentaire $commentaire)
   { 
      $q = $this->_bdd->prepare('INSERT INTO commentaire (auteur_comm, date_der_modif_comm, contenu_comm, article_id) VALUES(:auteur_comm, now(), :contenu_comm, :article_id)');

      $q->bindValue(':auteur_comm', $commentaire->auteurComm(), PDO::PARAM_STR);
      $q->bindValue(':contenu_comm', $commentaire->contenuComm(), PDO::PARAM_STR);
      $q->bindValue(':article_id', $commentaire->articleId(), PDO::PARAM_INT);
      
      $q->execute();
   }

   public function supprimer_article($article)
   {

      $q = $this->_bdd->prepare('DELETE FROM article WHERE id_article = :id');
      $q->bindValue(':id', $article->idArt(), PDO::PARAM_INT);
      $q->execute();
   }

   public function supprimer_comm($commentaire)
   { 
      $q = $this->_bdd->prepare('DELETE FROM commentaire WHERE id_comm = :id');
      $q->bindValue(':id', $commentaire->idComm(), PDO::PARAM_INT);
      $q->execute();
   }

   

    

   public function modifier_commentaire(Commentaire $comm) {
      $q = $this->_bdd->prepare('UPDATE commentaire 
      SET auteur_comm = :auteur, contenu_comm = :contenu, date_der_modif_comm = now()
      WHERE id_comm = :id');

      $q->bindValue(':auteur', $comm->auteurComm(), PDO::PARAM_STR);
      $q->bindValue(':contenu', $comm->contenuComm(), PDO::PARAM_STR);
      $q->bindValue(':id', $comm->idComm(), PDO::PARAM_INT);
      $q->execute();

   }

   public function lire_id($bdd, $id1) {
      $req = $this->_bdd->prepare('SELECT id_article FROM article WHERE id_article = :id');
      $req->bindValue(':id', $id1, PDO::PARAM_INT);
      $req->execute();
      return $req;
   }

   public function lire_id_comm($bdd, $id1) {
      $req = $this->_bdd->prepare('SELECT id_comm FROM commentaire WHERE id_comm = :id');
      $req->bindValue(':id', $id1, PDO::PARAM_INT);
      $req->execute();
      return $req;
   }

}