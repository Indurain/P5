<?php
include("../clean_blog/fonctions.php");
$bdd=connexion();

function chargerClasse($classname)
    {
        require '../clean_blog/'.$classname.'.class.'.'php';
    }
spl_autoload_register('chargerClasse');

$manager = new Manager($bdd);

$commentaire_manager = $manager->lire_commentaire($bdd);

$donnees = $commentaire_manager->fetch();

// Créer objet de la classe Article avec les données lus par le manager
$commentaire = new Commentaire($donnees);

$id = $_GET['idComm'];

if (isset($_POST['valider'])) {
            /*connexion bdd */
            $nbdd=connexion();
        
            /*Création objet $manager de la classe Manager */
            $nmanager = new Manager($nbdd);


            /* Création array pour stocker les données reçus du formulaire, on les transmettra ensuite en paramètres au constructeur de la classe Article */
            $ndonnees= array('idComm' => $_GET['idComm'], 'auteurComm' => $_POST['auteur_comm'], 'contenuComm' => $_POST['message']);

            /*Création objet $article de la classe Article */
            $comm = new Commentaire($ndonnees);
        
            /* Appel de la méthode ajouter article de la classe Manager */
            $nmanager->modifier_commentaire($comm);

            header('Location:index.php');
    }
    
include_once 'metas.php';
include_once 'header.php';


?>
    <h2>Voici le commentaire à modifier : </h2>
   <article>
        <form method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
        <div class="container">
            <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                        <h4>Auteur</h4>
                        <input type="text" class="form-control" name="auteur_comm" value="<?php echo htmlspecialchars($commentaire->auteurComm()) ?>">
                        <p class="help-block text-danger"></p>
                    </div>
                </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <h4>Commentaire :</h4>
                    <textarea rows="5" class="form-control" name="message" name="message" required data-validation-required-message="Please enter a message."> <?php echo htmlspecialchars($commentaire->contenuComm()); ?></textarea>
                        <p class="help-block text-danger"></p>
                    <button type="submit" id="envoyer" name="valider" class="btn btn-success btn-outline"> Valider </button>
                </div>
            </div>
        </div>
        </form>
    </article>

