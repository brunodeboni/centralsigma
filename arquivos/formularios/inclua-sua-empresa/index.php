<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Inclua sua Empresa</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/gioplugin.js"></script>
    <link href="../../default.css" rel="stylesheet">
</head>

<body>
<div id="container">
	<form action="" method="post" enctype="multipart/form-data">
	 	<span>Nome:</span>
	 	<input type="text" name="nome" class="block" required><br>
		
		<span>Empresa:</span>
		<input type="text" name="empresa" class="block" required><br>
		
		<span>Segmento:</span>
		<input type="text" name="segmento" class="block" required><br>
		
		<span>Telefone:</span>
		<input type="text" name="telefone" class="telefone block" required><br>
		
		<span>Celular:</span>
		<input type="text" name="celular" class="telefone block" required><br>
		
		<span>E-mail:</span>
		<input type="text" name="email" class="block" required><br>
		
		<span>Cidade:</span>
		<input type="text" name="cidade" class="block" required><br>
		
		<span>Estado:</span>
		<select name="uf" class="block" required>
			<option value="">Selecione...</option>
			<option value="AC">Acre</option>
            <option value="AL">Alagoas</option>
            <option value="AP">Amapá</option>
            <option value="AM">Amazonas</option>
            <option value="BA">Bahia</option>
            <option value="CE">Ceará</option>
            <option value="DF">Distrito Federal</option>
            <option value="ES">Espírito Santo</option>
            <option value="GO">Goiás</option>
            <option value="MA">Maranhão</option>
            <option value="MT">Mato Grosso</option>
            <option value="MS">Mato Grosso do Sul</option>
        	<option value="MG">Minas Gerais</option>
            <option value="PA">Pará</option>
            <option value="PB">Paraíba</option>
            <option value="PR">Paraná</option>
            <option value="PE">Pernambuco</option>
            <option value="PI">Piauí</option>
            <option value="RJ">Rio de Janeiro</option>
            <option value="RN">Rio Grande do Norte</option>
            <option value="RS">Rio Grande do Sul</option>
            <option value="RO">Rondônia</option>
            <option value="RR">Roraima</option>
            <option value="SC">Santa Catarina</option>
            <option value="SP">São Paulo</option>
            <option value="SE">Sergipe</option>
            <option value="TO">Tocantins</option>
		</select><br>
		
		<span>Logotipo:</span>
		<input type="file" name="logo" class="block" required>
		
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
	$empresa = $_POST['segmento'];
	$telefone = $_POST['telefone'];
	$celular = $_POST['celular'];
	$email = $_POST['email'];
	$cidade = $_POST['cidade'];
	$uf = $_POST['uf'];
	
	if ($_FILES["logo"]["error"] > 0) {
		echo '<div class="div_erro2">Erro: '.$_FILES["logo"]["error"].'</div>';
	}else {
		$unique = rand(00000, 99999); //adidiona números aleatórios para não substituir arquivos com mesmo nome
		$file_name = tiracento($_FILES["logo"]["name"]); //retira caracteres especiais do nome do arquivo
		$file_path = "E:/Inetpub/vhosts/cpro12924.publiccloud.com.br/joomla31/arquivos/formularios/inclua-sua-empresa/logos/".$unique.$file_name;
		move_uploaded_file($_FILES["logo"]["tmp_name"], $file_path);
		$file_link = "http://joomla31.centralsigma.com.br/arquivos/formularios/inclua-sua-empresa/logos/".$unique.$file_name;
	}
	
	$assunto_email = "Inclua sua Empresa";
	$mensagem = "Nome: ".$nome."<br>
		Empresa: ".$empresa."<br>
		Segmento: ".$segmento."<br>
		Telefone: ".$telefone."<br>
		Celular: ".$celular."<br>
		E-mail: ".$email."<br>
		Cidade: ".$cidade." / ".$uf."<br><br>
		<a href=".$file_link.">Baixar logotipo</a>";
	$destinatario = "gabriela@redeindustrial.com.br";
	
	
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