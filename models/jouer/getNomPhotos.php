<?php
require_once '../include/dbConnection.php';
function getNomPhotos($table){
    global $db;
    $query = "SELECT nom,photo FROM ".$table;
    $stmt = $db->prepare($query);
    $stmt->execute();
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $resultats;
}