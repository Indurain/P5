<?php
include '../clean_blog/fonctions.php';
$bdd=connexion();

function chargerClasse($classname)
    {
        require '../clean_blog/'.$classname.'.class.'.'php';
    }
spl_autoload_register('chargerClasse');

$manager = new Manager($bdd);
$id = $_GET['id'];
$article_manager = $manager->lire_article($id);
$donnees = $article_manager->fetch();

// Créer objet de la classe Article avec les données lus par le manager
$article = new Article($donnees);

$manager->supprimer_article($article);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'metas.php'; ?>
</head>
<?php  include 'header.php';

echo "L'article a été supprimé."
?>
