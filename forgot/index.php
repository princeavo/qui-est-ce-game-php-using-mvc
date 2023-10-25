<?php
    session_start();
    unset($_SESSION['mode']);
    unset($_SESSION['indicesCaches']);
    unset($_SESSION);
    session_destroy();
    header("location:../");
?>