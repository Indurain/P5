<?php 
    function chargerClasse($classname)
    {
        require $classname.'.class.'.'php';
    }
    spl_autoload_register('chargerClasse');

    include("fonctions.php");
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

    include("metas.php");
    
?>

<title>Clean Blog - Article</title>
</head>

<body>

    <!-- Navigation -->
    <?php include("nav.php"); ?>

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

    <hr>
    <?php include("footer.php"); ?>
   

</body>

</html>