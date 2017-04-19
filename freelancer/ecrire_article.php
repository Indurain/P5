<?php
    include 'fonctions.php';
    
    function chargerClasse($classname)
    {
        require $classname.'.class.'.'php';
    }
    spl_autoload_register('chargerClasse');

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
    <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="../freelancer/index.php">Retour à la page d'accueil</a>
            </div>

        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Header -->
  
    <header class="intro-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="post-heading">
                        <h1>Ecrivez ici votre article</h1>
                        <h2 class="subheading">Allez-y !</h2>
                        
                        <?php if (isset($_POST['valider'])) {
                            echo "<h3>";
                            echo "Votre article a bien été inseré, merci pour votre participation !";
                            echo "</h3>"; 
                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Post Content -->
    <article>
        <div class="container">
            
            <form method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label for="auteur">Votre nom</label>
                        <input type="text" class="form-control" placeholder="Votre nom" id="auteur" name="auteur" required data-validation-required-message="Please enter your name.">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label for="titre">Titre de l'article</label>
                        <input type="text" class="form-control" placeholder="Le titre de l'article" name="titre" required data-validation-required-message="S'il vous plaît, entrez un titre">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 floating-label-form-group controls">
                            <label for="chapo">Chapô</label>
                            <input type="tel" class="form-control" placeholder="Le chapô" name="chapo" required data-validation-required-message="Please enter your phone number.">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                <div class="row control-group">
                    <div class="form-group col-xs-12 floating-label-form-group controls">
                        <label for="message">article</label>
                        <textarea rows="5" class="form-control" placeholder="Le contenu de l'article" name = "message"required data-validation-required-message="Please enter a message."></textarea>
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
                <br>
                <div id="success"></div>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" name="valider" id="valider" class="btn btn-default">Envoyer</button>
                        </div>
                    </div>
                </div>       
            </form>
        </div>
    </article>

    <!--  Code de Carmen pour traiter le formulaire -->   
    <?php
        
        if (isset($_POST['valider'])) {
            /*connexion bdd */
            $bdd=connexion();
        
            /*Création objet $manager de la classe Manager */
            $manager = new Manager($bdd);


            /* Création array pour stocker les données reçus du formulaire, on les transmettra ensuite en paramètres au constructeur de la classe Article */
            $donnees= array('auteurArt' => $_POST['auteur'], 'titre' => $_POST['titre'], 'chapo' => $_POST['chapo'], 'contenuArt' => $_POST['message'] );


            /*Création objet $article de la classe Article */
            $article = new Article($donnees);

        
            /* Appel de la méthode ajouter article de la classe Manager */
            $manager->ajouter_article($article);
            
        }
    ?>
    <hr>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

</body>

</html>