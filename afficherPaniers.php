<?php
    require_once("classes/fruits.class.php");
    require_once("classes/fruits.manager.php");
    require_once("classes/panier.class.php");
    require_once("classes/monPDO.class.php");
    require_once("classes/paniers.manager.php");
    include("common/header.php");
    include("common/menu.php");  
?>

<div class="container">

    <?php
    if(isset($_POST['idFruit'])){
        $idFruit = $_POST['idFruit'];
        $poidsFruit = (int) $_POST['poidsFruit'];
        $prixFruit = (int) $_POST['prixFruit'];

        $res = fruitManager::updateFruit($idFruit, $poidsFruit, $prixFruit);
        if($res) {
            echo "La modification du fruit a bien été effectuée";
            
        } else {
            echo "La modification du fruit a échoué.";
        }
        // echo "Hello from afficherPanier";
    }
        panierManager::setPaniersFromDB();

        foreach(Panier::$paniers as $panier){
            $panier->setFruitToPanierFromDB();
            echo $panier;
        }
    ?>
</div>
<?php 
    include("common/footer.php");
?>