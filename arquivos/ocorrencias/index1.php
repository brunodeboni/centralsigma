<?php 
//Seta Fuso Horário
date_default_timezone_set('America/Sao_Paulo');

//Conexão mysql
require '../../conexoes.inc.php';
$db = Database::instance('centralsigma02');

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Registro de Ocorrência</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/gioplugin.js"></script>
    <script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/jquery.maskedinput.js"></script>
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
    	button{
	    	padding:10px 30px;
	    	background:#315D81;
	    	color: #FFF;
	    	font-weight: bold;
	    	
	    	border: 0;
	    	-webkit-border-radius: 5px;
	    	border-radius: 5px;
    	}
    	h1{
			display:block;
			margin-bottom:20px;
			text-align:center;
			padding:10px;
			font-size:16px;
			background: #315D81;
			color:#FFF;
			-webkit-border-radius: 5px;
	    	border-radius: 5px;
		}
		form {
			margin-left: 5px;
		}
		#div_erro{
			display: none;
			margin-left: 5px;
			margin-bottom: 10px;
			width: 90%;
			padding: 5px;
			background: #FEE;
			color: #900;
		}
		.colabs {display: none;}
    </style>
</head>

<body>
<div id="container">
	<h1>Registro de Ocorrência</h1>
	
	<form id="form_bo" action="processa_form.php" method="post">
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
		
		<button type="button">Enviar</button>
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
</body>
</html>