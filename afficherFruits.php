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