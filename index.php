<?php
// error_reporting(0);
// ini_set("display_errors", 0);
ini_set('max_execution_time', 6000); //300 seconds = 5 minutes

include_once('StravaApi.php');
// $api = new StravaApi("c56d24c43d4aaa704670521c6e31b09e655a42de"); //access token of buhu
// $api = new StravaApi("fd76e56b9f860e40486315f4043298a266968a52"); //access token of Nice
// $api = new StravaApi("c138b46d4d1d1d27d0df268499ef0a3dbedfeb0e"); //access token of BTC UpRace HCM
$api = new StravaApi("aab65002d2b37ec719b3f7191fb77599183b6f88"); //access token of BTC UpRace HN
	//////////////////////////// Find Athlete ////////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////
	// $athlete =$api->getCurrentAthlete("16397134");
	// print_r($athlete);
	
	//////////////////////////////// Find Club ///////////////////////////////////
	//////////////////////////////////////////////////////////////////////////////
	// $club = $api->getClub(294541);
	// print_r($club);

	//////////////////////////////// Find Club Members ///////////////////////////
	//////////////////////////////////////////////////////////////////////////////
	// $club = $api->getClubMembers(230974);
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
			// {				
				// echo("<br>[Club][". $clubs[$i]["id"]."] [" . $clubs[$i]["name"] . "]");
				// $athletes =	$api->client->getClubMembers($clubs[$i]["id"], 1, 200);
				// echo(" [Member count: ". count($athletes) . "]<br>");
				// for($j = 0; $j < count($athletes); $j++)
				// {
					// if(!StravaApi::in_array_r($athletes[$j]["id"], Rules::$SPY_IDS))
					// {
						// if(in_array((int)$athletes[$j]["id"], Rules::$ID_ATHLETES))
						// {							
							// echo("[VALID]".$athletes[$j]["id"]."</br>");
							// array_splice(Rules::$ID_ATHLETES, array_search((int)$athletes[$j]["id"], Rules::$ID_ATHLETES), 1);
							
						// }	
						// else{
							// echo("[INVALID]".$athletes[$j]["id"]."</br>");
						// }
					// }
					
				// }
				// echo("<br>");
			// }
		// } else {
			// print('No clubs found!');
		// }
	// } else {
		// print('No Athlete found!');
	// }
	// print_r(json_encode(Rules::$ID_ATHLETES));
	// exit();
	//////////////////////////// Find Raw Club's Activities////////////////////
	//////////////////////////////////////////////////////////////////////////////
	// $club = $api->getClubRawActivities(298988);
	// print_r($club);

	
	//////////////////////////// Find Club's Activities ///////////////////////////
	//////////////////////////////////////////////////////////////////////////////
	// $clubId = 230974; // VNG-RunClub
	// $clubInfo =$api->getClubActivitiesWithFilter($clubId, "2017-07-26");
	// if($clubInfo!=null)
	// {
		// echo ("Club " . $clubInfo->name . "<br>");
		// echo ("Total distance : " . ($clubInfo->totalDistance/1000) . " (km)<br>");
		// echo ("Total members : " . ($clubInfo->totalMembers) . " members<br>");
		// echo ("Total activities without filter in this time : " . ($clubInfo->totalActivitiesCounter) . " <br>");
		// if($clubInfo->isSpyExist){
			// $spyCount = count($clubInfo->spyList);
			// echo ("Total members (without spy) : " . ($clubInfo->totalMembers - $spyCount) . " members<br>Spy list:<br>");
			// for($j = 0; $j < $spyCount; $j++)
				// echo ("&nbsp&nbsp * " . $clubInfo->spyList[$j] . "<br>");
		// }
		// $activities = $clubInfo->activities;
		// $counter = count($activities);
		// for($i = 0; $i<$counter; $i++)
		// { 
			// $bonusDistance = $activities[$i]->bonusDistance>0?("(bonus ".$activities[$i]->bonusDistance." km)") : " ";
			// $content = ("[".$activities[$i]->athleteId . "][" . $activities[$i]->startTime . "] " . $activities[$i]->athleteName . " " . $activities[$i]->type . " " . $activities[$i]->distance . "(km)" .$bonusDistance." in " . $activities[$i]->duration . " with pace " . $activities[$i]->avgPace . "<br>");
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
	// $clubId = 298988; // LienQuan GST
	// $clubInfo =$api->getClubTotalDistance($clubId, "2017-08-3 00:00:00", "2017-08-3 23:59:59");
	// if($clubInfo!=null)
	// {
		// echo ("Club " . $clubInfo->name . "<br>");
		// echo ("Total distance : " . ($clubInfo->totalDistance/1000) . " (km)<br>");
		// echo ("Total activities without filter in this time : " . ($clubInfo->totalActivitiesCounter) . " <br>");
		// echo ("Total members : " . ($clubInfo->totalMembers) . " members<br>");
		// if($clubInfo->isSpyExist){
			// $spyCount = count($clubInfo->spyList);
			// echo ("Total members (without spy) : " . ($clubInfo->totalMembers - $spyCount) . " members<br>Spy list:<br>");
			// for($j = 0; $j < $spyCount; $j++)
				// echo ("&nbsp&nbsp * " . $clubInfo->spyList[$j] . "<br>");
		// }
		// $activities = $clubInfo->activities;
		// $counter = count($activities);
		// for($i = 0; $i<$counter; $i++)
		// { 
			// $bonusDistance = $activities[$i]->bonusDistance>0?("(bonus ".$activities[$i]->bonusDistance." km)") : " ";
			// $content = ("[".$activities[$i]->athleteId . "][" . $activities[$i]->startTime . "] " . $activities[$i]->athleteName . " " . $activities[$i]->type . " " . $activities[$i]->distance . "(km)" .$bonusDistance." in " . $activities[$i]->duration . " with pace " . $activities[$i]->avgPace . "<br>");
			// if($activities[$i]->isTreadMill)
				// $content = "[TreadMill][Photo ".$activities[$i]->photoCount."]". $content;
			
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
	// exit();
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
	//Display UI all score
	$clubIds = array(
	// 298988 //LienQuan GST
	// ,296230 //Run2Dead
	// ,298756 //Run2Dead
	// ,288686 //Gia Dinh
	// 230974 // VNG Run Club
	// ,163276 // SRC
	// ,193097 // YCB
	
	// group of HCM
	// 295557,
	// 295587,
	// 297405,
	// 297386,
	// 299848,
	// 299859,
	// 300344,
	// 299571,
	// 301338
	
	//group of HN
	300411, //Start HN
	301318, //Fast And Furious 9
	300383, //Biệt đội "."
    299042, //SunMoon
	301102, //Ban "Cờ - him"
	299004, //Team Rồng
	301591, //Tia chớp
	301264, //ÂM THỊNH
	300407, //Đôi cánh thiên thần 
	300091, //Lộn cái bàn
	300410, //GSN.Young
	300382, //ZSL - Super girl
	301784, //Meow Meow
	301778, //Kiểu gì cũng về đích
	300385, //Pikachu
	301533, //Chạy everywhere
	301815, //Lết
	
	);
	
	
	$clubIdsHN_A = array(	//5 nguoi
	//group of HN
	301318, //Fast And Furious 9
    299042, //SunMoon
	301591, //Tia chớp
	300091, //Lộn cái bàn
	300382, //ZSL - Super girl
	301784, //Meow Meow
	301778, //Kiểu gì cũng về đích
	301815, //Lết
	300385, //Pikachu
	301533, //Chạy everywhere
	301839, //Gừng Già
	
	//group hcm
// 294539,
// 294550,
// 295557,
// 295380,
// 295587,
// 297405,
// 297386,
// 299848,
// 299836,
// 294773,
// 300341,
// 297935,
// 298988,
// 294541,
// 298475,
// 299859,
// 299841,
// 300344,
// 299571,
// 298477,
// 299858,
// 301338,
// 301243,
// 299862,
// 299882,
// 298207,
// 298999,
// 297140,
// 297957,
// 301256,
// 298753,
// 299871,
// 298768,
// 300376,
// 300080,
// 298867,
// 298206,
// 300661,
// 301790,
// 295285,
// 296844,
// 299884,
// 298251,
// 297997,
// 298232,
// 300093,
// 300065,
// 300643,
// 297115,
// 301594,
// 301588,
// 301813,
// 301796,
// 299620,
// 298841,
// 300365,
	
	);
	$clubIdsHN_B = array(	//10 nguoi
	//group of HN
	300411, //Start HN
	300383, //Biệt đội "."
	300410, //GSN.Young
	300407, //Đôi cánh thiên thần 
	301264, //ÂM THỊNH
	299004, //Team Rồng
	301102, //Ban "Cờ - him"
	
	);
	$prefixTable = "A";	
	$file = 'data_cache/'.$prefixTable.'_day_4.json';
	$clubs = $api->reportMultiClubsWithSort($clubIdsHN_A, "2017-08-6 00:00:00", "2017-08-6 23:59:59", $file);
	$counter = count($clubs);
	
	
	$prefixTable = "B";
	$file = 'data_cache/'.$prefixTable.'_day_3.json';
	$clubs = array_merge($api->reportMultiClubsWithSort($clubIdsHN_B, "2017-08-6 00:00:00", "2017-08-6 23:59:59", $file), $clubs);
	$counter = count($clubs);
	
	//debug info
	for($n = 0; $n < $counter; $n++)
	{
		$clubInfo = $clubs[$n];
		
		if($clubInfo!=null)
		{
			// echo ("Club " . $clubInfo->name . "<br>");
			// echo ("Total distance : " . ($clubInfo->totalDistance/1000) . " (km)<br>");
			// echo ("Total member : " . ($clubInfo->totalMembers) . " members<br>");
			$activities = $clubInfo->activities;
			$countAct = count($activities);
			for($i = 0; $i<$countAct; $i++)
			{ 
				$content = ("[".$activities[$i]->Id . "][" . $activities[$i]->startTime . "] " . $activities[$i]->athleteName . " " . $activities[$i]->type . " " . $activities[$i]->distance . "(km) in " . $activities[$i]->duration . " with pace " . $activities[$i]->avgPace . "<br>");
				$content = ("[".$activities[$i]->Id . "][" . $activities[$i]->startTime . "] " . $activities[$i]->athleteName . " " . $activities[$i]->type . " " . $activities[$i]->distance . "(km)(bonus: ".$activities[$i]->bonusDistance." km) in " . $activities[$i]->duration . " with pace " . $activities[$i]->avgPace . "<br>");
				if($activities[$i]->isValid)
				{
					$content = "[OK]" . $content;
					echo $content;
				}
				else{
					$content = "[INVALID]" . $content;
					echo "<div style ='color:#ff0000'> $content </div>"; 
				}
			}

			$athletes = $clubInfo->athletes;
			foreach ($athletes as &$athlete)
			{ 
				$content = ("[".$athlete["id"] . "] " . $athlete["name"]. " run " . $athlete["distance"] . "(km)<br>");
				echo $content;
			}		
			

		}
	}
		
	$totalAthletes = array();
	for($d = 1; $d <= 12; $d++)
	{
		$filename = 'data_cache/A_day_'.$d.".json";
		if (file_exists($filename)) 
		{
			$records = json_decode(file_get_contents($filename));
			foreach ($records as &$record)
			{
				foreach ($record->athletes as &$athlete)
				{
					$added = false	;		
					foreach ($totalAthletes as &$athleteInTable)
					{ 
						if ($athlete->id == $athleteInTable->id) {
							$athleteInTable->oridistance += $athlete->oridistance;
							$athleteInTable->distance += $athlete->distance;
							$added = true;
							break;
						}
					}
					
					if($added == false)
						array_push($totalAthletes, $athlete);
				}
			}
		}
		$filename = 'data_cache/B_day_'.$d.".json";
		if (file_exists($filename)) 
		{
			$records = json_decode(file_get_contents($filename));
			foreach ($records as &$record)
			{
				foreach ($record->athletes as &$athlete)
				{
					$added = false	;		
					foreach ($totalAthletes as &$athleteInTable)
					{ 
						if ($athlete->id == $athleteInTable->id) {
							$athleteInTable->oridistance += $athlete->oridistance;
							$athleteInTable->distance += $athlete->distance;
							$added = true;
							break;
						}
					}
					
					if($added == false)
						array_push($totalAthletes, $athlete);
				}
			}
		}
	}
	
	usort($totalAthletes, array("StravaApi", "distCompareObject"));
	// print_r(json_encode($totalAthletes));
	file_put_contents("data_cache/total_ranking.json", json_encode($totalAthletes));
