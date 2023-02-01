<?php
    require_once('includes/microsoft_functions.php');

    if (!isSet($_GET['code'])) {
        header("Location:settings.php?microsoft-scope-error");
        exit();
    }

    $code = htmlspecialchars(strip_tags(trim($_GET['code'])));

    // Convert $code to a proper token
    $token = performMicrosoftToken($token, $code);
    // die(var_dump($token));

    // Check for errors in the token response
    if (!$token || array_key_exists('error', $token)) {
        if (array_key_exists('error', $token) && $token['error'] == 'invalid_grant' && array_key_exists('suberror', $token) && $token['suberror'] == 'consent_required') {
            header("Location:https://login.microsoftonline.com/common/adminconsent?client_id=".$client_id);
            exit();
        }
        header("Location:settings.php?microsoft-scope-error");
        exit();
    }

    // Token was successful, get the users email via /me endpoint
    $me = getMicrosoftMe();
    $email = $me['userPrincipalName'];

    // Store/update the token data
    executeQuery("
        INSERT IGNORE INTO `microsoft_calendar_accounts`(`username`,`email`,`access_token`,`refresh_token`,`token_data`) VALUES(
            '".$_SESSION['username']."','".$email."','".$token['access_token']."','".$token['refresh_token']."','".json_encode($token)."'
        ) ON DUPLICATE KEY UPDATE `email`='".$email."',`access_token`='".$token['access_token']."',`refresh_token`='".$token['refresh_token']."',`token_data`='".json_encode($token)."'
    ");

    doInitialMicrosoftSync();

    header("Location:settings.php?microsoft-connected");
    exit();
?>