<?php 
//Seta Fuso Horário
date_default_timezone_set('America/Sao_Paulo');

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Abertura de Ocorrência</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/gioplugin.js"></script>
    <script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/jquery.maskedinput.js"></script>
    <link rel="stylesheet" href="default.css">
    <style>
    	body {
	    	color: #24211D; 
	    	font-size: 14px; 
	    	font-family:Arial, sans-serif; 
	    	background: #FFFAF0;
    	}
    	#container {
    		width: 900px;
    		margin: auto;
    	}
		form {
			margin-left: 5px;
		}
		.colabs {display: none;}
    </style>
</head>

<body>
<div id="container">
	<h1>Registro de Ocorrência</h1>
	
	<form id="form_bo" action="" method="post">
		Use o formulário abaixo para relatar seu problema.
		<br><br>
		
		<label>
			<span>Data e hora do registro: <?php echo date("d/m/Y H:i"); ?></span>
			<input type="hidden" name="dh_registro" value="<?php echo date("d/m/Y H:i"); ?>"><br>
		</label>
		<label>
			<span>Responsável pelo registro:</span>
			<input type="text" id="responsavel" name="responsavel" placeholder="Nome"><br>
		</label>
		
		<span>Data e hora da ocorrência:</span>
		<input type="text" id="dia_ocorrencia" name="dia_ocorrencia" placeholder="dd/mm/aaaa">
		<input type="text" id="hora_ocorrencia" name="hora_ocorrencia" placeholder="hh:mm"><br>
		
		<span>Colaboradores envolvidos:</span><br>
		<select id="setores" name="setores">
			<option value="adm">Escolha o setor...</option>
			<option value="adm">Administrativo/Financeiro</option>
			<option value="analise">Análise</option>
			<option value="comercial">Comercial</option>
			<option value="consultoria">Consultoria</option>
			<option value="desenvolvimento">Desenvolvimento</option>
			<option value="mr_gomes">Desenvolvimento MR. Gomes</option>
			<option value="diretoria">Diretoria</option>
			<option value="marketing">Marketing/Divulgação</option>
		</select>
		<br>
		
		<div id="st_adm" class="colabs">
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Cristina Ritter">Cristina Ritter
		</div>
		<div id="st_analise" class="colabs">
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Davi Utzig">Davi Utzig
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Josias Boone">Josias Boone
		</div>
		<div id="st_comercial" class="colabs">
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Adriana Xavier">Adriana Xavier
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Alessandra Plássido">Alessandra Plássido
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Carolina Lima">Carolina Lima
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Juliana Shuster">Juliana Shuster
		</div>
		<div id="st_consultoria" class="colabs">
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Daniel Neves">Daniel Neves
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Márcio Lamberty">Márcio Lamberty
		</div>
		<div id="st_desenvolvimento" class="colabs">
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Giovanne Afonso">Giovanne Afonso
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Henrique Schimitt">Henrique Schimitt
		</div>
		<div id="st_diretoria" class="colabs">
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Abrahão Lima">Abrahão Lima
		</div>
		<div id="st_mr_gomes" class="colabs">
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Matheus Santos">Matheus Santos
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Rodolfo Gomes">Rodolfo Gomes
		</div>
		<div id="st_marketing" class="colabs">
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Bruno De Boni">Bruno De Boni
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Danna Wendling">Danna Wendling
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Gabriela Lima">Gabriela Lima
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Moisés Lima">Moisés Lima
		</div>
		
		<span style="font-size: 12px;">Você pode selecionar colaboradores de vários setores ao mesmo tempo.</span>
		<br>
		<br>
		<label>
			<span>Assunto:</span>
	 		<input type="text" id="assunto" size="114" name="assunto" style="margin-left: 50px;"><br>
		</label>
	 	<label>
			<span>Descreva o ocorrido:</span><br />
			<textarea id="ocorrencia" cols="100" rows="10" name="ocorrencia"></textarea><br>
		</label>
		<br>
		
		<span>O que está errado/fora de padrão?</span><br>
		<select id="erros" name="erros">
			<option value="">Selecione...</option>
			<option value="1">Informações não foram repassadas</option>
			<option value="2">Informações foram repassadas erradas/incompletas</option>
			<option value="3">Prazo de entrega não cumprido</option>
			<option value="4">Documentação exigida não foi entregue</option>
			<option value="5">Histórico de atendimentos não criado (fotos/depoimentos)</option>
			<option value="6">Site ou recurso indisponível / fora do ar / com erro</option>
			<option value="0">Outro</option>
		</select>
		<textarea id="erros_descricao" cols="100" rows="10" name="erros_descricao"></textarea><br>

		<label>
			<span>Como deveria ser?</span><br>
			<textarea id="sugestao" cols="100" rows="10" name="sugestao"></textarea><br>
		</label>
		
		<span>Quais problemas este erro gerou?</span><br>
		<select id="problemas" name="problemas">
			<option value="">Selecione...</option>
			<option value="1">Cliente insatisfeito, mantendo contrato/serviços</option>
			<option value="2">Cliente insatisfeito, cancelando contrato/serviços</option>
			<option value="3">Retrabalho / tempo de trabalho perdido</option>
			<option value="4">Despesas financeiras acima do previsto</option>
			<option value="5">Atraso no recebimento de valores do(s) cliente(s)</option>
			<option value="0">Outro</option>
		</select>
		<textarea id="problemas_descricao" cols="100" rows="10" name="problemas_descricao"></textarea><br>
		
		
		<br>
		<label>
			<span>Esta ocorrência está relacionada a algum cliente?</span>
			<input type="radio" id="sim" name="clientes" value="Sim">Sim
			<input type="radio" id="nao" name="clientes" value="Não" checked>Não
			<br>
		</label>
		<label>
			<span>Qual?</span>
			<input type="text" id="envolvido" name="envolvido" class="envolvidos" disabled><br>
		</label>
		<label>
			<span>Esta ocorrência chegou ao conhecimento do cliente? Explique.</span><br>
			<textarea id="ciencia_cliente" cols="100" rows="10" name="ciencia_cliente" class="envolvidos" disabled></textarea><br>
		</label>
		<br>
		<div id="div_erro"></div><br>
		
		<a class="btn" href="painel.php">Voltar</a>
		<button id="btn" type="button">Enviar</button>
	</form>

	<script>
	$(document).ready(function() {
		$('#dia_ocorrencia').mask('99/99/9999');
		$('#hora_ocorrencia').mask('99:99');
	});

	$('#setores').change(function enableCheckbox() {
		var sel = $('#setores option:selected').val();

		/*$('.colabs').hide();*/
		$('#st_'+sel).show();
		
	});
	
	$('input#sim').click(function enableInput() {
		$('.envolvidos').removeAttr('disabled', 'false');
	});
	
	$('input#nao').click(function disableInput() {
		$('.envolvidos').attr('disabled', 'true');
		$('#envolvido').val('');
		$('#ciencia_cliente').val('');
	});

	$('button').click(function verificaDados() {
		
		if( $('#responsavel').val() == "" ) {$("#div_erro").show();$("#div_erro").html("Por favor, informe seu nome no campo Responsável.");return false;}
		if( $('#dia_ocorrencia').val() == "" ) {$("#div_erro").show();$("#div_erro").html("Por favor, informe a data da ocorrência.");return false;}
		if( $('#hora_ocorrencia').val() == "" ) {$("#div_erro").show();$("#div_erro").html("Por favor, informe a hora da ocorrência.");return false;}
		if( $('#assunto').val() == "" ) {$("#div_erro").show();$("#div_erro").html("Por favor, informe o assunto da ocorrência.");return false;}
		if( $('#ocorrencia').val() == "" ) {$("#div_erro").show();$("#div_erro").html("Por favor, descreva a ocorrência.");return false;}
		if( $('#erros').val() == "" ) {$("#div_erro").show();$("#div_erro").html("Por favor, selecione uma das opções em O que está errado.");return false;}
		if( $('#erros').val() == "0" && $('#erros_descricao').val() == "" ) {$("#div_erro").show();$("#div_erro").html("Por favor, descreva o que está errado.");return false;}
		if( $('#sugestao').val() == "" ) {$("#div_erro").show();$("#div_erro").html("Por favor, informe sugestões em Como deveria ser.");return false;}
		if( $('#problemas').val() == "") {$("#div_erro").show();$("#div_erro").html("Por favor, selecione que problemas este erro gerou.");return false;}
		if( $('#problemas').val() == "0" && $('#problemas_descricao').val() == "") {$("#div_erro").show();$("#div_erro").html("Por favor, descreva que problemas este erro gerou.");return false;}
		if ( $('#sim').prop('checked') ) {
			if( $('#envolvido').val() == "" ) {$("#div_erro").show();$("#div_erro").html("Por favor, informe o cliente envolvido na ocorrência.");return false;}
			if( $('#ciencia_cliente').val() == "" ) {$("#div_erro").show();$("#div_erro").html("Por favor, explique como esta ocorrência chegou ao conhecimento do cliente.");return false;}
		}
		
		$('#form_bo').submit();
	});
	</script>
