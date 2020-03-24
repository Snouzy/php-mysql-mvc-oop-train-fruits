<?php
require_once "classes/formatage.utile.php";
require_once "classes/paniers.manager.php";
class Panier {
    public static $paniers = [];

    private $identifiant;
    private $nomClient;
    private $pommes = [];
    private $cerises = [];

    public function __construct($identifiant, $nomClient) {
        $this->identifiant = $identifiant;
        $this->nomClient = $nomClient;
    }

    public function getIdentifiant() {
        return $this->identifiant;
    }

    public function setFruitToPanierFromDB() {
        $fruits = panierManager::getFruitPanier($this->identifiant);

        foreach ($fruits as $fruit) {
            if (preg_match("/cerise/", $fruit['fruit'])) {
                $this->cerises[] = new Fruit($fruit['fruit'], $fruit['poids'], $fruit['prix']);
            } else if (preg_match("/pomme/", $fruit['fruit'])) {
                $this->pommes[] = new Fruit($fruit['fruit'], $fruit['poids'], $fruit['prix']);
            }
        }
    }

    public function __toString() {
        $affichage = utile::gererTitreNiveau2('Contenu du panier ' . $this->identifiant . " :");
        $affichage .= '<table class="table">';
            $affichage .= '<thead>';
                $affichage .= '<tr>';
                    $affichage .= '<td scope="col">Image</td>';
                    $affichage .= '<td scope="col">Nom</td>';
                    $affichage .= '<td scope="col">Poids</td>';
                    $affichage .= '<td scope="col">Prix</td>';
                    $affichage .= '<td scope="col">Action</td>';
                    $affichage .= '<td scope="col">Action</td>';
                $affichage .= '</tr>';
            $affichage .= '</thead>';
        $affichage .= '<tbody>';
        foreach ($this->pommes as $pomme) {
            $affichage .= $this->displayInfos($pomme);
        }
        foreach ($this->cerises as $cerise) {
            $affichage .= $this->displayInfos($cerise);
        }
        $affichage .= '</tbody>';
        $affichage .= '</table>';
        return $affichage;
    }

    private function displayInfos($fruit) {
        $affichage = '<tr>';
            $affichage .= '<td>' . $fruit->getImageSmall() . '</td>';
            $affichage .= '<td>' . $fruit->getNom() . '</td>';
            $affichage .= '<td>';

            //Affiche la modification du poids
            if(isset($_GET['idFruit']) && $_GET['idFruit'] === $fruit->getNom()) {
                $affichage .= '<form method="POST" action="#">';
                    $affichage .= "<input type='hidden' name='type' value='modification' id='type'>";
                    $affichage .= "<input type='hidden' value='". $fruit->getNom() ."' name='idFruit' id='idFruit'>";
                    $affichage .= "<input type='number' name='poidsFruit' id='poidsFruit' value='" . $fruit->getPoids() . "'>";
            } else {
                $affichage .=  $fruit->getPoids();
            }

            $affichage .= '</td>';
            $affichage .= '<td>';

            //Affiche la modification du poids
            if(isset($_GET['idFruit']) && $_GET['idFruit'] === $fruit->getNom()) {
                $affichage .= "<input type='number' name='prixFruit' id='prixFruit' value='" . $fruit->getPrix() . "'>";
            } else {
                $affichage .=  $fruit->getPrix();
            }
                
            $affichage .= '</td>';
            $affichage .= '<td>';
            if(isset($_GET['idFruit']) && $_GET['idFruit'] === $fruit->getNom()) {
                $affichage .= "<button type='submit' class='btn btn-success'>Valider</button>";
                $affichage .= '</form>';
            } else {
                $affichage .= '<form method="GET" action="#">';
                    $affichage .= "<input type='hidden' name='idFruit' value='". $fruit->getNom() ."' id='idFruit'>";
                    $affichage .= "<input type='submit' class='btn btn-primary' value='Modifier'>";
                $affichage .= '</form>';
            }
            $affichage .= '</td>';
            $affichage .= '<td>';
                $affichage .= '<form method="POST" action="#">';
                    $affichage .= "<input type='hidden' name='idFruit' value='". $fruit->getNom() ."' id='idFruit'>";
                    $affichage .= "<input type='hidden' name='prixFruit' value='". $fruit->getPrix() ."' id='prixFruit'>";
                    $affichage .= "<input type='hidden' name='poidsFruit' value='". $fruit->getPoids() ."' id='poidsFruit'>";
                    $affichage .= "<input type='hidden' name='type' value='supprimer' id='type'>";
                    $affichage .= "<input type='submit' class='btn btn-danger' value='Supprimer du panier'>";
                $affichage .= '</form>';
            $affichage .= '</td>';
        $affichage .= '</tr>';
        return $affichage;
        // $affichage .= "<button type='submit' class='btn btn-danger'>Supprimer</button>";
    }

    public function addFruit($fruit) {
        if (preg_match("/cerise/", $fruit->getNom())) {
            $this->cerises[] = $fruit;
        } else if (preg_match("/pomme/", $fruit->getNom())) {
            $this->pommes[] = $fruit;
        }
    }

    public function saveInDB() {
        return panierManager::insertIntoDB($this->identifiant, $this->nomClient);
    }

    public static function generateUniqueId() {
        return panierManager::getNbPanierInDB() + 1;
    }

}
?>