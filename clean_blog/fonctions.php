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