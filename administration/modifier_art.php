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

if (isset($_POST['valider'])) {
            /*connexion bdd */
            $nbdd=connexion();
        
            /*Création objet $manager de la classe Manager */
            $nmanager = new Manager($nbdd);

            $id_clean = control_get_id($_GET['id']);
            /* Création array pour stocker les données reçus du formulaire, on les transmettra ensuite en paramètres au constructeur de la classe Article */
            $ndonnees= array('idArt' => $id_clean, 'auteurArt' => $_POST['auteur'], 'titre' => $_POST['titre'], 'chapo' => $_POST['chapo'], 'contenuArt' => $_POST['message'] );

            /*Création objet $article de la classe Article */
            $narticle = new Article($ndonnees);
        
            /* Appel de la méthode ajouter article de la classe Manager */
            $nmanager->modifier_article($narticle);

            header('Location:index.php');
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'metas.php'; ?>
</head>

<body>

<?php  include 'header.php'; ?>
<!-- Post Content -->
    <article>
        <div class="container">
            <form method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
                <div class="row control-group">
                <h3>Nom</h3>
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        
                        <input type="text" class="form-control" id="auteur" name="auteur" value="<?php echo htmlspecialchars($article->auteurArt()) ?>" required data-validation-required-message="Please enter your name.">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="row control-group">
                <h3>Titre de l'article</h3>
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        
                        <input type="text" class="form-control" id="titre" name="titre" value="<?php echo htmlspecialchars($article->titre()); ?>" required data-validation-required-message="S'il vous plaît, entrez un titre">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="row control-group">
                <h3>Chapô</h3>
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <input type="tel" class="form-control" id="chapo" name="chapo" value="<?php echo htmlspecialchars($article->chapo()); ?>" required data-validation-required-message="Please enter your phone number.">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="row control-group">
                <h3>Contenu</h3>
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <textarea rows="5" class="form-control" id="message" name="message" required data-validation-required-message="Please enter a message."> <?php echo htmlspecialchars($article->contenuArt()); ?></textarea>
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                </br>
                <div id="success"></div>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" name="valider" id="valider" class="btn btn-default">Valider</button>
                        </div>
                    </div>
                </div>       
            </form>
        </div>
    </article>
</body>

</html>