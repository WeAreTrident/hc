<?php
    require_once('includes/google_functions.php');

    $client = authoriseGoogle(true);
    if ($client) {
        header("Location:settings.php?google-already-connected");
        exit();
    }
    header("Location:settings.php");
    exit();
?>