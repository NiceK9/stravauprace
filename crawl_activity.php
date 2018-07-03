<?php
// error_reporting(0);
// ini_set("display_errors", 0);
ini_set('max_execution_time', 6000); //300 seconds = 5 minutes

include_once('StravaApi.php');
$api = new StravaApi("341fb37b2f57b6499dff7b4c13944ddea6644fac"); //access token of Nice
$configDay = Rules::$configDays[Rules::$currentDay];

echo '<pre>';

// print_r($api->getActivity("1672003095"));
print_r($api->fetchActivity("1672003095", $configDay['from'], $configDay['to']));

echo '</pre>';
?>


