<?php
// session_start();
// if(!empty($_SESSION)){
//     unset($_SESSION);
//     session_destroy();
// }
    $title = "Notre jeu";
    $style = "<link href='/exercice1/css/presentation.css' rel='stylesheet'>";
    $style .= "\n<link href='/exercice1/css/acceuil.css' rel='stylesheet'>";
    require_once './include/header.php';
    require_once './views/acceuil.php';