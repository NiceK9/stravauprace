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

define ("TIME_FORMAT", 'Y-m-d H:i:s');
define ("TIME_INPUT_FORMAT", 'Y-m-d');

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
	
	public function getAthleteClubs($id = null)
	{
		$athlete = $this->client->getAthlete($id);
		if($athlete != null)
		{
			return $athlete["clubs"];
		}
		return null;
	}
	
	public function getClub($clubId)
	{
		return $this->client->getClub($clubId);
	}
	
	public function getClubRawActivities($clubId)
	{
		return $this->client->getClubActivities($clubId);
	}
	
	public function getClubActivitiesWithFilter($clubId, $onDateStr)
	{
		$clubInfos = new Club();
		$clubInfos->activities = array();
		$clubInfos->totalDistance = 0;
		$activities = $this->client->getClubActivities($clubId, 1, 200);		
		$club = $this->client->getClub($clubId);
		$clubInfos->name = $club["name"];
		$clubInfos->totalMembers = $club["member_count"];
		$counter = count($activities);
		if($counter>0)
		{
			$inputDate = DateTime::createFromFormat(TIME_INPUT_FORMAT, $onDateStr);
			$minPaceArrs = explode(":", Rules::$MIN_PACE);
			$maxPaceArrs = explode(":", Rules::$MAX_PACE);
			$minSeconds = ($minPaceArrs[0]*60 + (count($minPaceArrs)>1?$minPaceArrs[1]:0));
			$maxSeconds = ($maxPaceArrs[0]*60 + (count($maxPaceArrs)>1?$maxPaceArrs[1]:0));
			$idx = 0;
			for($i = 0; $i < $counter; $i++)
			{
				$strDate = $activities[$i]['start_date_local'];
				$strDate = str_replace("T", " ", $strDate);
				$strDate = str_replace("Z", "", $strDate);
				$activityDate = DateTime::createFromFormat(TIME_FORMAT, $strDate);
				$avgSecondToRun = StravaApi::speed_SecondsPerKm($activities[$i]['average_speed']);
				if($inputDate->format('Y-m-d') === $activityDate->format('Y-m-d') 	 
				 && strcmp($activities[$i]['type'], "Run")==0)
				 {
					$tmpActivity = new Activity();
					$tmpActivity->Id = $activities[$i]['id'];
					$tmpActivity->athleteId = $activities[$i]['athlete']['id'];
					$tmpActivity->athleteName = $activities[$i]['athlete']['firstname'] . " " . $activities[$i]['athlete']['lastname'];
					$tmpActivity->type = $activities[$i]['type'];
					$tmpActivity->distance = ($activities[$i]['distance']/1000);
					$tmpActivity->duration = StravaApi::secondToStr($activities[$i]['moving_time']);
					
					$tmpActivity->startTime = $strDate;
					$tmpActivity->avgPace = StravaApi::convertSpeedToPace($activities[$i]['average_speed']);
					if($avgSecondToRun>= $minSeconds && $avgSecondToRun <= $maxSeconds && $activities[$i]['distance'] >= Rules::$MIN_DISTANCE){
						$tmpActivity->isValid = true;
						$isDistX2 = $this->isDatetimeValidInArray(Rules::$DATE_THEWORLD_X2, $activityDate) || (Rules::$IS_FEMALE_X2_DISTANCE && StravaApi::in_array_r($tmpActivity->athleteId, Rules::$FEMALE_IDS));
						if($isDistX2){
							$clubInfos->totalDistance += $activities[$i]['distance']*2;
							$tmpActivity->bonusDistance = ($activities[$i]['distance']/1000);
							$tmpActivity->isPowerX2 = true;
						}
						else{
							$clubInfos->totalDistance += $activities[$i]['distance'];
							$tmpActivity->bonusDistance = 0;
							$tmpActivity->isPowerX2 = false;
						}
					}
					else
						$tmpActivity->isValid = false;
					
					$clubInfos->activities[$idx++] = $tmpActivity;
				 }
			}				
		}
		
		return $clubInfos;
	}
	
	public function getClubTotalDistance($clubId, $fromDate, $toDate)
	{
		$clubInfos = new Club();
		$clubInfos->totalDistance = 0;
		// Debug detail
		//$clubInfos->activities = array();
		$activities = $this->client->getClubActivities($clubId);
		$club = $this->client->getClub($clubId);
		$clubInfos->name = $club["name"];
		$clubInfos->totalMembers = $club["member_count"];
		$counter = count($activities);
		if($counter>0)
		{
			$inputDateFrom = DateTime::createFromFormat(TIME_FORMAT, $fromDate);
			$inputDateTo = DateTime::createFromFormat(TIME_FORMAT, $toDate);
			$minPaceArrs = explode(":", Rules::$MIN_PACE);
			$maxPaceArrs = explode(":", Rules::$MAX_PACE);
			$minSeconds = ($minPaceArrs[0]*60 + (count($minPaceArrs)>1?$minPaceArrs[1]:0));
			$maxSeconds = ($maxPaceArrs[0]*60 + (count($maxPaceArrs)>1?$maxPaceArrs[1]:0));
			$idx = 0;
			for($i = 0; $i < $counter; $i++)
			{
				$strDate = $activities[$i]['start_date_local'];
				$strDate = str_replace("T", " ", $strDate);
				$strDate = str_replace("Z", "", $strDate);
				$activityDate = DateTime::createFromFormat(TIME_FORMAT, $strDate);
				$avgSecondToRun = StravaApi::speed_SecondsPerKm($activities[$i]['average_speed']);
				if($activityDate >= $inputDateFrom && $activityDate <= $inputDateTo && strcmp($activities[$i]['type'], "Run")==0)
				 {
					// $tmpActivity = new Activity();
					// $tmpActivity->Id = $activities[$i]['id'];
					// $tmpActivity->athleteId = $activities[$i]['athlete']['id'];
					// $tmpActivity->athleteName = $activities[$i]['athlete']['firstname'] . " " . $activities[$i]['athlete']['lastname'];
					// $tmpActivity->type = $activities[$i]['type'];
					// $tmpActivity->distance = ($activities[$i]['distance']/1000);
					// $tmpActivity->duration = StravaApi::secondToStr($activities[$i]['moving_time']);
					
					// $tmpActivity->startTime = $strDate;
					// $tmpActivity->avgPace = StravaApi::convertSpeedToPace($activities[$i]['average_speed']);
					if($avgSecondToRun>= $minSeconds && $avgSecondToRun <= $maxSeconds && $activities[$i]['distance'] >= Rules::$MIN_DISTANCE){
						//$tmpActivity->isValid = true;
						$isDistX2 = $this->isDatetimeValidInArray(Rules::$DATE_THEWORLD_X2, $activityDate) || (Rules::$IS_FEMALE_X2_DISTANCE && StravaApi::in_array_r($tmpActivity->athleteId, Rules::$FEMALE_IDS));
						if($isDistX2){
							$clubInfos->totalDistance += $activities[$i]['distance']*2;
							$tmpActivity->isPowerX2 = true;
						}
						else{
							$clubInfos->totalDistance += $activities[$i]['distance'];
							$tmpActivity->isPowerX2 = false;
						}
					}
					// else
						// $tmpActivity->isValid = false;
					//$clubInfos->activities[$idx++] = $tmpActivity;
				 }
			}				
		}
		
		return $clubInfos;
	}
	
	public function reportMultiClubsWithSort($clubIds, $fromDate, $toDate)
	{
		$clubs = array();
		$counter = count($clubIds);
		for($i = 0; $i < $counter; $i++)
		{
			$clubs[$i] = $this->getClubTotalDistance($clubIds[$i], $fromDate, $toDate);
		}
		usort($clubs, array("StravaApi", "uCompare"));
		return $clubs;
	}
	
	static function uCompare($clubA, $clubB)
	{
		if($clubA->totalDistance == $clubB->totalDistance)
			return 0;
		return ($clubA->totalDistance < $clubB->totalDistance ? -1 : 1);
	}
	
	//// Static functions ////
	//////////////////////////
	public static function speed_SecondsPerKm($speed)
	{
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
	
	// $arrDateTimeStr: string array with datetime formated
	// $myDateTime: datetime object
	public static function isDatetimeValidInArray($arrDateTimeStr, $myDateTime)
	{
		if($arrDateTimeStr==null || count($arrDateTimeStr)==0)
			return false;
		for($i = 0; $i < count($arrDateTimeStr); $i++)
		{
			$tmpDate = DateTime::createFromFormat(TIME_INPUT_FORMAT, $arrDateTimeStr[$i]);
			if($tmpDate->format('Y-m-d') === $myDateTime->format('Y-m-d'))
				return true;
		}
		return false;
	}
	
	public static function in_array_r($item , $array){
		return preg_match('/"'.$item.'"/i' , json_encode($array));
	}
}
?>
