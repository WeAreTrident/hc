<?php
    /** Cron which should be ran every 5/15 minutes which will sync calendar event information from all Google/365 calendars */

    require_once('includes/calendar_functions.php');
    require_once("config/config.php");

    session_destroy();
    session_start();

    $f = fopen('calendar_cron.log', 'a');
    fwrite($f, '['.time().'] '.'Sync starting'.PHP_EOL);

    $q = executeQuery("SELECT * FROM `google_calendar_accounts`");
    while ($row = mysqli_fetch_array($q)) {
        try {
            $_SESSION['username'] = $row['username'];
            fwrite($f, '['.time().'] '.'Syncing Google account for '.$_SESSION['username'].PHP_EOL);
            doGoogleSync();
        }catch(\Exception $e) {fwrite($f, '['.time().'] '.'*FAILURE ON ABOVE*'.PHP_EOL);}
    }

    $q = executeQuery("SELECT * FROM `microsoft_calendar_accounts`");
    while ($row = mysqli_fetch_array($q)) {
        try {
            $_SESSION['username'] = $row['username'];
            fwrite($f, '['.time().'] '.'Syncing Microsoft account for '.$_SESSION['username'].PHP_EOL);
            doMicrosoftSync();
        }catch(\Exception $e) {fwrite($f, '['.time().'] '.'*FAILURE ON ABOVE*'.PHP_EOL);}
    }

    fwrite($f, '['.time().'] '.'Sync complete'.PHP_EOL.PHP_EOL);
    fclose($f);
?>