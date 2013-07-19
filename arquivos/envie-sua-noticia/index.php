<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Envie sua Notícia</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<link href="../default.css" rel="stylesheet">
</head>
<body>
<div id="container">
	<h1>Escreva sua notícia</h1>
	<form action="" method="post" id="form_noticia">
		<span>Nome:</span>
		<input type="text" name="nome" id="nome" class="block"><br>
		
		<span>Empresa:</span>
		<input type="text" name="empresa" id="empresa" class="block"><br>
		
		<span>Cargo:</span>
		<input type="text" name="cargo" id="cargo" class="block"><br>
		
		<span>Cidade:</span>
		<input type="text" name="cidade" id="cidade" class="block"><br>
		
		<span>Estado:</span>
		<select name="uf" id="uf" class="block">
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
		
		<span>E-mail:</span>
		<input type="text" name="email" id="email" class="block"><br>
		
		<span>Usa o SIGMA há quanto tempo?</span>
		<input type="text" name="tempo_usuario" id="tempo_usuario" class="block"><br>
		
		<span>Assunto:</span>
		<input type="text" name="assunto" id="assunto" class="block"><br>
		
		<span>Escreva sua Notícia:</span>
		<textarea rows="15" name="noticia" id="noticia" class="block"></textarea><br>
		
		<div id="div_erro"></div>
		
		<button type="button" id="btn">Enviar</button>
	</form>
	
<script>
$('#btn').click(function() {
	if ($('#nome').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu nome.'); return false;}
	if ($('#empresa').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe sua empresa.'); return false;}
	if ($('#cargo').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu cargo.'); return false;}
	if ($('#cidade').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe sua cidade.'); return false;}
	if ($('#uf').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu estado.'); return false;}
	if ($('#email').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu e-mail.'); return false;}
	if (! checarEmail($('#email').val())) {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu e-mail corretamente.'); return false;}
	if ($('#tempo_usuario').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe há quanto tempo é um usuário SIGMA.'); return false;}
	if ($('#assunto').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o assunto de sua notícia.'); return false;}
	if ($('#noticia').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, escreva sua notícia.'); return false;}

	$('#form_noticia').submit();
});

function checarEmail(mail){
	if(mail.length==0) return true;
	
	if ((mail.length > 7) && !((mail.indexOf("@") < 1) || (mail.indexOf('.') < 2)))
		{return true;}
	else
		{return false;}
}
</script>

<?php 

if (isset ($_POST['nome'])) {
	$nome = $_POST['nome'];
	$empresa = $_POST['empresa'];
	$cargo = $_POST['cargo'];
	$cidade = $_POST['cidade'];
	$uf = $_POST['uf'];
	$email = $_POST['email'];
	$tempo_usuario = $_POST['tempo_usuario'];
	$assunto = $_POST['assunto'];
	$noticia = $_POST['noticia'];
	
	
	//Conexão banco de dados
	require '../../conexoes.inc.php';
	$db = Database::instance('centralsigma02');
	
	$sql = "insert into news_enviadas 
	(nome, empresa, cargo, cidade, uf, email, tempo_usuario, assunto, noticia) 
	values (:nome, :empresa, :cargo, :cidade, :uf, :email, :tempo_usuario, :assunto, :noticia)";
	$query = $db->prepare($sql);
	$success = $query->execute(array(
		':nome' => $nome,
		':empresa' => $empresa,
		':cargo' => $cargo,
		':cidade' => $cidade,
		':uf' => $uf,
		':email' => $email,
		':tempo_usuario' => $tempo_usuario,
		':assunto' => $assunto,
		':noticia' => $noticia,
	));
	
	/*
	//Enviar e-mail com a notícia
	$headers = 'MIME-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
	$headers .= 'From: <'.$email.'>,<news@redeindustrial.com.br>'."\r\n";
	
	$message = '
<!doctype html>
<html>
<head>
	<meta charset="utf8">
</head>
<body>
	<pre style="font-size: 14px; font-family: Arial, sans-serif;">
<b>Nome:</b> '.$nome.'
<b>Empresa:</b> '.$empresa.'
<b>Cargo:</b> '.$cargo.'
<b>Cidade:</b> '.$cidade.'
<b>Estado:</b> '.$uf.'
<b>E-mail:</b> '.$email.'
<b>Há quanto tempo é usuário SIGMA:</b> '.$tempo_usuario.'

<b>Assunto:</b> '.$assunto.'

<b>Notícia:</b> 
'.$noticia.'
	
	</pre>
</body>
</html>

';
	$success = mail('news@redeindustrial.com.br', 'Noticias', $message, $headers);
	*/
	
	if ($success) {
		echo '<div id="div_sucesso">Notícia enviada com sucesso!</div>';
	}else {
		echo '<div class="div_erro2">Erro ao enviar sua notícia. Por favor, tente novamente.</div>';
	}
	
}

?>

</div>
</body>
</html>
