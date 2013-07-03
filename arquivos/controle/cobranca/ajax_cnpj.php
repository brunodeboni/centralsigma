<?php
if (isset ($_POST['cnpj'])) {
	$cnpj = $_POST['cnpj'];
	
	//Conexão com banco de dados
	include '../../../conexoes.inc.php';
	$db = Database::instance('controle');
	
	$sql = "select id as id_cliente, razao_social, responsavel, setor, email, telefone 
			from cob_clientes where cnpj = :cnpj";
	$query = $db->prepare($sql);
	$query->execute(array(':cnpj' => $cnpj));
	
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