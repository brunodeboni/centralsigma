<?php

require '../../conexoes.inc.php';
$db = Database::instance('centralsigma02');
		
$empresa = $_POST['empresa'];
$fantasia = $_POST['fantasia'];
$cnpj = $_POST['cnpj'];
$cnpj = str_replace ( '.' , '' , $cnpj);
$cnpj = str_replace ( '/' , '' , $cnpj );
$cnpj = str_replace ( '-' , '' , $cnpj );
$endereco = $_POST['endereco'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$uf = $_POST['UF'];
$cep = $_POST['cep'];
$cep = str_replace ( '-' , '' , $cep );
$telefone1 = $_POST['telefone1'];
$telefone2 = $_POST['telefone2'];
$email = $_POST['email'];
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];


$sql1 = "INSERT INTO pc_empresas (`EMPRESA`, `RAZAO_SOCIAL`, `CNPJ`, `ENDERECO`, `BAIRRO`, `CIDADE`, `UF`, `CEP`, `FONE1`, `FONE2`, `EMAIL`, `AUTORIZADO`)
	VALUES (:empresa, :fantasia, :cnpj, :endereco, :bairro, :cidade, :uf, :cep, :telefone1, :telefone2, :email, 'A')";
$query = $db->prepare($sql1);
$success = $query->execute(array(
	':empresa' => $empresa, 
	':fantasia' => $fantasia, 
	':cnpj' => $cnpj, 
	':endereco' => $endereco, 
	':bairro' => $bairro, 
	':cidade' => $cidade, 
	':uf' => $uf, 
	':cep' => $cep, 
	':telefone1' => $telefone1, 
	':telefone2' => $telefone2, 
	':email' => $email
));

if(!$success){
	$errmsg = '<p style="font-size: 12px; 
  color: #061218;
  font-weight:bold;
  text-align: left;
  font-family: Arial, Helvetica, Sans-Serif;">N&atilde;o foi poss&iacute;vel fazer o cadastro, provavelmente este CNPJ j&aacute; est&aacute; em uso.</p><br><br><br>'
		.'<a style="font-size: 12px; 
  color: #061218;
  font-weight:bold;
  text-align: left;
  font-family: Arial, Helvetica, Sans-Serif;" href="javascript:history.back();">Voltar</a><br><br><br><br><br><br><br><br>';
//		.'<small><b>Detalhes:</b> '.mysql_error($conn).'</small>';
	die($errmsg);
}

$codigoempresa = $db->lastInsertId('ID_EMPRESA');

$sql2 = "INSERT INTO pc_conexoes (`ID_EMPRESA`, `TIPOBANCO`, `SERVIDOR`, `USUARIO`, `SENHA`, `BANCO`)
VALUES (:codigoempresa, 'MYSQL', 'mysql.centralsigma.com.br', :usuario, :senha, :usuario)";
$query2 = $db->prepare($sql2);
$success2 = $query2->execute(array(
	':codigoempresa' => $codigoempresa,
	':usuario' => $usuario, 
	':senha' => $senha, 
	':usuario' => $usuario
));


if (!$success2){

	$errmsg = 'Ocorreu um erro inesperado.<br><br><br><br><br>
			<a href="javascript:history.back();">Voltar</a>';
//	echo($errmsg);
}

echo '<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
alert ("Cadastro efetuado com sucesso! Entraremos em contato.")
</SCRIPT>';


// CRIAR MENSAGEM PARA ENVIAR POR E-MAIL
$msg = "<strong>Nome: </strong> ".$empresa;
$msg .= "<br>  <strong>Empresa: </strong> ".$fantasia;
$msg .= "<br>  <strong>CNPJ: </strong> ".$cnpj;
$msg .= "<br>  <strong>Endere&ccedil;o: </strong> ".$endereco;
$msg .= "<br>  <strong>Bairro: </strong> ".$bairro;
$msg .= "<br>  <strong>Cidade: </strong> ".$cidade;				
$msg .= "<br>  <strong>CEP: </strong> ".$cep;
$msg .= "<br>  <strong>Estado: </strong> ".$uf;
$msg .= "<br>  <strong>Tel/Ramal: </strong> ".$telefone1;
$msg .= "<br>  <strong>Tel Celular: </strong> ".$telefone2;
$msg .= "<br>  <strong>Email: </strong> ".$email;
$msg .= "<br>  <strong>Usuario: </strong> ".$usuario;
$msg .= "<br>  <strong>Senha: </strong> ".$senha;


// ENVIAR E-MAIL
// Para quem vai ser enviado o email
$headers  = 'MIME-Version: 1.0' . "\r\n"
			. 'Content-type: text/html; charset=iso-8859-1' . "\r\n"
			. 'From: noreply@centralsigma.com.br' . "\r\n";
$para = 'carolina@redeindustrial.com.br, comercial@redeindustrial.com.br, marketing@redeindustrial.com.br';
$assunto = 'Cadastro solicitando SigmaWeb';
//Monta a mensagem
$mensagem = "$msg";
// enviar o email
mail($para, $assunto, $mensagem, $headers);
?>
<!doctype html>
<html>
<body>
<p style="font-size:18px;font-weight:bold;">Cadastro efetuado com sucesso</p>
</body>
</html>