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
                    $affichage .= '<th scope="col">Image</th>';
                    $affichage .= '<th scope="col">Nom</th>';
                    $affichage .= '<th scope="col">Poids</th>';
                    $affichage .= '<th scope="col">Prix</th>';
                $affichage .= '</tr>';
            $affichage .= '</thead>';
        $affichage .= '<tbody>';
        foreach ($this->pommes as $pomme) {
            $affichage .= '<tr>';
                $affichage .= '<td>' . $pomme->getImageSmall() . '</th>';
                $affichage .= '<td>' . $pomme->getNom() . '</th>';
                $affichage .= '<td>' . $pomme->getPoids() . '</th>';
                $affichage .= '<td>' . $pomme->getPrix() . '</th>';
            $affichage .= '</tr>';
        }
        foreach ($this->cerises as $cerise) {
            $affichage .= '<tr>';
                $affichage .= '<td>' . $cerise->getImageSmall() . '</th>';
                $affichage .= '<td>' . $cerise->getNom() . '</th>';
                $affichage .= '<td>' . $cerise->getPoids() . '</th>';
                $affichage .= '<td>' . $cerise->getPrix() . '</th>';
            $affichage .= '</tr>';
        }
            $affichage .= '</tbody>';
        $affichage .= '</table>';
        return $affichage;
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