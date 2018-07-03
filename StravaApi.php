<?php
include 'vendor/autoload.php';
include 'sclass/Athlete.php';
include 'sclass/Activity.php';
include 'sclass/Club.php';
include 'Rules.php';

use Pest as Pest;
use Strava\API\Client;
use Strava\API\Exception;
use Strava\API\Service\REST;

define ("TIME_ZONE", 'Asia/Ho_Chi_Minh');
define ("TIME_FORMAT", 'Y-m-d H:i:s');
define ("TIME_INPUT_FORMAT", 'Y-m-d');

function log_debug($str){
	// echo($str."</br>");
	$file = 'log.txt';
	// Write the contents to the file, 
	// using the FILE_APPEND flag to append the content to the end of the file
	// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
	$str.="\n";
	file_put_contents($file, $str, FILE_APPEND | LOCK_EX);
}
	
class StravaApi{
	public $token;
	public $adapter;
	public $service ;
    public $client;
	
	public function __construct($tk) {
		try{
			$this->token = $tk;
			$this->adapter = new Pest('https://www.strava.com/api/v3');
			$this->service = new REST($this->token, $this->adapter);  // Define your user token here..
			$this->client = new Client($this->service);
			
		} catch(Exception $e){
			print $e->getMessage();
		}
    }
	
	public function getCurrentAthlete($id = null)
	{
		return $this->client->getAthlete($id);
	}
	
	
	public function getActivity($id)
	{
		return $this->client->getActivity($id);
	}
	
	public function fetchActivity($id, $fromDate, $toDate)
	{
		$activity = $this->client->getActivity($id);
		
		$inputDateFrom = DateTime::createFromFormat(TIME_FORMAT, $fromDate, new DateTimeZone(TIME_ZONE));
		$inputDateTo = DateTime::createFromFormat(TIME_FORMAT, $toDate, new DateTimeZone(TIME_ZONE));
		$minPaceArrs = explode(":", Rules::$MIN_PACE);
		$maxPaceArrs = explode(":", Rules::$MAX_PACE);
		$minSeconds = ($minPaceArrs[0]*60 + (count($minPaceArrs)>1?$minPaceArrs[1]:0));
		$maxSeconds = ($maxPaceArrs[0]*60 + (count($maxPaceArrs)>1?$maxPaceArrs[1]:0));
			
		// $strDate = $activity['start_date'];
		$strDate = $activity['start_date_local'];
		$strDate = str_replace("T", " ", $strDate);
		$strDate = str_replace("Z", "", $strDate);
		$activityDate = DateTime::createFromFormat(TIME_FORMAT, $strDate, new DateTimeZone($activity['timezone']));
		$activityDate->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh')); //convert GMT +7
		$strDate = $activityDate->format(TIME_FORMAT);
		
		$avgSecondToRun = StravaApi::speed_SecondsPerKm($activity['average_speed']);
		$isValid = $activityDate >= $inputDateFrom && $activityDate <= $inputDateTo 
			&& strcmp($activity['type'], "Run")==0 
			&& $avgSecondToRun >= $minSeconds 
			&& $avgSecondToRun <= $maxSeconds 
			&& $activity['distance'] >= Rules::$MIN_DISTANCE;

		$tmpActivity = new Activity();
		$tmpActivity->Id = $activity['id'];
		$tmpActivity->athleteId = $activity['athlete']['id'];
		$tmpActivity->type = $activity['type'];
		$tmpActivity->distance = ($activity['distance']/1000);
		$tmpActivity->duration = StravaApi::secondToStr($activity['moving_time']);
		
		$tmpActivity->startTime = $strDate;
		$tmpActivity->avgPace = StravaApi::convertSpeedToPace($activity['average_speed']);
		$tmpActivity->isValid = $isValid;

		return $tmpActivity;
	}
	
	//// Static functions ////
	//////////////////////////
	public static function speed_SecondsPerKm($speed)
	{
		if($speed == 0)
			return 0;
		return floor(1000 / $speed);
	}
	public static function secondToStr($seconds)
	{
		$surplus = $seconds % 60;
		$remain = $seconds - $surplus;
		return $remain / 60 . ":" . ($surplus<10?("0".$surplus) : $surplus);
	}
	public static function convertSpeedToPace($speed)
	{
		$secondsPerKm = StravaApi::speed_SecondsPerKm($speed);
		return StravaApi::secondToStr($secondsPerKm);
	}
}
?>
