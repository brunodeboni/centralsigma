<?php
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_FusiontablesService.php';
require '../../conexoes.inc.php';
$db = Database::instance('centralsigma02');

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

$sql = "select distinct(u.id), u.nome, u.empresa,
case substring(u.telefone, 1, 2) 
        when '11' then 'São Paulo, SP'
		  when '12' then 'Cotia, SP'
		  when '13' then 'Guarujá, SP'
		  when '14' then 'Bauru, SP'
		  when '15' then 'Ibiuna, SP'
		  when '16' then 'Franca, SP'
		  when '17' then 'Barretos, SP'
		  when '18' then 'Assis, SP'
		  when '19' then 'Mogi Guaçu, SP'
		  when '21' then 'Rio de Janeiro, RJ'
		  when '22' then 'Cabo Frio, RJ'
		  when '24' then 'Vassouras, RJ'
		  when '27' then 'Vitoria, ES'
		  when '28' then 'Alegre, ES'
		  when '31' then 'Belo Horizonte, MG'
		  when '32' then 'Barbacena, MG'
		  when '33' then 'Alvarenga, MG'
		  when '34' then 'Araporã, MG'
		  when '35' then 'Alterosa, MG'
		  when '37' then 'Pompeu, MG'
		  when '38' then 'Diamantina, MG'
		  when '41' then 'Curitiba, PR'
		  when '42' then 'Ponta Grossa, PR'
		  when '43' then 'Londrina, PR'
		  when '44' then 'Rondon, PR'
		  when '45' then 'Foz do Iguaçu, PR'
		  when '46' then 'Pato Branco, PR'
		  when '47' then 'Brusque, SC'
		  when '48' then 'Florianópolis, SC'
		  when '49' then 'Chapecó, SC'
		  when '51' then 'Canoas, RS'
		  when '53' then 'Pelotas, RS'
		  when '54' then 'Caxias do Sul, RS'
		  when '55' then 'Alegrete, RS'
		  when '61' then 'Brasília, DF'
		  when '62' then 'Goiânia, GO'
		  when '63' then 'Palmas, TO'
		  when '64' then 'Quirinópolis, GO'
		  when '65' then 'Cuiabá, MT'
		  when '66' then 'Brasnorte, MT'
		  when '67' then 'Bonito, MS'
		  when '68' then 'Rio Branco, AC'
		  when '69' then 'Porto Velho, RO'
		  when '71' then 'Salvador, BA'
		  when '73' then 'Ilhéus, BA'
		  when '74' then 'Barra, BA'
		  when '75' then 'Entre Rios, BA'
		  when '77' then 'Mirante, BA'
		  when '79' then 'Aracaju ,SE'
		  when '81' then 'Recife, PE'
		  when '82' then 'Maceió, AL'
		  when '83' then 'João Pessoa, PB'
		  when '84' then 'Natal, RN'
		  when '85' then 'Fortaleza, CE'
		  when '86' then 'Teresina, PI'
		  when '87' then 'Petrolina, PE'
		  when '88' then 'Madalena, CE'
		  when '89' then 'Arraial, PI'
		  when '91' then 'Belém, PA'
		  when '92' then 'Manaus, AM'
		  when '93' then 'Altamira, PA'
		  when '94' then 'Sapucaia, PA'
		  when '95' then 'Boa Vista, RR'
		  when '96' then 'Macapá, AP'
		  when '97' then 'Tabatinga, AM'
		  when '98' then 'Brejo, MA'
		  when '99' then 'Arame, MA' 
end as regiao
from cwk_users as u
left join cw_cursos_inscritos as i 
on i.id_user = u.id
where i.status = 3";
$query = $db->query($sql);
$resultado = $query->fetchAll();
//$i = 0;
foreach ($resultado as $res) {
	
	$foto = "http://www.centralsigma.com.br/cpcm/resources/img/perfil/pp.png";
	$nome = $res['nome'];
	$endereco = $res['regiao'];
	$facebook = "Não publicado";
	$linkedin = "Não publicado";
	$empresa = "";
	$perfil = "http://www.centralsigma.com.br/cpcm/perfil/usuarios/".$res['id'];
	
	$select = "select Perfil from 1yAM4n2bIFsOfv70zz6E4fRq6yvf_WFmFw2vEhM0";
	$result = $service->query->sql($select);
	
	foreach ($result['rows'] as $key => $resu) {
		if ($resu[0] == $perfil) {
			$ja_tem = true;
			break;
		}else {
			$ja_tem = false;
		}	
	}
	
	if (! $ja_tem) {
		//echo $i." - ".$nome."<br>";
		//$i++;
		
		$updateQuery = "insert into 1yAM4n2bIFsOfv70zz6E4fRq6yvf_WFmFw2vEhM0 (Foto, Nome, Endereco, Facebook, LinkedIn, Empresa, Perfil) values ('".$foto."', '".$nome."', '".$endereco."', '".$facebook."', '".$linkedin."', '".$empresa."', '".$perfil."')";
		$service->query->sql($updateQuery);
	}
}
?>