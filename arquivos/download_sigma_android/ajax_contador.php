<?php

require '../../conexoes.inc.php';
$db = Database::instance('mobile_provider');

$sql = "select count(id) as total from clientes_aplicativos where aplicativo = 'sigmaandroid'";
$query = $db->query($sql);
$resultado = $query->fetchAll();

foreach ($resultado as $res) {
	echo $res['total'];
}


?>
