<?php
    /** Cron which should be ran daily which will perform various actions such as interval based notifications */

    require_once("config/config.php");
    require_once("includes/classes/Notification.php");

    session_destroy();
    session_start();

    $f = fopen('calendar_cron.log', 'a');
    fwrite($f, '['.time().'] '.'Sync starting'.PHP_EOL);

    $q = executeQuery("SELECT * FROM `forms` WHERE `next_reminder` LIKE '".date('Y-m-d')." %'");
    while ($row = mysqli_fetch_array($q)) {
        $team = explode(',', $row['team_members']);
        foreach($team as $member) {
            (new Notification($GLOBALS['con'], $_SESSION['username']))->insertNotification('/form.php?id='.$row['id'], $member, 'form_reminder');
        }
        
        $date = date('Y-m-d');
        $nextReminder = date('Y-m-d', strtotime($date. ' + '.$row['reminderOne'].' '.$row['reminderTwo'].'s'));
        executeQuery("UPDATE `forms` SET `next_reminder`='".$nextReminder."' WHERE `id`='".$row['id']."'");
    }
?>