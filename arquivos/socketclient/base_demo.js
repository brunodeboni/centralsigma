function __init__(){
	loopGetStatus(0);
}

function loopGetStatus(agd){
	mensagem = "AssinarModem:"+base_ajaxManager.imei;
	
	base_ajaxManager.send({msg:mensagem, agd:agd},function(data){
		if(data==""){
			// Não está conectado
			$("#modem td").removeClass("stup").addClass("stdown");
		}else{
			try{
				var jdata = $.parseJSON(data);
			}catch(err){
				var jdata = false;
			}
			
			if(typeof jdata != 'object'){
				alert("Erro ao receber resposta do modem\r\n"+data);
				$("#modem_header, .modem_porta").removeClass("stup");
				$("#modem_header, .modem_porta").addClass("stdown");
				return false;
			}
			
			$("#modem_header").removeClass("stdown");
			$("#modem_header").addClass("stup");
			var gps = jdata;
			//alert(data);return;			
			
			for(var i=1; i<=9; i++){
				var curcl = (gps[i]==1);
				if(curcl){
					$("#modem_porta_"+i).removeClass("stdown");
					$("#modem_porta_"+i).addClass("stup");
				}else{
					$("#modem_porta_"+i).removeClass("stup");
					$("#modem_porta_"+i).addClass("stdown");
				}
			}
			
			loopGetStatus(1);
		}
	});
}




var base_ajaxManager =
{
	url: "./base_ajax.php",
	imei: "355096030167182"
}


base_ajaxManager.send = function(dataobj, callback)
{
console.log("Enviando mensagem");
	$.post(base_ajaxManager.url, dataobj, function(data){
	//console.log("voltou");
		(callback)(data);
	});
}
