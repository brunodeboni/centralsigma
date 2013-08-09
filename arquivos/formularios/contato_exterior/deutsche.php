<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Contato Exterior</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js" type="text/javascript"></script>
	<link href="../../default.css" rel="stylesheet">
</head>
<body>
<div id="container">
	<h1>Kontaktieren Sie uns</h1>
	<div style="padding-bottom: 10px;">Bitte geben Sie Ihre Daten ein und wählen Sie, wie Sie uns zu kontaktieren.</div>
	
	<form id="form_idiomas" action="" method="post">
		<span>Name: </span><br>
		<input type="text" id="inp_nome" name="nome" class="block"><br>
		<span>Unternehmen: </span><br>
		<input type="text" id="inp_empresa" name="empresa" class="block"><br>
		<span>Arbeit: </span><br>
		<input type="text" id="inp_cargo" name="cargo" class="block"><br>
		<span>Telefon: </span><br>
		<input type="text" id="inp_telefone" name="telefone" class="block"><br>
		<span>E-mail: </span><br>
		<input type="text" id="inp_email" name="email" class="block"><br>
		<span>Stadt: </span><br>
		<input type="text" id="inp_cidade" name="cidade" class="block"><br>
		<span>Land: </span><br>
		<input type="text" id="inp_pais" name="pais" class="block"><br>
		<br>
		<input type="radio" name="tipo" value="call" checked> Rufen Sie mit Skype &nbsp;&nbsp;&nbsp;
		<input type="radio" name="tipo" value="chat"> Chat
		<br><br>
		<input type="hidden" name="atendeu" value="Henrique">
		
		<div id="div_erro"></div><br>
		
		<button type="button" onclick="verificaDados()">Gehen</button>
	</form>

<script>

function verificaDados() {
	if ($('#inp_nome').val() == "") {$('#div_erro').show(); $('#div_erro').html('Das Feld Name sollte gefüllt werden.'); return false;}
	if ($('#inp_empresa').val() == "") {$('#div_erro').show(); $('#div_erro').html('Das Unternehmen Feld muss ausgefüllt werden.'); return false;}
	if ($('#inp_cargo').val() == "") {$('#div_erro').show(); $('#div_erro').html('Die Feldarbeit abgeschlossen sein sollte.'); return false;}
	if ($('#inp_telefone').val() == "") {$('#div_erro').show(); $('#div_erro').html('Die Telefon Feld muss ausgefüllt werden.'); return false;}
	if ($('#inp_email').val() == "") {$('#div_erro').show(); $('#div_erro').html('Die E-Mail-Feld muss ausgefüllt werden.'); return false;}
	if ($('#inp_cidade').val() == "") {$('#div_erro').show(); $('#div_erro').html('Die Stadt Feld muss ausgefüllt werden.'); return false;}
	if ($('#inp_pais').val() == "") {$('#div_erro').show(); $('#div_erro').html('Das Land-Feld muss ausgefüllt werden.'); return false;}
	if(!checarEmail($('#inp_email').val())) {$('#div_erro').show(); $('#div_erro').html('Die E-Mail-Feld muss korrekt ausgefüllt werden.'); return false;}
	
	$("#form_idiomas").submit();
}

function checarEmail(mail){
	if(mail.length==0) return true;
	
	if ((mail.length > 7) && !((mail.indexOf("@") < 1) || (mail.indexOf('.') < 1)))
		{return true;}
	else
		{return false;}
}
</script>


<?php 

// Conexão com mysql
require '../../../conexoes.inc.php';
$db = Database::instance('centralsigma02');
	
if (isset($_POST['nome'])) {
	$nome = $_POST['nome'];
	$empresa = $_POST['empresa'];
	$cargo = $_POST['cargo'];
	$telefone = $_POST['telefone'];
	$email = $_POST['email'];
	$cidade = $_POST['cidade'];
	$pais = $_POST['pais'];
	$atendeu = $_POST['atendeu'];
	$tipo = $_POST['tipo'];
	
	$sql = "insert into contatos_exterior (nome, empresa, cargo, telefone, email, cidade, pais, atendeu) 
	values (:nome, :empresa, :cargo, :telefone, :email, :cidade, :pais, :atendeu)";
	$query = $db->prepare($sql);
	$query->execute(array(
		':nome' => $nome, 
		':empresa' => $empresa, 
		':cargo' => $cargo, 
		':telefone' => $telefone, 
		':email' => $email, 
		':cidade' => $cidade, 
		':pais' => $pais, 
		':atendeu' => $atendeu
	));
	
	if ($tipo == "call") {
		echo '<div id="div_sucesso">Ihre Daten wurden gesendet.</div>';
		header('Location: skype:redeindustrial.henrique?call');
	}else if ($tipo == "chat") {
		echo '<div id="div_sucesso">Ihre Daten wurden gesendet.</div>';
		header('Location: http://redeindustrial.mysuite.com.br/clientlegume.php?param=hd_chat_gc_cad_chatdep&inf=&sl=rdi&lf=&ca=&cr=&redirect=http://redeindustrial.mysuite.com.br/empresas/rdi/central.php');
	}
}

?>
</div>
</body>
</html>