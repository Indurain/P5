<?php 
    function chargerClasse($classname)
    {
        require $classname.'.class.'.'php';
    }
    spl_autoload_register('chargerClasse');

    include 'fonctions.php';
    $bdd=connexion();
    
    // On va créer un objet article pour travailler avec. Pour cela il faut d'abord créer un objet Manager

    // Création objet $manager de la classe Manager 
    $manager = new Manager($bdd);
    
    // on apelle la méthode lire_article et elle retourne un objet de la classe PDOStatement, qui a une propriété privée qui s'appelle queryString, => un string avec, comme clé le nom de la colonne (avec un AS pour que le nom coincide avec le nom de la propriété du future objet article) et comme valeur la valeur de la colonne.
    $article_manager = $manager->lire_article($bdd);
    
    // On accéde aux données avec la méthode fetch 
    $donnees = $article_manager->fetch();

    //Puis on crée notre objet de la classe Article avec les données
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

<!-- Affichage de l'article ###################################################################################### -->
    
    <!-- Page Header -->
    <header class="intro-header" >
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="post-heading">
                    <?php 
                        $id = $article->idArt();
                        $comm_exists = $article->aComm();
                        ?>

                        <h1> <?php echo htmlspecialchars($article->titre()); ?> </h1>
                        <h2> <?php echo htmlspecialchars($article->chapo()); ?></h2>
                        <span class="meta">Posted by <?php echo htmlspecialchars($article->auteurArt()); ?> le <?php echo htmlspecialchars($article->dateDerModifArt()); ?> </span>

                    </div>

                    
                    <?php echo "<a href=\"modifier_article.php?id=$id\">"; ?>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <button type="submit" name="modifier" id="modifier" class="btn btn-success btn-lg">Modifier cet article</button>
                            </div>
                        </div>
                    <?php echo "</a>"; ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Post Content -->
    <article>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                
                    <?php echo htmlspecialchars($article->contenuArt()); ?>
                </div>
            </div>
        </div>
    </article>

    <!-- Afichage des commentaires s'il y en a ######################################################################""-->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <?php
                    if ($comm_exists == 1) {
                        echo "Commentaires :";
                        $liste_comm = $manager->lister_commentaires();
                        while ($donnees = $liste_comm->fetch())
                        { 
                            $commentaire = new Commentaire ($donnees);
                ?>
                            <div class="post-preview">
                                <p class="post-meta"> Posté par <a href="#"><?php echo htmlspecialchars($commentaire->auteurComm()); ?></a> le <?php echo htmlspecialchars($commentaire->dateDerModifComm()); ?></p>
                                <p class="post-subtitle">
                                <?php echo htmlspecialchars($commentaire->contenuComm());?>
                                </p>
                            </div>
                <hr>
                        <?php 
                        }
                    }
                    else {
                        echo "Il n'y a pas de commentaires pour cet article.";
                    }?>
            </div>
        </div>
    </div>

    <!-- Affiche formulaire pour écrire un commentaire ########################################################################## -->
    <article>
        <form method="post" <?php echo "action=\"ecrire_commentaire.php?id=$id\">"; ?>
        <div class="container">
            <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                        <h4>Votre nom</h4>
                        <input type="text" class="form-control" name="auteur_comm" required data-validation-required-message="Please enter your name.">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <h4>Ecrivez votre commentaire :</h4>
                    <div class="form-group">
                        <textarea id="comm" name="comm"  class="form-control" rows="3" required data-validation-required-message="Please enter your name."></textarea>
                    </div>
                    <button type="submit" id="envoyer" name="envoyer" class="btn btn-success btn-outline"> Envoyer</button>
                   
                    
                </div>
            </div>
        </div>
        </form>
    </article>
    
    <hr>

    <hr>
    <?php include 'footer.php'; ?>
   

</body>

</html>