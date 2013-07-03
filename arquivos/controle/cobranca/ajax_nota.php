<?php
if (isset ($_POST['nro_nota'])) {
	$nro_nota = $_POST['nro_nota'];
	
	//Conexão com banco de dados
	include '../../../conexoes.inc.php';
	$db = Database::instance('controle');
	
	$sql = "select n.id as id_nota, n.valor, n.vencimento
			from cob_nota_fiscal as n
			where nro_nota = :nro_nota";
	$query = $db->prepare($sql);
	$query->execute(array(':nro_nota' => $nro_nota));
	
	if ($query->rowCount() > 0) {
		//Envia array de resultados como JSON
		foreach ($query->fetch(PDO::FETCH_ASSOC) as $key => $res) {
			$r[$key] = $res; 
		}
		echo json_encode($r);
	}else {
		echo 'false';
	}
}
?>
