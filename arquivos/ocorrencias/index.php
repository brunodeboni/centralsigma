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
	    	color: #1f5775; 
	    	font-size: 14px; 
	    	font-family:Arial, sans-serif; 
	    	background: #EEE9E9;
    	}
    	button{
	    	padding:10px 70px;
	    	background:#DDF;
	    	margin-left: 20px;
    	}
    	h1{
			display:block;
			margin-bottom:20px;
			padding:10px;
			border:1px solid #BBB;
			background:#F7F7F7;
			color:#666;
			text-align:center;
			font-size:18px;
		}
		.hlinput{border:2px solid #C00;}
		.colabs {display: none;}
    </style>
</head>

<body>
	<h1>Registro de Ocorrência</h1>
	Use o formulário abaixo para relatar seu problema.
	<br><br>
	
	<form id="form_bo" action="processa_form.php" method="post">
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
		<select id="setores" name="setores" onChange="enableCheckbox()">
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
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Marisabel Cavallin">Marisabel Cavallin
		</div>
		<div id="st_analise" class="colabs">
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Davi Utzig">Davi Utzig
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Henrique Weber">Henrique Weber
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Josias Boone">Josias Boone
			<input type="checkbox" class="colaboradores" name="colaboradores[]" value="Pedro Lima">Pedro Lima
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
		
		<label>
			<span>O que está errado/fora de padrão?</span><br>
			<textarea id="erro" cols="100" rows="10" name="erro"></textarea><br>
		</label>
		<label>
			<span>Como deveria ser?</span><br>
			<textarea id="sugestao" cols="100" rows="10" name="sugestao"></textarea><br>
		</label>
		<label>
			<span>Quais problemas este erro gerou?</span><br>
			<textarea id="problemas" cols="100" rows="10" name="problemas"></textarea><br>
		</label>
		
		<br>
		<label>
			<span>Esta ocorrência está relacionada a algum cliente?</span>
			<input type="radio" id="sim" name="clientes" onClick="enableInput()" value="Sim">Sim
			<input type="radio" id="nao" name="clientes" onClick="disableInput()" value="Não" checked>Não
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
		
		<button onClick="verificaDados()" type="button">Enviar</button>
	</form>

	<script>
	$(document).ready(function() {
		$('#dia_ocorrencia').mask('99/99/9999');
		$('#hora_ocorrencia').mask('99:99');
	});
	
	function enableInput() {
		$('.envolvidos').removeAttr('disabled', 'false');
	}
	
	function disableInput() {
		$('.envolvidos').attr('disabled', 'true');
	}

	function verificaDados() {
		
		if( $('#responsavel').val() == "" ) {$("#responsavel").focus();$("#responsavel").addClass("hlinput");return false;}
		if( $('#dia_ocorrencia').val() == "" ) {$("#dia_ocorrencia").focus();$("#dia_ocorrencia").addClass("hlinput");return false;}
		if( $('#hora_ocorrencia').val() == "" ) {$("#hora_ocorrencia").focus();$("#hora_ocorrencia").addClass("hlinput");return false;}
		if( $('#assunto').val() == "" ) {$("#assunto").focus();$("#assunto").addClass("hlinput");return false;}
		if( $('#ocorrencia').val() == "" ) {$("#ocorrencia").focus();$("#ocorrencia").addClass("hlinput");return false;}
		if( $('#erro').val() == "" ) {$("#erro").focus();$("#erro").addClass("hlinput");return false;}
		if( $('#sugestao').val() == "" ) {$("#sugestao").focus();$("#sugestao").addClass("hlinput");return false;}
		if( $('#problemas').val() == "" ) {$("#problemas").focus();$("#problemas").addClass("hlinput");return false;}
		if ( $('#sim').prop('checked') ) {
			if( $('#envolvido').val() == "" ) {$("#envolvido").focus();$("#envolvido").addClass("hlinput");return false;}
			if( $('#ciencia_cliente').val() == "" ) {$("#ciencia_cliente").focus();$("#ciencia_cliente").addClass("hlinput");return false;}
		}
		
		$('#form_bo').submit();
	}

	function enableCheckbox() {
		var sel = $('#setores option:selected').val();

		/*$('.colabs').hide();*/
		$('#st_'+sel).show();
		
	}
	</script>
</body>
</html>