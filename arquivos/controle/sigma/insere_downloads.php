<?php
require '../../../conexoes.inc.php';
$db_02 = Database::instance('centralsigma02');

$sql1 = "select m.cod, m.id_arquivo, date_format(m.data, '%d/%m/%Y %H:%i') as datahora, m.origem, m.pais, m.uf, m.arquivo, m.nome, 
	m.email, m.empresa, m.telefone, m.celular, c.obs, date_format(c.agenda, '%d/%m/%Y') as agenda, c.responsavel
	
	from downloads_meta as m
	left join downloads_contato as c on m.cod = c.id_download
	order by c.agenda, m.data desc limit :limite_d";

//
if (isset ($_POST['obs'])) {
	$sql = "insert into downloads_contato (id_download, obs, agenda, responsavel) 
	values (:cod, :obs, str_to_date(:agenda, '%d/%m/%Y'), :responsavel)";
	$query = $db_02->prepare($sql);
	$query->bindValue(':cod', $_POST['cod'], PDO::PARAM_INT);
	$query->bindValue(':obs', $_POST['obs'], PDO::PARAM_STR);
	$query->bindValue(':agenda', $_POST['agenda'], PDO::PARAM_STR);
	$query->bindValue(':responsavel', $_POST['responsavel'], PDO::PARAM_STR);
	$success = $query->execute();
	
	if ($success) echo 'Sucesso!';
	else echo 'Erro.';
}
?>