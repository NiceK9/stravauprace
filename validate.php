<?phpinclude_once 'configSubscription.php';$postdata = file_get_contents("php://input");$prefix="test";$requestData="";if(isset($_GET['hub_challenge'])){	echo "{\"hub.challenge\":\"".$_GET["hub_challenge"]."\"}";	$prefix="subcribe";}else{	try{		$result = json_decode($postdata);				$activity_id = $result->object_id;		$token_user = "341fb37b2f57b6499dff7b4c13944ddea6644fac";				$activity = fetchActivity($activity_id, $token_user)[0];		$athleteId = $activity->athlete->id;		$type = $activity->type;		$distance = ($activity->distance/1000);		$duration = secondToStr($activity->moving_time);		// $strDate = $activity->start_date_local;		// $strDate = str_replace("T", " ", $strDate);		// $strDate = str_replace("Z", "", $strDate);		// $activityDate = DateTime::createFromFormat(TIME_FORMAT, $strDate, new DateTimeZone($activity->timezone));		// $activityDate->setTimezone(new DateTimeZone('Asia/Ho_Chi_Minh')); //convert GMT +7		// $strDate = $activityDate->format(TIME_FORMAT);		// $startTime = $strDate;		$avgPace = convertSpeedToPace($activity->average_speed);				$requestData = "ID Athelete: ".$athleteId."/nType: ".$type."/nDistance: ".$distance."/n";		} catch(\Exception $e) {		$requestData = "CODE: ".$e->getCode()." MSG".$e->getMessage();			}	$prefix="request";}file_put_contents($prefix.date("Y.m.d-h.m.s").".txt", var_dump_ret($_GET)."\n\n".var_dump_ret($_POST)."\n\n".var_dump_ret($postdata)."\n\n".$requestData);?>