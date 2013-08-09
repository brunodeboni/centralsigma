<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Setor de Qualidade</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/gioplugin.js"></script>
    <link href="../../default.css" rel="stylesheet">
</head>

<body>
<div id="container">
	<form action="" method="post">
		<span>Urgência:</span>
	    <select name="urgencia" class="block" required>
	    	<option value="Alta">Alta</option>
	    	<option value="Media">Média</option>
	    	<option value="Baixa" selected>Baixa</option>
	    </select>
	    <br>
	 	<span>Assunto:</span>
	 	<input type="text" name="assunto" class="block" required><br />
	
		<span>Descreva sua questão:</span><br />
		<textarea class="block" rows="10" name="questao" required></textarea><br />
		<br />
		<span>Nome:</span>
		<input type="text" name="nome" class="block" required><br />
		
		<span>Empresa:</span>
		<input type="text" name="empresa" class="block" required><br />
		
		<span>Telefone:</span>
		<input type="text" name="telefone" class="telefone block" required><br />
		 
		<span>Celular:</span>
		<input type="text" name="celular" class="telefone block" required><br />
		 
		<span>E-mail:</span>
		<input type="text" name="email" class="block" required><br />
		<br />
		<button type="submit">Enviar</button>
	</form>

	<script>
	$(".telefone").telefone();
	</script>
<?php 
if (isset($_POST['assunto'])) {
	$urgencia = $_POST['urgencia'];
	$assunto = $_POST['assunto'];
	$questao = $_POST['questao'];
	$nome = $_POST['nome'];
	$empresa = $_POST['empresa'];
	$telefone = decode_telefone($_POST['telefone']);
	$celular = decode_telefone($_POST['celular']);
	$email = $_POST['email'];
	
	$assunto_email = "Urgência: ".$urgencia." - ".$assunto;
	$mensagem = "Urgência: ".$urgencia."<br><br><pre>".$questao."</pre><br><br>".$nome.
					"<br>".$empresa."<br>".$telefone."<br>".celular."<br>".$email;
	$destinatario = "qualidade@redeindustrial.com.br";
	
	
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	
	// Additional headers
	$headers .= 'From: qualidade@redeindustrial.com.br '. "\r\n";
	$headers .= 'Cc: '.$email. "\r\n";
	
	$enviar = mail($destinatario, $assunto_email, $mensagem, $headers);
	
	//Cadastrar no banco de dados
	require '../../../conexoes.inc.php';
	$db = Database::instance('centralsigma02');
	
	
	$sql = "insert into setor_qualidade (urgencia, assunto, questao, nome, empresa, telefone, celular, email) 
		values (:urgencia, :assunto, :questao, :nome, :empresa, :telefone, :celular, :email)";
	$query = $db->prepare($sql);
	$success = $query->execute(array(
		':urgencia' => $urgencia,
		':assunto' => $assunto, 
		':questao' => $questao, 
		':nome' => $nome, 
		':empresa' => $empresa, 
		':telefone' => $telefone, 
		':celular' => $celular, 
		':email' => $email
	));
	
	if ($success) {
		echo '<div id="div_sucesso">
				Mensagem enviada com sucesso ao Setor de Qualidade<br>
				E-mail : qualidade@redeindustrial.com.br<br>
				Tel : (011) 4062-0139
			</div>';
	}else {
		echo '<div class="div_erro2">Ocorreu um erro ao processar o envio. Por favor, tente novamente.</div>';
	}
	
	function decode_telefone($telefone){
			$telefone = trim($telefone);
			if($telefone=="") return "";
			$nums = "0123456789";
		
			$numsarr = str_split($nums);
			$telsarr = str_split($telefone);
		
			$novo_telefone = "";
		
			foreach($telsarr as $tel){
				$ex = false;
				foreach($numsarr as $num){
					if($tel == $num){
						$ex = true;
						break;
					}
				}
				 
				if($ex) $novo_telefone .= $tel;
			}
		
			return $novo_telefone;
	}
	
}

?>
</div>
</body>
</html>