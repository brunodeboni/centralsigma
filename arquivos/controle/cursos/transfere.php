<?php
	if (!isset ($_POST['turma'])) {
		die ('Informe a ID da turma.');
	}
	if (!isset ($_POST['cb_inscrito'])) {
		die ('Marque os inscritos a serem transferidos.');
	}
//Pega o id da turma onde ser� transferido
	if (isset ($_POST['turma']) && $_POST['cb_inscrito']) {
		$id_inscrito = $_POST['cb_inscrito'];
		$id_turma = $_POST['turma'];
	}
	
	
	
	// Conexão com mysql
	include '../../../conexoes.inc.php';
	$db = Database::instance('centralsigma02');
	
	foreach ($id_inscrito as $inscrito) {
		$sql = "UPDATE cw_cursos_inscritos SET id_turma = :id_turma WHERE id = :inscrito";
		$query = $db->prepare($sql);
		$query->execute(array(':id_turma' => $id_turma, ':inscrito' => $inscrito));
	}

	header("Location: controle_turmas.php");
?>