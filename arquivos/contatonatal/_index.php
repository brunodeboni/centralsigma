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
#content{
	margin:auto;
	width:500px;
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
<script type="text/javascript">
/********************
** ENCODE TELEFONE **
********************/
function decodenum(n){if(n.length==14){num=n[1]+n[2]+n[5]+n[6]+n[7]+n[8]+n[10]+n[11]+n[12]+n[13];
if(num.length==10)this.novo_numero=num;else this.novo_numero=false;}else if(n.length==10||(n.length==11 && n[0]==0)){
if(n.length==11)n=n[1]+n[2]+n[3]+n[4]+n[5]+n[6]+n[7]+n[8]+n[9]+n[10];vnum = true;for(i=0;i<n.length;i++){
if(n[i]!=0&&n[i]!=1&&n[i]!=2&&n[i]!=3&&n[i]!=4&&n[i]!=5&&n[i]!=6&&n[i]!=7&&n[i]!=8&&n[i]!=9){alert(i+"-"+n[i]);vnum=false;}}
if(vnum==false) this.novo_numero = false;else this.novo_numero = n;}if(this.novo_numero.length!=10) this.novo_numero = false;}
function encodenum(en){if(en.length==10){anum = "("+en[0]+en[1]+") "+en[2]+en[3]+en[4]+en[5]+"-"+en[6]+en[7]+en[8]+en[9];
this.novo_numero = anum;}else{this.novo_numero = false;}}
/********************/

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
	
	if($("#inp_telefone1").val().length!=14&&$("#inp_telefone1").val().length!=11){$("#inp_telefone1").focus();$("#inp_telefone1").addClass("hlinput");return false;}
	if($("#inp_telefone2").val().length!=14&&$("#inp_telefone2").val().length!=11){$("#inp_telefone2").focus();$("#inp_telefone2").addClass("hlinput");return false;}
	
	if($("#inp_cep").val()==""){$("#inp_cep").focus();$("#inp_cep").addClass("hlinput");return false;}
	
	if($("#UF").val()==""){$("#UF").focus();$("#UF").addClass("hlinput");return false;}
	
	if($("#tamanho").val()==""){$("#tamanho").focus();$("#tamanho").addClass("hlinput");return false;}
	
	nn1=new decodenum($("#inp_telefone1").val());
	if(nn1.novo_numero)$("#inp_telefone1").val(nn1.novo_numero);
	else{$("#inp_telefone1").focus();$("#inp_telefone1").addClass("hlinput");return false;}
	
	nn2=new decodenum($("#inp_telefone2").val());
	if(nn2.novo_numero)$("#inp_telefone2").val(nn2.novo_numero);
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
	
	$(".telefone").keydown(function(e){var code=(e.keyCode?e.keyCode:e.which);
		if(!((code>=0)&&(code<=9))&&!((code>=48)&&(code<=57))&&!((code>=96)&&(code<=105))&&!((code>=37)&&(code<=40))&&code!=13&&code!=46){
		e.keyCode=0;return false;}else{if(code!=8){le=$(this).val();length=le.length;if(length==2){if(le.charAt(0)!="(")$(this).val("(" +$(this).val()+") ");
		}if (length == 3) if (le.charAt(0)=="(") $(this).val($(this).val() + ") ");if(length == 9)$(this).val($(this).val() + "-");}}
    });$(".telefone").blur(function(e){en=new encodenum($(this).val());if(en.novo_numero){$(this).val=en.novo_numero;}});
	
});
</script>
</head>
<body>

<div id="content">
	<!--<div class="content">
		<ul class="menubar">
			<li class="parent"><a style="text-align:center;"><span class="sp_linguagem" style="font-size:85%;font-weight:bold;">Linguagem</span></a>
            	<ul class="submenu">
				<li><a href="javascript:void(0)" onClick="window.language='pt'">Portugu�s</a></li>
				<li><a href="javascript:void(0)" onClick="window.language='en'">English</a></li>
                </ul>
			</li>
		</ul>
	</div>-->
<br class="clear" />
<form action="processa_contato.php" method="post" id="form_processa_contato" enctype=multipart/form-data >

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
<input type="text" name="telefone1" id="inp_telefone1" class="block telefone" maxlength="14" /><br/>

<span class="sp_telefone2">Tel Celular</span>: <span style="color:#666;font-size:14px;float:right;">(XX) XXXX-XXXX</span><br/>
<input type="text" name="telefone2" id="inp_telefone2" class="block telefone" maxlength="14" /><br/>

<span class="sp_setor">Setor</span>:<br/>
<input type="text" name="setor" id="inp_setor" class="block"  /><br/>

<span class="sp_email">Email</span>:<br/>
<input type="text" name="email" id="inp_email" class="block" /><br/>

<span class="sp_tamanho">Tamanho da Camisa</span>:
<select name="tamanho" id="tamanho" style="width:170px;">
<option value="" class="sp_selecione" selected>Selecione...</option>
<option value="M" >M</option>
<option value="G" >G</option>
<option value="GG">GG</option>
</select><br/><br/>

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