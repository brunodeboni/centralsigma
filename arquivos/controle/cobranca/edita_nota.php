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
	<h1>Editar Nota Fiscal</h1>
	<form id="form_edita_nota" action="" method="post">
		<span>Número da Nota Fiscal:</span><br>
		<input type="text" name="nro_nota" id="nro_nota" onblur="buscaNota(this.value)" class="block"><br>
		
		<input type="hidden" name="id_nota" id="id_nota" value="">
		
		<span>Valor:</span><br>
		R$ &nbsp; <input type="text" name="valor" id="valor" style="width:93%;" disabled><br>
		
		<br>
		<div id="div_venc">
			<span>Vencimento:</span><br>
			<input type="text" name="vencimento[]" id="vencimento" disabled>
			<span id="mais" onclick="maisVenc('0')">+</span>
			<span style="font-size: 12px;">Clique para adicionar mais datas</span><br>
		</div>
		<br>
		
		<div id="div_erro"></div>
		
		<button type="button" class="btn" id="btn_edita">Enviar</button>
		<a class="btn" href="edita.php">Voltar</a>
	</form>
	
<script>
function buscaNota(nro_nota) {
	$.post('ajax_nota.php', {nro_nota: nro_nota}, function(data) {
		var data = $.parseJSON(data);
		//console.log(data);
		if (data == false) {
			$('#div_erro').show(); 
			$('#div_erro').html('Esta Nota Fiscal não está cadastrada. Por favor, recarregue a página e tente novamente.');
			
		} else {
			$('#id_nota').val(data.id_nota);
			$('#valor').removeAttr('disabled', 'false').val(data.valor);
			$('#vencimento').removeAttr('disabled', 'false');
			
			var vencimento = data.vencimento;
			var venc = vencimento.split('|');
			venc[0] = venc[0].replace('-', '/').replace('-', '/');
			$('#vencimento').val(venc[0]);
			
			for (var i=1;i<venc.length;i++) {
				var a = maisVenc(i);
				var vencimento = venc[i].replace('-', '/').replace('-', '/');
				$('#'+i).val(vencimento);
			}
		}
	});
}

function maisVenc(id) {
	$('<input>') 
	.attr('type', 'text').attr('name', 'vencimento[]').attr('id', id)
	.mask('99/99/9999')
	.appendTo('#div_venc');

	$('<br>').appendTo('#div_venc');
}

$(document).ready(function() {
	$('#vencimento').mask('99/99/9999');
});

$('#btn_edita').click(function() {
	if ($('#valor').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o valor.'); return false;}
	if ($('#vencimento').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe a data de vencimento.'); return false;}
	
	$('#form_edita_nota').submit();
});

</script>

<?php 
if (isset ($_POST['id_nota'])) {
 	$id_nota = $_POST['id_nota'];
	$nro_nota = $_POST['nro_nota'];
	$valor = $_POST['valor'];

	$v = "";
	foreach ($_POST['vencimento'] as $vencimento) {
		$venc = str_ireplace('/', '-', $vencimento);
		$v .= $venc."|";
	}
	$vencimento = trim($v, '|');
	
	//Inserir os dados no banco de dados
	include '../../../conexoes.inc.php';
	$db = Database::instance('controle');
	

	$sql = "update cob_nota_fiscal set valor = :valor, vencimento = :vencimento
			where id = :id_nota";
	$query = $db->prepare($sql);
	$success = $query->execute(array(
		':valor' => $valor,
		':vencimento' => $vencimento,
		':id_nota' => $id_nota
	));

	if ($success) {
		echo '<div id="div_sucesso">Nota Fiscal editada com sucesso!</div>';
	}else {
		echo '<div class="div_erro2">Erro ao editar nota. Por favor, recarregue a página e tente novamente.</div>';
	}
		
}

?>
</div>
</body>
</html>