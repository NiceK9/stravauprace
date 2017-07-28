<?php
// error_reporting(0);
// ini_set("display_errors", 0);

include_once('StravaApi.php');
$api = new StravaApi("c56d24c43d4aaa704670521c6e31b09e655a42de");

	//////////////////////////// Find Athlete ////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////
	// $athlete =$api->getCurrentAthlete("16397134");
	// print_r($athlete);
	
	//////////////////////////////// Find Club ///////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////
	// $club = $api->getClub(294541);
	// print_r($club);

	//////////////////////////// Find Athlete's Club /////////////////////////////
	//////////////////////////////////////////////////////////////////////////////
	// $clubs =$api->getAthleteClubs();
	// if($clubs!=null)
	// {
		// $clubSize = count($clubs);
		// if($clubSize>0)
		// {
			// for($i = 0; $i< $clubSize; $i++)
				// echo("[Club][". $clubs[$i]["id"]."] " . $clubs[$i]["name"] . "<br>");
		// } else {
			// print('No clubs found!');
		// }
	// } else {
		// print('No Athlete found!');
	// }
		
	//////////////////////////// Find Raw Club's Activities////////////////////
	//////////////////////////////////////////////////////////////////////////////
	// $club = $api->getClubRawActivities(298988);
	// print_r($club);

	
	//////////////////////////// Find Club's Activities ///////////////////////////
	//////////////////////////////////////////////////////////////////////////////
	// $clubId = 298988; // GST-LienQuan
	// $clubInfo =$api->getClubActivitiesWithFilter($clubId, "2017-07-26");
	// if($clubInfo!=null)
	// {
		// echo ("Club " . $clubInfo->name . "<br>");
		// echo ("Total distance : " . ($clubInfo->totalDistance/1000) . " (km)<br>");
		// echo ("Total member : " . ($clubInfo->totalMembers) . " members<br>");
		// $activities = $clubInfo->activities;
		// $counter = count($activities);
		// for($i = 0; $i<$counter; $i++)
		// { 
			// $content = ("[".$activities[$i]->athleteId . "][" . $activities[$i]->startTime . "] " . $activities[$i]->athleteName . " " . $activities[$i]->type . " " . $activities[$i]->distance . "(km)(bonus: ".$activities[$i]->bonusDistance." km) in " . $activities[$i]->duration . " with pace " . $activities[$i]->avgPace . "<br>");
			// if($activities[$i]->isValid)
			// {
				// if($activities[$i]->isPowerX2){
					// $content = "[POWER X2]" . $content;
					// echo "<div style ='color:#1858bf'> $content </div>";
					
				// } else {
					// $content = "[OK]" . $content;
					// echo $content;
				// }
			// }
			// else{
				// $content = "[INVALID]" . $content;
				// echo "<div style ='color:#ff0000'> $content </div>"; 
			// }
		// }
	// } else {
		// echo ("Hmm");
	// }
	
	
	///////////////////////////// Find Club's Total distance /////////////////////
	//////////////////////////////////////////////////////////////////////////////
	// $clubId = 230974; // VNG Run Club
	// $clubInfo =$api->getClubTotalDistance($clubId, "2017-07-24 00:00:00", "2017-07-29 00:00:00");
	// if($clubInfo!=null)
	// {
		// echo ("Club " . $clubInfo->name . "<br>");
		// echo ("Total distance : " . ($clubInfo->totalDistance/1000) . " (km)<br>");
		// echo ("Total member : " . ($clubInfo->totalMembers) . " members<br>");
		// $activities = $clubInfo->activities;
		// $counter = count($activities);
		// for($i = 0; $i<$counter; $i++)
		// { 
			// $content = ("[".$activities[$i]->Id . "][" . $activities[$i]->startTime . "] " . $activities[$i]->athleteName . " " . $activities[$i]->type . " " . $activities[$i]->distance . "(km) in " . $activities[$i]->duration . " with pace " . $activities[$i]->avgPace . "<br>");
			// $content = ("[".$activities[$i]->Id . "][" . $activities[$i]->startTime . "] " . $activities[$i]->athleteName . " " . $activities[$i]->type . " " . $activities[$i]->distance . "(km)(bonus: ".$activities[$i]->bonusDistance." km) in " . $activities[$i]->duration . " with pace " . $activities[$i]->avgPace . "<br>");
			// if($activities[$i]->isValid)
			// {
				// $content = "[OK]" . $content;
				// echo $content;
			// }
			// else{
				// $content = "[INVALID]" . $content;
				// echo "<div style ='color:#ff0000'> $content </div>"; 
			// }
		// }
	// }
	
	///////////////////////////// Report all groups UP-RACE //////////////////////
	//////////////////////////////////////////////////////////////////////////////
	// 230974: VNG Run Club
	// 163276: SRC
	// 193097: YCB
	// 296230: Run2Dead
	// 298988: LienQuan GST
	// $clubIds = array(298988, 230974, 296230, 193097, 163276); // GST-LienQuan
	// $clubs = $api->reportMultiClubsWithSort($clubIds, "2017-07-27 00:00:00", "2017-07-29 00:00:00");
	// $counter = count($clubs);
	// for($i = 0; $i < $counter; $i++)
	// {
		// echo ("Club " . $clubs[$i]->name . "<br>");
		// echo ("Total distance : " . ($clubs[$i]->totalDistance/1000) . " (km)<br>");
		// echo ("Total member : " . ($clubs[$i]->totalMembers) . " members<br>");
		// echo (" ****************************************************** <br>");
	// }
?>
