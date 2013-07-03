<?php
	include 'config_upload.inc.php';
		set_time_limit (0);
		ini_set('post_max_size', '8M');
		ini_set('upload_max_filesize', '8M'); 
		
		$nome = $_POST['nome'];
		$empresa =  $_POST['empresa'];
		$endereco = $_POST['endereco'];
		$bairro = $_POST['bairro'];
		$cidade = $_POST['cidade'];
		$uf = $_POST['UF'];
		$cep = $_POST['cep'];
		$telefone1 = $_POST['telefone1'];
		$telefone2 = $_POST['telefone2'];
		$setor = $_POST['setor'];
		$email = $_POST['email'];
		$tamanho = $_POST['tamanho'];
		$msgnatal = $_POST['msgnatal'];
		
		$nome_arquivo = $_FILES['arquivo']['name'];
		$tamanho_arquivo = $_FILES['arquivo']['size'];
		$arquivo_temporario = $_FILES['arquivo']['tmp_name'];

		if (($tamanho_arquivo < $tamanho_bytes) && ($tamanho_arquivo > '0')){
		
			$continua = '0';
			//faz as validaçoes necessarias para upload da imagem
			if(!empty ($nome_arquivo)){			
				if ($sobrescrever == "nao" && file_exists("$caminho_absoluto/$nome_arquivo")){
					echo '<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript" >alert ("Arquivo j\u00e1 existe!")</SCRIPT>';
				}
				else{
					$ext = strrchr($nome_arquivo,'.');
					if ($limitar_ext == "sim" && !in_array($ext,$extensoes_validas)){
						echo '<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript" >alert ("Extens\u00e3o de arquivo inv\u00e1lida!")</SCRIPT>';
						exit;
					}
					else{	
						if(move_uploaded_file($arquivo_temporario, "$caminho_absoluto/$nome_arquivo")){
							$continua = '1';
							echo "Upload do arquivo conclu&iacute;do com sucesso!";
						}
						
					}
				}
			}
			
			//arrays com as regioes, que serao utilziados abaixo para checagem.
			$norte_nordeste = array("AC", "RO", "AM", "RR", "PA", "AP", "TO", "MA", "PI",
				"CE", "RN", "PB", "PE", "AL", "SE", "BA"); 
			$sudeste_centrooeste = array("MT", "GO", "MS", "SP", "RJ", "MG", "ES");
			$sul = array("PR", "SC", "RS");
			
			//verifico de qual região é o cliente e seto o endereço do link na variável
			if (in_array($uf, $norte_nordeste)) { 
				$linkpagto = 'http://paghoje.com.br/sigma-recursos?page=shop.product_details&flypage=flypage.tpl&product_id=70&category_id=22';
				$regiao = "NORTE/NORDESTE";
			}
			
			if (in_array($uf, $sudeste_centrooeste)) { 
				$linkpagto = 'http://paghoje.com.br/sigma-recursos?page=shop.product_details&product_id=69&flypage=flypage.tpl&pop=0';
				$regiao = "SUDESTE/CENTRO-OESTE";
			}
			
			if (in_array($uf, $sul)) { 
				$linkpagto = 'http://paghoje.com.br/sigma-recursos?page=shop.product_details&product_id=68&flypage=flypage.tpl&pop=0';
				$regiao = "SUL";
			}		

			//aqui vou colocar os inserts dos dados do cliente no banco de dados
			$query = "INSERT INTO contato_pessoa(  
					`contpess_nome`
					,`contpess_empresa`
					,`contpess_endereco`
					,`contpess_bairro`
					,`contpess_cidade`
					,`contpess_cep`
					,`contpess_uf`
					,`contpess_regiao`
					,`contpess_telramal`
					,`contpess_telcel`
					,`contpess_setor`
					,`contpess_email`
					,`contpess_tamanho`
					,`contpess_msgnatal`
					,`contpess_camimagem`) VALUE (
					'$nome'
					,'$empresa'
					,'$endereco'
					,'$bairro'
					,'$cidade'				
					,'$cep'
					,'$uf'
					,'$regiao'
					,$telefone1
					,$telefone2
					,'$setor'
					,'$email'
					,'$tamanho'
					,'$msgnatal'
					,'$caminho_site/$nome_arquivo')";
			
			$con = mysql_connect($host,$user,$pass);
			mysql_set_charset("utf8",$con);
			if (!$con)
			{
				die('Could not connect: ' . mysql_error());
			}
			
			mysql_select_db($banco, $con);

			$confirmacad = '1';
			if (!mysql_query($query,$con))
			{
			  $confirmacad = '0';
			  //die('Error: ' . mysql_error());
			}

			mysql_close($con);		

			if($confirmacad > '0'){
				//se a imagem foi enviada corretamente, verifica os demais dados para envio da camiseta
				if($continua > '0'){
					
					// Verifica se é usuário do sigma
					$user_sigma = isset($_REQUEST["usuario_sigma"])?(int) $_REQUEST["usuario_sigma"]:0;
					
					// Se for suário do sigma
					if($user_sigma){
						//depois pergundo ao usuário se ele deseja efetuar o pagamento do frete
						//caso contrário retorna para a página de origem.
						echo '<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
							decisao = confirm("Caso n\u00e3o realize o pagamento do Frete, sua camisa n\u00e3o ser\u00e1 enviada. \r\n Deseja efetuar o pagamento do frete?");
							if (decisao){
								var variavelJS = "'.$linkpagto.'";							
								window.top.location.href=variavelJS;
							}else{
								var variavelJS = "'.$_SERVER['HTTP_REFERER'].'";
								location.href=variavelJS;
							}
							</SCRIPT>';
					}
					// Se NÃO for usuário do sigma
					else{
						echo "Obrigado por enviar esta mensagem.";
					}
				}
			}else{
				// Sem conexão com o banco de daods
					echo '<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">alert ("N\u00e3o foi possivel registrar seu cadastro. Tente novamente. Caso o erro persista entre em contato pela \u00e1rea de contato do site, obrigado.")</SCRIPT>';
					echo '<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">var variavelJS = "'.$_SERVER['HTTP_REFERER'].'"; location.href=variavelJS; </SCRIPT>';
				}
				

			$nome = $_POST['nome'];
			$arquivo = $_FILES["arquivo"];
			$assunto = "Mensagem de Natal na árvore";
			$msg = "<strong>Nome: </strong> ".$nome;
			$msg .= "<br>  <strong>Empresa: </strong> ".$empresa;
			$msg .= "<br>  <strong>Endere&ccedil;o: </strong> ".$endereco;
			$msg .= "<br>  <strong>Bairro: </strong> ".$bairro;
			$msg .= "<br>  <strong>Cidade: </strong> ".$cidade;				
			$msg .= "<br>  <strong>CEP: </strong> ".$cep;
			$msg .= "<br>  <strong>Estado: </strong> ".$uf;
			$msg .= "<br>  <strong>Regi&atilde;o: </strong> ".$regiao;
			$msg .= "<br>  <strong>Tel/Ramal: </strong> ".$telefone1;
			$msg .= "<br>  <strong>Tel Celular: </strong> ".$telefone2;
			$msg .= "<br>  <strong>Setor: </strong> ".$setor;
			$msg .= "<br>  <strong>Email: </strong> ".$email;
			$msg .= "<br>  <strong>Tamanho Camisa: </strong> ".$tamanho;
			$msg .= "<br>  <strong>Mensagem de Natal: </strong> ".$msgnatal;
			$msg .= "<br>  <strong>Caminho da Foto no servidor: </strong>".$caminho_site."/".$nome_arquivo;
			$msg .= "<br><br>  <strong>Mensagem: Gostaria que minha mensagem fosse colocada na &Aacute;rvore.</strong>";

			// Para quem vai ser enviado o email
			$para = $emaildestino;

			$boundary = "XYZ-".date("dmYis")."-ZYX";
			$fp = fopen($caminho_absoluto."/".$nome_arquivo, "rb"); // abre o arquivo enviado
			$anexo = fread($fp, filesize($caminho_absoluto."/".$nome_arquivo)); // calcula o tamanho
			$anexo = base64_encode($anexo); // codifica o anexo em base 64

			// cabeçalho do email
			$headers  = "MIME-Version: 1.0\n";
			$headers .= "From: \"$nome\" <$email>\r\n";
			$headers .= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";
			$headers .= "$boundary\n";

			//MOnta a mensagem
			$mensagem = "MIME-Version: 1.0\r\n";
			$mensagem .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$mensagem .= "--$boundary\n";
			$mensagem .= "Content-Transfer-Encoding: 8bits\n";
			$mensagem .= "Content-Type: text/html; charset=\"ISO-8859-1\"\n\n"; 
			$mensagem .= "$msg\n";
			$mensagem .= "--$boundary\n";
			$mensagem .= "Content-Type: application/force-download\n";

			// anexo
			$mensagem .= "Content-Type: ".$_FILES['arquivo']['type']."; name=".$_FILES['arquivo']['name']." \n";
			$mensagem .= "Content-Transfer-Encoding: base64 \n";
			$mensagem .= "Content-Disposition: attachment; filename=".$nome_arquivo." \r\n";
			$mensagem .= "$anexo \n";
			$mensagem .= "--$boundary \n";

			// enviar o email
			mail($para, $assunto, $mensagem, $headers);

		}else{
				echo '<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript" >alert ("O arquivo excedeu o tamanho permitido!")</SCRIPT>';
				echo '<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript" >javascript:history.back()</SCRIPT>';
				
			}
?>