<?php
function var_dump_ret($n)
{
	ob_start();
	var_dump($n);
	return ob_get_clean();
}
$postdata = file_get_contents("php://input");
$prefix="test";
if(isset($_GET['hub_challenge']))
{
	echo "{\"hub.challenge\":\"".$_GET["hub_challenge"]."\"}";
	$prefix="subcribe";
}else
{	
	// foreach (getallheaders() as $name => $value) {
		// echo "$name: $value\n";
	// }
	$prefix="request";
}
file_put_contents($prefix.date("Y.m.d-h.m.s").".txt", var_dump_ret($_GET)."\n\n".var_dump_ret($_POST)."\n\n".var_dump_ret($postdata)."\n\n".var_dump_ret(getallheaders()));
?>