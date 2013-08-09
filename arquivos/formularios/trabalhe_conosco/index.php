<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Trabalhe Conosco</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/gioplugin.js"></script>
    <link href="../../default.css" rel="stylesheet">
</head>

<body>
<div id="container">
	<form action="" method="post" enctype="multipart/form-data">
	 	<span>Nome:</span>
	 	<input type="text" name="nome" class="block" required><br>
		
		<span>Endereço:</span>
		<input type="text" name="endereco" class="block" required><br>
		
		<span>Telefone:</span>
		<input type="text" name="telefone" class="telefone block" required><br>
		
		<span>Celular:</span>
		<input type="text" name="celular" class="telefone block" required><br>
		
		<span>E-mail:</span>
		<input type="text" name="email" class="block" required><br>
		
		<span>Função Desejada:</span>
		<input type="text" name="funcao" class="block" required><br>
		
		<span>Currículo:</span>
		<input type="file" name="curriculo" class="block" required>
		
		<br>
		<button type="submit">Enviar</button>
	</form>

	<script>
	$(".telefone").telefone();
	</script>
<?php
function tiracento($texto){
	$trocarIsso = array('à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ü','ú','ÿ','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','O','Ù','Ü','Ú','Ÿ', ' ',);
	$porIsso = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','0','U','U','U','Y', '-',);
	$titletext = str_replace($trocarIsso, $porIsso, $texto);
	return $titletext;
}

if (isset($_POST['nome'])) {
	$nome = $_POST['nome'];
	$endereco = $_POST['endereco'];
	$telefone = $_POST['telefone'];
	$celular = $_POST['celular'];
	$email = $_POST['email'];
	$funcao = $_POST['funcao'];
	
	if ($_FILES["curriculo"]["error"] > 0) {
		echo '<div class="div_erro2">Erro: '.$_FILES["curriculo"]["error"].'</div>';
	}else {
		$unique = rand(00000, 99999); //adidiona números aleatórios para não substituir arquivos com mesmo nome
		$file_name = tiracento($_FILES["curriculo"]["name"]); //retira caracteres especiais do nome do arquivo
		$file_path = "E:/Inetpub/vhosts/cpro12924.publiccloud.com.br/joomla31/arquivos/formularios/trabalhe_conosco/curriculos/".$unique.$file_name;
		move_uploaded_file($_FILES["curriculo"]["tmp_name"], $file_path);
		$file_link = "http://joomla31.centralsigma.com.br/arquivos/formularios/trabalhe_conosco/curriculos/".$unique.$file_name;
	}
	
	$assunto_email = "Trabalhe Conosco";
	$mensagem = "Nome: ".$nome."<br>
		Endereço: ".$endereco."<br>
		Telefone: ".$telefone."<br>
		Celular: ".$celular."<br>
		E-mail: ".$email."<br>
		Função Desejada: ".$funcao."<br><br>
		<a href=".$file_link.">Baixar currículo</a>";
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