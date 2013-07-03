<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Formul&aacute;rio de cadastro Sigma 2012</title>
<style type="text/css">
*{      
	font-family:Tahoma, Geneva, sans-serif;
	padding:0;
	margin:0;
	font-size:12px;
}

body{
	background:#82BEDE;
}

.titulo{
	display:block;
	padding:20px;
	text-align:center;
	font-size:18px;
	font-weight:bold;
}

.warning{
	display:block;
	padding:5px;
	border:1px solid #090;
	color:#090;
	background:#DFD;
	font-weight:bold;
}

#form {
    	margin: auto;
	width:600px;
	font-weight:bold;
	font-size:12px;
}

input,select{padding:5px;font-size:12px;border:1px solid #CCC;outline:0;font-wei}
input:focus,select:focus{background:#FFFFCC;}
.block{width:100%;margin:auto;display:block;}
button{padding:10px 70px;background:#DDF;}

ul.links{list-style:none;font-size:12px;}
ul.links li{margin-right:20px;display:inline;}

.menubar{list-style:none;font-size:12px;float:right;cursor:pointer;width:100px;}
.menubar li a{text-decoration:none;padding:1px 5px;display:block;background:#F0F8FF;border:1px solid #39C;color:#036;}
.menubar .submenu{list-style:none;position:absolute;display:none;font-size:90%;width:100px;}
.menubar .submenu li a{padding:5px;background:#F0F8FF;display:block;}
.menubar .submenu li a:hover{background:#006699;color:#FFF;}
.menubar li:hover .submenu{display:block;}


.hlinput{border:2px solid #C00;}
.hOutput{padding:5px;font-size:12px;border:1px solid #CCC;outline:0;}
.clear{clear:both;}
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="http://centralsigma.com.br/arquivos/plugins/gioplugin.js"></script>
<script type="text/javascript">
function getUF(pais){
	$("#UF").css("display","inline");
	opts = "";
	if(pais=="XX"){
		$("#ufdiv").html('<input type="text" name="UF" id="UF2" style="width:305px;position:relative;left:15px;" />');
		return;
	}else{
		$("#ufdiv").html('<select name="UF" id="UF" style="width:320px;position:relative;left:15px;"></select>');
	}
	
	if(pais=="BR"){
		opts  = '<option value="AC">Acre</option>';
		opts += '<option value="AL">Alagoas</option>';
		opts += '<option value="AP">Amap&aacute;</option>';
		opts += '<option value="AM">Amazonas</option>';
		opts += '<option value="BA">Bahia</option>';
		opts += '<option value="CE">Cear&aacute;</option>';
		opts += '<option value="DF">Distrito Federal</option>';
		opts += '<option value="ES">Esp&iacute;rito Santo</option>';
		opts += '<option value="GO">Goi&aacute;s</option>';
		opts += '<option value="MA">Maranh&atilde;o</option>';
		opts += '<option value="MT">Mato Grosso</option>';
		opts += '<option value="MS">Mato Grosso do Sul</option>';
		opts += '<option value="MG">Minas Gerais</option>';
		opts += '<option value="PA">Par&aacute;</option>';
		opts += '<option value="PB">Para&iacute;ba</option>';
		opts += '<option value="PR">Paran&aacute;</option>';
		opts += '<option value="PE">Pernambuco</option>';
		opts += '<option value="PI">Piau&iacute;</option>';
		opts += '<option value="RJ">Rio de Janeiro</option>';
		opts += '<option value="RN">Rio Grande do Norte</option>';
		opts += '<option value="RS">Rio Grande do Sul</option>';
		opts += '<option value="RO">Rond&ocirc;nia</option>';
		opts += '<option value="RR">Roraima</option>';
		opts += '<option value="SC">Santa Catarina</option>';
		opts += '<option value="SP">S&atilde;o Paulo</option>';
		opts += '<option value="SE">Sergipe</option>';
		opts += '<option value="TO">Tocantins</option>';
	}
	
	defopt = '<option value="" class="sp_selecione">Selecione...</option>';
	
	$("#UF").html('');
	$("#UF").append(defopt+opts);
}

function verificaDados(){
	if($("#inp_nome").val()==""){$("#inp_nome").focus();$("#inp_nome").addClass("hlinput");return false;}
	
	if($("#inp_email").val()=="" || !checarEmail($("#inp_email").val()) ){$("#inp_email").focus();$("#inp_email").addClass("hlinput");return false;}
	
	if($("#inp_empresa").val()==""){$("#inp_empresa").focus();$("#inp_empresa").addClass("hlinput");return false;}
	
	if($("#inp_cidade").val()==""){$("#inp_cidade").focus();$("#inp_cidade").addClass("hlinput");return false;}
	
	if($("#inp_bairro").val()==""){$("#inp_bairro").focus();$("#inp_bairro").addClass("hlinput");return false;}
	
	if($("#inp_setor").val()==""){$("#inp_setor").focus();$("#inp_setor").addClass("hlinput");return false;}
	
	if($("#inp_msgnatal").val()==""){$("#inp_msgnatal").focus();$("#inp_msgnatal").addClass("hlinput");return false;}
	
	if($("#inp_endereco").val()==""){$("#inp_endereco").focus();$("#inp_endereco").addClass("hlinput");return false;}
	
	//if($("#inp_telefone1").val().length!=14&&$("#inp_telefone1").val().length!=11){$("#inp_telefone1").focus();$("#inp_telefone1").addClass("hlinput");return false;}
	//if($("#inp_telefone2").val().length!=14&&$("#inp_telefone2").val().length!=11){$("#inp_telefone2").focus();$("#inp_telefone2").addClass("hlinput");return false;}
	
	if($("#inp_cep").val()==""){$("#inp_cep").focus();$("#inp_cep").addClass("hlinput");return false;}
	
	if($("#UF").val()==""){$("#UF").focus();$("#UF").addClass("hlinput");return false;}
	
	if($("#tamanho").val()==""){$("#tamanho").focus();$("#tamanho").addClass("hlinput");return false;}
	
	var nn1 = gioplugin.telefone.decodenum($("#inp_telefone1").val());
	if(nn1)$("#inp_telefone1").val(nn1);
	else{$("#inp_telefone1").focus();$("#inp_telefone1").addClass("hlinput");return false;}
	
	var nn2 = gioplugin.telefone.decodenum($("#inp_telefone2").val());
	if(nn2)$("#inp_telefone2").val(nn2);
	else{$("#inp_telefone2").focus();$("#inp_telefone2").addClass("hlinput");return false;}
	
	$("#form_processa_contato").submit();
}

function limitaTextarea(valor) {
	quantidade = 340;
	total = valor.length;

	if(total <= quantidade) {
		resto = quantidade- total;
		document.getElementById('contador').innerHTML = resto;
	} else {
		document.getElementById('inp_msgnatal').value = valor.substr(0, quantidade);
	}
}

function checarEmail(mail){
	if(mail.length==0) return true;
	
	if ((mail.length > 7) && !((mail.indexOf("@") < 1) || (mail.indexOf('.') < 2)))
		{return true;}
	else
		{return false;}
}

$(document).ready(function(e) {	
	$("input, select").blur(function(e) {
        if($(this).val()=="") 
			$(this).addClass("hlinput");
		else 
			$(this).removeClass("hlinput");
    });
	
	// Formatação dos telefones
	$(".telefone").keyup(function(e) {
		$(this).val(gioplugin.telefone.encodenum($(this).val()));
    }).focusout(function(e) {
		txp = $(this).val().replace(/\D/g,'');
        if(!txp || txp==null || txp=="") $(this).val("");
		else $(this).val(gioplugin.telefone.encodenum($(this).val()));
    }).blur(function(e) {
        $(this).val(gioplugin.telefone.encodenum($(this).val()));
    });
});
</script>
</head>
<body>


<div id="form">
<h1 class="titulo">Formul&aacute;rio de presente - Central Sigma</h1>
<div class="warning">Informe corretamente seus dados e sua mensagem de natal para que o seu cadastro seja aprovado e você receba o presente.</div>
<br class="clear" />
<form action="processa_contato.php?page_id=<?php echo $_GET['page_id']; ?>" method="post" id="form_processa_contato" enctype="multipart/form-data" >

<span>Você é usuário do Sigma?</span>:<br><br>
<label><input type="radio" name="usuario_sigma" value="1"> Sim</label><br><br>
<label><input type="radio" name="usuario_sigma" value="0" checked="checked"> Não</label><br><br><br>

<span class="sp_nome">Nome Completo</span>:<br/>
<input type="text" name="nome" id="inp_nome" class="block" /><br/>

<span class="sp_empresa">Empresa</span>:<br/>
<input type="text" name="empresa" id="inp_empresa" class="block" /><br/>

<span class="sp_endereco">Endere&ccedil;o</span>:<br/>
<input type="text" name="endereco" id="inp_endereco" class="block" /><br/>

<span class="sp_bairro">Bairro</span>:<br/>
<input type="text" name="bairro" id="inp_bairro" class="block"  /><br/>

<span class="sp_cidade">Cidade</span>:<br/>
<input type="text" name="cidade" id="inp_cidade" class="block" /><br/>

<span class="sp_estado">Estado</span>:
<select name="UF" id="UF" style="width:170px;">
<option value="" class="sp_selecione" selected>Selecione...</option>
<option value="AC">Acre</option>
<option value="AL">Alagoas</option>
<option value="AP">Amap&aacute;</option>
<option value="AM">Amazonas</option>
<option value="BA">Bahia</option>
<option value="CE">Cear&aacute;</option>
<option value="DF">Distrito Federal</option>
<option value="ES">Esp&iacute;rito Santo</option>
<option value="GO">Goi&aacute;s</option>
<option value="MA">Maranh&atilde;o</option>
<option value="MT">Mato Grosso</option>
<option value="MS">Mato Grosso do Sul</option>
<option value="MG">Minas Gerais</option>
<option value="PA">Par&aacute;</option>
<option value="PB">Para&iacute;ba</option>
<option value="PR">Paran&aacute;</option>
<option value="PE">Pernambuco</option>
<option value="PI">Piau&iacute;</option>
<option value="RJ">Rio de Janeiro</option>
<option value="RN">Rio Grande do Norte</option>
<option value="RS">Rio Grande do Sul</option>
<option value="RO">Rond&ocirc;nia</option>
<option value="RR">Roraima</option>
<option value="SC">Santa Catarina</option>
<option value="SP">S&atilde;o Paulo</option>
<option value="SE">Sergipe</option>
<option value="TO">Tocantins</option>
</select><br/><br/>

<span class="sp_cep">CEP</span>:<br/>
<input type="text" name="cep" id="inp_cep" class="block" /><br/>

<span class="sp_telefone1">Tel/Ramal</span>: <span style="color:#666;font-size:14px;float:right;">(XX) XXXX-XXXX</span><br/>
<input type="text" name="telefone1" id="inp_telefone1" class="block telefone" maxlength="15" /><br/>

<span class="sp_telefone2">Tel Celular</span>: <span style="color:#666;font-size:14px;float:right;">(XX) XXXX-XXXX</span><br/>
<input type="text" name="telefone2" id="inp_telefone2" class="block telefone" maxlength="15" /><br/>

<span class="sp_setor">Setor</span>:<br/>
<input type="text" name="setor" id="inp_setor" class="block"  /><br/>

<span class="sp_email">Email</span>:<br/>
<input type="text" name="email" id="inp_email" class="block" /><br/>


<span class="sp_msgnatal">Mensagem de Natal</span>: (caracteres restantes: <span id="contador">340</span>)<br/> 
<textarea rows="4" class="block" name="msgnatal" id="inp_msgnatal" onKeyUp="limitaTextarea(this.value)">
</textarea>
<br />

<span class="sp_imagem">Insira a sua imagem ou da sua equipe (limite de 8mb)</span>:<br/>
<input type="hidden" name="MAX_FILE_SIZE" value="8000000" >
<input type="file" name="arquivo" size="30" ><br/>


<!-- [Display:Block] -->
<br class="clear" />
<button type="button" onClick="verificaDados()">Cadastrar</button>
</form>
</div>

</body>
</html>