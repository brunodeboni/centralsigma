<?php
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

//$foto = "http://www.centralsigma.com.br/cpcmteste/resources/img/perfil/pp.png";
$foto = "http://www.centralsigma.com.br/cpcm/".$_POST['foto'];
$perfil = "http://www.centralsigma.com.br/cpcm/perfil/usuarios/".$_POST['id'];
//$id = $_POST['id']; 

$findRowid = "select rowid from 1yAM4n2bIFsOfv70zz6E4fRq6yvf_WFmFw2vEhM0 where Perfil = '".$perfil."'";
$result = $service->query->sql($findRowid);
$rowid = $result["rows"][0][0];

$updateQuery = "update 1yAM4n2bIFsOfv70zz6E4fRq6yvf_WFmFw2vEhM0 set Foto = '".$foto."' where rowid = '".$rowid."'";
$service->query->sql($updateQuery);

?>