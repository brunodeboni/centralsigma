<?php

require '../../conexoes.inc.php';
$db = Database::instance('mobile_provider');

$sql = "select id from cadastro where usuario = :usuario";
$db->prepare($sql);
$query->execute(array(':usuario' => $_POST['usuario']));

if ($query->rowCount() > 0) echo 'true';
else echo 'false';


?>