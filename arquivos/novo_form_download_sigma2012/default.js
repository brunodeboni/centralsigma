

function getUF(pais){
	$("#UF").css("display","inline");
	opts = "";
	if(pais=="XX"){
		$("#ufdiv").html('<input type="text" name="UF" id="UF2" style="width:305px;position:relative;left:15px;" />');
		return;
	}else{
		$("#ufdiv").html('<select name="UF" id="UF" style="width:320px;position:relative;left:15px;"></select>');
	}
	
	
	if(pais=="PT"){
		opts  = '<option value="AV">Aveiro</option>';
		opts += '<option value="BE">Beja</option>';
		opts += '<option value="BR">Braga</option>';
		opts += '<option value="BG">Bragança</option>';
		opts += '<option value="CB">Castelo Branco</option>';
		opts += '<option value="CO">Coimbra</option>';
		opts += '<option value="EV">Évora</option>';
		opts += '<option value="FA">Faro</option>';
		opts += '<option value="GU">Guarda</option>';
		opts += '<option value="LE">Leiria</option>';
		opts += '<option value="LI">Lisboa</option>';
		opts += '<option value="PA">Portalegre</option>';
		opts += '<option value="PO">Porto</option>';
		opts += '<option value="SA">Santarém</option>';
		opts += '<option value="SE">Setubal</option>';
		opts += '<option value="VC">Viana do Castelo</option>';
		opts += '<option value="VR">Vila Real</option>';
		opts += '<option value="VI">Viseu</option>';
	}else{
		opts  = '<option value="AC">Acre</option>';
		opts += '<option value="AL">Alagoas</option>';
		opts += '<option value="AP">Amapá</option>';
		opts += '<option value="AM">Amazonas</option>';
		opts += '<option value="BA">Bahia</option>';
		opts += '<option value="CE">Ceará</option>';
		opts += '<option value="DF">Distrito Federal</option>';
		opts += '<option value="ES">Espírito Santo</option>';
		opts += '<option value="GO">Goiás</option>';
		opts += '<option value="MA">Maranhão</option>';
		opts += '<option value="MT">Mato Grosso</option>';
		opts += '<option value="MS">Mato Grosso do Sul</option>';
		opts += '<option value="MG">Minas Gerais</option>';
		opts += '<option value="PA">Pará</option>';
		opts += '<option value="PB">Paraíba</option>';
		opts += '<option value="PR">Paraná</option>';
		opts += '<option value="PE">Pernambuco</option>';
		opts += '<option value="PI">Piauí</option>';
		opts += '<option value="RJ">Rio de Janeiro</option>';
		opts += '<option value="RN">Rio Grande do Norte</option>';
		opts += '<option value="RS">Rio Grande do Sul</option>';
		opts += '<option value="RO">Rondônia</option>';
		opts += '<option value="RR">Roraima</option>';
		opts += '<option value="SC">Santa Catarina</option>';
		opts += '<option value="SP">São Paulo</option>';
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
	if($("#inp_telefone").val()==""){$("#inp_telefone").focus();$("#inp_telefone").addClass("hlinput");return false;}
	if($("#pais").val()==""){$("#pais").focus();$("#pais").addClass("hlinput");return false;}
	if($("#UF").val()==""){$("#UF").focus();$("#UF").addClass("hlinput");return false;}
	if($("#UF2").val()==""){$("#UF2").focus();$("#UF2").addClass("hlinput");return false;}
	
	nn = gioplugin.telefone.decodenum( $('#inp_telefone').val() );
        if( nn ) $('#inp_telefone').val(nn);
	else{$("#inp_telefone").focus();$("#inp_telefone").addClass("hlinput");return false;}
	
	nn = gioplugin.telefone.decodenum( $('#inp_celular').val() );
        if( nn ) $('#inp_celular').val(nn);
	else{$("#inp_celular").focus();$("#inp_celular").addClass("hlinput");return false;}
	
	$("#form_download").submit();
}

function checarEmail(mail){
	if(mail.length==0) return true;
	
	if ((mail.length > 7) && !((mail.indexOf("@") < 1) || (mail.indexOf('.') < 2)))
		{return true;}
	else
		{return false;}
}


function changeLanguage(lg){
	window.language = lg;
	
	lang = new Object();
	lang.pt = {nome:"Nome Completo",email:"E-Mail",empresa:"Empresa",telefone:"Telefone",celular:"Celular",pais:"País",estado:"Estado",linguagem:"Linguagem",selecione:"Selecione..."}
	lang.en = {nome:"Full Name",email:"E-Mail",empresa:"Company",telefone:"Phone Number",celular:"Cell Phone",pais:"Country",estado:"State",linguagem:"Language",selecione:"Select..."}
	
	$(".sp_nome").html(eval("lang."+window.language+".nome"));
	$(".sp_email").html(eval("lang."+window.language+".email"));
	$(".sp_empresa").html(eval("lang."+window.language+".empresa"));
	$(".sp_telefone").html(eval("lang."+window.language+".telefone"));
	$(".sp_celular").html(eval("lang."+window.language+".celular"));
	$(".sp_pais").html(eval("lang."+window.language+".pais"));
	$(".sp_estado").html(eval("lang."+window.language+".estado"));
	$(".sp_linguagem").html(eval("lang."+window.language+".linguagem"));
	$(".sp_selecione").html(eval("lang."+window.language+".selecione"));
}

function formatFone(pais) {
	if (pais == "BR") {
		$(".telefone").mask('(99) 9999-9999?9');
	}else if (pais == "PT") {
		$(".telefone").mask('+351 (99) 999-9999?9');
	}else {
		$(".telefone").mask('?99999999999999', {placeholder: ' '});
	}
}

$(document).ready(function(e) {
	$("#pais").click(function(){getUF(this.value); formatFone(this.value);});
	window.language = "pt";
	changeLanguage(window.language);
	
	$(document).click(function(e) {
		changeLanguage(window.language);
    });
	
	$("input, select").blur(function(e) {
        if($(this).val()=="") $(this).addClass("hlinput");
		else $(this).removeClass("hlinput");
    });
	
	$(".telefone").mask('(99) 9999-9999?9');
});