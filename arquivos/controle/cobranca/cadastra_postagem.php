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
	<title>Postagem de Cobrança</title>
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
	</style>
</head>
<body>
<div id="container">
	<h1>Postagem de Cobrança</h1>
	<form id="form_postagem" action="" method="post">
		
		<span>Número da Nota Fiscal:</span><br>
		<input type="text" name="nro_nota" id="nro_nota" class="block"><br>
		
		<span>Data da Postagem:</span><br>
		<input type="text" name="data_postagem" id="data_postagem" class="block"><br>
		
		<span>Localizador:</span><br>
		<input type="text" name="localizador" id="localizador" class="block"><br>
		
		<div id="div_erro"></div>
		
		<button type="button" id="btn" onclick="validar()">Enviar</button>
		<a id="btn" href="cadastra.php">Voltar</a>
	</form>

<script>
$(document).ready(function() {
	$('#data_postagem').mask('99/99/9999');
});

function validar() {
	if ($('#nro_nota').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o número da nota fiscal.'); return false;}
	if ($('#data_postagem').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe a data da postagem.'); return false;}
	if ($('#localizador').val() == "") {$('#div_erro').show(); $('#div_erro').html('Por favor, informe o localizador da postagem.'); return false;}

	$('#form_postagem').submit();
}
</script>
<?php 

if (isset ($_POST['nro_nota'])) {
	
	$nro_nota = mysql_real_escape_string($_POST['nro_nota']);
	$data_postagem = mysql_real_escape_string($_POST['data_postagem']);
	$localizador = mysql_real_escape_string($_POST['localizador']);
	
	//Inserir os dados no banco de dados
	$conn = mysql_connect("mysql.centralsigma.com.br","webadmin","webADMIN") or die("Sem conexão com o Banco de Dados");
	mysql_select_db("controle",$conn) or die("N&atilde;o foi possivel selecionar o Banco de Dados");
	mysql_set_charset('utf8');
	
	$sql = "select id from cob_nota_fiscal where nro_nota = '".$nro_nota."'";
	$query = mysql_query($sql, $conn);
	
	if (mysql_num_rows($query) > 0) {
		$res = mysql_fetch_assoc($query);
		$id_nota = $res['id'];
	
		$sql2 = "update cob_conta_cobranca set data_postagem = str_to_date('".$data_postagem."', '%d/%m/%Y'), localizador_postagem = '".$localizador."' where id_nota_fiscal = ".$id_nota;
		$query2 = mysql_query($sql2, $conn);
		
		if ($query2 == 1) {
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
