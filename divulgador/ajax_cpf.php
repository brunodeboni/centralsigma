<?php
//Verifica se já possui CPF cadastrado
$cpf = $_POST['cpf'];

//Conexão mysql
require '../conexoes.inc.php';
$db = Database::instance('centralsigma02');

$sql = "select codigo from dv_divulgadores_sigma where cpf = :cpf";
$query = $db->prepare($sql);
$query->execute(array(':cpf' => $cpf));

if ($query->rowCount() > 0) {
	echo 'false'; //erro: cpf já cadastrado
}else {
	echo 'true'; //pode cadastrar
}

?>