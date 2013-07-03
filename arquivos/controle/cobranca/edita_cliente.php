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
	<title>Editar Nota Fiscal</title>
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
	.block{
		width:100%;
		margin:auto;
		display:block;
	}
	
	.btn{
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
	<h1>Editar Cadastro de Cliente</h1>
	<form id="form_edita_cliente" action="" method="post">
		<span>CNPJ:</span><br>
		<input type="text" name="cnpj_cliente" id="cnpj_cliente" onblur="existsCliente(this.value)" class="block"><br>
		
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
		
		<button type="button" class="btn" id="btn_edita">Enviar</button>
		<a class="btn" href="edita.php">Voltar</a>
	</form>
	
<script>
function existsCliente(cnpj) {
	$.post('ajax_cnpj.php', {cnpj: cnpj}, function(data) {
		if (data == 'false') { //se não existe
			$('#div_erro').show(); 
			$('#div_erro').html('Este CNPJ não está cadastrado. Por favor, recarregue a página e tente novamente.');
			
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
	})
	.fail(function (xhr, ajaxOptions, thrownError) {
        console.log(xhr.status);
        console.log(thrownError);
        console.log(xhr.responseText);
      });
}

$(document).ready(function() {
	$('#cnpj_cliente').mask('99.999.999/9999-99');
	$('#telefone').mask('(99) 9999-9999?9');
});

$('#btn_edita').click(function() {
	if ($('#cnpj_cliente').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o CNPJ do cliente.'); return false;}
	if ($('#razao_social').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe a Razão Social do cliente.'); return false;}
	if ($('#responsavel').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o responsável.'); return false;}
	if ($('#setor').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o setor do responsável.'); return false;}
	if ($('#email').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o e-mail do cliente.'); return false;}
	if ($('#telefone').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o telefone do cliente.'); return false;}

	$('#form_edita_cliente').submit();
});

</script>

<?php 
if (isset ($_POST['id_cliente'])) {
 	$id_cliente = $_POST['id_cliente'];
	$cnpj_cliente = $_POST['cnpj_cliente'];
	$razao_social = $_POST['razao_social'];
	$responsavel = $_POST['responsavel'];
	$setor = $_POST['setor'];
	$email = $_POST['email'];
	$telefone = $_POST['telefone'];
	
	//Inserir os dados no banco de dados
	include '../../../conexoes.inc.php';
	$db = Database::instance('controle');

	$sql = "update cob_clientes set razao_social = :razao_social, responsavel = :responsavel,
			setor = :setor, email = :email, telefone = :telefone
			where id = :id_cliente";
	$query = $db->prepare($sql);
	$success = $query->execute(array(
		':razao_social' => $razao_social,
		':responsavel' => $responsavel,
		':setor' => $setor,
		':email' => $email,
		':telefone' => $telefone,
		':id_cliente' => $id_cliente
	));

	if ($success) {
		echo '<div id="div_sucesso">Cadastro editado com sucesso!</div>';
	}else {
		echo '<div class="div_erro2">Erro ao editar cadastro. Por favor, recarregue a página e tente novamente.</div>';
	}
		
}

?>
</div>
</body>
</html>