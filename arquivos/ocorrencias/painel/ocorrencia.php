<?php
//Verifica se usuário está logado
session_start();
if(!isset($_SESSION['usuario'])) die("<strong>Acesso Negado!</strong>");

if (isset ($_GET['codigo'])) {
	$codigo = $_GET['codigo'];

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
		width:700px;
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
	#voltar {
		float: right;
		font-weight: bold;	
		margin-top: -5px;
	}
	</style>
</head>
<body>
<div class="ocorrencias">
	<div id="voltar"><a href="painel.php">Voltar</a></div>
	<h1>Painel de Registros de Ocorrência</h1>
<?php 

//Conexão com mysql
require '../../../conexoes.inc.php';
$db = Database::instance('centralsigma02');

$sql = "select codigo, date_format(dh_registro, '%d/%m/%Y %h:%m') as dh_registro, responsavel, dia_ocorrencia, hora_ocorrencia, colaboradores, assunto, ocorrencia, erro, sugestao, problemas, clientes, envolvido, ciencia_cliente from bo_ocorrencias where codigo = :codigo";
$query = $db->prepare($sql);
$query->execute(array(':codigo' => $codigo));
$resultado = $query->fetchAll();

foreach ($resultado as $res) {

	$dh_registro = $res['dh_registro'];
	$responsavel = $res['responsavel'];
	$data_ocorrencia = $res['dia_ocorrencia']." ".$res['hora_ocorrencia'];
	$colaboradores = $res['colaboradores'];
	$assunto = $res['assunto'];
	$ocorrencia = $res['ocorrencia'];
	$erro = $res['erro'];
	$sugestao = $res['sugestao'];
	$problemas = $res['problemas'];
	$clientes = $res['clientes'];
	$envolvido = $res['envolvido'];
	$ciencia_cliente = $res['ciencia_cliente'];
	
	echo '
	<table>
		<tr class="firstline">
			<td>Código da Ocorrência</td>
			<td>'.$codigo.'</td>
		</tr>
		<tr class="secondline">
			<td>Data e Hora do Registro</td>
			<td>'.$dh_registro.'</td>
		</tr>
		<tr class="firstline">
			<td>Responsável pelo Registro</td>
			<td>'.$responsavel.'</td>
		</tr>
		<tr class="secondline">
			<td>Data e Hora da Ocorrência</td>
			<td>'.$data_ocorrencia.'</td>
		</tr>
		<tr class="firstline">
			<td>Colaboradores envolvidos</td>
			<td>'.$colaboradores.'</td>
		</tr>
		<tr class="secondline">
			<td>Assunto</td>
			<td>'.$assunto.'</td>
		</tr>
		<tr class="firstline">
			<td>Descrição do ocorrido</td>
			<td>'.$ocorrencia.'</td>
		</tr>
		<tr class="secondline">
			<td>O que está errado/fora do padrão</td>
			<td>'.$erro.'</td>
		</tr>
		<tr class="firstline">
			<td>Como deveria ser</td>
			<td>'.$sugestao.'</td>
		</tr>
		<tr class="secondline">
			<td>Quais problemas este erro gerou</td>
			<td>'.$problemas.'</td>
		</tr>
		<tr class="firstline">
			<td>Esta ocorrência está relacionada a algum cliente?</td>
			<td>'.$clientes.'</td>
		</tr>
		<tr class="secondline">
			<td>Qual?</td>
			<td>'.$envolvido.'</td>
		</tr>
		<tr class="firstline">
			<td>Esta ocorrência chegou ao conhecimetno do cliente? Explique.</td>
			<td>'.$ciencia_cliente.'</td>
		</tr>
	</table>';
}

?>

</div>
</body>
</html>
<?php }else echo '&Eacute; necess&aacute;rio especificar um c&oacute;digo de ocorr&ecirc;ncia!'; ?>