<?php

    include 'fonctions.php';

    $bdd=connexion();

    function chargerClasse($classname)
    {
        require $classname.'.class.'.'php';
    }
    spl_autoload_register('chargerClasse');

        
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

    }
    
   // Création objet $manager de la classe Manager pour lire l'article demandé
    $manager = new Manager($bdd);
   
    $article_manager = $manager->lire_article($bdd);

    $donnees = $article_manager->fetch();
    

    // Créer objet de la classe Article avec les données lus par le manager
    $article = new Article($donnees);

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'metas.php'; ?>
    <!-- Head's open tag is in metas.php -->
    <title>Carmen Fabo : le Blog</title>
</head>

<body>

    <!-- Navigation -->
    <?php include 'nav.php'; ?>

    <!-- Page Header -->

    <header class="intro-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="post-heading">
                        <h1>Modifiez ici l'article</h1>
                        <h2 class="subheading">Allez-y !</h2>  
                        <?php if (isset($_POST['valider'])) {
                            echo "<h3>";
                            echo "Votre article a bien été modifé, merci pour votre participation !";
                            echo "</h3>"; 
                        }
                        ?>  

                    </div>
                </div>
            </div>
        </div>
    </header>

    
    <?php 
        $id = $article->idArt();
    ?>

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

    
    <hr>

    <?php include 'footer.php'; ?>

</body>

</html>