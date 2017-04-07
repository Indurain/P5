<?php
include("../clean_blog/fonctions.php");
$bdd=connexion();

function chargerClasse($classname)
    {
        require '../clean_blog/'.$classname.'.class.'.'php';
    }
spl_autoload_register('chargerClasse');

$manager = new Manager($bdd);
$id = $_GET['id'];
$manager->supprimer_article($id);

include('metas.php');
include('header.php');

echo "L'article a été supprimé."
?>
