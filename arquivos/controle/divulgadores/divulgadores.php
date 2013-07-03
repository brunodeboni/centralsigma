<?php

session_start();
if(!isset($_SESSION['5468usuario'])) die("<strong>Acesso Negado!</strong>");

?>
<!doctype html> 
<html>
<head>
    <meta charset="utf-8" />
	<title>Divulgadores SIGMA</title>
	<style>
	body{font-size:14px; font-family: Arial, Helvetica, sans-serif;}
	.firstline {background-color: #FAF0E6; width: 250px;}
	.secondline {background-color: #FAEBD7; width: 250px;}
	.mostrar {font-weight:bold;}
	.divulgadores{
		margin:10px auto;
		padding:5px;
		width:650px;
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
	<div class="divulgadores">
	<h1>Divulgadores SIGMA</h1>
	<h2>Clique no código para cadastrar as negociações</h2>
	<h2>Clique no nome para visualizar as negociações</h2>
	<table>
		<tr class="firstline">
			<td>Código</td>
			<td>Nome</td>
			<td>Cidade</td>
			<td>UF</td>
			<td>Data Cadastro</td>
			<td></td>
		</tr>
<?php
	// Conexão com mysql
	include '../../../conexoes.inc.php';
	$db = Database::instance('centralsigma02');
	
	//Pesquisa a quantidade de SMS's enviados por dia
	$sql = "select codigo, nome, cidade, uf, date_format(dh_cadastro, '%d/%m/%Y %H:%i') as dh_cadastro from dv_divulgadores_sigma order by codigo desc";
	$query = $db->prepare($sql);
	$query->execute();
	$resultado = $query->fetchAll();
	
	$rowq = true; //Classe para cores das linhas
	
	foreach ($resultado as $res) {
		//Classe para cores das linhas
        if($rowq) $class = "secondline";
		else $class = "firstline";
		$rowq = !$rowq;
		
		$codigo = $res['codigo'];
		$nome = $res['nome'];
		
		//Tabela exibe quantidade de SMS's enviados por dia
		echo "<tr class=\"$class\">";
		echo "<td><a href=\"cadastra.php?codigo=".$codigo."\">".$codigo."</a></td>";
		echo "<td><a href=\"visualiza.php?codigo=".$codigo."\">".$nome."</a></td>";
		echo "<td>".$res['cidade']."</td>";
		echo "<td>".$res['uf']."</td>";
		echo "<td>".$res['dh_cadastro']."</td>";
		echo "<td><a href=\"completo.php?codigo=".$codigo."\">Ver cadastro completo</a></td>";
		echo "</tr>";
	}
		

?>
	</table>
	</div>
</center>
</body>