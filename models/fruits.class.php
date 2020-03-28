<?php 
require_once("../controllers/Fruits.manager.php");
class Fruit{
    private $nom;
    private $poids;
    private $prix;

    public static $fruits = [];

    public function __construct($nom,$poids,$prix){
        $this->nom = $nom;
        $this->poids = $poids;
        $this->prix = $prix;
    }

    public function getNom(){
        return $this->nom;
    }
    public function getPoids(){
        return $this->poids;
    }
    public function getPrix(){
        return $this->prix;
    }

    public function __toString(){
        $affichage = $this->getAffichageIMG();
        $affichage .= "Nom : " . $this->nom . "<br />";
        $affichage .= "Poids : " . $this->poids . "<br />";
        $affichage .= "Prix : " . $this->prix . "<br />";
        return $affichage;
    }
    // fruitManager::getClientOfTheFruit($this->nom) .' ';
    public function afficherListeFruit(){
        $affichage = '<div class="card text-center">';
            $affichage .= $this->getAffichageIMG();
            $affichage .= '<div class="card-body">';
                $affichage .= '<h5 class="card-title">Nom : ' . $this->nom . '</h5>';
                $affichage .= '<p class="card-text">';
                    $affichage .= 'Poids : ' . $this->poids . '<br />';
                    $affichage .= 'Prix : ' . $this->prix . '<br />';
                    $affichage .= 'Panier : ';
                    $affichage .= '<form method="POST" action="#">';
                        $affichage .= '<input type="hidden" name="idFruit" value="'. $this->nom .'" id="idFruit" />';
                        $affichage .= '<select name="panierChoisi" id="panierChoisi" onChange="submit()" class="form-control-sm">';
                        $clients = panierManager::getAllClients();
                        foreach($clients as $client){
                            $nomClient = $client['NomClient'];
                            if($nomClient === fruitManager::getClientOfTheFruit($this->nom)) {
                                $affichage .= '<option selected value="'.$client['identifiant'].'">' . $nomClient . '</option>';
                            } else {
                                $affichage .= '<option value="'.$client['identifiant'].'">' . $nomClient . '</option>';
                            }
                        }
                        $affichage .= '</select>';
                    $affichage .= '</form>';
                $affichage .= "</p>";
            $affichage .= "</div>";
        $affichage .= "</div>";
        return $affichage;
    }

    public function saveInDB($idPanier){
        return fruitManager::insertIntoDB($this->nom, $this->poids,$this->prix,$idPanier);
    }

    private function getAffichageIMG(){
        if(preg_match("/cerise/",$this->nom)){
            return "<img class=\"card-img-top mx-auto\" style='width:200px' src ='../assets/images/cherry.png' alt='image cerise' /><br/>";
        }
        if(preg_match("/pomme/",$this->nom)){
            return "<img class=\"card-img-top mx-auto\" style='width:200px' src ='../assets/images/apple.png' alt='image pomme' /><br/>";
        }
    }

    public function getImageSmall(){
        if(preg_match("/cerise/",$this->nom)){
            return "<img class=\"card-img-top mx-auto\" style='width:50px' src ='../assets/images/cherry.png' alt='image cerise' /><br/>";
        }
        if(preg_match("/pomme/",$this->nom)){
            return "<img class=\"card-img-top mx-auto\" style='width:50px' src ='../assets/images/apple.png' alt='image pomme' /><br/>";
        }
    }

    public static function genererUniqueID(){
        return fruitManager::getNbFruitsInDB() + 1;
    }

}

?>