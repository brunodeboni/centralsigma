<?php
require '../../../conexoes.inc.php';
$db_02 = Database::instance('centralsigma02');

$sql = "select id from downloads_contato where id_download = :id";
$query = $db_02->prepare($sql);
$query->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
$query->execute();

if ($_POST['classe'] == 'obs') {
	
	if ($query->rowCount() > 0) {
		$sql1 = "update downloads_contato set obs = :obs where id_download = :id";
		$query1 = $db_02->prepare($sql1);
		$query1->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
		$query1->bindValue(':obs', $_POST['valor'], PDO::PARAM_STR);
		$success = $query1->execute();
		
		if ($success) echo 'sucesso';
		else echo 'erro';			
	}else {
	
		$sql1 = "insert into downloads_contato (id_download, obs) values (:id, :obs)";
		$query1 = $db_02->prepare($sql1);
		$query1->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
		$query1->bindValue(':obs', $_POST['valor'], PDO::PARAM_STR);
		$success = $query1->execute();
		
		if ($success) echo 'sucesso';
		else echo 'erro';
	}
	
}else if ($_POST['classe'] == 'agenda') {
	
	if ($query->rowCount() > 0) {
		$sql1 = "update downloads_contato set agenda = str_to_date(:agenda, '%d/%m/%Y') where id_download = :id";
		$query1 = $db_02->prepare($sql1);
		$query1->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
		$query1->bindValue(':agenda', $_POST['valor'], PDO::PARAM_STR);
		$success = $query1->execute();
		
		if ($success) echo 'sucesso';
		else echo 'erro';			
	}else {
	
		$sql1 = "insert into downloads_contato (id_download, agenda) values (:id, str_to_date(:agenda, '%d/%m/%Y'))";
		$query1 = $db_02->prepare($sql1);
		$query1->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
		$query1->bindValue(':agenda', $_POST['valor'], PDO::PARAM_STR);
		$success = $query1->execute();
		
		if ($success) echo 'sucesso';
		else echo 'erro';
	}
	
}else if ($_POST['classe'] == 'responsavel') {
	
	if ($query->rowCount() > 0) {
		$sql1 = "update downloads_contato set responsavel = :responsavel where id_download = :id";
		$query1 = $db_02->prepare($sql1);
		$query1->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
		$query1->bindValue(':responsavel', $_POST['valor'], PDO::PARAM_STR);
		$success = $query1->execute();
		
		if ($success) echo 'sucesso';
		else echo 'erro';			
	}else {
	
		$sql1 = "insert into downloads_contato (id_download, responsavel) values (:id, :responsavel)";
		$query1 = $db_02->prepare($sql1);
		$query1->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
		$query1->bindValue(':responsavel', $_POST['valor'], PDO::PARAM_STR);
		$success = $query1->execute();
		
		if ($success) echo 'sucesso';
		else echo 'erro';
	}
	
}

?>