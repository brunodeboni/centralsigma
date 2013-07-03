<?php

session_start();
if(!isset($_SESSION['5468usuario'])) die("<strong>Acesso Negado!</strong>");

?>
<!doctype html> 
<html>
<head>
    <meta charset="utf-8" />
	<title>Resumo de SMS's</title>
	<style>
	body{font-size:14px; font-family: Arial, Helvetica, sans-serif;}
	.firstline {background-color: #FAF0E6; width: 250px;}
	.secondline {background-color: #FAEBD7; width: 250px;}
	.mostrar {font-weight:bold;}
	.sms{
	margin:10px auto;
	padding:5px;
	width:350px;
	background:#F7F7FF;
	}
	h1{
		margin-bottom:5px;
		text-align:center;
		padding:5px;
		font-size:18px;
		background:#B03060;
		
		color:#FFF;
	}
	h2{
		margin-bottom:5px;
		text-align:center;
		padding:5px;
		font-size:18px;
		background:#369;
		color:#FFF;
	}
	table{
		margin-bottom:5px;
		width:100%;
		border-collapse:collapse;
		border-bottom:2px solid #6969AF;
	}
		table thead tr{
			background:#6969AF;
			
		}
		table th, table td{
			padding:10px;
			text-align:right;
			font-weight: bold;
		}
	</style>
</head>
<body>
<center>
	<div class="sms">
	<h1>SMS's enviados</h1>
	<h2>Clique no link para ver as mensagens</h2>
	<table>
		<tr class="firstline">
			<td>Data
			<td>Quantidade

<?php
	 // Conexão com mysql
	include '../../../conexoes.inc.php';
	$db = Database::instance('centralsigma02');
	
	//Pesquisa a quantidade de SMS's enviados por dia
	$sql = "select DATE_FORMAT(DATE(DATA_ENVIO), '%d/%m/%Y') AS dia, count(CODIGO) AS quantidade 
		from sms WHERE DATA_ENVIO IS NOT NULL group by DIA order by DATA_ENVIO desc";
	$query = $db->prepare($sql);
	$query->execute();
	$resultado = $query->fetchAll();
	
	$rowq = true; //Classe para cores das linhas
	
	foreach ($resultado as $res) {
		//Classe para cores das linhas
        if($rowq) $class = "secondline";
		else $class = "firstline";
		$rowq = !$rowq;
		
		$dia = $res['dia'];
		
		//Tabela exibe quantidade de SMS's enviados por dia
		echo "<tr class=\"$class\">";
		echo "<td><a href=\"quantidade.php?data=".$dia."\">".$dia."</a>";
		echo "<td>".$res['quantidade'];
	}
		

?>
	</table>
	</div>
	<br>
	<a class="mostrar" href="relatorio.php" target="_blank">Gerar Relat&oacute;rio em PDF</a>
</center>
</body>