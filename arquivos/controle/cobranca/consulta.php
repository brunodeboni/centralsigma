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
	<title>Páginas de Controle</title>
	<style>
	*{      
	font-family:Tahoma, Geneva, sans-serif;
	padding:0;
	margin:0;
	font-size:12px;
	}
	div {
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
			text-align: center;
			font-weight: bold;
	}
	.firstline {background-color: #FAF0E6; width: 250px;}
	.secondline {background-color: #FAEBD7; width: 250px;}
	a, a:link, a:visited {text-decoration: none;}
	a:hover, a.over {text-decoration: none; background-color: #F7F7FF;}
	#logout {
		padding: 5px 30px;
		font-weight: bold;
		color: #FFF;
		background-color: #6969AF;
	}
	</style>
</head>
<body>
	<div>
		<h1>Consulta de cobranças</h1>
			<table>
				<tr class="firstline"><td><a href="consulta_nota.php">Consulta de Nota Fiscal</a></td></tr>		
			</table>
			<div>
				<a id="logout" href="index.php">Sair</a>
				<a id="logout" href="../controle.php">Voltar</a>
			</div>
	</div>
</body>
</html>