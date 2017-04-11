<?php

function connexion() {
   try
   {
      $dsn = 'mysql:host=localhost; dbname=P5; charset=utf8';
      $username='root';
      $password='';
      
      $bdd = new PDO($dsn, $username, $password);
      $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
      $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
   }

   catch(Exception $e)
   {
      die('Erreur : '.$e->getMessage());
   }

   return $bdd;
}

function compter_articles($bdd) {
   $sql = "SELECT COUNT(id_article) AS nbArt FROM article";
   $req = $bdd->query($sql);
   $data = $req->fetch();
   $data2 = $data['nbArt'];
   return $data2; 
}

function compter_commentaires($bdd) {
   $sql = "SELECT COUNT(id_comm) AS nbComm FROM commentaire";
   $req = $bdd->query($sql);
   $data = $req->fetch();
   $data2 = $data['nbComm'];
   return $data2;
}

function dernier_id($bdd) {
   $sql = "SELECT id_article FROM article ORDER BY id_article DESC";
   $stmt = $bdd->query($sql);
   $result = $stmt->fetch();
   $id=$result['id_article'];
   return $id;
}


function control_get_id($id) {
      $id_int =(int) $id;
      $id1 = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
      
      if ($id1 == 0) {
         header('Location:erreur.php');
      }
      else {
         // on lit le dernier id 
         $bdd = connexion();
         $der_id = dernier_id($bdd);
         $manager = new Manager($bdd);
         

         if ($id1 < 1 || $id1 > $der_id) {
            header('Location:erreur.php');
         }

         $id_bdd = $manager->lire_id($bdd, $id1);
         $donnees = $id_bdd->fetch();

         if ($donnees == FALSE) {
            header('Location:erreur.php');
         }
         else {
            return $id1;
         }

         

        
      }
}
