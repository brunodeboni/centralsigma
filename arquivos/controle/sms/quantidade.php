<?php

session_start();
if(!isset($_SESSION['5468usuario'])) die("<strong>Acesso Negado!</strong>");

?>
<!doctype> 
<html>
<head>
    <meta charset="utf-8" />
	<title>SMS's Enviados</title>
	<style>
	.firstline {background-color: #FAF0E6;}
	.secondline {background-color: #FAEBD7;}
	</style>
</head>
<body>
<table>
	<tr class="firstline">
		<td>Data</td>
		<td>Hora</td>
		<td>Remetente</td>
		<td>Destino</td>
		<td>Mensagem</td>
	</tr>
<?php
	//Pega a data pesquisada
	if (!isset ($_GET['data'])) {
		echo "&Eacute; necess&aacute;rio definir uma data.";	
	}else {
		$data = $_GET['data']; 
	
	//Conexão com o banco de dados
	include '../../../conexoes.inc.php';
	$db = Database::instance('centralsigma02');
	
	//Pesquisa mensagem enviada
	$sql = "select DATE_FORMAT(DATE(DATA_ENVIO), '%d/%m/%Y') AS DIA, time(DATA_ENVIO) as hora, CELULAR_REMETENTE, CELULAR_DESTINO, MENSAGEM 
		from sms where DATA_ENVIO IS NOT NULL and DATE_FORMAT(DATE(DATA_ENVIO), '%d/%m/%Y') = :data order by hora desc";
	$query = $db->prepare($sql);
	$query->execute(array(':data' => $data));
	$resultado = $query->fetchAll();
	
	$rowq = true; //Classe para cores das linhas
	
	foreach ($resultado as $res) {
		$dia = $res['DIA'];
		$hora = $res['hora'];
		$remetente = $res['CELULAR_REMETENTE'];
		$destino = $res['CELULAR_DESTINO'];
		$mensagem = $res['MENSAGEM'];
		
		//Classe para cores das linhas
        if($rowq) $class = "secondline";
		else $class = "firstline";
		$rowq = !$rowq;
		
		echo "<tr class=\"$class\">";
		echo "<td>".$dia."</td>";
		echo "<td>".$hora."</td>";
		if ($remetente == true) { //Há muitos campos nulos
			echo "<td>".$remetente."</td>";
		} else {
			$remetente = "N&atilde;o h&aacute;";
			echo "<td>".$remetente."</td>";
			}
		echo "<td>".$destino."</td>";
		echo "<td>".$mensagem."</td>";
		echo "</tr>";
	}
}
?>
</table>
</body>