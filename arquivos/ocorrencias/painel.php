<?php
//Verifica se usuário está logado
session_start();
if(!isset($_SESSION['usuario'])) die("<strong>Acesso Negado!</strong>");

?>
<!doctype> 
<html>
<head>
    <meta charset="utf-8" />
	<title>Painel de Ocorrências</title>
	<style>
	body{
		color: #24211D; 
	    font-size: 14px; 
	    font-family:Arial, sans-serif; 
	    background: #FFFAF0;
	}
	.firstline {background-color: #FAEBD7; width: 250px;}
	.secondline {background-color: #FAF0E6; width: 250px;}
	.mostrar {font-weight:bold;}
	.ocorrencias{
		margin:10px auto;
		padding:5px;
		width:300px;
		background: #EEEEEE;
	}
	h1{
		display:block;
		margin-bottom:5px;
		text-align:center;
		padding:10px;
		font-size:16px;
		background: #315D81;
		color:#FFF;
		-webkit-border-radius: 5px;
	    border-radius: 5px;
	}
	h2{
		margin-bottom:5px;
		text-align:center;
		padding:5px;
		font-size:16px;
		background:#369;
		color:#FFF;
	}
	table{
		font-size: 14px;
		margin-bottom:5px;
		width:100%;
		border-collapse:collapse;
		border-bottom:2px solid #315D81;
		-webkit-border-radius: 5px;
	    border-radius: 5px;
	}
	table th, table td{
		padding:10px;
		text-align:center;
		font-weight: bold;
	}
	table a, table a:visited {
		color: blue;
	}
	#logout {
		float: right;	
		margin-top: 20px;
		margin-bottom: 10px;
	}
	#logout a {
		padding:10px 30px;
	    background:#315D81;
	    color: #FFF;
	    font-weight: bold;
	    text-decoration: none;
	    	
	    border: 0;
	    -webkit-border-radius: 5px;
	    border-radius: 5px;
	}
	</style>
</head>
<body>
<div class="ocorrencias">
	<h1>Painel de Registro de Ocorrências</h1>
	<table>
		<tr class="firstline">
			<td><a href="abertura_ocorrencia.php">Abertura de Ocorrência</a></td>
		</tr>
		<tr class="secondline">
			<td><a href="consulta_ocorrencia.php">Consulta de Ocorrências</a></td>
		</tr>
		<tr class="firstline">
			<td><a href="solucao_ocorrencia.php">Solução de Ocorrências</a></td>
		</tr>
		<!-- 
		<tr class="secondline">
			<td><a href="lista_ocorrencias.php">Lista de Ocorrências</a></td>	
		</tr>
		 -->
	</table>
	<div id="logout"><a href="index.php">Sair</a></div>
</div>
</body>
</html>
