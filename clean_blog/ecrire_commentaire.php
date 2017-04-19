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
   
    if (isset($_POST['envoyer'])) {

    /* Création array pour stocker les données reçus du formulaire, on les transmettra ensuite en paramètres au constructeur de la classe Commentaire */
    $id = $_GET['id'];
    $donnees= array('auteurComm' => $_POST['auteur_comm'], 'contenuComm' => $_POST['comm'], 'articleId' => $id );
   
    //Création objet de la classe Commentaire 
    $commentaire = new Commentaire($donnees);
   

    // Appel de la méthode ajouter commentaire de la classe Manager 
    $manager->ajouter_commentaire($commentaire);

    // Comme on a ajouté un commentaire, on modifie la variable _comm_exists de l'objet article
    $comm_exists = 1;
    $article->setAComm($comm_exists);

    // Appel de méthode pour changer bdd : champ comm_exists de l'article qu'a été commenté
    $manager->changer_comm_exists($comm_exists);

    }
    header('Location:article.php?id='.$id);
?> 