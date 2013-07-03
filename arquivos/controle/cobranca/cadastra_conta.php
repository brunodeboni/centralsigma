<?php
session_start();
if(!isset($_SESSION['5468usuario'])) {
	die("<strong>Acesso Negado!</strong>");
}else if($_SESSION['6542role'] != '2') {
	die("<strong>Acesso Negado!</strong>");
}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Contas a Receber / Cobrança</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/jquery.maskedinput.js"></script>
	<style>
	body {
		font-size:14px; 
		font-family: Arial, Helvetica, sans-serif;
	}
	#container {
		padding: 10px;
		width: 500px;
		margin: auto;
		background:#F7F7FF;
	}
	h1 {
		text-align: center;
		padding: 5px;
		background: #B03060;
		color:#FFF;
	}
	h2 {
		text-align: center;
		padding: 5px;
		background: #369;
		color:#FFF;
	}
	.block{
		width:100%;
		margin:auto;
		display:block;
	}
	
	#btn{
		background: #B03060; 
		padding: 10px 40px; 
		color: #FFF; 
		font-weight: bold;
		font-size: 14px;
		border: 0;
		text-decoration: none;
	}
	#div_erro {
		display: none;
		margin-bottom:10px;
		width:90%;
		padding:5px;
		background:#FEE;
		color:#900;
	}
	.div_erro2 {
		margin-top:10px;
		width:90%;
		padding:5px;
		background:#FEE;
		color:#900;
	}
	#div_sucesso {
		margin-top:10px;
		width:90%;
		padding:5px;
		background:#FAF0E6;
		color:#D2691E;
		font-weight: bold;
	}
	#mais {
		padding: 5px;
		background: #4682B4;
		color: #FFF;
		font-weight: bold;
		-webkit-border-radius: 50px;
		border-radius: 50px;
	}
	</style>
</head>
<body>
<div id="container">
	<h1>Cadastro de Conta a Receber</h1>
	<h2>Dados da Nota Fiscal</h2>
	<form id="form_cobranca" action="" method="post">
		
		<span>Número da Nota Fiscal:</span><br>
		<input type="text" id="nro_nota" name="nro_nota" class="block"><br>
		
		<span>Emitente:</span><br>
		<select name="emitente" id="emitente" onchange="selectCnpj(this.value)" class="block">
			<option value="">Selecione...</option>
			<option value="MICROCENTER COM. EQUIP. ELETRÔN. LTDA">MICROCENTER COM. EQUIP. ELETRÔN. LTDA</option>
			<option value="SGM MANUTENÇÃO INDUSTRIAL LTDA">SGM MANUTENÇÃO INDUSTRIAL LTDA</option>
		</select><br>
		
		<span>CNPJ Emitente:</span><br>
		<input type="text" name="cnpj_emitente" id="cnpj_emitente" value="" class="block" maxlength="18"><br>
		
		<span>Valor:</span><br>
		R$ &nbsp; <input type="text" name="valor" id="valor" style="width:93%;"><br>
		
		<div id="div_venc">
			<span>Vencimento:</span><br>
			<input type="text" name="vencimento[]" id="vencimento">
			<span id="mais" onclick="maisVenc()">+</span>
			<span style="font-size: 12px;">Clique para adicionar mais datas</span><br>
		</div>
		<br>
		
		<span>Produto / Serviço:</span><br>
		<input type="text" name="produto" id="produto" class="block"><br>
		
		<span>Forma de Pagamento:</span><br>
		<select name="forma_pagto" id="forma_pagto" class="block">
			<option value="">Selecione...</option>
			<option value="Boleto Bancário">Boleto Bancário</option>
			<option value="Depósito Banco Itaú Ag. 6383 CC 01290-0">Depósito Banco Itaú Ag. 6383 CC 01290-0</option>
			<option value="Depósito Banco Itaú Ag. 0293 CC 87167-9">Depósito Banco Itaú Ag. 0293 CC 87167-9</option>
		</select><br>
		
		<span>Ordem de Compra:</span><br>
		<select onchange="enableInput(this.value)" id="ordem_compra" name="ordem_compra" class="block">
			<option value="">Selecione...</option>
			<option value="Informada">Informada</option>
			<option value="Não Informada">Não Informada</option>
		</select>
		<span style="font-size: 12px;">Número da Ordem de Compra:</span>
		<input type="text" name="nro_ordem" id="nro_ordem" class="block" disabled><br>
		
		<h2>Dados do Cliente</h2>
		
		<span>CNPJ:</span><br>
		<input type="text" name="cnpj_cliente" id="cnpj_cliente" onblur="existsCliente(this.value)" class="block" maxlength="18"><br>
		
		<input type="hidden" id="id_cliente" name="id_cliente" value="">
		
		<span>Razão Social:</span><br>
		<input type="text" name="razao_social" id="razao_social" class="block cliente" disabled><br>
		
		<span>Responsável:</span><br>
		<input type="text" name="responsavel" id="responsavel" class="block cliente" disabled><br>
		
		<span>Setor:</span><br>
		<input type="text" name="setor" id="setor" class="block cliente" disabled><br>
		
		<span>E-mail:</span><br>
		<input type="text" name="email" id="email" class="block cliente" disabled><br>
		
		<span>Telefone:</span><br>
		<input type="text" name="telefone" id="telefone" class="block cliente" disabled><br>
		
		<div id="div_erro"></div>

		<button type="button" id="btn" onclick="validar()">Enviar</button>
		<a id="btn" href="cadastra.php">Voltar</a>
	</form>
	
