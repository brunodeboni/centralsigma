<?php
$codigo = $_POST['codigo'];

// Conexão com mysql
require '../conexoes.inc.php';
$db = Database::instance('centralsigma02');

$sql = "select nome from dv_divulgadores_sigma where codigo = :codigo";
$query = $db->prepare($sql);
$query->execute(array(':codigo' => $codigo));

if ($query->rowCount() > 0) {
	echo 'true';
}else {
	echo 'false';
}

?>