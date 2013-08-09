<?php
//Verificar se perfil está cadastrado
$perfil = $_POST['perfil'];
$id_user = substr($perfil, -4);

require '../../conexoes.inc.php';
$db = Database::instance('centralsigma02');

$sql = "select id from cw_perfil where id_user = :id_user";
$query = $db->prepare($sql);
$query->execute(array(':id_user' => $id_user));

if ($query->rowCount() > 0) echo 'true';
else echo 'false';

?>