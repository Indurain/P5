<?php

    include("../clean_blog/fonctions.php");
    $bdd=connexion();
    
    function chargerClasse($classname)
    {
        require '../clean_blog/'.$classname.'.class.'.'php';
    }
    spl_autoload_register('chargerClasse');
    
    // Requête pour lire les dix dernièrs articles postés
    $manager = new Manager($bdd);
    
    $requete_10 = $manager->lire_liste_articles($bdd);

   
    
    include("metas.php");
?>



<body>
    
    <div id="wrapper">
        <?php include 'header.php'; ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-clock-o fa-fw"></i> Vue globale des dix derniers articles et leurs commentaires
            </div>
                
            <div class="panel-body">

                <?php
                while ($donnees = $requete_10->fetch()) 
                {
                    // Pour chaque article lu de la bdd on crée un objet pour le montrer
                    $article = new Article ($donnees);
                    $id = $article->idArt();
                    $_GET['id'] = $id;
                    $comm_exists = $article->aComm();
                ?>
                
                <ul class="timeline">
                    <li>
                        <div class="timeline-badge"><i class="fa fa-file-text"></i>
                        </div>

                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4 class="timeline-title">
                                    <?php 
                                    // echo "<a href=\"article.php?id=$id\">";
                                    echo htmlspecialchars($article->titre()); 
                                    // echo " </a>"; 
                                    ?> 
                                </h4>
                                <p><small class="text-muted"><i class="fa fa-clock-o"></i> 
                                    <?php 
                                    echo htmlspecialchars($article->dateDerModifArt()); 
                                    echo " par : ";
                                    echo htmlspecialchars($article->auteurArt());
                                    ?>
                                </small>
                                </p>
                            </div>
                            <div class="timeline-body">
                                <?php echo htmlspecialchars($article->chapo());  ?>
                                <hr>
                                <div class="btn-group">
                                    <?php echo "<a href=\"modifier_art.php?id=$id\">"; ?>
                                    <button type="button" class="btn btn-warning" name="modifier"> Lire / Modifier</button>
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <?php echo "<a href=\"supprimer_art.php?id=$id\">"; ?>
                                    <button type="button" class="btn btn-danger" name="supprimer">Supprimer</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                    
                    <?php
                    // Si cet article a des commentaires, on va les lister
                    if ($comm_exists == 1) {

                        $liste_comm = $manager->lister_commentaires();
                        while ($donnees2 = $liste_comm->fetch())
                        { 

                            $commentaire = new Commentaire ($donnees2);
                            $idComm = $commentaire->idComm();

                            $_GET['idComm'] = $idComm;
                    ?>

                            <li class="timeline-inverted">
                                <div class="timeline-badge warning"><i class="fa fa-comments"></i>
                                </div>
                                <div class="timeline-panel">
                                    <div class="timeline-heading">
                                        <h4 class="timeline-title">Commentaire posté par <?php echo htmlspecialchars($commentaire->auteurComm()); ?></h4>
                                        <p><small class="text-muted"><i class="fa fa-clock-o"></i> à </small>
                                        <?php echo htmlspecialchars($commentaire->dateDerModifComm()); ?>
                                        </p>
                                    </div>
                                    <div class="timeline-body">
                                        <p>
                                        <?php echo htmlspecialchars($commentaire->contenuComm()); ?>
                                        </p>
                                    <hr>
                                    <div class="btn-group">
                                        <?php echo "<a href=\"modifier_comm.php?idComm=$idComm\">"; ?>
                                        <button type="button" class="btn btn-warning">Lire / Modifier</button>
                                        </a>
                                    </div>
                                    <div class="btn-group">
                                        <?php echo "<a href=\"supprimer_comm.php?idComm=$idComm\">"; ?>
                                        <button type="button" class="btn btn-danger">Supprimer</button>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        <?php 
                        }
                    }?>
                </ul>
            <?php
            }
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
                    else { 
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
    <!-- Morris Charts JavaScript -->
    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>