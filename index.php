<?php
// error_reporting(0);
// ini_set("display_errors", 0);

include_once('StravaApi.php');
$api = new StravaApi("c56d24c43d4aaa704670521c6e31b09e655a42de"); //access token of buhu

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

	//Display UI all score
	$clubIds = array(
	298988 //LienQuan GST
	,296230 //Run2Dead
	// 230974 // VNG Run Club
	// ,163276 // SRC
	// ,193097 // YCB
	);
	$clubs = $api->reportMultiClubsWithSort($clubIds, "2017-07-28 00:00:00", "2017-07-31 00:00:00");
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
					// echo $content;
				}
				else{
					$content = "[INVALID]" . $content;
					// echo "<div style ='color:#ff0000'> $content </div>"; 
				}
			}
			
			$athletes = $clubInfo->athletes;
			foreach ($athletes as &$athlete)
			{ 
				$content = ("[".$athlete["id"] . "] " . $athlete["name"]. " run " . $athlete["distance"] . "(km)<br>");
				// echo $content;
			}
		}
	}
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
        <li class="three"><a><?php echo ($clubInfo->totalDistance/1000);?></a></li>
        <li class="four"><a><?php echo ($clubInfo->totalDistance/1000);?></a></li>
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
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.3/js/bootstrap.min.js'></script>

    <script src="js/index.js"></script>

</body>
</html>

