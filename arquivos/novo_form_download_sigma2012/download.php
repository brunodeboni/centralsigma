<?php
/*
ini_set('display_errors',0);
error_reporting(0);
*/
	// Validações
	if
	(!(
		isset($_REQUEST['aid'])
		&& isset($_REQUEST['origem'])
		&& isset($_REQUEST['nome'])
		&& isset($_REQUEST['email'])
		&& isset($_REQUEST['empresa'])
		&& isset($_REQUEST['telefone'])
		&& isset($_REQUEST['celular'])
		&& isset($_REQUEST['pais'])
		&& isset($_REQUEST['UF'])
	)) exit;
	
	//Conexão com mysql
	require '../../conexoes.inc.php';
	$db = Database::instance('centralsigma02');
	
	// Dados
	$id_arquivo = (int) $_REQUEST['aid'];
	$origem   = $_REQUEST["origem"];
	$nome     = $_REQUEST["nome"];
	$email    = $_REQUEST["email"];
	$empresa  = $_REQUEST["empresa"];
	$telefone = $_REQUEST["telefone"];
	$celular = $_REQUEST["celular"];
	$pais     = $_REQUEST["pais"];
	$uf       = $_REQUEST["UF"];
	
	// Pegar url do arquivo
	$sql1 = "select nome, url from downloads_id_arquivos where id = :id_arquivo";
	$qry1 = $db->prepare($sql1);
	$qry1->execute(array(':id_arquivo' => $id_arquivo));
	$resultado1 = $qry1->fetchAll();
	
	if ($qry1->rowCount() <= 0) die("O arquivo não existe");
	foreach ($resultado1 as $res1) {
		$link_nome = $res1['nome'];
		$link      = $res1['url']; // Link para o arquivo
	}
	// Aumentar o contador de downloads com o ID do arquivo ou iniciar um novo contador caso não exista ainda
	$sqld = "update downloads set downloads = downloads+1 where id_arquivo = :id_arquivo";
	$qryd = $db->prepare($sqld);
	$qryd->execute(array(':id_arquivo' => $id_arquivo));
	
	if($qryd->rowCount() <= 0) {
		$sqld2 = "insert into downloads (id_arquivo, downloads) values (:id_arquivo, 1)";
		$qryd2 = $db->prepare($sqld2);
		$qryd2->execute(array(':id_arquivo' => $id_arquivo));
	}
	
	// Inserir os dados da pessoa que está efetuando download
	$sql2 = "INSERT INTO downloads_meta (id_arquivo, origem, pais, uf, nome, email, empresa, telefone, celular)
				VALUES (:id_arquivo, :origem, :pais, :uf, :nome, :email, :empresa, :telefone, :celular)";
	$qry2 = $db->prepare($sql2);
	$qry2->execute(array(
		':id_arquivo' => $id_arquivo, 
		':origem' => $origem,
		':pais' => $pais,
		':uf' => $uf, 
		':nome' => $nome,
		':email' => $email,
		':empresa' => $empresa,
		':telefone' => $telefone, 
		':celular' => $celular
	));
	
	//Enviar e-mail para pessoa que está efetuando download
	$headers = 'MIME-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
	$headers .= 'From: Rede Industrial <comercial@redeindustrial.com.br>'."\r\n";
	
	$destinatario = $email;
	$assunto = "Confirmação de download do SIGMA - Sistema de Manutenção";
	$msg = "
Caro(a) Sr.(a),

Localizamos em nosso sistema seu cadastro em função da realização do download do SIGMA - Sistema de Gerenciamento de Manutenção.
  
A Rede Industrial, fundada em 1987, coloca a sua disposição, todos os seus colaboradores para lhe auxiliar no que for necessário para a sua melhor utilização do SIGMA que é o software de manutenção mais popular do Brasil, que atualmente atingiu a marca de 310 mil downloads.

Através do site http://www.centralsigma.com.br você tem a sua disposição:

1 - Centenas de vídeos que ensinam a utilização do SIGMA (publicados também no Youtube);
2 - Dezenas de manuais online para você ler e tirar suas dúvidas;
3 - Cursos gratuitos de PCM para você aprender a planejar a manutenção;
4 - Suporte técnico para você falar diretamente com nossos técnicos;
5 - Fórum de usuários SIGMA com milhares de usuários cadastrados;
6 - Fórum Rede Industrial com mais de 20 mil profissionais cadastrados;
7 - Link de voz gratuito através do Skype e link para envio de SMS gratuito;
8 - Acesso à workshops e palestras sobre PCM;
9 - Diversos links para você postar comentários, dúvidas, etc;
10 - Dezenas de profissionais preparados para atendê-lo, a qualquer momento.

Enfim, saiba que ao utilizar o SIGMA você está optando por um software de altíssima tecnologia, desenvolvido ininterruptamente há 25 anos por vários engenheiros e técnicos de diversas indústrias de todo Brasil.

Esperamos que sua experiência com o SIGMA seja ótima e garanta bons resultados a você e aos seus projetos.

Ao baixar o SIGMA, você tem direito a solicitar um curso gratuito de PCM - Planejamento e controle da Manutenção. Basta solicitar através de nosso site http://www.centralsigma.com.br


Atenciosamente,

Equipe Rede Industrial
Callcenter: (11) 4062-0139
comercial@redeindustrial.com.br";
	
	$mensagem = '
		<!doctype html>
		<html>
		<head>
			<meta charset="utf-8">
		</head>
		<body>
			<p><pre style="font-family:Arial, Tahoma, sans-serif; font-size:16px;">'.$msg.'</pre></p>
		</body>
		</html>';
	
	$email_enviado = mail($destinatario, $assunto, $mensagem, $headers);
	
	//Envia SMS avisando sobre o download
	$celular = $_POST['celular'];
	$celular = decode_telefone($celular);
	$mensagem = "Download do SIGMA concluido. Entre em contato conosco e solicite um curso GRATUITO de PCM - www.centralsigma.com.br";
	
	$sql2 = "INSERT INTO `sms` (`CELULAR_REMETENTE`, `CELULAR_DESTINO`, `MENSAGEM`, `STATUS`, `USUARIO`, `CODIGO_CLIENTE`)
	VALUES ('9999999999', :celular, :mensagem, '1', '151', '')";
	$query2 = $db->prepare($sql2);
	$query2->execute(array(':celular' => $celular, ':mensagem' => $mensagem));
	
	function decode_telefone($telefone){
		$telefone = trim($telefone);
		if($telefone=="") return "";
		$nums = "0123456789";
	
		$numsarr = str_split($nums);
		$telsarr = str_split($telefone);
	
		$novo_telefone = "";
	
		foreach($telsarr as $tel){
			$ex = false;
			foreach($numsarr as $num){
				if($tel == $num){
					$ex = true;
					break;
				}
			}
	
			if($ex) $novo_telefone .= $tel;
		}
	
		return $novo_telefone;
	}
	
mysql_close($conn);

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Download SIGMA</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
</head>
<body>
	<script>
	$(document).ready(function() {
		alert('Seus dados foram recebidos com sucesso. O download do SIGMA já foi iniciado.');
		self.location = "<?php echo $link;?>";
	});
	</script>
</body>
</html>


