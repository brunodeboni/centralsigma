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

$foto = "http://www.centralsigma.com.br/cpcm/resources/img/perfil/pp.png";
$nome = $_POST['nome'];
$endereco = $_POST['endereco'].", ".$_POST['cidade'].", ".$_POST['uf'];
if ($_POST['facebook'] != "") {
	$facebook = $_POST['facebook'];
}else {
	$facebook = "Não publicado";
}
if ($_POST['linkedin'] != "") {
	$linkedin = $_POST['linkedin'];
}else {
	$linkedin = "Não publicado";
}
$empresa = $_POST['empresa'];
$perfil = "http://www.centralsigma.com.br/cpcm/perfil/usuarios/".$_POST['id'];

//Primeiro verifica se este perfil já está cadastrado
$select = "select Perfil from 1yAM4n2bIFsOfv70zz6E4fRq6yvf_WFmFw2vEhM0";
$result = $service->query->sql($select);
	
foreach ($result['rows'] as $key => $resu) {
	if ($resu[0] == $perfil) {
		$ja_tem = true;
		continue;
	}else {
		$ja_tem = false;
	}	
}

//Depois insere ou atualiza registro
if (! $ja_tem) {
	$insertQuery = "insert into 1yAM4n2bIFsOfv70zz6E4fRq6yvf_WFmFw2vEhM0 (Foto, Nome, Endereco, Facebook, LinkedIn, Empresa, Perfil) values ('".$foto."', '".$nome."', '".$endereco."', '".$facebook."', '".$linkedin."', '".$empresa."', '".$perfil."')";
	$service->query->sql($insertQuery);
}else {
	$findRowid = "select rowid from 1yAM4n2bIFsOfv70zz6E4fRq6yvf_WFmFw2vEhM0 where Perfil = '".$perfil."'";
	$resultado = $service->query->sql($findRowid);
	$rowid = $resultado["rows"][0][0];
	
	$updateQuery = "update 1yAM4n2bIFsOfv70zz6E4fRq6yvf_WFmFw2vEhM0 set Foto = '".$foto."', Nome = '".$nome."', Endereco = '".$endereco."', Facebook = '".$facebook."', LinkedIn = '".$linkedin."', Empresa = '".$empresa."' where rowid = '".$rowid."'";
	$service->query->sql($updateQuery);
}

?>