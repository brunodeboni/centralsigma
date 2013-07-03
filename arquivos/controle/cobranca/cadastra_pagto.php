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
	<title>Pagamento de Cobrança</title>
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
	<h1>Postagem de Cobrança</h1>
	<form id="form_postagem" action="" method="post">
		
		<span>Número da Nota Fiscal:</span><br>
		<input type="text" name="nro_nota" id="nro_nota" class="block"><br>
		
		<div id="div_pagto">
			<span>Data do Pagamento:</span><br>
			<input type="text" name="data_pagto[]" id="data_pagto">
			<span id="mais">+</span>
			<span style="font-size: 12px;">Clique para adicionar mais datas</span><br>
		</div>
		<br>
		
		<div id="div_erro"></div>
		
		<button type="button" id="btn">Enviar</button>
		<a id="btn" href="cadastra.php">Voltar</a>
	</form>

<script>
$(document).ready(function() {
	$('#data_pagto').mask('99/99/9999');
});

$('#btn').click(function() {
	if ($('#nro_nota').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o número da nota fiscal.'); return false;}
	if ($('#data_pagto').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe a data do pagamento.'); return false;}

	$('#form_postagem').submit();
});

$('#mais').click(function() {
	$('<input>') 
	.attr('type', 'text').attr('name', 'data_pagto[]')
	.mask('99/99/9999')
	.appendTo('#div_pagto');

	$('<br>').appendTo('#div_pagto');
		
});
</script>
<?php 

if (isset ($_POST['nro_nota'])) {
	
	$nro_nota = $_POST['nro_nota'];
	
	$p = "";
	foreach ($_POST['data_pagto'] as $data_pagto) {
		$data_pagto = str_ireplace('/', '-', $data_pagto);
		$p .= $data_pagto."|";
	}
	$data_pagto = trim($p, '|');
	
	//Inserir os dados no banco de dados
	$db = new PDO(
         'mysql:host=mysql.centralsigma.com.br;dbname=controle', 
         'webadmin', 'webADMIN', 
         array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
	);
	
	$sql = "select id from cob_nota_fiscal where nro_nota = :nro_nota";
	$query = $db->prepare($sql);
	$query->execute(array(':nro_nota' => $nro_nota));
	
	if ($query->rowCount() > 0) {
		$resultado = $query->fetchAll();
		foreach ($resultado as $res) {
			$id_nota = $res['id'];
		}
	
		$sql2 = "update cob_conta_cobranca set data_liquidacao = :data_pagto where id_nota_fiscal = :id_nota";
		$query2 = $db->prepare($sql2);
		$success = $query2->execute(array(
			':data_pagto' => $data_pagto,
			':id_nota' => $id_nota
		));
		
		if ($success) {
			echo '<div id="div_sucesso">Informações cadastradas com sucesso!</div>';
		}else {
			echo '<div class="div_erro2">Erro ao cadastrar informações. Por favor, recarregue a página e tente novamente.</div>';
		}
	}else {
		echo '<div class="div_erro2">Esta Nota Fiscal não está cadastrada.</div>';
	}
}

?>
</div>
</body>
</html>
