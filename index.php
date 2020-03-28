<?php 
    include("common/header.php");
    include("common/menu.php");
    require_once("classes/formatage.utile.php");
?>
<div class="container">
    <?php echo utile::gererTitreNiveau1('Snouz\'fruits, the php POO marketplace !💙') ; ?>
    <div class="row">
        <div class="col">
            <h1 style="margin-top: 30px">Que faire? </h1>
            <div class="col btnContainer">
                <div class="col">
                    <div class="mx-auto" style="width:200px"><a class="btn btn-menu btn-primary" href="afficherPaniers.php" role="button">Gestion des paniers 🛒</a></div>
                </div>
                <div class="col">
                    <div class="mx-auto" style="width:200px"><a class="btn btn-menu btn-primary" href="afficherFruits.php" role="button">Gestion des fruits 🍊</a></div>
                </div>
            </div>
        </div>
    </div>
    <hr style="margin: 30px"/>
        <div class="col">
            <h1 style="margin-top: 30px">Pourquoi ce "site" ? 🧐</h1>
            <div class="col quoteDiv">
            <blockquote>  
                <p>Pour m'entraîner en <strong> PHP </strong>& <strong>MySQL</strong> en vue de découvrir le framework <strong>Symfony</strong>; dans le but de devenir développeur <strong>fullstack</strong>.</p>
                <cite>Mathias Bradiceanu </cite>😉
            </blockquote>
            </div>
        </div>
</div>
<?php 
    include("common/footer.php");
?>