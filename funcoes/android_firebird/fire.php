<?php
$conexao = ibase_connect("187.0.218.34:D:\ARQUIVOS\SUP_DESENV\BANCO_SSWEB\DEMO_2010.FDB","SYSDBA","masterkey");

$query = file_get_contents("php://input");

$resultado = ibase_query($conexao, $query);

$rows = array();

while ($row = ibase_fetch_assoc($resultado)) {
	$rows[] = $row;
}

ibase_free_result($resultado);
ibase_close($conexao);

if(count($rows) > 0)
	echo json_encode($rows);

exit();
?>