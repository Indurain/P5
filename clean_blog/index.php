<?php

    include 'fonctions.php';
    $bdd=connexion();
    
    function chargerClasse($classname)
    {
        require $classname.'.class.'.'php';
    }
    spl_autoload_register('chargerClasse');
    
    $manager = new Manager($bdd);
    $requete_10 = $manager->lire_liste_articles($bdd);
    
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

    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <img class="img-responsive" src="profile.jpg" alt="">
                    <div class="intro-text">
                        <span class="name">Carmen Fabo</span>
                        <hr class="star-light">
                        <span class="skills">Web Developer - PHP / Symfony :</span>
                        <span class="skills">Une idée, un projet, votre site !</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                
                <?php
                    while ($donnees = $requete_10->fetch()) 
                    {
                        $article = new Article ($donnees);
                        // Lecture de l'id pour le passer en paramètre avec l'adresse url
                        $id = $article->idArt();
                        // Lecture pour savoir si cet article a des commentaires
                        $comm_exists = $article->aComm();
                ?>
                    
                    <!-- Affiche un aperçu de l'article (sans le contenu) -->
                    <div class="post-preview">
                        <h2 class="post-title">
                        <?php 
                            echo "<a href=\"article.php?id=$id\">";
                            echo htmlspecialchars($article->titre());
                            echo " </a>"; 
                        ?> 
                        </h2>
                        <h3 class="post-subtitle">
                        <?php echo htmlspecialchars($donnees['chapo']);  ?>
                        </h3>
                        <p class="post-meta"> Posté par <?php echo htmlspecialchars($article->auteurArt()); ?> le <?php echo htmlspecialchars($article->dateDerModifArt()); ?></p>
                    </div>
                <hr>

                <?php 
                    }
                    $requete_10->closeCursor(); 
                ?>

            <!-- Pagination -->
                <ul class="pagination">
                    <?php 
                    //  Appel à fonction qui donne le nombre d'articles qu'il y a dans la base
                    $nArticles = compter_articles($bdd);
    
                    // Stocke le nombre d'articles par page
                    $perPage = 5;

                    // Stocke la page actuelle
                    if (isset($_GET['p'])) {
                        $cPage = $_GET['p'];
                    } 
                    else{ 
                        $cPage = 1;
                    }
                    
                    // Variable qui contient le nombre de pages qu'il y aura en fonction du nombre d'articles et d'articles/page. 
                    $nbPages = ceil($nArticles/$perPage);
                        
                    for ($i=1; $i<=$nbPages; $i++) 
                    {
                        if ($i == $cPage) {
                           echo "<li id=\"pageAct\"> $i </li> ";

                        }
                        else {
                             echo "<li> <a href=\"index.php?p=$i\"> $i </a> </li> ";
                        }
                        
                    }
                            
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <hr>

    <?php include 'footer.php'; ?>


</body>

</html>
