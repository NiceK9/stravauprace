<?php
// // error_reporting(0);
// // ini_set("display_errors", 0);
// ini_set('max_execution_time', 6000); //300 seconds = 5 minutes

// include_once('StravaApi.php');
// $api = new StravaApi("341fb37b2f57b6499dff7b4c13944ddea6644fac"); //access token of Nice
// $configDay = Rules::$configDays[Rules::$currentDay];

// echo '<pre>';

// // print_r($api->getActivity("1672003095"));
// print_r($api->fetchActivity("1672003095", $configDay['from'], $configDay['to']));

// echo '</pre>';


include_once 'configSubscription.php';
include_once 'StravaApiExt.php';

$activity_id = "1672003095";
$token_user = "341fb37b2f57b6499dff7b4c13944ddea6644fac";
$activity = fetchActivity($activity_id, $token_user)[0];

var_dump($activity);

$athleteId = $activity->athlete->id;
$type = $activity->type;
$distance = ($activity->distance/1000);
$duration = secondToStr($activity->moving_time);

$strDate = $activity->start_date_local;
$strDate = str_replace("T", " ", $strDate);
$strDate = str_replace("Z", "", $strDate);
$activityDate = DateTime::createFromFormat(TIME_FORMAT, $strDate, new DateTimeZone($activity->timezone));
$activityDate->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh')); //convert GMT +7
$strDate = $activityDate->format(TIME_FORMAT);
$startTime = $strDate;
$avgPace = convertSpeedToPace($activity->average_speed);

echo "</br>".$athleteId;	
?>


