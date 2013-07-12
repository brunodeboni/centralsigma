<?
	ini_set('display_errors',1);
	ini_set('errors_report',E_ALL);
	//CONECTA MYSQL 
	$con = mysql_connect("mysql.centralsigma.com.br","centralsigma02","a2q3pdt140212") or die("não conectou ao banco");
	mysql_select_db('centralsigma02');
	
	function cadastraCliente($id,$nome){
		if ($id<>$nome)
		try {
			$sql = "SELECT count(*) as EXISTE FROM CLIENTE WHERE CLIENTE_ID = $id";
			$rs = mysql_query($sql);
			$registro = mysql_fetch_assoc($rs);
			if ($registro[EXISTE]==0){
				$sql = "INSERT INTO CLIENTE(CLIENTE_ID,NOME) VALUES('$id','$nome')" ;
				mysql_query($sql);
			}
		} catch (Exception $e) {
			
		}
	}
	# Aqui está o segredo para resolver problemas de caracteres especiais
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');
	
	//CONECTA FIREBIRD
	$conexao = ibase_connect("187.0.218.34:atualizador","SYSDBA","masterkey");
	

	function remover($str, $enc = "UTF-8"){
		
		$acentos = array(
		'A' => '/&Agrave;|&Aacute;|&Acirc;|&Atilde;|&Auml;|&Aring;/',
		'a' => '/&agrave;|&aacute;|&acirc;|&atilde;|&auml;|&aring;/',
		'C' => '/&Ccedil;/',
		'c' => '/&ccedil;/',
		'E' => '/&Egrave;|&Eacute;|&Ecirc;|&Euml;/',
		'e' => '/&egrave;|&eacute;|&ecirc;|&euml;/',
		'I' => '/&Igrave;|&Iacute;|&Icirc;|&Iuml;/',
		'i' => '/&igrave;|&iacute;|&icirc;|&iuml;/',
		'N' => '/&Ntilde;/',
		'n' => '/&ntilde;/',
		'O' => '/&Ograve;|&Oacute;|&Ocirc;|&Otilde;|&Ouml;/',
		'o' => '/&ograve;|&oacute;|&ocirc;|&otilde;|&ouml;/',
		'U' => '/&Ugrave;|&Uacute;|&Ucirc;|&Uuml;/',
		'u' => '/&ugrave;|&uacute;|&ucirc;|&uuml;/',
		'Y' => '/&Yacute;/',
		'y' => '/&yacute;|&yuml;/',
		'a.' => '/&ordf;/',
		'o.' => '/&ordm;/');
	
	   return preg_replace($acentos,
						   array_keys($acentos),
						   htmlentities($str,ENT_NOQUOTES, $enc));
	}
	$_REQUEST['mensagem'] = remover($_REQUEST['mensagem']);
	//$tipo_prog = utf8_decode($_REQUEST['tipo_prog']);
	
	function UTF8ToEntities ($string) {
		/* note: apply htmlspecialchars if desired /before/ applying this function
		/* Only do the slow convert if there are 8-bit characters */
		/* avoid using 0xA0 (\240) in ereg ranges. RH73 does not like that */
		if (! ereg("[\200-\237]", $string) and ! ereg("[\241-\377]", $string))
			return $string;
	   
		// reject too-short sequences
		$string = preg_replace("/[\302-\375]([\001-\177])/", "&#65533;\\1", $string);
		$string = preg_replace("/[\340-\375].([\001-\177])/", "&#65533;\\1", $string);
		$string = preg_replace("/[\360-\375]..([\001-\177])/", "&#65533;\\1", $string);
		$string = preg_replace("/[\370-\375]...([\001-\177])/", "&#65533;\\1", $string);
		$string = preg_replace("/[\374-\375]....([\001-\177])/", "&#65533;\\1", $string);
	   
		// reject illegal bytes & sequences
			// 2-byte characters in ASCII range
		$string = preg_replace("/[\300-\301]./", "&#65533;", $string);
			// 4-byte illegal codepoints (RFC 3629)
		$string = preg_replace("/\364[\220-\277]../", "&#65533;", $string);
			// 4-byte illegal codepoints (RFC 3629)
		$string = preg_replace("/[\365-\367].../", "&#65533;", $string);
			// 5-byte illegal codepoints (RFC 3629)
		$string = preg_replace("/[\370-\373]..../", "&#65533;", $string);
			// 6-byte illegal codepoints (RFC 3629)
		$string = preg_replace("/[\374-\375]...../", "&#65533;", $string);
			// undefined bytes
		$string = preg_replace("/[\376-\377]/", "&#65533;", $string);
	
		// reject consecutive start-bytes
		$string = preg_replace("/[\302-\364]{2,}/", "&#65533;", $string);
	   
		// decode four byte unicode characters
		$string = preg_replace(
			"/([\360-\364])([\200-\277])([\200-\277])([\200-\277])/e",
			"'&#'.((ord('\\1')&7)<<18 | (ord('\\2')&63)<<12 |" .
			" (ord('\\3')&63)<<6 | (ord('\\4')&63)).';'",
		$string);
	   
		// decode three byte unicode characters
		$string = preg_replace("/([\340-\357])([\200-\277])([\200-\277])/e",
	"'&#'.((ord('\\1')&15)<<12 | (ord('\\2')&63)<<6 | (ord('\\3')&63)).';'",
		$string);
	   
		// decode two byte unicode characters
		$string = preg_replace("/([\300-\337])([\200-\277])/e",
		"'&#'.((ord('\\1')&31)<<6 | (ord('\\2')&63)).';'",
		$string);
	   
		// reject leftover continuation bytes
		$string = preg_replace("/[\200-\277]/", "&#65533;", $string);
	   
		return $string;
	}	
	
	if(!isset($_REQUEST['cnpj'])){$cnpj = 0;}
	if(!isset($_REQUEST['nomedest'])){$nomedest = 0;}
	if(!isset($_REQUEST['nomecli'])){$nomecli = 0;}
	if(!isset($_REQUEST['mensagem'])){$mensagem = 0;}
	$tamanho = strlen($mensagem);
	if(!isset($_REQUEST['telefone'])){$telefone = 0;}
	$datacorrente = date('Y/m/d h:i:s');
	if(!isset($_REQUEST['funcao'])){$tipofuncao = 0;}
	if(!isset($_REQUEST['valorpago'])){$valorpago = 0;}
	if(!isset($_REQUEST['formapagto'])){$formapagto = 0;}
	if(!isset($_REQUEST['datapagto'])){$datapagto = 0;}
	if(!isset($_REQUEST['trancodigo'])){$trancodigo = 0;}
	if(!isset($_REQUEST['trantipo'])){$trantipo = 0;}
	if(!isset($_REQUEST['trandthoralib'])){$trandthoralib = 0;}
	if(!isset($_REQUEST['tranvalunit'])){$tranvalunit = 0;}
	if(!isset($_REQUEST['tranqtdesms'])){$tranqtdesms = 0;}
	if(!isset($_REQUEST['tranqtde'])){$tranqtde = 0;}
	if(!isset($_REQUEST['tranpacote'])){$tranpacote = 0;}
	if(!isset($_REQUEST['nomeaplic'])){$nomeaplic = 0;}
	if(!isset($_REQUEST['referencia'])){$referencia = 0;}
	if(!isset($_REQUEST['codigo_prog'])){$codigo_prog = 0;}
	if(!isset($_REQUEST['codigo_grupo'])){$codigo_grupo = 0;}
	if(!isset($_REQUEST['codigo_contato'])){$codigo_contato = 0;}
	if(!isset($_REQUEST['programado'])){$programado = 0;}
	if(!isset($_REQUEST['dh_programado'])){$dh_programado = 0;}
	if(!isset($_REQUEST['tipo_prog'])){$tipo_prog = 0;}
	if(!isset($_REQUEST['codigo_remetente'])){$tipo_prog = 0;}
	
	$dh_programado = $_REQUEST['dh_programado'];
	$tipo_prog = ($_REQUEST['tipo_prog']);//Diu00e1ria
	$mensagem = $_REQUEST['mensagem'];
	$codigo_prog = $_REQUEST['codigo_prog'];
	$codigo_cliente = $_REQUEST['cnpj'];
	
	if($_REQUEST['funcao'] == 'updateprogramacao')
	{
		
		//$mensagem = str_replace("fllecha.com.br","",$mensagem);
		if($_REQUEST['status'] == '')
		{
			$sql = "update vsms_documento set dh_programado = '$dh_programado', mensagem='$mensagem', tipo_prog='$tipo_prog' where codigo_prog = '$codigo_prog' and codigo_cliente = '$codigo_cliente'";
			$sql = "update SMS SET DATA_AGENDADO = '$dh_programado', mensagem='$mensagem',tipo_prog='$tipo_prog' where codigo_prog = '$codigo_prog' and codigo_cliente = '$codigo_cliente' AND (CAST(coalesce(DATA_ENVIO,CURRENT_DATE) AS DATE)< CAST('$dh_programado' AS DATE)) ";
		}
		else
			{
				//hora da codigo_prog int é chave primaria firebird
				//código cliente
				// tipo programação char(20) diária, semanal, mensal
				// código_contato 
				$sql = "update vsms_documento set status = 'AGUARDANDO ENVIO', cod_status = 'P', dh_programado = '$dh_programado', mensagem='$mensagem', tipo_prog='$tipo_prog' where codigo_prog = '$codigo_prog' and codigo_cliente = '$codigo_cliente'";	
				$sql = "update SMS SET status=1,DATA_AGENDADO = '$dh_programado', mensagem='$mensagem',tipo_prog='$tipo_prog' where codigo_prog = '$codigo_prog' and codigo_cliente = '$codigo_cliente' AND (CAST(coalesce(DATA_ENVIO,CURRENT_DATE) AS DATE)< CAST('$dh_programado' AS DATE)) ";
			}
		mysql_query($sql, $con); 
		echo mysql_error();
	}
	
	if($_REQUEST['funcao'] == 'registrahistoricodc')
	{
		$cnpj = $_REQUEST['cnpj'];
		
		$query7 = " SELECT IDCLIENTE_CNPJ, IDCLIENTE FROM CLIENTE_CNPJ WHERE CNPJ = '$cnpj'";
		$resultado7 = ibase_query($conexao, $query7);
		$row7 = ibase_fetch_assoc($resultado7);
		$codclientecnpj =  $row7['IDCLIENTE_CNPJ'];
		$codcliente =  $row7['IDCLIENTE'];
		
		
		$qr3 = " SELECT 
			codigo, 
			dh_envio, 
			mensagem, 
			destino_celular, 
			codigo_cliente 
			FROM vsms_documento where codigo_cliente = '$cnpj'
			and status = 'SUCESSO'";
		$qr3 = " SELECT 
			codigo, 
			DATA_ENVIO AS dh_envio, 
			mensagem, 
			CELULAR_DESTINO AS destino_celular, 
			codigo_cliente 
			FROM SMS where codigo_cliente = '$cnpj'
			and status = '4'";			
		$res2 = mysql_query($qr3);
		//O QUE É

		while ($row = mysql_fetch_assoc($res2)) { 			
			
			$destcel = $row['destino_celular'];
			$dh_envio = $row['dh_envio'];
			$mensagem = $row['mensagem'];
			$codigo_cliente = $row['codigo_cliente'];
			$codigo = $row['codigo'];
			
			$qr4 = " SELECT COUNT(HISTC_ID) AS TOTAL 
				FROM
				HISTORICO_CLIENTE 
				WHERE HISTC_CODIGOMYSQL = '$codigo'";
			$resultado = ibase_query($conexao, $qr4);
			$row2 = ibase_fetch_assoc($resultado);
			$total =  $row2['TOTAL'];
			
			if($total == '0')
			{
				$query5 = "INSERT INTO HISTORICO_CLIENTE 
					(HISTC_TELEFONE, HISTC_DTHORA, HISTC_MENSAGEM, HISTC_DESTINATARIO,HISTC_REMETENTE, HISTC_CODIGOMYSQL, IDCLIENTE_CNPJ,IDCLIENTE) VALUES 
					('$destcel','$dh_envio','$mensagem','$destcel','$codigo_cliente','$codigo','$codclientecnpj','$codcliente')";
				    $resultado5 = ibase_query($conexao, $query5);
			}
		}
	}

	if($_REQUEST['funcao'] == 'registrasms')
	{
		$qtdeenviada = 1;
		
		//PESQUISO OS DADOS DO CLIENTE NO BANCO DO DC PARA VALIDAR O REGISTRO DO SMS
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
		$bloqueado = $row['BLOQUEAR_SMS'];
		cadastraCliente($_REQUEST['cnpj'],$_REQUEST['nomecli']);
		
		//SE NAO ESTIVER BLOQUEADO E POSSUIR CREDITO A INSERCAO DA MENSAGEM SERÁ REALZIADA
		if($bloqueado != 'S' && $creditosms > '0')
		{
		  
		  $nomecli = $_REQUEST['nomecli'];
		  $mensagem = $_REQUEST['mensagem'];
		  $tamanho = strlen($mensagem);
		  $cnpj = $_REQUEST['cnpj'];
		  $telefone = $_REQUEST['telefone'];
		  
		  $qr1 = 'SELECT codigo FROM vsms_usuario WHERE login LIKE "'.$nomecli.'"';
		  $res1 = mysql_query($qr1);
		  $cod4 = mysql_fetch_assoc($res1);
		  $codigo4 = $cod4["codigo"];
		  $codigo_cliente = $_REQUEST['cnpj'];
			  
		  if (mysql_num_rows($res1) == 1) 
		  {	
		      	
			  $id = $cnpj."_".date('d/m/Y_h:i:s');               
			  $qr2 = 'INSERT INTO virtual_sequencia (id) VALUES ("'.$id.'")';
			  mysql_query($qr2);
			  
			  $qr3 = ' SELECT * FROM virtual_sequencia where id = "'.$id.'"';
			  $res2 = mysql_query($qr3);
			  $cod = mysql_fetch_assoc($res2);
			  $codigo = $cod["codigo"];
			  
			  $qr4 = 'INSERT INTO vsms_documento (
			  			usuario
						, pasta
						, dh_entrada
						, assunto
						, status
						, preso
						, programado
						, visualizado
						, origem
						, prioridade_usuario
						, prioridade_fila
						, cod_status
						, remetente
						, alerta
						, tamanho
						, destino_celular
						, mensagem,codigo
						,codigo_cliente
						) 
					  VALUES
					  ('.$codigo4.', 
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
							 '.$codigo.',
							 '.$codigo_cliente.')';
			  
			  //NOVO SMS INSERE AGUARDANDO ENVIO
			  $qr4 = "insert into SMS(
							  DATA_CADASTRO,
							  CELULAR_DESTINO,
							  MENSAGEM,
							  STATUS,
							  CODIGO_CLIENTE,
							  USUARIO,
							  CELULAR_REMETENTE
							  )
							  VALUES (
							  '$datacorrente'
							  ,'$telefone' 
							  ,'$mensagem' 
							  ,'1'
							  ,'$codigo_cliente'
							  ,'$codigo4'
							  ,'$_REQUEST[celular_remetente]'
							  )";
						
			  mysql_query($qr4);
			  $erro = mysql_error($con);
			  
					
			  //SE NAO RETORNOU NENHUM ERRO NA INSERCAO DO SMS, O CREDITO DO CLIENTE É DEBITADO
			  if($erro == '')
			  {				  
				  $novovalor = $creditosms - $qtdeenviada;
				  $query2 = "UPDATE CREDITO_SMS
					  SET CREDITO_SMS.CSMS_CREDITO = '$novovalor' 
					  WHERE CREDITO_SMS.CLIENTECNPJ_ID = '$idclientecnpj'";
					  
				  $resultado2 = ibase_query($conexao, $query2);
					  
				  $resultado3 = ibase_query($conexao, $query);
				  $row3 = ibase_fetch_assoc($resultado3);								  				  
				  echo $novovalor;
			  }
			  else
				{
					//SE HOUVE ERRO NA INSERCAO DA MENSAGEM O VALOR DO CREDITO É RETORNADO SEM DEBITO
					echo $creditosms;	
				}
				
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
					  destino_celular,mensagem,codigo,codigo_cliente) 
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
							 '.$codigo2.',
							 '.$codigo_cliente.')';
				  //NOVO SMS INSERE AGUARDANDO ENVIO
				  $qr11 = "insert into SMS(
								  DATA_CADASTRO,
								  CELULAR_DESTINO,
								  MENSAGEM,
								  STATUS,
								  CODIGO_CLIENTE,
								  USUARIO
								  )
								  VALUES (
								  '$datacorrente'
								  ,'$telefone' 
								  ,'$mensagem' 
								  ,'1'
								  ,'$codigo_cliente'
								  ,'$codigo1'
								  )";
							 
				  mysql_query($qr11);				
				  $erro = mysql_error($con);
					
					//SE NAO RETORNOU NENHUM ERRO NA INSERCAO DO SMS, O CREDITO DO CLIENTE É DEBITADO
					if($erro == '')
					{				  
						$novovalor = $creditosms - $qtdeenviada;
						$query2 = "UPDATE CREDITO_SMS
							SET CREDITO_SMS.CSMS_CREDITO = '$novovalor' 
							WHERE CREDITO_SMS.CLIENTECNPJ_ID = '$idclientecnpj'";
							
						$resultado2 = ibase_query($conexao, $query2);
							
						$resultado3 = ibase_query($conexao, $query);
						$row3 = ibase_fetch_assoc($resultado3);								  				  
						echo $novovalor;
					}
					else
					  {
						  //SE HOUVE ERRO NA INSERCAO DA MENSAGEM O VALOR DO CREDITO É RETORNADO SEM DEBITO
						  echo $creditosms;	
					  }
					  
			  }
	  
		}
		else
			{
				echo "N";
			}
	}
	
	if($_REQUEST['funcao'] == 'registraprogramacao')
	{
		$qtdeenviada = 1;
		
		//PESQUISO OS DADOS DO CLIENTE NO BANCO DO DC PARA VALIDAR O REGISTRO DO SMS
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
		$bloqueado = $row['BLOQUEAR_SMS'];
		cadastraCliente($_REQUEST['cnpj'],$_REQUEST['nomecli']);
		
		//SE NAO ESTIVER BLOQUEADO E POSSUIR CREDITO A INSERCAO DA MENSAGEM SERÁ REALZIADA
		if($bloqueado != 'S' && $creditosms > '0')
		{
		  
		  $nomecli = $_REQUEST['nomecli'];
		  $mensagem = $_REQUEST['mensagem'];
		  
		  $tamanho = strlen($mensagem);
		  $cnpj = $_REQUEST['cnpj'];
		  $telefone = $_REQUEST['telefone'];
		  $codigo_cliente = $_REQUEST['cnpj'];
		  $codigo_prog = $_REQUEST['codigo_prog'];
		  $codigo_grupo = $_REQUEST['codigo_grupo'];
		  $codigo_contato = $_REQUEST['codigo_contato'];
		  $programado = $_REQUEST['programado'];
		  $tipo_prog = $_REQUEST['tipo_prog'];
		  $dh_programado = $_REQUEST['dh_programado'];
		  
		  
		  $qr1 = 'SELECT codigo FROM vsms_usuario WHERE login LIKE "'.$nomecli.'"';
		  $res1 = mysql_query($qr1);
		  $cod4 = mysql_fetch_assoc($res1);
		  $codigo4 = $cod4["codigo"];
			
		  //SE LOCALIZOU O USUARIO INSERE
		  if (mysql_num_rows($res1) >= 1) 
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
					  destino_celular, mensagem,codigo,codigo_prog, codigo_cliente,codigo_grupo,codigo_contato,
					  dh_programado,tipo_prog, status_envio) VALUES('.$codigo4.', 
							 "-2", 
							 "'.$datacorrente.'",
							 "SEM TITULO", 
							 "AGUARDANDO ENVIO", 
							 "F", 
							 "T", 
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
							 '.$codigo.',
							 '.$codigo_prog.',
							 "'.$codigo_cliente.'",
							 '.$codigo_grupo.',
							 '.$codigo_contato.',
							 "'.$dh_programado.'",
							 "'.$tipo_prog.'",
							 "N")';
							 
			  //NOVO SMS INSERE AGUARDANDO ENVIO
			  $qr4 = "insert into SMS(
							  DATA_CADASTRO,
							  CELULAR_DESTINO,
							  MENSAGEM,
							  STATUS,
							  CODIGO_CLIENTE,
							  USUARIO,
							  DATA_AGENDADO,
							  TIPO_PROG,
							  CODIGO_PROG,
							  CODIGO_CONTATO,
							  CELULAR_REMETENTE
							  )
							  VALUES (
							  '$datacorrente'
							  ,'$telefone' 
							  ,'$mensagem' 
							  ,'1'
							  ,'$codigo_cliente'
							  ,'$codigo4'
							  ,'$dh_programado'
							  ,'$tipo_prog'
							  ,'$codigo_prog'
							  ,'$codigo_contato'
							  ,'$_REQUEST[celular_remetente]'
							  )";
							 
			  mysql_query($qr4);
			  $erro = mysql_error($con);
			  
			  //SE NAO RETORNOU NENHUM ERRO NA INSERCAO DO SMS, O CREDITO DO CLIENTE É DEBITADO
			  if($erro == '')
			  {				  
				  $novovalor = $creditosms - $qtdeenviada;
				  $query2 = "UPDATE CREDITO_SMS
					  SET CREDITO_SMS.CSMS_CREDITO = '$novovalor' 
					  WHERE CREDITO_SMS.CLIENTECNPJ_ID = '$idclientecnpj'";
					  
				  $resultado2 = ibase_query($conexao, $query2);
					  
				  $resultado3 = ibase_query($conexao, $query);
				  $row3 = ibase_fetch_assoc($resultado3);
				  echo $novovalor;
			  }
			  else
			  	{
					//SE HOUVE ERRO NA INSERCAO DA MENSAGEM O VALOR DO CREDITO É RETORNADO SEM DEBITO
					echo $creditosms;	
				}
		  }
		  //SE NAO LOCALIZOU O USUARIO, CADASTRA UM NOVO USUARIO E INSERE
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
	  
				  echo $qr11 = 'INSERT INTO vsms_documento (usuario, pasta, dh_entrada, assunto, status, preso, programado,
					  visualizado, origem, prioridade_usuario, prioridade_fila, cod_status, remetente, alerta, tamanho,
					  destino_celular, mensagem,codigo,codigo_prog, codigo_cliente,codigo_grupo,codigo_contato,
					  dh_programado,tipo_prog, status_envio) VALUES('.$codigo4.', 
							 "-2", 
							 "'.$datacorrente.'",
							 "SEM TITULO", 
							 "AGUARDANDO ENVIO", 
							 "F", 
							 "T", 
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
							 '.$codigo.',
							 '.$codigo_prog.',
							 "'.$codigo_cliente.'",
							 '.$codigo_grupo.',
							 '.$codigo_contato.',						   
							 "'.$dh_programado.'",
							 "'.$tipo_prog.'",
							 "N")';
			  echo $qr11 = "insert into SMS(
							  DATA_CADASTRO,
							  CELULAR_DESTINO,
							  MENSAGEM,
							  STATUS,
							  CODIGO_CLIENTE,
							  USUARIO,
							  DATA_AGENDADO,
							  TIPO_PROG,
							  CODIGO_PROG,
							  CODIGO_CONTATO
							  )
							  VALUES (
							  '$datacorrente'
							  ,'$telefone' 
							  ,'$mensagem' 
							  ,'1'
							  ,'$codigo_cliente'
							  ,'$codigo4'
							  ,'$dh_programado'
							  ,'$tipo_prog'
							  ,'$codigo_prog'
							  ,'$codigo_contato'
							  )";
							 
				  mysql_query($qr11);				
				  $erro = mysql_error($con);
				  
				  //SE NAO RETORNOU NENHUM ERRO NA INSERCAO DO SMS, O CREDITO DO CLIENTE É DEBITADO
				  if($erro == '')
				  {				  
					  $novovalor = $creditosms - $qtdeenviada;
					  $query2 = "UPDATE CREDITO_SMS
						  SET CREDITO_SMS.CSMS_CREDITO = '$novovalor' 
						  WHERE CREDITO_SMS.CLIENTECNPJ_ID = '$idclientecnpj'";
						  
					  $resultado2 = ibase_query($conexao, $query2);
						  
					  $resultado3 = ibase_query($conexao, $query);
					  $row3 = ibase_fetch_assoc($resultado3);								  				  
					  echo $novovalor;
				  }
				  else
					{
						//SE HOUVE ERRO NA INSERCAO DA MENSAGEM O VALOR DO CREDITO É RETORNADO SEM DEBITO
						echo $creditosms;	
					}
					
			  }
	  
		}
		else
			{
				echo "N";
			}
	}
	
	if($_REQUEST['funcao'] == 'retornacredito')
	{
		$cnpj = $_REQUEST['cnpj'];
		$qtdeenviada = $_REQUEST['qtdeenviada'];
		
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
			if($qtdeenviada <> '0' && $creditosms <> 0)
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
				echo "Saldo de ".$creditosms." SMS(s) Bloqueado(s).";
			}
	}
	
	if($_REQUEST['funcao'] == 'retornavalidade')
	{
		$cnpj = $_REQUEST['cnpj'];
		
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
			echo "000";
		}
		else
			{
				echo date('m/d/Y h:i', strtotime($row['CSMS_DTHR_TERMINO']));
			}
	}
	
	if($_REQUEST['funcao'] == 'retornabloqueado')
	{
	
		$query = " SELECT BLOQ_NUMERO FROM BLOQUEADO ";
		$resultado = ibase_query($conexao, $query);

		$i = 0;
		$arr = array();
		
		while ($row = ibase_fetch_assoc($resultado)) { 
			$arr[] = array ('telefone'=>$row['BLOQ_NUMERO']);
			$i++; 
		}
		
		if($i == 0)
		{
			echo json_encode("0");
		}
		else
			{
				echo json_encode($arr);
			}
	}
	
	if($_REQUEST['funcao'] == 'retornapacote')
	{
		$idaplicativo = $_REQUEST['idaplicativo'];
		$query = " SELECT 
			P.DESCRICAO, 
			P.VALOR_UNIT, 
			P.QUANTIDADE  
			FROM PACOTE P 
			LEFT JOIN PACOTE_APLICATIVO PA ON 
			P.ID_PACOTE = PA.IDPACOTE 
			WHERE PA.IDAPLICATIVO = '$idaplicativo'";
		$resultado = ibase_query($conexao, $query);

		$i = 0;
		$arr = array();
		
		while ($row = ibase_fetch_assoc($resultado)) { 
			$arr[] = array ('descricao'=>$row['DESCRICAO'],
						    'valor_unit'=>$row['VALOR_UNIT'],
						    'quantidade'=>$row['QUANTIDADE']);
			$i++; 
		}
		
		if($i == 0)
		{
			echo json_encode("0");
		}
		else
			{
				echo json_encode($arr);
			}
	}
	
	if($_REQUEST['funcao'] == 'retornaprogramacao')
	{
	
		$codigo_cliente = $_REQUEST['cnpj'];
		
		$qr3 = " SELECT 
			codigo_prog, 
			dh_programado, 
			status_envio, 
			tipo_prog, 
			mensagem, 
			destino_celular, 
			codigo_contato 
			FROM vsms_documento where codigo_cliente = '$codigo_cliente'
			and status = 'SUCESSO'
            AND codigo_prog IS NOT NULL";
		$qr3 = " SELECT 
			codigo_prog, 
			DATA_AGENDADO AS dh_programado, 
			NULL AS status_envio, 
			tipo_prog, 
			mensagem, 
			CELULAR_DESTINO AS destino_celular, 
			codigo_contato 
			FROM SMS where codigo_cliente = '$codigo_cliente'
			and status = '4'
            AND codigo_prog IS NOT NULL";
		$res2 = mysql_query($qr3);
		//O QUE É STATUS IGUAL A SUCESSO
		
		$i = 0;
		$arr = array();
		
		
		while ($row = mysql_fetch_assoc($res2)) { 
			$arr[] = array ('codigo_prog'=>$row['codigo_prog'],
							'dh_programado'=>date('m/d/Y H:i',strtotime($row['dh_programado'])),
							'status_envio'=>"SUCESSO",
							'tipo_prog'=>html_entity_decode( UTF8ToEntities($row['tipo_prog']),ENT_NOQUOTES ,'ISO-8859-1'),
							'mensagem'=>$row['mensagem'],
							'destino_celular'=>$row['destino_celular'],
							'codigo_contato'=>$row['codigo_contato']);
			$i++; 
		}
		
		if($i == 0)
		{
			echo json_encode("0");
		}
		else
			{
				echo json_encode($arr);
			}
	}
	
	if($_REQUEST['funcao'] == 'retornareferencia')
	{
		$cnpj = $_REQUEST['cnpj'];
		
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
	}
	
	if($_REQUEST['funcao'] == 'statusconexao')
	{
		echo "OK";
	}
	
	if($_REQUEST['funcao'] == 'retornacodcadastro')
	{
		$query = " SELECT GEN_ID(GEN_CADASTROINICIAL,1) AS CODIGO FROM PARAMETRO_LOCAL ";
		$resultado = ibase_query($conexao, $query);
		$row = ibase_fetch_assoc($resultado);
		$codinicial =  $row['CODIGO'];
		
		echo $codinicial;
	}
	
	if($_REQUEST['funcao'] == 'liberacredito')
	{
		$cnpj = $_REQUEST['cnpj'];
		$referencia = $_REQUEST['referencia'];
		$tranqtde = $_REQUEST['tranqtde'];
		$valorpago = $_REQUEST['valorpago'];
		$formapagto = $_REQUEST['formapagto'];
		$datapagto = $_REQUEST['datapagto'];
		$trancodigo = $_REQUEST['trancodigo'];
		$trantipo = $_REQUEST['trantipo'];
		$trandthoralib = $_REQUEST['trandthoralib'];
		$tranvalunit = $_REQUEST['tranvalunit'];
		$tranqtdesms = $_REQUEST['tranqtdesms'];
		$tranpacote = $_REQUEST['tranpacote'];
		
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
					SET CREDITO_SMS.CSMS_CREDITO = '$novovalor',
					CREDITO_SMS.CSMS_DTHR_LIBERADO = '$trandthoralib' 
					WHERE CREDITO_SMS.CLIENTECNPJ_ID = '$codcliente'";
				$resultado5 = ibase_query($conexao, $query5);
				echo $novovalor;
			}
			else
				{
					$query5 = "INSERT INTO CREDITO_SMS 
					(CLIENTECNPJ_ID, CSMS_CREDITO, CSMS_DTHR_LIBERADO) VALUES 
					('$codcliente','$tranqtdesms','$trandthoralib')";
				    $resultado5 = ibase_query($conexao, $query5);
					echo $tranqtdesms;
				}
		}
	}
	
	if($_REQUEST['funcao'] == 'inserecredito')
	{
		$cnpj = $_REQUEST['cnpj'];
		$nomecli = $_REQUEST['nomecli'];
		$nomeaplic = $_REQUEST['nomeaplic'];
		$qtdeenviada = $_REQUEST['qtdeenviada'];
		
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
			
			$query8 = "INSERT INTO CREDITO_SMS (CLIENTECNPJ_ID,CSMS_CREDITO) VALUES ('$codclientecnpj','$qtdeenviada')";
			$resultado8 = ibase_query($conexao, $query8);
			
			$query9 = " SELECT IDAPLICATIVO FROM APLICATIVO WHERE APLICATIVO = '$nomeaplic'";
			$resultado9 = ibase_query($conexao, $query9);
			$row9 = ibase_fetch_assoc($resultado9);
			$codaplicativo =  $row9['IDAPLICATIVO'];
			
			$query10 = "INSERT INTO APLICATIVO_CNPJ (IDCLIENTE_CNPJ,IDAPLICATIVO,PERMITIDO) VALUES ('$codclientecnpj','$codaplicativo','T')";
			$resultado10 = ibase_query($conexao, $query10);
			
			echo "000";
		}
	}
	
//FECHA CONEXÃO MYSQL	
mysql_close($con);
//FECHA CONEXÃO FIREBIRD
ibase_close();

?>