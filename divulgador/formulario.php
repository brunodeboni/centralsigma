<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Divulgador SIGMA</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/gioplugin.js"></script>
	<script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/jquery.maskedinput.js"></script>
	<link type="text/css" rel="stylesheet" href="../arquivos/default.css">
	<style>
	#unchecked {
		font-size: 12px;
		font-weight: bold;
		width: 40px;
		padding:10px 30px;
		background: #EEE;
		color: grey;
		border: 1px solid grey;
		-webkit-border-radius: 15px; 
		border-radius: 15px;
		-webkit-box-shadow: 1px 1px 3px #888;
		box-shadow: 1px 1px 3px #888;
	}
	</style>
</head>
<body>
<div id="container">
	<h1>Divulgador SIGMA</h1>
	
	<form id="form_divulgador" action="" method="post">
		
		<div style="padding-bottom: 10px;">Preencha o cadastro com seus dados:</div>
		
		<span>Nome Completo: </span><br>
		<input type="text" id="inp_nome" name="nome" class="block">
		
		<span>Telefone Fixo: </span><br>
		<input type="text" id="inp_telefone" name="telefone" class="block telefone" maxlength="15">
		
		<span>Telefone Celular: </span><br>
		<input type="text" id="inp_celular" name="celular" class="block telefone" maxlength="15">
		
		<span>E-mail: </span><br>
		<input type="text" id="inp_email" name="email" class="block"><br>
		
		<span>Endereço: </span><br>
		<input type="text" id="inp_endereco" name="endereco" class="block">
		
		<span>Bairro: </span><br>
		<input type="text" id="inp_bairro" name="bairro" class="block">
		
		<span>CEP: </span><br>
		<input type="text" id="inp_cep" name="cep" class="block cep">
		
		<span>Cidade: </span><br>
		<input type="text" id="inp_cidade" name="cidade" class="block">
		
		<span>Estado: </span><br>
		<select name="uf" id="inp_uf" class="block">
			<option value ="">Selecione...</option>
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
		
		<span>CPF: </span><br>
		<input type="text" id="inp_cpf" name="cpf" class="block cpf"><br>
		
		<span>Dados Bancários: </span><br>
		<span>Banco: </span><br>
		<input type="text" id="inp_banco" name="banco" class="block">
		<span>Agência: </span><br>
		<input type="text" id="inp_agencia" name="agencia" class="block">
		<span>Conta Corrente: </span><br>
		<input type="text" id="inp_conta" name="conta" class="block"><br>
		
		<span>Escolha uma senha: </span><br>
		<input type="password" id="inp_senha" name="senha" class="block">
		<span>Confirme sua senha: </span><br>
		<input type="password" id="inp_conf_senha" name="conf_senha" class="block"><br>
		
		<input type="checkbox" onchange="allowSubmit(this)" id="inp_aceito" name="aceito" value="sim">
		<span>Li, aceito e estou de acordo com o <a href="Termo_de_Adesao-Divulgador_SIGMA.pdf" target="_blank">Termo de Adesão ao Programa de Incentivo ao Divulgador SIGMA</a>.</span><br>
		<br>
		<div id="div_erro"></div>
		
		<div id="botao"><div id="unchecked">Enviar</div></div>
	</form>
<script>
$(document).ready(function() {
	$(".telefone").telefone();
	$(".cep").mask('99999-999');
	$(".cpf").mask('999.999.999-99');
});

