<?php 
    require_once("classes/fruits.class.php");
    require_once("classes/panier.class.php");
    require_once("classes/formatage.utile.php");
    include("common/header.php");
    include("common/menu.php");
?>
<div class="container">
<?php echo utile::gererTitreNiveau2("➕ Ajout d'un panier :"); ?>

<form class="" action="#" method ="POST">
    <div class="form-group ">
        <label for="client">Nom du client : </label>
        <input type="text" class="form-control" name="client" id="client" aria-describedby="client" >
        <!-- <small id="client" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
    </div>
    <div class="form-group">
        <label for="nb_pommes">Nombre de pommes : </label>
        <input type="number" class="form-control" name="nb_pommes" id="nb_pommes">
    </div>
    <div class="form-group">
        <label for="nb_cerise">Nombre de cerises : </label>
        <input type="number" class="form-control" name="nb_cerise" id="nb_cerise">
    </div>
    <button type="submit" class="btn btn-primary">Créer le panier  !</button>
</form>
<?php   
    if(isset($_POST['client']) && !empty($_POST['client'])){
        $p = new Panier(Panier::generateUniqueId(),$_POST['client']);
        $res = $p->saveInDB();
        if($res){
            $nbPomme = (int)$_POST['nb_pommes'];
            $nbCerise = (int)$_POST['nb_cerise'];
            $cpt = 1;
            $nbFruitInDB=Fruit::genererUniqueID();
            for($i = 0 ; $i < $nbPomme;$i++){
                $fruit = new Fruit("pomme".($nbFruitInDB+$cpt),rand(120,160),20);
                $fruit->saveInDB($p->getIdentifiant());
                $p->addFruit($fruit);
                $cpt++;
            }
            for($i = 0 ; $i < $nbCerise;$i++){
                $fruit = new Fruit("cerise".($nbFruitInDB+$cpt),rand(120,160),20);
                $fruit->saveInDB($p->getIdentifiant());
                $p->addFruit($fruit);
                $cpt++;
            } 
            echo 'Done 😉';
        } else {
            echo "L'ajout n'a pas fonctionné";
        }
    }
?>
</div>
<?php 
    include("common/footer.php");
?>