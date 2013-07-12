<?
	
	ini_set('display_errors',1);
	ini_set('errors_report',E_ALL);

	$qtdeenviada = $_REQUEST['qtdeenviada'];
	$cnpj = $_REQUEST['cnpj'];
	$nomedest = $_REQUEST['nomedest'];
	$nomecli = $_REQUEST['nomecli'];
	$mensagem = $_REQUEST['mensagem'];
	$tamanho = strlen($mensagem);
	$telefone = $_REQUEST['telefone'];
	$datacorrente = date('Y/m/d h:i:s');
	$tipofuncao = $_REQUEST['funcao'];
	$valorpago = $_REQUEST['valorpago'];
	$formapagto = $_REQUEST['formapagto'];
	$datapagto = $_REQUEST['datapagto'];
	$trancodigo = $_REQUEST['trancodigo'];
	$trantipo = $_REQUEST['trantipo'];
	$trandthoralib = $_REQUEST['trandthoralib'];
	$tranvalunit = $_REQUEST['tranvalunit'];
	$tranqtdesms = $_REQUEST['tranqtdesms'];
	$tranqtde = $_REQUEST['tranqtde'];
	$tranpacote = $_REQUEST['tranpacote'];
	$nomeaplic = $_REQUEST['nomeaplic'];
	$referencia = $_REQUEST['referencia'];

	if($tipofuncao == 'registrasms')
	{
		$con = mysql_connect("mysql.centralsigma.com.br","centralsigma02","a2q3pdt140212");
		mysql_select_db("centralsigma02");
		
		$qr1 = 'SELECT codigo FROM vsms_usuario WHERE login LIKE "'.$nomecli.'"';
		$res1 = mysql_query($qr1);
		$cod4 = mysql_fetch_assoc($res1);
		$codigo4 = $cod4["codigo"];
			
		if (mysql_num_rows($res1) == 1) 
		{		
			$id = $cnpj."_".date('d/m/Y_h:i:s');               
	        $qr2 = 'INSERT INTO virtual_sequencia (id) VALUES ("'.$id.'")';
			mysql_query($qr2);
			
			$qr3 = ' SELECT * FROM virtual_sequencia where id = "'.$id.'"';
			$res2 = mysql_query($qr3);
			$cod = mysql_fetch_assoc($res2);
			$codigo = $cod["codigo"];
			
			$qr4 = 'INSERT INTO vsms_documento (usuario, pasta, dh_entrada, assunto, status, preso, programado,
	                visualizado, origem, prioridade_usuario, prioridade_fila, cod_status, remetente, alerta, tamanho,
					destino_celular, mensagem,codigo) 
					VALUES('.$codigo4.', 
						   "-2", 
						   "'.$datacorrente.'",
						   "SEM TITULO", 
						   "AGUARDANDO ENVIO", 
						   "F", 
						   "F", 
						   "F", 
						   "S", 
						   "3", 
						   "2", 
						   "P", 
						   "'.$codigo4.'", 
						   "F", 					    
						   "'.$tamanho.'",
	  				       "'.$telefone.'", 
						   "'.$mensagem.'", 
						   '.$codigo.')';
			mysql_query($qr4);
			echo "000";
		}
		else
			{
			    $id = $cnpj."_".date('d/m/Y_h:i:s');
				$qr5 = 'INSERT INTO virtual_sequencia (id) VALUES ("'.$id.'")';
				mysql_query($qr5);
			
				$qr6 = ' SELECT * FROM virtual_sequencia where id = "'.$id.'"';
				$res3 = mysql_query($qr6);
				$cod5 = mysql_fetch_assoc($res3);
				$codigo5 = $cod5["codigo"];
			
				$qr7 = 'INSERT INTO vsms_usuario(login,nome,senha,sexo,adm_mestre,codigo) 
				VALUES ("'.$nomecli.'","'.$nomecli.'","'.$nomecli.'","0","F","'.$codigo5.'")';
				mysql_query($qr7);
			
				$qr8 = 'SELECT * FROM vsms_usuario WHERE LOGIN LIKE "'.$nomecli.'"';
				$res3 = mysql_query($qr8);
				$cod1 = mysql_fetch_assoc($res3);
				$codigo1 = $cod1["codigo"];
	
	            $id = $cnpj."_".date('d/m/Y_h:i:s');
	            $qr9 = 'INSERT INTO virtual_sequencia (id) VALUES ("'.$id.'")';
				mysql_query($qr9);
				
				$qr10 = 'SELECT * FROM virtual_sequencia where id = "'.$id.'"';
				$res4 = mysql_query($qr10);
				$cod2 = mysql_fetch_assoc($res4);
				$codigo2 = $cod2["codigo"];
	
				$qr11 = 'INSERT INTO vsms_documento (usuario, pasta, dh_entrada, assunto, status, preso, programado,
	                visualizado, origem, prioridade_usuario, prioridade_fila, cod_status,remetente,alerta,tamanho,
					destino_celular,mensagem,codigo) 
					VALUES('.$codigo1.', 
						   "-2", 
						   "'.$datacorrente.'",
						   "SEM TITULO", 
						   "AGUARDANDO ENVIO", 
						   "F", 
						   "F", 
						   "F", 
						   "S", 
						   "3", 
						   "2", 
						   "P", 
						   '.$codigo1.', 
						   "F", 					    
						   "'.$tamanho.'",
	  				       "'.$telefone.'", 
						   "'.$mensagem.'", 
						   '.$codigo2.')';
				mysql_query($qr11);
				
				echo "000";
			}
	
		mysql_close($con);
	}
	
	if($tipofuncao == 'retornacredito')
	{
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
		
		if($permitido != 'S')
		{
			if($qtdeenviada <> '0')
			{
				$novovalor = $creditosms - $qtdeenviada;
				$query2 = "UPDATE CREDITO_SMS
					SET CREDITO_SMS.CSMS_CREDITO = '$novovalor' 
					WHERE CREDITO_SMS.CLIENTECNPJ_ID = '$idclientecnpj'";
					
				$resultado2 = ibase_query($conexao, $query2);
					
				$resultado3 = ibase_query($conexao, $query);
				$row3 = ibase_fetch_assoc($resultado3);
				echo $row['CSMS_CREDITO'];
			}
			else
				{
					echo $creditosms;	
				}
		}
		else
			{
				echo "Saldo de ".$creditosms."SMS(s) Bloqueado(s).";
			}
		ibase_close();
	}
	
	if($tipofuncao == 'retornavalidade')
	{
		$conexao = ibase_connect("187.0.218.34:atualizador","SYSDBA","masterkey");
		
		$query = " SELECT 
			CLIENTE_CNPJ.IDCLIENTE, 
			CLIENTE_CNPJ.CNPJ, 
			CLIENTE_CNPJ.POSSUI_CONTRATO, 
			CREDITO_SMS.CSMS_DTHR_TERMINO, 
			CREDITO_SMS.CLIENTECNPJ_ID 
			FROM 
			CLIENTE_CNPJ 
			LEFT JOIN CREDITO_SMS ON 
			CLIENTE_CNPJ.IDCLIENTE_CNPJ = CREDITO_SMS.CLIENTECNPJ_ID 
			WHERE 
			CLIENTE_CNPJ.CNPJ = '$cnpj'";
		$resultado = ibase_query($conexao, $query);
		$row = ibase_fetch_assoc($resultado);
		$idclientecnpj =  $row['CLIENTECNPJ_ID'];
		$dthoratermino =  strtotime($row['CSMS_DTHR_TERMINO']);
		$dthoracorrente = strtotime(date('Y/m/d h:i:s'));
		
		if($dthoracorrente > $dthoratermino)
		{
			$query2 = "UPDATE CREDITO_SMS
				SET CREDITO_SMS.CSMS_CREDITO = '0' 
				WHERE CREDITO_SMS.CLIENTECNPJ_ID = '$idclientecnpj'";
				
			$resultado2 = ibase_query($conexao, $query2);
				
			$resultado3 = ibase_query($conexao, $query);
			$row3 = ibase_fetch_assoc($resultado3);
			echo "0";
		}
		else
			{
				echo $row['CSMS_DTHR_TERMINO'];
			}
		ibase_close();
	}
	
	if($tipofuncao == 'retornabloqueado')
	{
		$conexao = ibase_connect("187.0.218.34:atualizador","SYSDBA","masterkey");
		
		$query = " SELECT COUNT(BLOQ_NUMERO) AS TOTAL FROM BLOQUEADO WHERE BLOQ_NUMERO = '$telefone'";
		$resultado = ibase_query($conexao, $query);
		$row = ibase_fetch_assoc($resultado);
		$total =  $row['TOTAL'];
		echo $total;
		ibase_close();
	}
	
	if($tipofuncao == 'retornareferencia')
	{
		$conexao = ibase_connect("187.0.218.34:atualizador","SYSDBA","masterkey");
		
		$query = " SELECT GEN_ID(GEN_PAGSEGURO,1) AS CODIGO FROM PARAMETRO_LOCAL";
		$resultado = ibase_query($conexao, $query);
		$row = ibase_fetch_assoc($resultado);
		$codreferencia =  $row['CODIGO'];
		
		$query2 = " SELECT IDCLIENTE_CNPJ FROM CLIENTE_CNPJ WHERE CNPJ = '$cnpj'";
		$resultado2 = ibase_query($conexao, $query2);
		$row2 = ibase_fetch_assoc($resultado2);
		$codcliente =  $row2['IDCLIENTE_CNPJ'];
		
		$statuspadrao = 'ABERTO';
		$query3 = " INSERT INTO TRANSACAO
		(IDCLIENTE,TRAN_REFERENCIA, 
		TRAN_STATUS,TRAN_CPFCNPJ) 
		VALUES ('$codcliente','$codreferencia',
		'$statuspadrao','$cnpj')";
		$resultado3 = ibase_query($conexao, $query3);
		
		echo $codreferencia;
		ibase_close();
	}
	
	if($tipofuncao == 'retornacodcadastro')
	{
		$conexao = ibase_connect("187.0.218.34:atualizador","SYSDBA","masterkey");
		$query = " SELECT GEN_ID(GEN_CADASTROINICIAL,1) AS CODIGO FROM PARAMETRO_LOCAL ";
		$resultado = ibase_query($conexao, $query);
		$row = ibase_fetch_assoc($resultado);
		$codinicial =  $row['CODIGO'];
		
		echo $codinicial;
		ibase_close();
	}
	
	if($tipofuncao == 'liberacredito')
	{
		$conexao = ibase_connect("187.0.218.34:atualizador","SYSDBA","masterkey");
		
		$query = " SELECT 
			TRAN_STATUS 
			FROM 
			TRANSACAO 
			WHERE TRAN_REFERENCIA = '$referencia'";
		$resultado = ibase_query($conexao, $query);
		$row = ibase_fetch_assoc($resultado);
		$status =  $row['TRAN_STATUS'];
		
		if($status != 'PAGA')
		{
			$query2 = " UPDATE TRANSACAO SET 
			TRAN_QTDE = '$tranqtde',
			TRAN_STATUS = 'PAGA',
			TRAN_VALOR = '$valorpago',
			TRAN_FORMAPAGTO = '$formapagto',
			TRAN_DATAPAGTO = '$datapagto',
			TRAN_CODIGO = '$trancodigo',
			TRAN_TIPO = '$trantipo',
			TRAN_DATAHORA_LIBERA = '$trandthoralib',
			TRAN_VALUNIT_FLLECHA = '$tranvalunit',
			TRAN_CPFCNPJ = '$cnpj',
			TRAN_QTDE_FLLECHA = '$tranqtdesms',
			TRAN_PACOTE = '$tranpacote' 
			WHERE TRAN_REFERENCIA = '$referencia'";
			$resultado2 = ibase_query($conexao, $query2);
			
			$query3 = " SELECT IDCLIENTE_CNPJ FROM CLIENTE_CNPJ WHERE CNPJ = '$cnpj'";
			$resultado3 = ibase_query($conexao, $query3);
			$row3 = ibase_fetch_assoc($resultado3);
			$codcliente =  $row3['IDCLIENTE_CNPJ'];
			
			$query4 = " SELECT COUNT(IDCLIENTE_CNPJ) AS CODIGO FROM CLIENTE_CNPJ WHERE IDCLIENTE_CNPJ = '$codcliente'";
			$resultado4 = ibase_query($conexao, $query4);
			$row4 = ibase_fetch_assoc($resultado4);
			$total =  $row4['CODIGO'];
			
			if($total > '0')
			{
				$query6 = " SELECT CREDITO_SMS.CSMS_CREDITO FROM CREDITO_SMS WHERE CREDITO_SMS.CLIENTECNPJ_ID = '$codcliente'";
			    $resultado6 = ibase_query($conexao, $query6);
			    $row6 = ibase_fetch_assoc($resultado6);
			    $credito =  $row6['CSMS_CREDITO'];
				
				$novovalor = $credito + $tranqtdesms;
				$query5 = "UPDATE CREDITO_SMS
					SET CREDITO_SMS.CSMS_CREDITO = '$novovalor' WHERE CREDITO_SMS.CLIENTECNPJ_ID = '$codcliente'";
				$resultado5 = ibase_query($conexao, $query5);
				echo $novovalor;
			}
			else
				{
					$query5 = "INSERT INTO CREDITO_SMS 
					(CLIENTECNPJ_ID, CSMS_CREDITO) VALUES 
					('$codcliente','$tranqtdesms')";
				    $resultado5 = ibase_query($conexao, $query5);
					echo $tranqtdesms;
				}
		}
		ibase_close();
	}
	
	if($tipofuncao == 'inserecredito')
	{
		$conexao = ibase_connect("187.0.218.34:atualizador","SYSDBA","masterkey");
		
		$query = " SELECT COUNT(IDCLIENTE_CNPJ) AS TOTAL 
			FROM 
			CLIENTE_CNPJ 
			WHERE CNPJ = '$cnpj'";
		$resultado = ibase_query($conexao, $query);
		$row = ibase_fetch_assoc($resultado);
		$total =  $row['TOTAL'];
		
		if($total == '0')
		{
			$query5 = "INSERT INTO CLIENTE (CLIENTE) VALUES ('$nomecli')";
			$resultado5 = ibase_query($conexao, $query5);
			
			$query4 = " SELECT IDCLIENTE FROM CLIENTE WHERE CLIENTE LIKE '$nomecli'";
			$resultado4 = ibase_query($conexao, $query4);
			$row4 = ibase_fetch_assoc($resultado4);
			$codcliente =  $row4['IDCLIENTE'];
			
			$query6 = "INSERT INTO CLIENTE_CNPJ (IDCLIENTE,CNPJ,POSSUI_CONTRATO) VALUES ('$codcliente','$cnpj','F')";
			$resultado6 = ibase_query($conexao, $query6);
			
			$query7 = " SELECT IDCLIENTE_CNPJ FROM CLIENTE_CNPJ WHERE IDCLIENTE = '$codcliente'";
			$resultado7 = ibase_query($conexao, $query7);
			$row7 = ibase_fetch_assoc($resultado7);
			$codclientecnpj =  $row7['IDCLIENTE_CNPJ'];
			
			$query8 = "INSERT INTO CREDITO_SMS (CLIENTECNPJ_ID,CSMS_CREDITO) VALUES ('$codclientecnpj','10')";
			$resultado8 = ibase_query($conexao, $query8);
			
			$query9 = " SELECT IDAPLICATIVO FROM APLICATIVO WHERE APLICATIVO = '$nomeaplic'";
			$resultado9 = ibase_query($conexao, $query9);
			$row9 = ibase_fetch_assoc($resultado9);
			$codaplicativo =  $row9['IDAPLICATIVO'];
			
			$query10 = "INSERT INTO APLICATIVO_CNPJ (IDCLIENTE_CNPJ,IDAPLICATIVO,PERMITIDO) VALUES ('$codclientecnpj','$codaplicativo','T')";
			$resultado10 = ibase_query($conexao, $query10);
			
			echo "000";
		}
		ibase_close();		
	}
	
?>