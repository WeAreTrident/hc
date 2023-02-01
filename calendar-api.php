<?php
    require_once('config/config.php');
    require_once('includes/google_functions.php');
    require_once('includes/microsoft_functions.php');

    if(isSet($_POST['delete'])) {
        $eventID = strip_tags($_POST['delete']);
        if (isGoogleConnected() && googleHasEvent($eventID)) {
            try {
                deleteEventFromGoogle($eventID);
            }catch(\Exception $e) {}
        }
        if (isMicrosoftConnected() && microsoftHasEvent($eventID)) {
            try {
                deleteEventFromMicrosoft($eventID);
            }catch(\Exception $e) {}
        }
        executeQuery("DELETE FROM `events` WHERE `username`='".$_SESSION['username']."' AND `id`='".$eventID."'");
        die(json_encode(['status'=>'success']));
    }

    $date = date('m/d/Y');
    if (isSet($_GET['date']))
        $date = strip_tags($_GET['date']);
    $date = datetime::createfromformat('m/d/Y', $date);
    $q = executeQuery("SELECT * FROM `events` WHERE `username`='".$_SESSION['username']."' AND `start` LIKE '".$date->format('Y-m-d')."%'");
    $events = [];
    while ($row = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
        $start = datetime::createfromformat('Y-m-d H:i:s', $row['start']);
        $end = datetime::createfromformat('Y-m-d H:i:s', $row['end']);

        $row['start_str'] = $start->format('H:ia');
        $row['end_str'] = $end->format('H:ia');

        if ($row['all_day']) {
            $row['period_str'] = 'All Day';
        }else{
            $diff = $start->diff($end);
            $hrs = $diff->format('%h');
            if ($hrs > 0) {
                if ($diff->format('%m') > 0) {
                    $row['period_str'] = $hrs.' '.plural($hrs, 'hour').' '.$diff->format('%i').' mins';
                }else
                    $row['period_str'] = $hrs.' '.plural($hrs, 'hour');
            }else{
                if ($diff->format('%i') > 0) {
                    $row['period_str'] = $diff->format('%i').' mins';
                }else
                    $row['period_str'] = 'All Day';
            }
        }
        
        $events[] = $row;
    }
    echo json_encode(['events'=>$events]);

    function plural($num, $str) {
        return ($num == 1 ? $str : $str.'s');
    }
?>