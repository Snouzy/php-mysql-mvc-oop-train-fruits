<?php
    require_once("../models/fruits.class.php");
    require_once("../controllers/fruits.manager.php");
    require_once("../models/panier.class.php");
    require_once("../models/monPDO.class.php");
    require_once("../controllers/Paniers.manager.php");
    include("../common/header.php");
    include("../controllers/menu.php");  
?>
<?php 
    echo utile::gererTitreNiveau2("⚙ Gestion des paniers :"); 
    echo "<hr />";
?>

<div class="container">

    <?php
    if(isset($_POST['idFruit']) && $_POST['type'] === 'modification'){
        $idFruit = $_POST['idFruit'];
        $poidsFruit = (int) $_POST['poidsFruit'];
        $prixFruit = (int) $_POST['prixFruit'];

        $res = fruitManager::updateFruit($idFruit, $poidsFruit, $prixFruit);
        if($res) {
            echo '
            <div class="alert alert-success mt-3" role="alert">
                <h4 class="alert-heading">Félicitations!</h4>
                <p>Aww yeah, votre modification a bien été prise en compte.</p>
            </div>';
        }
        else {
            echo '
            <div class="alert alert-danger mt-3" role="alert">
                <h4 class="alert-heading">Arrrrrgh...</h4>
                <p>La modification n\'a pas été effectuée... Veuillez réessayer</p>
            </div>';
        }
    } else if(isset($_POST['idFruit']) && $_POST['type'] === 'supprimer') {
        $res = fruitManager::deleteFruitFromPanier($_POST['idFruit']);
        if($res) {
            echo '
            <div class="alert alert-success mt-3" role="alert">
                <h4 class="alert-heading">Félicitations!</h4>
                <p>Bravo, votre fruit a été supprimé du panier. Vous avez gagné ' . $_POST['poidsFruit'].'g et ' . $_POST['prixFruit']. ' centimes.</p>
                <hr>
                <small>Promis, vous n\'entenderez plus jamais parler de <b>'. $_POST['idFruit'] .'</b>...</small>
            </div>';
        }
        else {
            echo '
            <div class="alert alert-danger mt-3" role="alert">
                <h4 class="alert-heading">Arrrrrgh...</h4>
                <p>La modification n\'a pas été effectuée... Veuillez réessayer</p>
            </div>';
        }
    }
        
        panierManager::setPaniersFromDB();

        foreach(Panier::$paniers as $panier){
            $panier->setFruitToPanierFromDB();
            echo $panier;
        }
    ?>
</div>
<?php 
    include("../common/footer.php");
?>