<?php

require_once("classes/fruits.class.php");
require_once("classes/monPDO.class.php");
class fruitManager{
    public static function setFruitsFromDB(){
        $pdo = monPDO::getPDO();
        $stmt = $pdo->prepare("Select f.nom as Nom, f.poids as Poids, f.prix as Prix, p.NomClient as Client from fruit f inner join panier p on f.identifiant = p.identifiant");
        $stmt->execute();
        $fruits = $stmt->fetchAll();
        foreach ($fruits as $fruit){
            Fruit::$fruits[] = new fruit($fruit['Nom'],$fruit['Poids'],$fruit['Prix']);
        }
    }

    public static function getNbFruitsInDB(){
        $pdo = monPDO::getPDO();
        $req = "select count(*) as nbFruit from fruit";
        $stmt = $pdo->prepare($req);
        $stmt->execute();
        $resultat = $stmt->fetch();
        return $resultat['nbFruit'];
    }

    public static function insertIntoDB($nom, $poids,$prix,$idPanier){
        $pdo = monPDO::getPDO();
        $req = "insert into fruit values (:nom,:poids,:prix,:idPanier)";
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
}
?>