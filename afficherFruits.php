<?php
    require_once("classes/fruits.class.php");
    require_once("classes/panier.class.php");
    require_once("classes/monPDO.class.php");
    require_once("classes/fruits.manager.php");
    include("common/header.php");
    include("common/menu.php");  
?>
<div class="container">
<?php  echo utile::gererTitreNiveau2("Fruits :") ?>

<?php

    if(isset($_POST['panierChoisi']) && isset($_POST['idFruit'])) {
        $res = fruitManager::updatePanierFruit((int)$_POST['panierChoisi'], $_POST['idFruit']);
        if($res) {
            echo 'succes';
            // echo '
            // <div class="alert alert-success mt-3" role="alert">
            //     <h4 class="alert-heading">Félicitations!</h4>
            //     <p>Bravo, votre fruit a été supprimé du panier. Vous avez gagné ' . $_POST['poidsFruit'].'g et ' . $_POST['prixFruit']. ' centimes.</p>
            //     <hr>
            //     <small>Promis, vous n\'entenderez plus jamais parler de <b>'. $_POST['idFruit'] .'</b>...</small>
            // </div>';
        }
        else {
            echo 'dmg';
            // echo '
            // <div class="alert alert-danger mt-3" role="alert">
            //     <h4 class="alert-heading">Arrrrrgh...</h4>
            //     <p>La modification n\'a pas été effectuée... Veuillez réessayer</p>
            // </div>';
        }
    }

    fruitManager::setFruitsFromDB();
    echo '<div class="row mx-auto">';
    foreach(Fruit::$fruits as $fruit){
        echo '<div class="col-sm p-2">';
            echo $fruit->afficherListeFruit();
        echo '</div>'; 
    }
    echo '</div>';
?>
</div>
<?php 
    include("common/footer.php");
?>