function verificaDados() {
	if ($('#inp_nome').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu Nome Completo.'); return false;}
	if ($('#inp_telefone').val() == "" || $('#inp_telefone').val().length < 13) {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu Telefone Fixo.'); return false;}
	if ($('#inp_celular').val() == "" || $('#inp_celular').val().length < 13) {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu Telefone Celular.'); return false;}
	if ($('#inp_email').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu E-mail.'); return false;}
	if ($('#inp_endereco').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu Enderço.'); return false;}
	if ($('#inp_bairro').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu Bairro.'); return false;}
	if ($('#inp_cep').val() == "" || $('#inp_cep').val().length < 9) {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu CEP.'); return false;}
	if ($('#inp_cidade').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe sua Cidade.'); return false;}
	if ($('#inp_uf').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu Estado.'); return false;}
	if ($('#inp_cpf').val() == "" || $('#inp_cpf').val().length < 14) {$('#div_erro').show(); $('#div_erro').html('Por favor, informe seu CPF.'); return false;}
	if ($('#inp_banco').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o nome de seu Banco.'); return false;}
	if ($('#inp_agencia').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o número de sua Agência Bancária.'); return false;}
	if ($('#inp_conta').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o número de sua Conta Corrente.'); return false;}
	if ($('#inp_senha').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, escolha uma senha.'); return false;}
	if ($('#inp_conf_senha').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, confirme sua senha.'); return false;}
	
	if (!checarEmail($('#inp_email').val())) {$('#div_erro').show(); $('#div_erro').html('Por favor, informe um e-mail válido.'); return false;}
	if ($('#inp_senha').val() != $('#inp_conf_senha').val()) {$('#div_erro').show(); $('#div_erro').html('As senhas não estão iguais.'); return false;}

	$("#form_divulgador").submit();
}

function checarEmail(mail){
	if(mail.length==0) return true;
	
	if ((mail.length > 7) && !((mail.indexOf("@") < 1) || (mail.indexOf('.') < 1)))
		{return true;}
	else
		{return false;}
}

//callback function de checarCpf()
function a(data) {
	if (data == 'false') {
		$('#div_erro').show();
		$('#div_erro').html('Este CPF já está cadastrado.');
	}else {
		verificaDados();
	}
}

function checarCpf(cpf) {
	$.post('ajax_cpf.php',{cpf: cpf}, function(data) {
		a(data);
	});
}

function allowSubmit(inp) {
	if (inp.checked) {
		$('#botao').html('<button type="button" onclick="checarCpf($(\'#inp_cpf\').val())">Enviar</button>');
	}else {
		$('#botao').html('<div id="unchecked">Enviar</div>');
	}
}

</script>

<?php

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

//Função verifica se os dados foram preenchidos
function valida($array) {
	foreach ($array as $obj => $info) {
		if ($obj == "") {
			echo '<div id="form-titulo">Por favor, informe '.$info.'!</div>'; 
			return false;
			break;
		}
	}
}

if (isset($_POST['nome'])) {
	
	// Conexão com mysql
	require '../conexoes.inc.php';
	$db = Database::instance('centralsigma02');
	
	//Cadastro no Banco de Dados
	$nome = $_POST['nome'];
	$telefone = decode_telefone($_POST['telefone']);
	$celular = decode_telefone($_POST['celular']);
	$email = $_POST['email'];
	$endereco = $_POST['endereco'];
	$bairro = $_POST['bairro'];
	$cep = $_POST['cep'];
	$cidade = $_POST['cidade'];
	$uf = $_POST['uf'];
	$cpf = $_POST['cpf'];
	$banco = $_POST['banco'];
	$agencia = $_POST['agencia'];
	$conta = $_POST['conta'];
	$senha = $_POST['senha'];
	$conf_senha = $_POST['conf_senha'];
	
	//Valida se todos os dados foram preenchidos
	$dados = array(
		$nome => 'seu Nome Completo',
		$telefone => 'seu Telefone Fixo',
		$celular => 'seu Celular',
		$email => 'seu E-mail',
		$endereco => 'seu Endereco',
		$bairro => 'seu Bairro',
		$cep => 'seu CEP',
		$cidade => 'sua Cidade',
		$uf => 'seu Estado',
		$cpf => 'seu CPF',
		$banco => 'seu Banco',
		$agencia => 'o número de sua Agência bancária',
		$conta => 'sua Conta Corrente',
		$senha => 'sua Senha',
		$conf_senha => 'a confirmação de sua Senha'
	);
	$verificar = valida($dados);
	
	//Confere se senhas digitadas conferem
	if ($senha != $conf_senha) {
		echo '<div id="form-titulo">Suas senhas não conferem!</div>'; 
		$verificar = false;
	}
	//Encripta senha
	$senha = md5($_POST['senha']);
	
	if ($verificar) {
		$sql = "insert into dv_divulgadores_sigma (senha, nome, telefone, celular, email, endereco, bairro, cep, cidade, uf, cpf, banco, agencia, conta) 
		values (:senha, :nome, :telefone, :celular, :email, :endereco, :bairro, :cep, :cidade, :uf, :cpf, :banco, :agencia, :conta)";
		$query = $db->prepare($sql);
		$success = $query->execute(array(
			':senha' => $senha, 
			':nome' => $nome, 
			':telefone' => $telefone, 
			':celular' => $celular, 
			':email' => $email, 
			':endereco' => $endereco, 
			':bairro' => $bairro, 
			':cep' => $cep, 
			':cidade' => $cidade,
			':uf' => $uf, 
			':cpf' => $cpf, 
			':banco' => $banco, 
			':agencia' => $agencia, 
			':conta' => $conta
		));
		$codigo = $db->lastInsertId('codigo');
		
		if (! $success) {
			echo '<div class="div_erro2">Erro ao processar seu cadastro. Por favor, atualize a página e tente novamente!</div>';
		
		}else {
		
			//Envia SMS de confirmação
			$mensagem_cel = "Recebemos com sucesso o seu cadastro de divulgador SIGMA. Para mais informações entre em contato.";
			$sql2 = "insert into `sms` (`CELULAR_REMETENTE`, `CELULAR_DESTINO`, `MENSAGEM`, `CODIGO_CLIENTE`, `STATUS`, `USUARIO`)
				values ('9999999999', :celular, :mensagem_cel, '', '1', '151')";
			$query2 = $db->prepare($sql2);
			$query2->execute(array(':celular' => $celular, ':mensagem_cel' => $mensagem_cel));
		
		
			//Envia e-mail de confirmação
			$destinatario = "<".$email.">";
			$assunto = "Divulgador SIGMA - Cadastro efetuado com sucesso!";
			$msg = "
Olá ".$nome.",

Recebemos com sucesso o seu cadastro para ser um Divulgador do SIGMA! O seu código de divulgador é o <b>".$codigo."</b>.

A partir de agora você pode começar a indicar o SIGMA aos seus colegas da área para que, havendo fechamento de negócio com os mesmos, você receba a premiação pela indicação!

Para acessar o Painel do Divulgador, e acompanhar o andamento das negociações com as empresas que você indicar o SIGMA, guarde os dados a seguir:

- Link de acesso: <a href=\"http://www.centralsigma.com.br/divulgador/\" target=\"_blank\">www.centralsigma.com.br/divulgador</a>
- Login: ".$codigo."
- Senha: ".$_POST['senha']."

Lembre-se que é importante que os seus contatos indicados sempre tenham em mãos o seu código de divulgador, para que o atendimento dos mesmos seja vinculado à sua conta.

Desejamos sucesso em suas indicações e para mais informações não hesite em nos contatar.

Atenciosamente,

Setor Comercial SIGMA
<a href=\"mailto:comercial@redeindustrial.com.br\">comercial@redeindustrial.com.br</a>
(11) 4062-0139";
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
		 	
		 	echo '<div id="div_sucesso">
		 	Cadastro efetuado com sucesso!<br>
		 	Seu código é <b>'.$codigo.'</b><br>
		 	<span style="font-size: 12px;">Atenção: Este código será o seu identificador e também o seu login.</span>
		 	</div>';
		}
	}
}

?>
</div>
</body>
</html>