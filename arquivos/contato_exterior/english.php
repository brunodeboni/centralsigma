<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Contato Exterior</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js" type="text/javascript"></script>
	<link type="text/css" rel="stylesheet" href="default.css">
</head>
<body>
<div id="content">
	<div id="form-titulo">Contact us</div>
	<div style="padding-bottom: 10px;">Please fill in your information below and choose how to contact us.</div>
	<div id="div_erro"></div>
	<form id="form_idiomas" action="" method="post">
		<span>Name: </span><br>
		<input type="text" id="inp_nome" name="nome" class="block"><br>
		<span>Company: </span><br>
		<input type="text" id="inp_empresa" name="empresa" class="block"><br>
		<span>Occupation: </span><br>
		<input type="text" id="inp_cargo" name="cargo" class="block"><br>
		<span>Telephone Number: </span><br>
		<input type="text" id="inp_telefone" name="telefone" class="block"><br>
		<span>E-mail: </span><br>
		<input type="text" id="inp_email" name="email" class="block"><br>
		<span>City: </span><br>
		<input type="text" id="inp_cidade" name="cidade" class="block"><br>
		<span>Country: </span><br>
		<input type="text" id="inp_pais" name="pais" class="block"><br>
		<br>
		<input type="radio" name="tipo" value="call" checked> Call with Skype &nbsp;&nbsp;&nbsp;
		<input type="radio" name="tipo" value="chat"> Chat
		<br><br>
		<input type="hidden" name="atendeu" value="Josias">
		<button type="button" onclick="verificaDados()">Go</button>
	</form>
</div>
<script>

function verificaDados() {
	if ($('#inp_nome').val() == "") {$('#div_erro').show(); $('#div_erro').html('Please inform your Name.'); return false;}
	if ($('#inp_empresa').val() == "") {$('#div_erro').show(); $('#div_erro').html('Please inform your Company.'); return false;}
	if ($('#inp_cargo').val() == "") {$('#div_erro').show(); $('#div_erro').html('Please inform your Occupation.'); return false;}
	if ($('#inp_telefone').val() == "") {$('#div_erro').show(); $('#div_erro').html('Please inform your Phone Number.'); return false;}
	if ($('#inp_email').val() == "") {$('#div_erro').show(); $('#div_erro').html('Please inform your E-mail.'); return false;}
	if ($('#inp_cidade').val() == "") {$('#div_erro').show(); $('#div_erro').html('Please inform your City.'); return false;}
	if ($('#inp_pais').val() == "") {$('#div_erro').show(); $('#div_erro').html('Please inform your Country.'); return false;}
	if(!checarEmail($('#inp_email').val())) {$('#div_erro').show(); $('#div_erro').html('Please inform a valid E-mail.'); return false;}
	
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
</body>
</html>

<?php 

// Conexão com mysql
require '../../conexoes.inc.php';
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
		echo 'Thank you for submitting.';
		header('Location: skype:redeindustrial.josias?call');
	}else if ($tipo == "chat") {
		echo 'Thank you for submitting.';
		header('Location: http://redeindustrial.mysuite.com.br/clientlegume.php?param=hd_chat_gc_cad_chatdep&inf=&sl=rdi&lf=&ca=&cr=&redirect=http://redeindustrial.mysuite.com.br/empresas/rdi/central.php');
	}
}

?>
