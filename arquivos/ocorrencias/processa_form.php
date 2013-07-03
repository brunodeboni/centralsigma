<?php 
//Cadastrar no banco de dados
require '../../conexoes.inc.php';
$db = Database::instance('centralsigma02');

$dh_registro = $_POST['dh_registro'];
$responsavel = $_POST['responsavel'];
$dia_ocorrencia = $_POST['dia_ocorrencia'];
$hora_ocorrencia = $_POST['hora_ocorrencia'];
if (! isset($_POST['colaboradores'])) {
	$col = "Não há";
}else {
	$colaboradores = $_POST['colaboradores'];
	
	if (is_array($colaboradores)) {
		$col = "";
		foreach ($colaboradores as $colaborador) {
			$col .= $colaborador."|";
		}
		$col = trim($col, "|");
	}
}
$assunto = $_POST['assunto'];
$ocorrencia = $_POST['ocorrencia'];
$erro = $_POST['erro'];
$sugestao = $_POST['sugestao'];
$problemas = $_POST['problemas'];
$clientes = $_POST['clientes'];
if ($clientes == "Sim") {
	$envolvido = $_POST['envolvido'];
	$ciencia_cliente = $_POST['ciencia_cliente'];
}else {
	$envolvido = "Não há";
	$ciencia_cliente = "Não há";
}


$sql = "insert into bo_ocorrencias (responsavel, dia_ocorrencia, hora_ocorrencia, colaboradores, assunto, ocorrencia, erro, sugestao, problemas, clientes, envolvido, ciencia_cliente) 
	values (:responsavel, :dia_ocorrencia, :hora_ocorrencia, :col, :assunto, :ocorrencia, :erro, :sugestao, :problemas, :clientes, :envolvido, :ciencia_cliente)";
$query = $db->prepare($sql);
$success = $query->execute(array(
	':responsavel' => $responsavel,
	':dia_ocorrencia' => $dia_ocorrencia, 
	':hora_ocorrencia' => $hora_ocorrencia, 
	':col' => $col, 
	':assunto' => $assunto, 
	':ocorrencia' => $ocorrencia, 
	':erro' => $erro, 
	':sugestao' => $sugestao, 
	':problemas' => $problemas, 
	':clientes' => $clientes, 
	':envolvido' => $envolvido, 
	':ciencia_cliente' => $ciencia_cliente
));
$cod_registro = $db->lastInsertId('codigo');

//Enviar e-mail para setor de ocorrências e responsável
$assunto_email = "Registro de ocorrencia ".$cod_registro;

$mensagem = "<b>C&oacute;digo do Registro de Ocorr&ecirc;ncia:</b> ".$cod_registro."<br>
<b>Data e hora do registro:</b> ".$dh_registro."<br>
<b>Respons&aacute;vel pelo registro:</b> ".$responsavel."<br>
<b>Data e hora da ocorr&ecirc;ncia:</b> ".$dia_ocorrencia." ".$hora_ocorrencia."<br>
<b>Colaboradores envolvidos:</b> ".$col."<br>
<br>
<b>Assunto:</b> ".$assunto."<br>
<b>Descreva o ocorrido:</b><br>".$ocorrencia."<br>
<br>
<b>O que est&aacute; errado/fora de padr&atilde;o?</b><br>".$erro."<br><br>
<b>Como deveria ser?</b><br>".$sugestao."<br><br>
<b>Quais problemas este erro gerou?</b><br>".$problemas."<br><br>
<br>
<b>Esta ocorr&ecirc;ncia est&aacute; relacionada a algum cliente?</b> ".$clientes."<br>
<b>Qual?</b> ".$envolvido."<br>
<b>Esta ocorr&ecirc;ncia chegou ao conhecimento do cliente? Explique.</b><br>".$ciencia_cliente;

$destinatario = "qualidade@redeindustrial.com.br";

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= 'From: qualidade@redeindustrial.com.br '. "\r\n";

$enviar = mail($destinatario, $assunto_email, $mensagem, $headers);


if ($success) {
	header("Location: enviado.php?c=".$cod_registro);
}else {
	echo "Ocorreu um erro ao registrar sua ocorr&ecirc;ncia. Por favor <a href=\"index.php\">tente novamente</a>";
}


?>