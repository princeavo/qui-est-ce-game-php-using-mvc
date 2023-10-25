<?php
require_once '../include/dbConnection.php';
function getByIdFromTable($table,$id){
    global $db;
    $stmt = $db->prepare("SELECT * FROM  ".$table ." WHERE id= :id ");
    $stmt->bindParam(":id",$id);
    $stmt->execute();
    $element =  $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $element;
}