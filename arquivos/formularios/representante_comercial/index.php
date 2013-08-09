<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Representantes Comerciais</title>
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
		
		<span>Telefone Comercial:</span>
		<input type="text" name="telefone" class="telefone block" required><br>
		 
		<span>Celular:</span>
		<input type="text" name="celular" class="telefone block" required><br>
		
		<span>E-mail:</span>
		<input type="text" name="email" class="block" required><br>
		
		<span>Área de Atuação (Cidade/Estado/Região):</span>
		<input type="text" name="area" class="block" required><br>
		
		<span>Site da Representação:</span>
		<input type="text" name="site" class="block" required><br>
		
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
	$area = $_POST['area'];
	$site = $_POST['site'];
	
	$assunto_email = "Representantes Comerciais";
	$mensagem = "Nome: ".$nome."<br>
		Empresa: ".$empresa."<br>
		Telefone Comercial: ".$telefone."<br>
		Celular: ".$celular."<br>
		E-mail: ".$email."<br>
		Área de Atuação: ".$area."<br>
		Site da Representação: ".$site;
	$destinatario = "comercial@redeindustrial.com.br";
	
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	
	// Additional headers
	$headers .= 'From: comercial@redeindustrial.com.br '. "\r\n";
	
	$enviar = mail($destinatario, $assunto_email, $mensagem, $headers);
	
	if ($enviar) {
		echo '<div id="div_sucesso">Mensagem enviada com sucesso</div>';
	}else {
		echo '<div class="div_erro2">Ocorreu um erro ao processar o envio. Por favor, tente novamente.</div>';
	}
	
}

?>
</div>
</body>
</html>
