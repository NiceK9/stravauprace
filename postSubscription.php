<?php
$url = 'https://api.strava.com/api/v3/push_subscriptions?client_id=26496&client_secret=06db3de6b974347549b2d27e3c4794dd05e3f811';
$data = array(
'callback_url' => 'http://teststrava.000webhostapp.com/validate.php', 
'verify_token' => 'STRAVA');

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */ }

var_dump($result);

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