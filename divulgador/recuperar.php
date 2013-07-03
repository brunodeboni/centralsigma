<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Recupere sua senha</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<style>
	*{      
		font-family:Tahoma, Geneva, sans-serif;
		margin-top: 0;
		font-size:12px;
	}
	#container {
		position: relative;
		width: 700px;
		margin: auto;
	}
	#fundo {
		width: 700px;
		position: absolute;
		top: 0;
	}
	#termo {
		position: absolute;
		top: 530px;
		left: 250px;
		width: 100px;
		height: 15px;
	}
	#form {
		position: absolute;
		top: 350px;
		left: 150px;
		width:400px;
	}
	h1 {
		text-align: center;
		font-size: 16px;
	}
	button {
		padding:8px 40px;
		background:#DDF;
	}
	#confirmacao {
		position: absolute;
		top: 500px;
		left: 150px;
		font-weight: bold;
		color: #116298;
	}
	.block {
		width:100%;
		margin:auto;
		display:block;
	}
	</style>
</head>
<body>
<div id="container">
	<img src="img/fundo_login.png" id="fundo">
	<a href="Termo_de_Adesao-Divulgador_SIGMA.pdf" target="_blank" id="termo"></a>
<?php if (!isset($_POST['codigo']) && !isset($_POST['caracteres'])) {?>
	<div id="form">
		<h1>Recupere sua senha</h1>
		<p>Digite seu Código de Divulgador SIGMA e receba em seu e-mail um código para redefinir sua senha.</p>	
		<form id="form_recupere" action="" method="post">
			<input id="inp_codigo" type="text" name="codigo" size="50"><br><br>
			<button type="button" onclick="verificaCod()">Enviar</button>
		</form>
	</div>
	<script>
	function verificaCod() {
		if ($('#inp_codigo').val() == "") {
			alert('Por favor, preencha o campo com seu código de identificação.');
		}else {
			codigoExists($('#inp_codigo').val());
		}
		
	}

	//callback function de codigoExists(codigo)
	function f(data) {
		if (data == 'true') {
			$('#form_recupere').submit();
		}else if (data == 'false') {
			alert('O código digitado está incorreto.');
		}
	}
	
	function codigoExists(codigo) {
		$.post('ajax_codigo.php', {codigo: codigo}, function(data) {
			f(data);
		});
	}
	</script>
<?php


}else if (isset ($_POST['codigo'])) {
	$codigo = $_POST['codigo'];
	
	// Conexão com mysql
	require '../conexoes.inc.php';
	$db = Database::instance('centralsigma02');
	
	$sql = "select nome, email from dv_divulgadores_sigma where codigo = :codigo";
	$query = $db->prepare($sql);
	$query->execute(array(':codigo' => $codigo));
	$resultado = $query->fetchAll();
	
	$caracteres = geraCodigo(8, false, true);
	//echo '<div id="confirmacao">'.$senha.'</div>';
	
	foreach ($resultado as $res) {
		
		$destinatario = "<".$res['email'].">";
		$assunto = "Divulgador SIGMA - Recupere sua senha";
		$msg = "
Olá, ".$res['nome'].",

A recuperação de sua senha foi solicitada através do seu Código de Divulgador SIGMA: ".$codigo.".
Código para redefinir senha: ".$caracteres."

Caso não tenha solicitado este e-mail, contate-nos.

Atenciosamente,

Setor Comercial SIGMA
<a href=\"mailto:comercial@redeindustrial.com.br\">comercial@redeindustrial.com.br</a>
(11) 4062-0139
";
		$headers = 'MIME-Version: 1.0'."\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
		$headers .= 'From: Rede Industrial <comercial@redeindustrial.com.br>'."\r\n";
		
		$mensagem = '
			<!doctype html>
			<html>
			<head>
				<meta charset="utf-8">
			</head>
			<body style="width: 550px;">
				<p><pre style="font-family:Arial, Tahoma, sans-serif; font-size:14px;">'.$msg.'</pre></p>
			</body>
			</html>';
		
	 	$email_enviado = mail($destinatario, $assunto, $mensagem, $headers);
		
	}
?>
	<div id="form">
		<h1>Redefinir senha</h1>
		<form id="form_redefine" action="" method="post">
			<input type="hidden" name="cod" value="<?php echo $codigo; ?>">
			
			<span>Código recebido por e-mail: </span><br>
			<input id="inp_cod" type="text" name="caracteres" class="block">
			
			<span>Nova senha: </span><br>
			<input id="inp_senha" type="password" name="nova_senha" class="block">
			<span>Confirme a nova senha: </span><br>
			<input id="inp_conf" type="password" name="nova_senha_conf" class="block">

			<button style="margin-top: 5px;" type="button" onclick="verifica()">Enviar</button>
		</form>
	</div>
	<script>
	var cod = "<?php echo $caracteres; ?>";
	function verifica() {
		if ($('#inp_cod').val() == "" || $('#inp_senha').val() == "" || $('#inp_conf').val() == "") {alert('Por favor, preencha todos os campos.'); return false;}
		if ($('#inp_senha').val() != $('#inp_conf').val()) {alert('As senhas digitadas não conferem.'); return false;}
		if ($('#inp_cod').val() != cod) {alert('O código digitado está incorreto. Verifique seu e-mail.'); return false;}
		$('#form_redefine').submit();
	}
	</script>
<?php 	
}else if (isset ($_POST['caracteres'])) {
	$codigo = $_POST['codigo'];
	$nova_senha = $_POST['nova_senha'];
	
	$sql = "update dv_divulgadores_sigma set senha = :nova_senha where codigo = :codigo";
	$query = $db->prepare($sql);
	$success = $query->execute(array(
		':codigo' => $codigo, 
		':nova_senha' => md5($nova_senha)
	));
	
	if($success) {
		header('Location: index.php');
	}
}
	
function geraCodigo($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false) {
	
	$lmin = 'abcdefghijklmnopqrstuvwxyz';
	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num = '1234567890';
	$simb = '!@#$%*-';
	$retorno = '';
	$caracteres = '';
	
	$caracteres .= $lmin;
	if ($maiusculas) $caracteres .= $lmai;
	if ($numeros) $caracteres .= $num;
	if ($simbolos) $caracteres .= $simb;

	$len = strlen($caracteres);
	for ($n = 1; $n <= $tamanho; $n++) {
		$rand = mt_rand(1, $len);
		$retorno .= $caracteres[$rand-1];
	}
	
	return $retorno;
}

?>

</div>
</body>
</html>