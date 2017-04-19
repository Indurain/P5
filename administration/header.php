<?php 
$nbArt = compter_articles($bdd);
$nbComm = compter_commentaires($bdd);
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><a href="index.php">Tableau de bord du Blog du P5</a></h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $nbArt; ?></div>
                            <div>Articles</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <div class="col-lg-6 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $nbComm; ?></div>
                            <div>Commentaires</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>