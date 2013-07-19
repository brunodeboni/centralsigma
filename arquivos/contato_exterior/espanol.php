<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Contato Exterior</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js" type="text/javascript"></script>
	<link href="../default.css" rel="stylesheet">
</head>
<body>
<div id="container">
	<h1>Contáctenos</h1>
	<div style="padding-bottom: 10px;">Por favor, complete con sus datos abajo y elija una forma de contactarnos.</div>

	<form id="form_idiomas" action="" method="post">
		<span>Nombre: </span><br>
		<input type="text" id="inp_nome" name="nome" class="block"><br>
		<span>Empresa: </span><br>
		<input type="text" id="inp_empresa" name="empresa" class="block"><br>
		<span>Ocupación: </span><br>
		<input type="text" id="inp_cargo" name="cargo" class="block"><br>
		<span>Teléfono: </span><br>
		<input type="text" id="inp_telefone" name="telefone" class="block"><br>
		<span>E-mail: </span><br>
		<input type="text" id="inp_email" name="email" class="block"><br>
		<span>Ciudad: </span><br>
		<input type="text" id="inp_cidade" name="cidade" class="block"><br>
		<span>País: </span><br>
		<input type="text" id="inp_pais" name="pais" class="block"><br>
		<br>
		<input type="radio" name="tipo" value="call" checked> Llamar por el Skype &nbsp;&nbsp;&nbsp;
		<input type="radio" name="tipo" value="chat"> Chat
		<br><br>
		<input type="hidden" name="atendeu" value="Daniel">
		
		<div id="div_erro"></div><br>
		
		<button type="button" onclick="verificaDados()">Ir</button>
	</form>

<script>
function verificaDados() {
	if ($('#inp_nome').val() == "") {$('#div_erro').show(); $('#div_erro').html('El campo Nombre debe ser llenado.'); return false;}
	if ($('#inp_empresa').val() == "") {$('#div_erro').show(); $('#div_erro').html('El campo Empresa debe ser llenado.'); return false;}
	if ($('#inp_cargo').val() == "") {$('#div_erro').show(); $('#div_erro').html('El campo Ocupación debe ser llenado.'); return false;}
	if ($('#inp_telefone').val() == "") {$('#div_erro').show(); $('#div_erro').html('El campo Teléfono debe ser llenado.'); return false;}
	if ($('#inp_email').val() == "") {$('#div_erro').show(); $('#div_erro').html('El campo E-mail debe ser llenado.'); return false;}
	if ($('#inp_cidade').val() == "") {$('#div_erro').show(); $('#div_erro').html('El campo Ciudad debe ser llenado.'); return false;}
	if ($('#inp_pais').val() == "") {$('#div_erro').show(); $('#div_erro').html('El campo País debe ser llenado.'); return false;}
	if(!checarEmail($('#inp_email').val())) {$('#div_erro').show(); $('#div_erro').html('El campo E-mail debe ser llenado correctamente.'); return false;}
	
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
		echo '<div id="div_sucesso">Gracias por enviar!</div>';
		header('Location: skype:suporterj.sgm?call');
	}else if ($tipo == "chat") {
		echo '<div id="div_sucesso">Gracias por enviar!</div>';
		header('Location: http://redeindustrial.mysuite.com.br/clientlegume.php?param=hd_chat_gc_cad_chatdep&inf=&sl=rdi&lf=&ca=&cr=&redirect=http://redeindustrial.mysuite.com.br/empresas/rdi/central.php');
	}
	
}

?>

</div>
</body>
</html>