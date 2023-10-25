<?php
require_once '../include/dbConnection.php';
function meilleurScoreNiveau ($niveau =null)  {
	global $db;
	$query = "SELECT nom, MAX(score) as sc FROM joueurs " . (is_null($niveau)?" ":" WHERE niveau=$niveau ") . " ORDER BY sc ASC LIMIT 1";
	$stmt= $db->prepare($query);
	$stmt->execute();
	$nomScore = $stmt->fetch(PDO::FETCH_ASSOC);
	$stmt->closeCursor();
	return $nomScore;
}