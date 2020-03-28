<?php

require_once("classes/fruits.class.php");
require_once("classes/monPDO.class.php");
class fruitManager{
    public static function setFruitsFromDB(){
        $pdo = monPDO::getPDO();
        $stmt = $pdo->prepare("SELECT f.nom AS Nom, f.poids AS Poids, f.prix AS Prix, p.NomClient AS Client FROM fruit f INNER JOIN panier p ON f.identifiant = p.identifiant");
        $stmt->execute();
        $fruits = $stmt->fetchAll();
        foreach ($fruits as $fruit){
            Fruit::$fruits[] = new fruit($fruit['Nom'],$fruit['Poids'],$fruit['Prix']);
        }
    }

    public static function getNbFruitsInDB(){
        $pdo = monPDO::getPDO();
        $req = "SELECT count(*) AS nbFruit FROM fruit";
        $stmt = $pdo->prepare($req);
        $stmt->execute();
        $resultat = $stmt->fetch();
        return $resultat['nbFruit'];
    }

    public static function insertIntoDB($nom, $poids,$prix,$idPanier){
        $pdo = monPDO::getPDO();
        $req = "INSERT INTO fruit VALUES (:nom,:poids,:prix,:idPanier)";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
        $stmt->bindValue(":poids", $poids, PDO::PARAM_INT);
        $stmt->bindValue(":prix", $prix, PDO::PARAM_INT);
        $stmt->bindValue(":idPanier", $idPanier, PDO::PARAM_INT);
        try{
            return $stmt->execute();
        } catch (PDOException $e){
            echo "Erreur : ". $e->getMessage();
            return false;
        }
    }

    public static function updateFruit($nom, $poids, $prix) {
        $pdo = monPDO::getPDO();
        $req = "UPDATE fruit SET Poids = :poids, Prix = :prix WHERE Nom = :nom";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
        $stmt->bindValue(":poids", $poids, PDO::PARAM_INT);
        $stmt->bindValue(":prix", $prix, PDO::PARAM_INT);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    public static function deleteFruitFromPanier($nomFruit) {
        $pdo = monPDO::getPDO();
        $req = "UPDATE fruit SET identifiant = null WHERE Nom = :nom";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":nom", $nomFruit, PDO::PARAM_STR);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            return false;
        }
    }

    public static function getClientOfTheFruit($nomFruit) {
        $pdo = monPDO::getPDO();
        $req = "SELECT p.NomClient 
        AS Client 
        FROM panier p 
        INNER JOIN fruit f
        ON f.identifiant = p.identifiant
        WHERE f.nom = :nom";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":nom", $nomFruit, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch();
        return $res['Client'];
    }

    public static function updatePanierFruit($panierChoisi, $idFruit){
        $pdo = monPDO::getPDO();
        $req = "UPDATE fruit SET identifiant = :panierChoisi WHERE Nom = :idFruit";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":panierChoisi", $panierChoisi, PDO::PARAM_INT);
        $stmt->bindValue(":idFruit", $idFruit, PDO::PARAM_STR);
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            return false;
        }
    }

}
?>