</div>
<?php 
//Cadastrar no banco de dados
require '../../conexoes.inc.php';
$db = Database::instance('centralsigma02');

if (isset ($_POST['dh_registro'])) {
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
	
	$sql = "insert into bo_ocorrencias (responsavel, dia_ocorrencia, hora_ocorrencia, colaboradores, assunto, ocorrencia, erros, erros_descricao, sugestao, problemas, problemas_descricao, clientes, envolvido, ciencia_cliente, status) 
		values (:responsavel, :dia_ocorrencia, :hora_ocorrencia, :col, :assunto, :ocorrencia, :erros, :erros_descricao, :sugestao, :problemas, :problemas_descricao, :clientes, :envolvido, :ciencia_cliente, '0')";
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
		case '1': $erros = 'Informações não foram repassadas'; break;
		case '2': $erros = 'Informações foram repassadas erradas/incompletas'; break;
		case '3': $erros = 'Prazo de entrega não cumprido'; break;
		case '4': $erros = 'Documentação exigida não foi entregue'; break;
		case '5': $erros = 'Histórico de atendimentos não criado (fotos/depoimentos)'; break;
		case '6': $erros = 'Site ou recurso indisponível / fora do ar / com erro'; break;
		default: $erros = 'Outro'; break;
	}
	switch($problemas) {
		case '1': $problemas = 'Cliente insatisfeito, mantendo contrato/serviços'; break;
		case '2': $problemas = 'Cliente insatisfeito, cancelando contrato/serviços'; break;
		case '3': $problemas = 'Retrabalho / tempo de trabalho perdido'; break;
		case '4': $problemas = 'Despesas financeiras acima do previsto'; break;
		case '5': $problemas = 'Atraso no recebimento de valores do(s) cliente(s)'; break;
		default: $problemas = 'Outro'; break;
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
			case 'Danna Wendling': $col_email[] = '<danna@redeindustrial.com.br>'; break;
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
	$headers .= 'CC: <abrahaolslima@gmail.com>, ';
	foreach ($col_email as $email) {
		$headers .= $email.', ';
	}
	$headers .= "\r\n";
	
	$enviar = mail($destinatario, $assunto_email, $mensagem, $headers);
	
	if ($success) {
		//header("Location: enviado.php?c=".$cod_registro);
		echo '<div id="div_sucesso">Sua ocorrência foi registrada com sucesso. O código da ocorrência é: '.$cod_registro.'.</div>';
	}else {
		echo "<div id=\"div_erro\">Ocorreu um erro ao registrar sua ocorrência. Por favor tente novamente.</div>";
	}
}

?>
</body>
</html>