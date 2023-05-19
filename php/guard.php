<?php
//con esto indicamos que se inicia la sesion.
session_start();


if (!isset($_SESSION['ath'])) {
    header("location:../index.php");
    die();
}
if ($_SESSION['ath'] != "administrador" && $_SESSION['ath'] != "normal") {
    header("location:../index.php");
    die();
}

?>