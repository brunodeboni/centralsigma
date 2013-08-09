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
$erros = (int) $_POST['erros'];
$erros_descricao = $_POST['erros_descricao'];
$sugestao = $_POST['sugestao'];
$problemas = (int) $_POST['problemas'];
$problemas_descricao = $_POST['problemas_descricao'];
$clientes = $_POST['clientes'];
if ($clientes == "Sim") {
	$envolvido = $_POST['envolvido'];
	$ciencia_cliente = $_POST['ciencia_cliente'];
}else {
	$envolvido = "Não há";
	$ciencia_cliente = "Não há";
}

$sql = "insert into bo_ocorrencias (responsavel, dia_ocorrencia, hora_ocorrencia, colaboradores, assunto, ocorrencia, erros, erros_descricao, sugestao, problemas, problemas_descricao, clientes, envolvido, ciencia_cliente) 
	values (:responsavel, :dia_ocorrencia, :hora_ocorrencia, :col, :assunto, :ocorrencia, :erros, :erros_descricao, :sugestao, :problemas, :problemas_descricao, :clientes, :envolvido, :ciencia_cliente)";
$query = $db->prepare($sql);
$query->bindValue(':responsavel', $responsavel, PDO::PARAM_STR);
$query->bindValue(':dia_ocorrencia', $dia_ocorrencia, PDO::PARAM_STR);
$query->bindValue(':hora_ocorrencia', $hora_ocorrencia, PDO::PARAM_STR);
$query->bindValue(':col', $col, PDO::PARAM_STR);
$query->bindValue(':assunto', $assunto, PDO::PARAM_STR);
$query->bindValue(':ocorrencia', $ocorrencia, PDO::PARAM_STR);
$query->bindValue(':erros', $erros, PDO::PARAM_INT);
$query->bindValue(':erros_descricao', $erros_descricao, PDO::PARAM_STR);
$query->bindValue(':sugestao', $sugestao, PDO::PARAM_STR);
$query->bindValue(':problemas', $problemas, PDO::PARAM_INT);
$query->bindValue(':problemas_descricao', $problemas_descricao, PDO::PARAM_STR);
$query->bindValue(':clientes', $clientes, PDO::PARAM_STR);
$query->bindValue(':envolvido', $envolvido, PDO::PARAM_STR);
$query->bindValue(':ciencia_cliente', $ciencia_cliente, PDO::PARAM_STR);
$success = $query->execute();
$cod_registro = $db->lastInsertId('codigo');

switch($erros) {
	case '1': 'Informações não foram repassadas'; break;
	case '2': 'Informações foram repassadas erradas/incompletas'; break;
	case '3': 'Prazo de entrega não cumprido'; break;
	case '4': 'Documentação exigida não foi entregue'; break;
	case '5': 'Histórico de atendimentos não criado (fotos/depoimentos)'; break;
	case '6': 'Site ou recurso indisponível / fora do ar / com erro'; break;
	default: 'Outro'; break;
}
switch(problemas) {
	case '1': 'Cliente insatisfeito, mantendo contrato/serviços'; break;
	case '2': 'Cliente insatisfeito, cancelando contrato/serviços'; break;
	case '3': 'Retrabalho / tempo de trabalho perdido'; break;
	case '4': 'Despesas financeiras acima do previsto'; break;
	case '5': 'Atraso no recebimento de valores do(s) cliente(s)'; break;
	case '6': 'Outro'; break;
	default: 'Outro'; break;
}
$col_email = array();
foreach ($colaboradores as $colaborador) {
	switch($colaborador) {
		case 'Abrahão Lima': $col_email[] = '<abrahaolslima@gmail.com>'; break;
		case 'Cristina Ritter': $col_email[] = '<administrativo@redeindustrial.com.br>'; break;
		case 'Davi Utzig': $col_email[] = '<analise@redeindustrial.com.br>'; break;
		case 'Josias Boone': $col_email[] = '<analise@redeindustrial.com.br>'; break;
		case 'Márcio Lamberty': $col_email[] = '<consultor@redeindustrial.com.br>'; break;
		case 'Daniel Neves': $col_email[] = '<consultor@redeindustrial.com.br>'; break;
		case 'Rodolfo Gomes': $col_email[] = '<ropgomes@gmail.com>'; break;
		case 'Matheus Santos': $col_email[] = '<mat.oliveira.santos@gmail.com>'; break;
		case 'Alessandra Plássido': $col_email[] = '<comercial@redeindustrial.com.br>'; break;
		case 'Adriana Xavier': $col_email[] = '<comercial2@redeindustrial.com.br>'; break;
		case 'Juliana Shuster': $col_email[] = '<comercial3@redeindustrial.com.br>'; break;
		case 'Danna Wendling': $col_email[] = '<dannabo@live.com>'; break;
		case 'Moisés Lima': $col_email[] = '<moises@redeindustrial.com.br>'; break;
		case 'Gabriela Lima': $col_email[] = '<gabriela@redeindustrial.com.br>'; break;
		case 'Giovanne Afonso': $col_email[] = '<giovanneafonso@gmail.com>'; break;
		case 'Henrique Schimitt': $col_email[] = '<henriquesschmitt@gmail.com>'; break;
		case 'Bruno De Boni': $col_email[] = '<brunodeboni@gmail.com>';
		case 'Carolina Lima': $col_email[] = '<qualidade@redeindustrial.com.br>';
	}
}

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
<b>O que est&aacute; errado/fora de padr&atilde;o?</b><br>".$erros."<br>".$erros_descricao."<br><br>
<b>Como deveria ser?</b><br>".$sugestao."<br><br>
<b>Quais problemas este erro gerou?</b><br>".$problemas."<br>".$problemas_descricao."<br><br>
<br>
<b>Esta ocorr&ecirc;ncia est&aacute; relacionada a algum cliente?</b> ".$clientes."<br>
<b>Qual?</b> ".$envolvido."<br>
<b>Esta ocorr&ecirc;ncia chegou ao conhecimento do cliente? Explique.</b><br>".$ciencia_cliente;

$destinatario = "qualidade@redeindustrial.com.br";

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= 'From: qualidade@redeindustrial.com.br '. "\r\n";
$headers .= 'CC: ';
foreach ($col_email as $email) {
	$headers .= $email.', ';
}
$headers .= "\r\n";

$enviar = mail($destinatario, $assunto_email, $mensagem, $headers);

if ($success) {
	header("Location: enviado.php?c=".$cod_registro);
}else {
	echo "Ocorreu um erro ao registrar sua ocorr&ecirc;ncia. Por favor <a href=\"index.php\">tente novamente</a>";
}


?>