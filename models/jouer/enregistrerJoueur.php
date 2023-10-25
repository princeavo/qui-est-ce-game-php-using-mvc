<?php
require_once '../include/dbConnection.php';
function enregisterJoueur($nom,$niveau,$score){
    global $db;
    $stmt = $db->prepare("SELECT * FROM joueurs WHERE nom = :nom AND niveau = :niveau");
    $stmt->bindParam(":nom",$nom);
    $stmt->bindParam(":niveau",$niveau);
    $stmt->execute();

    $ligne = $stmt->fetch(PDO::FETCH_ASSOC);

    if($ligne)/*L'user existe déjà.On va donc faire une mise à jour*/{
        $scoreDeLaTable = $ligne['score'];
        if($scoreDeLaTable < $score){
            $stmt->closeCursor();
            $stmt = $db->prepare("UPDATE  joueurs SET score = :score WHERE nom = :nom AND niveau = :niveau ");
            $stmt->bindParam(":nom",$nom);
            $stmt->bindParam(":niveau",$niveau);
            $stmt->bindParam(":score",$score);
            $stmt->execute();
            $stmt->closeCursor();
        }
        
    }else{
        $stmt->closeCursor();
        $stmt = $db->prepare("INSERT INTO joueurs (id,nom,niveau,score) VALUES (NULL,:nom,:niveau,:score)");
        $stmt->bindParam(":nom",$nom);
        $stmt->bindParam(":niveau",$niveau);
        $stmt->bindParam(":score",$score);
        $stmt->execute();
        $stmt->closeCursor();
    } 
}