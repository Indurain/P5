<?php
include '../clean_blog/fonctions.php';
$bdd=connexion();

function chargerClasse($classname)
    {
        require '../clean_blog/'.$classname.'.class.'.'php';
    }
spl_autoload_register('chargerClasse');

$manager = new Manager($bdd);
$id = $_GET['idComm'];
$comm_manager = $manager->lire_commentaire($id);
$donnees = $comm_manager->fetch();

// Créer objet de la classe Article avec les données lus par le manager
$commentaire = new Commentaire($donnees);

$manager->supprimer_comm($commentaire);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'metas.php'; ?>
</head>
<?php  include 'header.php'; 

echo "Le commentaire a été supprimé."
?>




