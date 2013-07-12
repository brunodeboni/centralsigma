<?php
$cnpj = $_POST['cnpj'];

$conexao = ibase_connect("187.0.218.34:atualizador","SYSDBA","masterkey");
		$query = "SELECT 
		CLIENTE_CNPJ.IDCLIENTE, 
		CLIENTE_CNPJ.CNPJ, 
		CLIENTE_CNPJ.POSSUI_CONTRATO, 
		CLIENTE_CNPJ.BLOQUEAR_SMS, 
		CREDITO_SMS.CSMS_CREDITO, 
		CREDITO_SMS.CLIENTECNPJ_ID,
		CREDITO_SMS.CSMS_PRIMEIRA 
		FROM 
		CLIENTE_CNPJ  
		LEFT JOIN CREDITO_SMS ON 
		CLIENTE_CNPJ.IDCLIENTE_CNPJ = CREDITO_SMS.CLIENTECNPJ_ID 
		WHERE 
		CLIENTE_CNPJ.CNPJ = '$cnpj'";
			
		$resultado = ibase_query($conexao, $query);
		$row = ibase_fetch_assoc($resultado);
		$idclientecnpj =  $row['CLIENTECNPJ_ID'];
		$creditosms =  $row['CSMS_CREDITO'];
		$permitido = $row['BLOQUEAR_SMS'];
		echo $idclientecnpj; 
		echo $creditosms; 
		echo $permitido; 
?>