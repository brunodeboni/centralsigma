<?php
//Verifica se usuário está logado
session_start();
if(!isset($_SESSION['usuario'])) die("<strong>Acesso Negado!</strong>");

?>
<!doctype> 
<html>
<head>
    <meta charset="utf-8" />
	<title>Consulta de Ocorrências</title>
	<link rel="stylesheet" href="default.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/jquery.maskedinput.js"></script>
	<style>
	.ocorrencias {
		width: 500px;
	}
	</style>
</head>
<body>
<div class="ocorrencias">
	<h1>Solução de Ocorrência</h1>
	<form action="" method="post">
		<p>Cadastre a solução para uma ocorrência:</p>
		
		<span>Código da ocorrência:</span>
		<input type="text" name=codigo id="codigo" class="block"><br>
		
		<span>Solução:</span>
		<textarea name="solucao" id="solucao" class="block" rows="5"></textarea><br>
		
		<span>Data:</span>
		<input type="text" name="date" id="date" class="block"><br>
		
		<span>Responsável pela solução:</span>
		<input type="text" name="responsavel_solucao" id="responsavel_solucao" class="block"><br>
		
		<div id="div_erro"></div><br>
		
		<button id="btn">Enviar</button>
	</form>
	
	<script>
	$(document).ready(function() {
		$('#date').mask('99/99/9999');
	});
	
	$('#btn').click(function() {
		if ($('#codigo').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o código da ocorrência.'); return false;}
		if ($('#solucao').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, descreva a solução da ocorrência.'); return false;}
		if ($('#date').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe a data da solução da ocorrência.'); return false;}
		if ($('#responsavel_solucao').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o responsável pela solução.'); return false;}

		$('form').submit();	
	});
	
	
	</script>
<?php 

if (isset ($_POST['codigo'])) {
	
	//Conexão com mysql
	require '../../conexoes.inc.php';
	$db = Database::instance('centralsigma02');
	
	$sql = "insert into bo_solucao 
	(cod_ocorrencia, solucao, date, responsavel_solucao)
	values (:cod_ocorrencia, :solucao, :date, :responsavel_solucao)";
	$query = $db->prepare($sql);
	$query->bindValue(':cod_ocorrencia', $_POST['codigo'], PDO::PARAM_INT);
	$query->bindValue(':solucao', $_POST['solucao'], PDO::PARAM_STR);
	$query->bindValue(':date', $_POST['date'], PDO::PARAM_STR);
	$query->bindValue(':responsavel_solucao', $_POST['responsavel_solucao'], PDO::PARAM_STR);
	$success = $query->execute();
	
	if ($success) {
		$sql = "update bo_ocorrencias set status = '1' where codigo = :codigo";
		$query = $db->prepare($sql);
		$query->bindValue(':codigo', $_POST['codigo'], PDO::PARAM_INT);
		$query->execute();
		
		echo '<div id="div_sucesso">Solução cadastrada com sucesso!</div>';
	}else {
		echo '<div id="div_erro2">Ocorreu um erro ao enviar as informações. Por favor, tente novamente.</div>';
	}
}
?>
	<div id="logout">
		<a href="painel.php">Voltar</a>
		<a href="index.php">Sair</a>
	</div>
</div>
</body>
</html>
