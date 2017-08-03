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
	
	public function getClubMembers($clubId)
	{
		return $this->client->getClubMembers($clubId);
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
		$clubInfos->isSpyExist = false;
		$clubInfos->spyList = array();
		$counter = count($activities);
		$clubInfos->totalActivitiesCounter  = $counter;
		if($counter>0)
		{
			$inputDate = DateTime::createFromFormat(TIME_INPUT_FORMAT, $onDateStr);
			$minPaceArrs = explode(":", Rules::$MIN_PACE);
			$maxPaceArrs = explode(":", Rules::$MAX_PACE);
			$minSeconds = ($minPaceArrs[0]*60 + (count($minPaceArrs)>1?$minPaceArrs[1]:0));
			$maxSeconds = ($maxPaceArrs[0]*60 + (count($maxPaceArrs)>1?$maxPaceArrs[1]:0));
			$idx = 0;
			$spyCounter = 0;
			for($i = 0; $i < $counter; $i++)
			{
				if(StravaApi::in_array_r($activities[$i]['athlete']['id'], Rules::$SPY_IDS))
				{
					$athleteName = $activities[$i]['athlete']['firstname'] . " " . $activities[$i]['athlete']['lastname'];
					if(!$clubInfos->isSpyExist){
						$clubInfos->isSpyExist = true;
						$clubInfos->spyList[$spyCounter++] = $athleteName;
					}
					else {
						
						if(!StravaApi::in_array_r($athleteName, $clubInfos->spyList))
							$clubInfos->spyList[$spyCounter++] = $athleteName;
					}
					continue;
				}
				
				$strDate = $activities[$i]['start_date'];
				// $strDate = $activities[$i]['start_date_local'];
				$strDate = str_replace("T", " ", $strDate);
				$strDate = str_replace("Z", "", $strDate);
				$activityDate = DateTime::createFromFormat(TIME_FORMAT, $strDate);
				$activityDate->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh')); //convert GMT +7
				$strDate = $activityDate->format('Y-m-d H:i:s');
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

		$clubInfos->activities = array();
		$activities = $this->client->getClubActivities($clubId, 1, 200);		
		// print_r(json_encode($activities));
		
		$athletes =	$this->client->getClubMembers($clubId, 1, 200);
		
		$club = $this->client->getClub($clubId);
		$clubInfos->id = $club["id"];
		$clubInfos->name = $club["name"];
		$clubInfos->totalMembers = $club["member_count"];
		
		$clubInfos->athletes = array();
		for($i = 0; $i < count($athletes); $i++)
		{
			$athletes[$i]["name"] = $athletes[$i]['firstname'] . " " . $athletes[$i]['lastname'];
			$athletes[$i]["oridistance"] = 0;
			$athletes[$i]["distance"] = 0;
			$athletes[$i]["isspy"] = StravaApi::in_array_r($athletes[$i]['id'], Rules::$SPY_IDS);
			$clubInfos->athletes[$athletes[$i]["id"]] = $athletes[$i];
		}

		$clubInfos->isSpyExist = false;
		$clubInfos->spyList = array();
		
		$counter = count($activities);
		$clubInfos->totalActivitiesCounter  = $counter;
		log_debug("count act: ".$counter);
		if($counter>0)
		{
			$inputDateFrom = DateTime::createFromFormat(TIME_FORMAT, $fromDate, new DateTimeZone(TIME_ZONE));
			$inputDateTo = DateTime::createFromFormat(TIME_FORMAT, $toDate, new DateTimeZone(TIME_ZONE));
			$minPaceArrs = explode(":", Rules::$MIN_PACE);
			$maxPaceArrs = explode(":", Rules::$MAX_PACE);
			$minSeconds = ($minPaceArrs[0]*60 + (count($minPaceArrs)>1?$minPaceArrs[1]:0));
			$maxSeconds = ($maxPaceArrs[0]*60 + (count($maxPaceArrs)>1?$maxPaceArrs[1]:0));
			$idx = 0;
			$spyCounter = 0;
			for($i = 0; $i < $counter; $i++)
			{				
				log_debug("checking act: ".$counter);
				if(StravaApi::in_array_r($activities[$i]['athlete']['id'], Rules::$SPY_IDS))
				{
					$athleteName = $activities[$i]['athlete']['firstname'] . " " . $activities[$i]['athlete']['lastname'];
					if(!$clubInfos->isSpyExist){
						$clubInfos->isSpyExist = true;
						$clubInfos->spyList[$spyCounter++] = $athleteName;
					}
					else {
						
						if(!StravaApi::in_array_r($athleteName, $clubInfos->spyList))
							$clubInfos->spyList[$spyCounter++] = $athleteName;
					}
					continue;
				}
				
				$strDate = $activities[$i]['start_date'];
				// $strDate = $activities[$i]['start_date_local'];
				$strDate = str_replace("T", " ", $strDate);
				$strDate = str_replace("Z", "", $strDate);
				$activityDate = DateTime::createFromFormat(TIME_FORMAT, $strDate);
				$activityDate->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh')); //convert GMT +7
				$strDate = $activityDate->format(TIME_FORMAT);
				
				log_debug ($i." time ".($strDate)."</br>");
				log_debug ($i." condition 1 ".($fromDate)."</br>");
				log_debug ($i." condition 2 ".($toDate)."</br>");
				log_debug ($i." condition 3 ".($activities[$i]['type'])."</br>");
				log_debug ($i." condition 4 ".($activities[$i]['average_speed'])."</br>");
				if($activityDate >= $inputDateFrom && $activityDate <= $inputDateTo && strcmp($activities[$i]['type'], "Run")==0 && $activities[$i]['average_speed'] > 0)
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
					$avgSecondToRun = StravaApi::speed_SecondsPerKm($activities[$i]['average_speed']);
					
					$isTreadMill = $activities[$i]["manual"];
					$tmpActivity->isTreadMill = $isTreadMill;
					$tmpActivity->photoCount = $activities[$i]['total_photo_count'];
					$validTreadMill = $tmpActivity->photoCount >= Rules::$PHOTO_REQUIRE_TREADMILL;
					
					if($avgSecondToRun>= $minSeconds && $avgSecondToRun <= $maxSeconds && $activities[$i]['distance'] >= Rules::$MIN_DISTANCE){
						if($isTreadMill && (Rules::$BAN_TREADMILL == true || !$validTreadMill))
							$tmpActivity->isValid = false;
						else
						{
							$tmpActivity->isValid = true;
							$isDistX2 = $this->isDatetimeValidInArray(Rules::$DATE_THEWORLD_X2, $activityDate) || (Rules::$IS_FEMALE_X2_DISTANCE && StravaApi::in_array_r($activities[$i]['athlete']['id'], Rules::$FEMALE_IDS));
							if($isDistX2){
								$clubInfos->totalDistance += $activities[$i]['distance']*2/1000;
								$clubInfos->athletes[$activities[$i]['athlete']['id']]["oridistance"] += $activities[$i]['distance']/1000;
								$clubInfos->athletes[$activities[$i]['athlete']['id']]["distance"] += ($activities[$i]['distance']*2)/1000;
								$clubInfos->athletes[$activities[$i]['athlete']['id']]["sex"] = "F";
								$tmpActivity->isPowerX2 = true;
							}
							else{
								$clubInfos->totalDistance += $activities[$i]['distance']/1000;
								$clubInfos->athletes[$activities[$i]['athlete']['id']]["oridistance"] += $activities[$i]['distance']/1000;
								$clubInfos->athletes[$activities[$i]['athlete']['id']]["distance"] += $activities[$i]['distance']/1000;
								$clubInfos->athletes[$activities[$i]['athlete']['id']]["sex"] = "M";
								$tmpActivity->isPowerX2 = false;
							}
						}
					}
					else
						$tmpActivity->isValid = false;
					$clubInfos->activities[$idx++] = $tmpActivity;
				 }
			}				
		}		
		
		usort($clubInfos->athletes, array("StravaApi", "distCompare"));
		
		return $clubInfos;
	}
	
	public function reportMultiClubsWithSort($clubIds, $fromDate, $toDate, $filename)
	{
		$clubs = array();
		$counter = count($clubIds);
		for($i = 0; $i < $counter; $i++)
		{
			$clubs[$i] = $this->getClubTotalDistance($clubIds[$i], $fromDate, $toDate);
		}
		usort($clubs, array("StravaApi", "uCompare"));
				
		$current = json_encode($clubs);
		file_put_contents($filename, $current);
	
		return $clubs;
	}	
	
	static function makeTotalRanking($clubs)
	{
		$totalAthletes = array();
		foreach ($clubs as &$club)
		{ 		
			$totalAthletes = array_merge($totalAthletes, $club->athletes);
		}
		usort($totalAthletes, array("StravaApi", "distCompare"));
		return $totalAthletes;
	}
	
	static function distCompare($athleteA, $athleteB)
	{
		if($athleteA["distance"] == $athleteB["distance"])
			return 0;
		return ($athleteA["distance"] > $athleteB["distance"] ? -1 : 1);
	}
	
	static function distCompareObject($athleteA, $athleteB)
	{
		if($athleteA->distance == $athleteB->distance)
			return 0;
		return ($athleteA->distance > $athleteB->distance ? -1 : 1);
	}
	
	static function uCompare($clubA, $clubB)
	{
		if($clubA->totalDistance == $clubB->totalDistance)
			return 0;
		return ($clubA->totalDistance > $clubB->totalDistance ? -1 : 1);
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
