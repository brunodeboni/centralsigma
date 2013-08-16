<?php
// Informa qual o conjunto de caracteres será usado.
header('Content-Type: text/html; charset=utf-8');

// Conexão com mysql
include '../../../conexoes.inc.php';
$db = Database::instance('centralsigma02');

//Pega e-mail de todos que já baixaram
$sql = "select distinct(email) from downloads_meta";
$query = $db->query($sql);
$resultado = $query->fetchAll();

foreach ($resultado as $res) {
	
	$headers = 'MIME-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
	$headers .= 'From: Rede Industrial <comercial@redeindustrial.com.br>'."\r\n";
	
	$destinatario = $res["email"];
	$assunto = "Confirmação de download do SIGMA - Sistema de Manutenção";
	$msg = "
Caro Sr.,

Verificamos em nosso sistema, seu cadastro e a realização do download do SIGMA - Sistema Gerencial de Manutenção. 
  
A Rede Industrial, fundada em 1987, coloca a sua disposição, todos os seus colaboradores para lhe auxiliar no que for necessário para a sua melhor utilização do SIGMA, Software de manutenção mais popular do Brasil, com mais de 320 MIL downloads.

Através do site http://www.centralsigma.com.br você tem a sua disposição:

1 - Centenas de vídeos no youtube que ensinam a utilização do SIGMA;
2 - Dezenas de manuais ON-LINE para você ler e tirar suas dúvidas;
3 - Cursos gratuitos de PCM para você aprender a plenejar a manutenção;
4 - Suporte técnico para você falar diretamente com nossos técnicos;
5 - Fórum de usuários SIGMA com milhares de usuários cadastrados;
6 - Fórum Rede Industrial com mais de 20 Mil profissionais cadastrados;
7 - Link de voz gratuito através do SKYPE e LINK de SMS gratuito ;
8 - Acesso à workshops e palestras sobre PCM;
9 - Diversos Links para você postar comentários, dúvidas, etc;
10 - Dezenas de profissionais preparados para atendê-lo a qualquer momento.

Enfim, saiba que ao utilizar o SIGMA você está com um software de altíssima tecnologia, desenvolvido ininterruptamente há 25 anos por vários engenheiros e técnicos de diversas indústrias de todo Brasil.

Esperamos que sua experiência com o SIGMA seja ótima e garanta bons resultados a você e aos seus projetos.

Ao baixar o SIGMA, você tem direito a solicitar um curso gratuito de PCM - Planejamento e controle da Manutenção. Basta solicitar através de nosso site http://www.centralsigma.com.br


Rede Industrial";
	
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
	
	if ($email_enviado)
		echo "E-Mail enviado para ".$destinatario."!<br>";
	else
		echo '<span style="color:red">Erro ao enviar o E-Mail para '.$destinatario.'!</span><br>';
}

?>