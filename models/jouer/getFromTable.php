<?php 
require_once '../include/dbConnection.php';
function getFromTable($table,$limit=null){
    global $db;
    $query = "SELECT * FROM ".$table ." ";
    if(!is_null($limit))
        $query .= "LIMIT $limit";
    $stmt = $db->query($query);
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $resultats;
}