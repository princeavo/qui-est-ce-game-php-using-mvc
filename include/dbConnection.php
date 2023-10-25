<?php
$host = "localhost";
$dbname = "exercice";
$user = "root";
$userPassword = "";
$dsn = "mysql:host=$host;dbname=$dbname";
$db = null;
try{
    $db = new PDO($dsn, $user, $userPassword, [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]);
} catch (PDOException $e) {
    echo "Erreur lors de la connexion à la base de données " . $e->getMessage();
}