<?php

    include("fonctions.php");
    $bdd=connexion();
    
    function chargerClasse($classname)
    {
        require $classname.'.class.'.'php';
    }
    spl_autoload_register('chargerClasse');
    
    $manager = new Manager($bdd);
    
    $requete_10 = $manager->lire_liste_articles($bdd);

    include("metas.php"); 
    
?>
    <title>Carmen Fabo : le Blog</title>
</head>

<body>

    <!-- Navigation -->
    <?php include("nav.php"); ?>

    <!-- Page Header -->
    <header class="intro-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="site-heading">
                        <h1>Carmen Fabo, le Blog</h1>
                        <hr class="small">
                        <span class="subheading">Le Blog du projet 5</span>
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
                        $id = $article->idArt();
                        $comm_exists = $article->aComm();
                        // Lecture de l'id pour le passer en paramètre avec l'adresse url
                        
                ?>
       
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

            <!-- Pager -->
                <ul class="pagination">
                    <?php 
                    //  Appel à fonction qui me donne le nombre d'articles qu'il y a dans la base puis conversion en entier
                    $nArticles = compter_articles($bdd);
    
                    // Variable pour stocker le nombre d'articles par page
                    $perPage = 5;

                    // Variable pour stocker la page actuelle
                    if (isset($_GET['p'])) {
                        $cPage = $_GET['p'];
                    } 
                    else{ 
                        $cPage = 1;
                    }
                    
                    // Variable qui contiendra le nombre de pages qu'il y aura en fonction du nombre d'articles et d'articles/page. 
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

    <?php include("footer.php"); ?>


</body>

</html>
