<?php
//Verifica se usuário está logado
session_start();
if(!isset($_SESSION['usuario'])) die("<strong>Acesso Negado!</strong>");

?>
<!doctype> 
<html>
<head>
    <meta charset="utf-8" />
	<title>Lista de Ocorrências</title>
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
		text-align:right;
		font-weight: bold;
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
	<h1>Lista de Ocorrências</h1>
	<table>
		<tr class="firstline">
			<td>Código</td>
			<td>Data/Hora do Registro</td>
		</tr>
<?php 

//Conexão com mysql
require '../../conexoes.inc.php';
$db = Database::instance('centralsigma02');

$sql = "select codigo, date_format(dh_registro, '%d/%m/%Y %h:%m') as dh_registro from bo_ocorrencias order by codigo desc";
$query = $db->query($sql);
$resultado = $query->fetchAll();

$rowq = true; //Classe para cores das linhas
foreach ($resultado as $res) {
	//Classe para cores das linhas
    if($rowq) $class = "secondline";
	else $class = "firstline";
	$rowq = !$rowq;
		
	$codigo = $res['codigo'];
	$dh_registro = $res['dh_registro'];
	
	echo '
	<tr class="'.$class.'">
		<td><a href="ocorrencia.php?codigo='.$codigo.'">'.$codigo.'</a></td>
		<td>'.$dh_registro.'</td>
	</tr>';
}

?>
	</table>
	<div id="logout">
		<a href="painel.php">Voltar</a>
		<a href="index.php">Sair</a>
	</div>
</div>
</body>
</html>
