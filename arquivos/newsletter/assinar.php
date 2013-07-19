<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Assine nossa Newsletter</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/jquery.maskedinput.js"></script>
	<link href="../default.css" rel="stylesheet">
</head>
<body>
<div id="container">
	<h1>Assine nossa Newsletter</h1>
	<form action="" method="post" id="form_assinar">
		<span>Nome:</span>
		<input type="text" name="nome" id="nome" class="block"><br>
		
		<span>Empresa:</span>
		<input type="text" name="empresa" id="empresa" class="block"><br>
		
		<span>Endereço Completo:</span>
		<input type="text" name="endereco" id="endereco" class="block"><br>
		
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
		
		<span>Telefone Fixo:</span>
		<input type="text" name="telefone" id="telefone" class="block"><br>
		
		<span>Celular:</span>
		<input type="text" name="celular" id="celular" class="block"><br>
		
		<span>E-mail:</span>
		<input type="text" name="email" id="email" class="block"><br>
		
		<span>Usa o SIGMA há quanto tempo?</span>
		<input type="text" name="tempo_usuario" id="tempo_usuario" class="block"><br>
		
		<span>Qual a versão do SIGMA que utiliza?</span><br>
		<input type="radio" name="versao" id="versao_201" value="2010 ou anterior">2010 ou anterior
		<input type="radio" name="versao" id="versao_free" value="2012 Free">2012 Free
		<input type="radio" name="versao" id="versao_professional" value="2010 Professional ou Enterprise">2012 Professional ou Enterprise
		<br><br>
		
		<span>Utiliza recursos adicionais do SIGMA? Se sim, quais?</span>
		<input type="text" name="recursos_adicionais" id="recursos_adicionais" class="block"><br>
		
		<span>O SIGMA é utilizado em rede na sua empresa? Se sim, com quantos usuários?</span>
		<input type="text" name="em_rede" id="em_rede" class="block"><br>
		
		<div id="div_erro"></div>
		
		<button type="button" id="btn">Assinar</button>
	</form>
	
<script>
$(document).ready(function() {
	$('#telefone').mask('(99) 9999-9999?9');
	$('#celular').mask('(99) 9999-9999?9');
});

$('#btn').click(function() {
	if ($('#nome').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu nome.'); return false;}
	if ($('#empresa').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe sua empresa.'); return false;}
	if ($('#endereco').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu endereco.'); return false;}
	if ($('#cidade').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe sua cidade.'); return false;}
	if ($('#uf').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu estado.'); return false;}
	if ($('#telefone').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu telefone fixo.'); return false;}
	if ($('#celular').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu celular.'); return false;}
	if ($('#email').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu e-mail.'); return false;}
	if (! checarEmail($('#email').val())) {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu e-mail corretamente.'); return false;}
	if ($('#tempo_usuario').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe há quanto tempo é um usuário SIGMA.'); return false;}
	if (!$('input:radio[name=versao]').is(':checked')) {$('#div_erro').show(); $('#div_erro').html('Por favor, informe sua versão do SIGMA.'); return false;}
	if ($('#recursos_adicionais').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe se usa recursos adicionais do SIGMA.'); return false;}
	if ($('#em_rede').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe se utiliza o SIGMA em rede.'); return false;}

	$('#form_assinar').submit();
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
	$endereco = $_POST['endereco'];
	$cidade = $_POST['cidade'];
	$uf = $_POST['uf'];
	$telefone = $_POST['telefone'];
	$celular = $_POST['celular'];
	$email = $_POST['email'];
	$tempo_usuario = $_POST['tempo_usuario'];
	$versao = $_POST['versao'];
	$recursos_adicionais = $_POST['recursos_adicionais'];
	$em_rede = $_POST['em_rede'];
	
	//Conexão banco de dados
	require '../../conexoes.inc.php';
	$db = Database::instance('centralsigma02');
	
	$sql = "insert into news_assinantes 
	(nome, empresa, endereco, cidade, uf, telefone, celular, email, tempo_usuario, versao, recursos_adicionais, em_rede) 
	values (:nome, :empresa, :endereco, :cidade, :uf, :telefone, :celular, :email, :tempo_usuario, :versao, :recursos_adicionais, :em_rede)";
	$query = $db->prepare($sql);
	$success = $query->execute(array(
		':nome' => $nome,
		':empresa' => $empresa,
		':endereco' => $endereco,
		':cidade' => $cidade,
		':uf' => $uf,
		':telefone' => $telefone,
		':celular' => $celular,
		':email' => $email,
		':tempo_usuario' => $tempo_usuario,
		':versao' => $versao,
		':recursos_adicionais' => $recursos_adicionais,
		':em_rede' => $em_rede
	));
	
	if ($success) {
		echo '<div id="div_sucesso">Cadastrado com sucesso!</div>';
	}else {
		echo '<div class="div_erro2">Erro ao realizar cadastro. Por favor, tente novamente.</div>';
	}
	
}

?>

</div>
</body>
</html>