<script>
$(document).ready(function() {
	$('#vencimento').mask('99/99/9999');
	$('#cnpj_cliente').mask('99.999.999/9999-99');
	$('#telefone').mask('(99) 9999-9999?9');
});

function selectCnpj(emitente) {
	if (emitente == 'MICROCENTER COM. EQUIP. ELETRÔN. LTDA') {
		$('#cnpj_emitente').val('94.212.248/0001-60');
	}else if (emitente == 'SGM MANUTENÇÃO INDUSTRIAL LTDA') {
		$('#cnpj_emitente').val('05.155.514/0001-30');
	}
}

function enableInput(valor) {
	if (valor == 'Informada') {
		$('#nro_ordem').removeAttr('disabled', 'false');
	}else {
		$('#nro_ordem').attr('disabled', 'true');
	}
}

function existsCliente(cnpj) {
	$.post('ajax_cnpj.php', {cnpj: cnpj}, function(data) {
		callback(data);
	})
	.fail(function (xhr, ajaxOptions, thrownError) {
        console.log(xhr.status);
        console.log(thrownError);
        console.log(xhr.responseText);
      });
}

function callback(data) {
	if (data == 'false') { //se não existe
		$('.cliente').removeAttr('disabled', 'false');
		
	}else {
		var data = $.parseJSON(data);
	
		$('#id_cliente').val(data.id_cliente);
		$('#razao_social').val(data.razao_social);
		$('#responsavel').val(data.responsavel);
		$('#setor').val(data.setor);
		$('#email').val(data.email);
		$('#telefone').val(data.telefone);
		
		$('.cliente').removeAttr('disabled', 'false');
	}
}

function maisVenc() {
	$('<input>') 
	.attr('type', 'text').attr('name', 'vencimento[]')
	.mask('99/99/9999')
	.appendTo('#div_venc');

	$('<br>').appendTo('#div_venc');
}

