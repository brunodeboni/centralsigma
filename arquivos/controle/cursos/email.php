<?php 
if (!isset ($_GET['turma'])) {
	die('&Eacute; necess&aacute;rio especificar uma turma.');
} else {
	$turma = $_GET['turma'];
}
?>
<!doctype html> 
<html>
<head>
	<meta charset="utf-8">
    <title>Envia E-mail</title>
    <style type="text/css">
    body {font-family:Arial, Tahoma, sans-serif; color: color: #CD5C5C;}
	textarea {font-family:Arial, Tahoma, sans-serif; font-size:16px;}
	</style>
</head>
<body>
<div id="div_email">
<form action="#" method="post" id="form_msg">
	<span><b>Envie um e-mail para a Turma <?php echo $turma ?></b></span><br><br>
	<span><b>Assunto:</b></span><br>
	<textarea name="assunto" form="form_msg" rows="1" cols="100" required></textarea><br>
	<span><b>Mensagem:</b></span><br>
	<textarea style="font-family:Arial, Tahoma, sans-serif; font-size:16px;" form="form_msg" name="mensagem_mail" rows="10" cols="100" required></textarea><br>
	<button type="submit">Enviar</button>
</form>
</div>

<?php

//Pega assunto e mensagem
if (isset ($_POST['assunto']) && ($_POST['mensagem_mail'])){
	//Pega id da turma
	if (!isset ($_GET['turma'])) {
		die('&Eacute; necess&aacute;rio especificar uma turma.');
	} else {
		$turma = $_GET['turma'];
	}

// Conexão com mysql
include '../../../conexoes.inc.php';
$db = Database::instance('centralsigma02');
	
//Pega os e-mails da turma desejada
$sql = "SELECT usuarios.email 
FROM cwk_users as usuarios

left join cw_cursos_inscritos as inscritos
on inscritos.id_user = usuarios.id

WHERE id_turma = :turma";
$query = $db->prepare($sql);
$query->execute(array(':turma' => $turma));
$resultado = $query->fetchAll();

foreach ($resultado as $res) {
	$destinatario = $res['email'];
	$assunto = $_POST['assunto'];
	$msg = $_POST['mensagem_mail'];
	$headers = 'MIME-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
	$headers .= 'From: CPCM Rede Industrial <cpcm@redeindustrial.com.br>'."\r\n";
	
	$mensagem = '
		<!doctype html>
		<html>
		<head>
			<meta charset="utf-8">
		</head>
		<body style="width: 550px;">
			<p><pre style="font-family:Arial, Tahoma, sans-serif; font-size:16px;">'.$msg.'</pre></p>
		</body>
		</html>';
	
	
	//Divide o destinatario em partes quando houver espa�os ou sinais 
	//(mais de um email foi cadastrado)
	$parte = preg_split("/[\s,]+/", $destinatario);
	
	//se n�o houver mais de uma parte
	if (!isset ($parte[1])) {
		//Envia e-mail
 		$email_enviado = mail($destinatario, $assunto, $mensagem, $headers);

		if ($email_enviado)
			echo "E-Mail enviado para ".$destinatario."!<br>";
		else
			echo "Erro ao enviar o E-Mail para ".$destinatario."!<br>";

	} else { 	//se houver mais de uma parte
		foreach ($parte as $destinatario) {
			//Envia e-mail
 			$email_enviado = mail($destinatario, $assunto, $mensagem, $headers);

			if ($email_enviado)
				echo "E-Mail enviado para ".$destinatario."!<br>";
			else
				echo "Erro ao enviar o E-Mail para ".$destinatario."!<br>";
		}	
	}	
		
}
//email para cpcm
$assunto = $_POST['assunto'];
$msg = $_POST['mensagem_mail'];
$headers = 'MIME-Version: 1.0'."\r\n";
$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
//$headers .= 'From: bruno.boni@redeindustrial.com.br'."\r\n";
$mensagem = $msg.' Enviado para turma '.$turma.'!';
$cpcm = mail('cpcm@redeindustrial.com.br', $assunto, $mensagem);
//verifica se enviou
if ($cpcm)
	echo "E-Mail enviado para cpcm@redeindustrial.com.br!";
else
	echo "Erro ao enviar o E-Mail para cpcm@redeindustrial.com.br";

} else echo ''; //se n�o h� $_post

?>
<br>
<br>
<div>
<a href="sms.php?turma=<?php echo $turma;?>">Enviar SMS para turma</a>
<br><br>
<a href="controle_turmas.php">Voltar</a>
</div>