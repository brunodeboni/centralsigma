<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Visita Técnica</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/gioplugin.js"></script>
    <link href="../../default.css" rel="stylesheet">
</head>

<body>
<div id="container">
	<form action="" method="post">
	 	<span>Nome:</span>
	 	<input type="text" name="nome" class="block" required><br>
		
		<span>Empresa:</span>
		<input type="text" name="empresa" class="block" required><br>
		
		<span>Telefone:</span>
		<input type="text" name="telefone" class="telefone block" required><br>
		
		<span>Celular:</span>
		<input type="text" name="celular" class="telefone block" required><br>
		
		<span>E-mail:</span>
		<input type="text" name="email" class="block" required><br>
		
		<span>Solicitação:</span>
		<textarea type="text" name="solicitacao" class="block" rows="2" required></textarea><br>
		
		<br>
		<button type="submit">Enviar</button>
	</form>

	<script>
	$(".telefone").telefone();
	</script>
<?php 
if (isset($_POST['nome'])) {
	$nome = $_POST['nome'];
	$empresa = $_POST['empresa'];
	$telefone = $_POST['telefone'];
	$celular = $_POST['celular'];
	$email = $_POST['email'];
	$solicitacao = $_POST['solicitacao'];
	
	$assunto_email = "Solicite sua visita técnica";
	$mensagem = "Nome: ".$nome."<br>
		Empresa: ".$empresa."<br>
		Telefone: ".$telefone."<br>
		Celular: ".$celular."<br>
		E-mail: ".$email."<br>
		Solicitação: ".$solicitacao;
	$destinatario = "comercial@redeindustrial.com.br";
	
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	
	// Additional headers
	$headers .= 'From: comercial@redeindustrial.com.br '. "\r\n";
	
	$enviar = mail($destinatario, $assunto_email, $mensagem, $headers);
	
	if ($enviar) {
		echo '<div id="div_sucesso">Cadastro enviado com sucesso</div>';
	}else {
		echo '<div class="div_erro2">Ocorreu um erro ao processar o envio. Por favor, tente novamente.</div>';
	}
	
}

?>
</div>
</body>
</html>