function validar() {
	if ($('#nro_nota').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o número da nota fiscal.'); return false;}
	if ($('#emitente').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe a empresa emitente.'); return false;}
	if ($('#cnpj_emitente').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o CNPJ do emitente.'); return false;}
	if ($('#valor').val() == "" || $('#valor').val() == "R$ ") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o valor.'); return false;}
	if ($('#vencimento').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe a data de vencimento.'); return false;}
	if ($('#produto').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o produto/serviço.'); return false;}
	if ($('#forma_pagto').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe a forma de pagamento.'); return false;}
	if ($('#ordem_compra').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe se há ordem de compra.'); return false;}
	if ($('#ordem_compra').val() == "Informada" && $('#nro_ordem').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o número da ordem de compra.'); return false;}

	if ($('#cnpj_cliente').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o CNPJ do cliente.'); return false;}
	if ($('#razao_social').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe a Razão Social do cliente.'); return false;}
	if ($('#responsavel').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o responsável.'); return false;}
	if ($('#setor').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o setor do responsável.'); return false;}
	if ($('#email').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o e-mail do cliente.'); return false;}
	if ($('#telefone').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o telefone do cliente.'); return false;}

	$('#form_cobranca').submit();
}
</script>

<?php 
if (isset ($_POST['nro_nota'])) {
	$nro_nota = $_POST['nro_nota'];
	$emitente = $_POST['emitente'];
	$cnpj_emitente = $_POST['cnpj_emitente'];
	$valor = $_POST['valor'];
	
	$v = "";
	foreach ($_POST['vencimento'] as $vencimento) {
		$venc = mysql_real_escape_string($vencimento);
		$venc = str_ireplace('/', '-', $venc);
		$v .= $venc."|";
	}
	$vencimento = trim($v, '|');

	$produto = $_POST['produto'];
	$forma_pagto = $_POST['forma_pagto'];
	$ordem_compra = $_POST['ordem_compra'];
	
	if ($ordem_compra == "Informada") {
		$nro_ordem = $_POST['nro_ordem'];
		$ordem_compra = $nro_ordem;
	}
	
	$cnpj_cliente = $_POST['cnpj_cliente'];
	$id_cliente = $_POST['id_cliente'];
	$razao_social = $_POST['razao_social'];
	$responsavel = $_POST['responsavel'];
	$setor = $_POST['setor'];
	$email = $_POST['email'];
	$telefone = $_POST['telefone'];
	
	//Inserir os dados no banco de dados
	include '../../../conexoes.inc.php';
	$db = Database::instance('controle');
	
	if ($id_cliente == "") {
		$sql = "insert into cob_clientes (cnpj, razao_social, responsavel, setor, email, telefone) values (:cnpj_cliente, :razao_social, :responsavel, :setor, :email, :telefone)";
		$query = $db->prepare($sql);
		$success = $query->execute(array(
			':cnpj_cliente' => $cnpj_cliente, 
			':razao_social' => $razao_social, 
			':responsavel' => $responsavel, 
			':setor' => $setor, 
			':email' => $email, 
			':telefone' => $telefone
		));
		$id_cliente = $db->lastInsertId('id');
	}else {
		$sql = "update cob_clientes set cnpj = :cnpj_cliente, razao_social = :razao_social, responsavel = :responsavel, setor = :setor, email = :email, telefone = :telefone where id = :id_cliente";
		$query = $db->prepare($sql);
		$success = $query->execute(array(
			':cnpj_cliente' => $cnpj_cliente, 
			':razao_social' => $razao_social,
			':responsavel' => $responsavel,
			':setor' => $setor,
			':email' => $email,
			':telefone' => $telefone,
			':id_cliente' => $id_cliente
		));
	}
	
	if ($success) {
		$sql2 = "insert into cob_nota_fiscal (nro_nota, emitente, cnpj_emitente, valor, vencimento, produto, forma_pagto, ordem_compra, id_cliente) values (:nro_nota, :emitente, :cnpj_emitente, :valor, :vencimento, :produto, :forma_pagto, :ordem_compra, :id_cliente)";
		$query2 = $db->prepare($sql2);
		$success2 = $query2->execute(array(
			':nro_nota' => $nro_nota, 
			':emitente' => $emitente, 
			':cnpj_emitente' => $cnpj_emitente, 
			':valor' => $valor, 
			':vencimento' => $vencimento, 
			':produto' => $produto, 
			':forma_pagto' => $forma_pagto, 
			':ordem_compra' => $ordem_compra, 
			':id_cliente' => $id_cliente
		));
		$id_nota = $db->lastInsertId('id');
		
		if ($success2) {
			$sql3 = "insert into cob_conta_cobranca (id_nota_fiscal, data_postagem, localizador_postagem, data_liquidacao) values (:id_nota, null, 'Não postado', null)";
			$query3 = $db->prepare($sql3);
			$success3 = $query3->execute(array(
				':id_nota' => $id_nota
			));
		
			if ($success3) {
				echo '<div id="div_sucesso">Nota Fiscal cadastrada com sucesso!</div>';
			}else {
				echo '<div class="div_erro2">Erro ao cadastrar cobrança. Por favor, recarregue a página e tente novamente.</div>';
			}
		}else {
			echo '<div class="div_erro2">Erro ao cadastrar Nota Fiscal. Por favor, recarregue a página e tente novamente.</div>';
		}
	}else {
		echo '<div class="div_erro2">Erro ao cadastrar cliente. Por favor, recarregue a página e tente novamente.</div>';
	}
}

?>
</div>
</body>
</html>