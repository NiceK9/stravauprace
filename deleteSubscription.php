<?php
$url = 'https://api.strava.com/api/v3/push_subscriptions?client_id=26496&client_secret=06db3de6b974347549b2d27e3c4794dd05e3f811';
$result = file_get_contents($url);
if ($result === FALSE) { /* Handle error */ }
$arr = json_decode($result);
if(sizeof($arr) > 0)
{	
	$obj = $arr[0];
	echo "ID Request: ".$obj->id."<br>";	

	$url = 'https://api.strava.com/api/v3/push_subscriptions/'.$obj->id.'?client_id=26496&client_secret=06db3de6b974347549b2d27e3c4794dd05e3f811';
	$data = array();

	// use key 'http' even if you send the request to https://...
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'DELETE',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	if ($result === FALSE) { 
	/* Handle error */ 
		var_dump($result);
	}else{
		echo "Deleted";
	}
}else
{
	echo "None of request exists";
}

// function var_dump_ret($n)
// {
	// ob_start();
	// var_dump($n);
	// return ob_get_clean();
// }
// $postdata = file_get_contents("php://input");
// echo "{\"hub.challenge\":\"".$_GET["hub_challenge"]."\"}";
// // foreach (getallheaders() as $name => $value) {
    // // echo "$name: $value\n";
// // }
// file_put_contents("test".date("Y.m.d-h.m.s").".txt", var_dump_ret($_GET)."\n\n".var_dump_ret($_POST)."\n\n".var_dump_ret($postdata)."\n\n".var_dump_ret(getallheaders())."\n\n".$return);
?>