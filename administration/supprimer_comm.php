<?php
include("../clean_blog/fonctions.php");
$bdd=connexion();

function chargerClasse($classname)
    {
        require '../clean_blog/'.$classname.'.class.'.'php';
    }
spl_autoload_register('chargerClasse');

$manager = new Manager($bdd);
$id = $_GET['idComm'];

$manager->supprimer_comm($id);

include('metas.php');
include('header.php');

echo "Le commentaire a été supprimé."
?>




