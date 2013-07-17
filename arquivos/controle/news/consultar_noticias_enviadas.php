<?php
session_start();
if(!isset($_SESSION['5468usuario'])) die("<strong>Acesso Negado!</strong>");

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Notícias enviadas</title>
	<style>
	body {
		font-size: 12px; 
		font-family:Verdana, sans-serif;
	}
	
	h1 {
	 	font-size:20px;
	   	padding: 5px;
	    /*background: #CC6C6C;*/
	    background: #CD5C5C;
	    color: #fff;
	    text-align: center;
	    -webkit-border-radius: 5px;
		border-radius: 5px;
	}
	
	.wrapper {
		background: #F7F7F7; 
	    padding: 5px; 
	    padding-bottom: 10px;
	    border: 1px outset #fff;
	}
	
	.btn {
		border: 0;
		padding: 5px 10px; 
		background: #B22222; 
		color: #fff; 
		font-weight:bold; 
		text-decoration: none;
		-webkit-border-radius: 5px;
		border-radius: 5px;
		-webkit-box-shadow: 1px 1px 3px #7E7E7E;
		box-shadow: 1px 1px 3px #7E7E7E;
	}
	
	table{
		margin: 10px;
		margin-bottom:5px;
		width: 98%;
		border-collapse:collapse;
		border-bottom:2px solid #6969AF;
	}
	table th, table td{
		width: 50%;
		padding: 10px;
		text-align: right;
	}
	.firstline {background-color: #FAF0E6;}
	.secondline {background-color: #FAEBD7;}
	</style>
</head>
<body>
<div class="wrapper">
	<h1>Notícias Enviadas</h1>
<?php 
require '../../../conexoes.inc.php';
$db = Database::instance('centralsigma02');

$sql = "select nome, empresa, cargo, cidade, uf, email, tempo_usuario, 
		assunto, noticia from news_enviadas";
$query = $db->query($sql);
$resultado = $query->fetchAll();
foreach ($resultado as $res) {

?>
	<table>
		<tr class="firstline">
			<td><b>Nome</b></td>
			<td><?php echo $res['nome']; ?></td>
		</tr>
		<tr class="secondline">
			<td><b>Empresa</b></td>
			<td><?php echo $res['empresa']; ?></td>
		</tr>
		<tr class="firstline">
			<td><b>Cargo</b></td>
			<td><?php echo $res['cargo']; ?></td>
		</tr>
		<tr class="secondline">
			<td><b>Cidade</b></td>
			<td><?php echo $res['cidade']; ?></td>
		</tr>
		<tr class="firstline">
			<td><b>Estado</b></td>
			<td><?php echo $res['uf']; ?></td>
		</tr>
		<tr class="secondline">
			<td><b>E-mail</b></td>
			<td><?php echo $res['email']; ?></td>
		</tr>
		<tr class="firstline">
			<td><b>Tempo de usuário SIGMA</b></td>
			<td><?php echo $res['tempo_usuario']; ?></td>
		</tr>
		<tr class="secondline">
			<td><b>Assunto</b></td>
			<td><?php echo $res['assunto']; ?></td>
		</tr>
		<tr class="firstline">
			<td><b>Notícia</b></td>
			<td><?php echo $res['noticia']; ?></td>
		</tr>
	</table>
<?php 
}
?>
</div>
</body>
</html>