<?php
error_reporting(0);
ini_set("display_errors", 0);
include 'vendor/autoload.php';
include_once('StravaApi.php');

use Strava\API\Exception;
use Strava\API\Service\REST;
use Strava\API\OAuth;

define("GETCLUB_URL", 'http://localhost/myprojects/strava/getCurrentClubIds.php');
//define("GETCLUB_URL", 'http://static.deadtarget.info/Utils/strava/getCurrentClubIds.php');

try {
    $options = array(
        'clientId'     => 19157,
        'clientSecret' => 'b228db055030c46916eb737892d27e00abf597d5',
        'redirectUri'  => GETCLUB_URL
    );
    $oauth = new OAuth($options);

    if (!isset($_GET['code'])) {
        print '<a href="'.$oauth->getAuthorizationUrl().'">Generate permission</a>';
    } else {
echo ("<html><body>");		
        $token = $oauth->getAccessToken('authorization_code', array(
            'code' => $_GET['code']
        ));
        
		$api = new StravaApi($token);
		//////////////////////////// Find Athlete's Club /////////////////////////////
		$clubs =$api->getAthleteClubs();
		if($clubs!=null)
		{
			$clubSize = count($clubs);
			if($clubSize>0)
			{
				echo ("<article>");
				echo ("<h1> All your Clubs </h1>");
				for($i = 0; $i< $clubSize; $i++)
					echo("[Club][". $clubs[$i]["id"]."] " . $clubs[$i]["name"] . "<br>");
				echo ("</article>");
			} else {
				print('No clubs found!');
			}
		} else {
			print('No Athlete found!');
		}
echo ("</body></html>");
    }
} catch(Exception $e) {
    print $e->getMessage();
}
?>
