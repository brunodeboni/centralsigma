<?php

function decode_telefone($telefone){
	$telefone = trim($telefone);
	if($telefone=="") return "";
	$nums = "0123456789";

	$numsarr = str_split($nums);
	$telsarr = str_split($telefone);

	$novo_telefone = "";

	foreach($telsarr as $tel){
		$ex = false;
		foreach($numsarr as $num){
			if($tel == $num){
				$ex = true;
				break;
			}
		}

		if($ex) $novo_telefone .= $tel;
	}

	return $novo_telefone;
}

// Conexão com mysql
require '../../conexoes.inc.php';
$db = Database::instance('centralsigma02');

//Envia SMS avisando sobre o download
$celular = $_POST['celular'];
$celular = decode_telefone($celular);
$mensagem = "Download do SIGMA concluido. Entre em contato conosco e solicite um curso GRATUITO de PCM - www.centralsigma.com.br";

$sql2 = "INSERT INTO `sms` (`CELULAR_REMETENTE`, `CELULAR_DESTINO`, `MENSAGEM`, `STATUS`, `USUARIO`, `CODIGO_CLIENTE`)
VALUES ('9999999999', :celular, :mensagem, '1', '151', '')";
$query2 = $db->prepare($sql2);
$query2->execute(array(':celular' => $celular, ':mensagem' => $mensagem));

echo 'Obrigado por fazer o download.';

?>