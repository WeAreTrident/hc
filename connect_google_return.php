<?php
    require_once('includes/google_functions.php');

    if (!isSet($_GET['code']) || !isSet($_GET['scope'])) {
        header("Location:settings.php?google-scope-error");
        exit();
    }

    $client = getClient();

    if (!$client) {
        header("Location:settings.php?google-scope-error");
        exit();
    }

    // code=4/0AX4XfWiIOA6gI8zoiaJDJmVBQFje6r2NL7x-6H00jeT9Lg-PNzmtDes4MH6B4doMa3kFmw
    // scope=https://www.googleapis.com/auth/calendar.events%20https://www.googleapis.com/auth/calendar
    $code = htmlspecialchars(strip_tags(trim($_GET['code'])));
    $scopes = explode(' ', htmlspecialchars(strip_tags(trim($_GET['scope']))));
    if (
        !in_array('https://www.googleapis.com/auth/calendar', $scopes)
        ||
        !in_array('https://www.googleapis.com/auth/calendar.events', $scopes)
        ) {
        header("Location:settings.php?google-scope-error");
        exit();
    }

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (array_key_exists('error', $token)) {
        header("Location:settings.php?google-scope-error");
        exit();
    }

    executeQuery("
        INSERT IGNORE INTO `google_calendar_accounts`(`username`,`access_token`,`refresh_token`,`token_data`) VALUES(
            '".$_SESSION['username']."','".$token['access_token']."','".$token['refresh_token']."','".json_encode($token)."'
        ) ON DUPLICATE KEY UPDATE `access_token`='".$token['access_token']."',`refresh_token`='".$token['refresh_token']."',`token_data`='".json_encode($token)."'
    ");

    doInitialGoogleSync();

    header("Location:settings.php?google-connected");
    exit();
?>