$(document).ready(function(e) {
	// Transformar todos os $(.telefone) em campos de telefone
	$('.telefone').telefone();
	
	
	// FORMULÁRIO DE DOWNLOAD DO FLLECHA	http://fllecha.com.br/sistema/download
	// Quando o usuário enviar o formulário, transforma o valor dos campos de telefone em número
	$("#chronoform_formdownload").submit(function(e) {
		var telf = $('.telefone');
    	telf.val(gioplugin.telefone.decodenum(telf.val()));
		return false;
	});
});