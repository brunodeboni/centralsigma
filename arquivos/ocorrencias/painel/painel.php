<?php
//Verifica se usuário está logado
session_start();
if(!isset($_SESSION['usuario'])) die("<strong>Acesso Negado!</strong>");

?>
<!doctype> 
<html>
<head>
    <meta charset="utf-8" />
	<title>Painel de Indicações SIGMA</title>
	<style>
	body{font-size:14px; font-family: Arial, Helvetica, sans-serif;}
	.firstline {background-color: #0277BE; width: 250px;}
	.secondline {background-color: #A6D0E7; width: 250px;}
	.mostrar {font-weight:bold;}
	.ocorrencias{
		margin:10px auto;
		padding:5px;
		width:300px;
		background: #EEEEEE;
	}
	h1{
		margin-bottom:5px;
		text-align:center;
		padding:5px;
		font-size:16px;
		background: #315D81;
		color:#FFF;
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
	}
	table th, table td{
		padding:10px;
		text-align:right;
		font-weight: bold;
	}
	#logout {
		float: right;
		font-weight: bold;	
		margin-top: -5px;
	}
	</style>
</head>
<body>
<div class="ocorrencias">
	<div id="logout"><a href="index.php">Sair</a></div>
	<h1>Painel de Registros de Ocorrência</h1>
	<table>
		<tr class="firstline">
			<td>Código</td>
			<td>Data/Hora do Registro</td>
		</tr>
<?php 

//Conexão com mysql
require '../../../conexoes.inc.php';
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

</div>
</body>
</html>