?>

<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Bootstrap custom collapse table</title>
  
  
  <link rel='stylesheet prefetch' href='https://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.css'>

      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>
  
<div class="page-header">
  <h1>Bảng xếp hạng UpRace<small></small></h1>
</div>
<div class="well">
  <span>VNG Run Club</span>
</div>
<!-- CUSTOM BOOTSTRAP ELEMENT -->
<div class="collapse-custom">
  <!-- HEADING -->
  <nav class="navbar navbar-default navbar-heading" role="navigation">
    <div class="navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="one"><a>Thứ hạng</a></li>
        <li class="two"><a>Đội</a></li>
        <li class="three"><a>Tổng</a></li>
	<?php
		$numDay = 12;
		for($countDay = 1; $countDay <= $numDay; $countDay++)
		{		
	?>
		<li class="fore"><a><?php echo("Ngày ".$countDay); ?></a></li>
	<?php
		}
	?>
        
      </ul>
    </div>
  </nav>
  <!-- ROW 1 -->
  <?php
  	$counter = count($clubs);
	for($n = 0; $n < $counter; $n++)
	{
		$clubInfo = $clubs[$n];
		
		if($clubInfo!=null)
		{
  ?>
  <nav class="navbar navbar-default" role="navigation">
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" data-toggle="collapse" href=<?php echo('"#collapse'.$n.'"');?>>
      <ul class="nav navbar-nav">
        <li class="one"><a><?php echo($n + 1);?></a></li>
        <li class="two"><a><?php echo ($clubInfo->name);?></a></li>
        <li class="three"><a><?php echo ($clubInfo->totalDistance);?></a></li>
        <li class="four"><a><?php echo ($clubInfo->totalDistance);?></a></li>
      </ul>
    </div>
  </nav>
  <!-- HIDDING CONTANT -->
  <div id=<?php echo('"collapse'.$n.'"');?> class="collapse" data-parent="bs-example-navbar-collapse-1">

  <div class="container">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            Thành viên
                        </th>
                        <th>
                            Tổng
                        </th>
<?php
  	$numDay = 12;
	for($countDay = 1; $countDay <= $numDay; $countDay++)
	{		
?>
                        <th>
                            <?php echo("Ngày ".$countDay);
							?>
                        </th>
<?php
	}
?>
                    </tr>
                </thead>
                <tbody>
				<?php
					$athletes = $clubInfo->athletes;
					foreach ($athletes as &$athlete)
					{ 		
						if($athlete["isspy"]==0)
						{
				?>
                    <tr class="active">
                        <td>
                            <?php echo($athlete["name"]); ?>
                        </td>
                        <td>
                            <?php echo($athlete["distance"]); ?>
                        </td>
                        <td>
                            <?php echo($athlete["distance"]); ?>
                        </td>
                    </tr>  
				<?php
						}
					}
				?>					
                </tbody>
            </table>
</div>

  </div>
<?php
		}
	}
?>

</div>

  <!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.10&appId=1329894410374017";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-like" data-href="https://www.facebook.com/groups/VNGRunClub/" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
  
<div class="fb-comments" data-href="https://www.facebook.com/groups/VNGRunClub/permalink/1527053424025370/" data-width="600" data-numposts="5"></div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.10&appId=1329894410374017";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/js/bootstrap.min.js'></script>

    <script src="js/index.js"></script>

</body>
</html>

