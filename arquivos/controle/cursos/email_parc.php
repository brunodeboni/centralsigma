<?php 
if (!isset ($_POST['cb_parceiro'])) {
	die('&Eacute; necess&aacute;rio especificar um usu&aacute;rio.');
} else {
	$cb_parceiro = $_POST['cb_parceiro'];
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
	<span><b>Envie um e-mail para o(s) Usu&aacute;rio(s) <?php foreach ($cb_parceiro as $parceiro) echo $parceiro." " ?></b></span><br><br>
	<span><b>Assunto:</b></span><br>
	<textarea name="assunto" form="form_msg" rows="1" cols="100" required></textarea><br>
	<span><b>Mensagem:</b></span><br>
	<textarea style="font-family:Arial, Tahoma, sans-serif; font-size:16px;" form="form_msg" name="mensagem_mail" rows="10" cols="100" required></textarea><br>
	<?php 
	//para continuar com post dos parceiros selecionados
	foreach ($cb_parceiro as $parceiro) 
		echo '<input type="hidden" name="cb_parceiro[]" value="'.$parceiro.'">';
	?>
	<button type="submit">Enviar</button>
</form>
</div>

<?php

//Pega assunto e mensagem
if (isset ($_POST['assunto']) && ($_POST['mensagem_mail'])){
	//Pega id do parceiro selecionado
	if (!isset ($_POST['cb_parceiro'])) {
		die('&Eacute; necess&aacute;rio especificar um usu&aacute;rio.');
	} else {
		$cb_parceiro = $_POST['cb_parceiro'];
	}

// Conexão com mysql
//$conn = mysql_connect("cloud1.redeindustrial.com.br","webadmin","webADMIN") or die("Sem conexão com o Banco de Dados");
//mysql_select_db("centralsigma02",$conn) or die("N&atilde;o foi possivel selecionar o Banco de Dados");
include '../../../conexoes.inc.php';
$db = Database::instance('cpcm_teste');
	
//$usuario = array();
foreach ($cb_parceiro as $parceiro) { 
	//Pega os e-mails dos usu�rios desejados
	$sql = "SELECT usuarios.email 
	FROM cwk_users as usuarios
	WHERE usuarios.id = :parceiro";
	$query = $db->prepare($sql);
	$query->execute(array(':parceiro' => $parceiro));
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
	
			if ($email_enviado) {
				echo "E-Mail enviado para ".$destinatario."!<br>";
				//$usuario[] = $destinatario;
			} else
				echo "Erro ao enviar o E-Mail para ".$destinatario;
	
		} else { 	//se houver mais de uma parte
			foreach ($parte as $destinatario) {
				//Envia e-mail
	 			$email_enviado = mail($destinatario, $assunto, $mensagem, $headers);
	
				if ($email_enviado) {
					echo "E-Mail enviado para ".$destinatario."!<br>";
					//$usuario[] = $destinatario;
				} else
					echo "Erro ao enviar o E-Mail para ".$destinatario;
			}	
		}	
	}
	 
}

//email para cpcm
$assunto = $_POST['assunto'];
$mensagem = $_POST['mensagem_mail'];
$headers = 'MIME-Version: 1.0'."\r\n";
$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
$headers .= 'From: bruno.boni@redeindustrial.com.br'."\r\n";
//$mensagem = $msg.' Enviado para seguintes usuarios '.$usuario.'!';
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
<script> 
function enviar_formulario(){ 
   document.formulario.submit(); 
} 
</script> 
<div>
<form method="post" action="sms_parc.php" name="formulario">
<?php
//Envia ids dos parceiros selecionados via post
foreach($cb_parceiro as $parceiro) {
	echo '<input type="hidden" name="parceiro[]" value="'.$parceiro.'">';
}
?>
<a href="javascript:enviar_formulario()">Enviar SMS para parceiros</a>
</form>

<br><br>
<a href="controle_turmas.php">Voltar</a>
</div>
</body>
</html>