<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Treinamentos</title>
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
		
		<span>Treinamento desejado:</span>
		<select name="treinamento" class="block" required>
			<option value="">Selecione...</option>
			<option value="Cursos Gratuitos SIGMA">Cursos Gratuitos SIGMA</option>
			<option value="Treinamento de Implantação SIGMA">Treinamento de Implantação SIGMA</option>
			<option value="Treinamento Avançado SIGMA">Treinamento Avançado SIGMA</option>
			<option value="Programa de Certificação SIGMA">Programa de Certificação SIGMA</option>
			<option value="Curso de PCM / SIGMA - EAD">Curso de PCM / SIGMA - EAD</option>
		</select><br>
		
		<span>Observação:</span>
		<textarea name="observacao" class="block" rows="3"></textarea><br>
		
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
	$treinamento = $_POST['treinamento'];
	$observacao = $_POST['observacao'];
	
	$assunto_email = $treinamento;
	$mensagem = "Nome: ".$nome."<br>
		Empresa: ".$empresa."<br>
		Telefone: ".$telefone."<br>
		Celular: ".$celular."<br>
		E-mail: ".$email."<br>
		Observação: ".$observacao;
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



