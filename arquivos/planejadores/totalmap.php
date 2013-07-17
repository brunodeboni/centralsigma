<?php
/*
require '../../conexoes.inc.php';
$db = Database::instance('centralsigma02');

$sql = "select count(id) as total from cw_perfil where planejador = 'sim'";
$query = $db->query($sql);
$resultado = $query->fetchAll();

foreach ($resultado as $res) {
	echo $res['total'];
}
*/

require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_FusiontablesService.php';

/* Define all constants */
$CLIENT_ID = '227205142996.apps.googleusercontent.com';
$FT_SCOPE = 'https://www.googleapis.com/auth/fusiontables';
$SERVICE_ACCOUNT_NAME = '227205142996@developer.gserviceaccount.com';
$KEY_FILE = 'google-api-php-client/91fadf839057c4ed0a92914f7c3137669481cbe3-privatekey.p12';

$client = new Google_Client();
$client->setApplicationName("GFTPrototype");
$client->setClientId($CLIENT_ID);

//add key
$key = file_get_contents($KEY_FILE);
$client->setAssertionCredentials(new Google_AssertionCredentials(
    $SERVICE_ACCOUNT_NAME,
    array($FT_SCOPE),
    $key)
);


$service = new Google_FusiontablesService($client);

$query = "select count(rowid) as total from 1yAM4n2bIFsOfv70zz6E4fRq6yvf_WFmFw2vEhM0";
$query = $service->query->sql($query);

echo $query['rows'][0][0];

?>