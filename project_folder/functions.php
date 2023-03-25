<?php

require_once 'data.php';

function load(array &$data): array
{
    foreach ($_POST as $k => $v) {
        if (array_key_exists($k, $data)) {
            $data[$k]['value'] = $v;
        }
    }
    return $data;
}

function calculateHowManyDaysYouLive(array $data): int
{
    $day = $data['day']['value'];
    $month = $data['month']['value'];
    $year = $data['year']['value'];
    $currentDate = date('Y-m-d H:i:s');
    $otherDate = DateTime::createFromFormat('Y-m-d H:i:s', "$year-$month-$day 00:00:00");
    $interval = date_diff(new DateTime($currentDate), $otherDate);
    return $interval->days;
}

function getDaysLivedMessage(array $data): string
{
    if (checkdate($data['month']['value'], $data['day']['value'], $data['year']['value']) == false) {
        return "Input is NOT correct";
    }
    $daysLived = calculateHowManyDaysYouLive($data);

    //Forming the future $message
    if ($daysLived < 0) {
        $message = "You were never born";
    } elseif ($daysLived == 0) {
        $message = "Happy birthday to you!";
    } elseif ($daysLived == 1) {
        $message = "You have been alive for $daysLived day.";
    } else {
        $message = "You have been alive for $daysLived days.";
    }
    return $message;
}
?>