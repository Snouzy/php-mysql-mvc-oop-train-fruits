<?php

require_once("../models/panier.class.php");
require_once("../models/monPDO.class.php");
class panierManager{
    public static function setPaniersFromDB(){
        $pdo = monPDO::getPDO();
        $stmt = $pdo->prepare("SELECT identifiant, NomClient FROM panier");
        $stmt->execute();
        $paniers = $stmt->fetchAll();
        foreach ($paniers as $panier){
            Panier::$paniers[] = new Panier($panier['identifiant'], $panier['NomClient']);
        }
    }

    public static function getFruitPanier($identifiant){
        $pdo = monPDO::getPDO();
        $req = "SELECT f.nom AS fruit, f.poids AS poids, f.prix AS prix FROM panier p INNER JOIN  fruit f ON f.identifiant = p.identifiant WHERE p.identifiant = :id";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":id", $identifiant, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function getNbPanierInDB(){
        $pdo = monPDO::getPDO();
        $req = "SELECT count(*) AS nbPanier FROM panier";
        $stmt = $pdo->prepare($req);
        $stmt->execute();
        $resultat = $stmt->fetch();
        return $resultat['nbPanier'];
    }

    public static function insertIntoDB($identifiant,$nom){
        $pdo = monPDO::getPDO();
        $req = "INSERT INTO panier (identifiant, NomClient) VALUES (:id,:nom)";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":id", $identifiant, PDO::PARAM_INT);
        $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
        try{
            return $stmt->execute();
        } catch (PDOException $e){
            echo "Erreur : ". $e->getMessage();
            return false;
        }
    }

    public static function getAllClients(){
        $pdo = monPDO::getPDO();
        $req = "SELECT identifiant, NomClient FROM `panier`";
        $stmt = $pdo->prepare($req);
        $stmt->execute();
        $resultat = $stmt->fetchAll();
        return $resultat;
    }
}
?>