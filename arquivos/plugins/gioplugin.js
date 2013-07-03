var gioplugin = {
	validar: {
		email: function(email){
			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			/*"*/ return re.test(email);
		},
		
		telefone: function(n){
			// Retorna true se o telefone for válido
			if(n==gioplugin.telefone.decodenum(n)){
				nlen = n.length;
				
				if((nlen==10||nlen==11) && n.indexOf('0')!==0){
					return true;
				}else if(nlen==12 && n.indexOf('0')===0){
					return true;
				}
				
			}
			return false;
		}
	},
	
	/* TELEFONE [inicio] */
	telefone: {
		encodenum: function(n){
			// Cria a máscara para o número passado
			var b=n;var c=b.length;var d=b.replace(/\D/g,'');var e=d.length;if(e<3){return svc("("+d)}else if(e<7){return svc("("+d.substr(0,2)+") "+d.substr(2));}
			else if(e<11){return svc("("+d.substr(0,2)+") "+d.substr(2,4)+"-"+d.substr(6));
			}else if(e>=11){return svc("("+d.substr(0,2)+") "+d.substr(2,5)+"-"+d.substr(7,4));}function svc(a){return a}
		},
		
		decodenum: function(n){
			// Retorna somente números
			return n.replace(/\D/g,'');
		},
		
		is_valid: function(n){
			return gioplugin.validar.telefone(n);
		}
	},
	/* TELEFONE [fim] */
	
	url: {
		get_query: function(){
			var urlParams = [];
			(function () {
				var match,
					pl     = /\+/g,  // Regex for replacing addition symbol with a space
					search = /([^&=]+)=?([^&]*)/g,
					decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
					query  = window.location.search.substring(1);
			
				while (match = search.exec(query))
				   urlParams[decode(match[1])] = decode(match[2]);
			})();
			
			return urlParams;
		}
	}
};


(function($){
	$.fn.telefone = function(){
		$el = $(this);
		$el.attr('max_length',15);
		
		$el.keyup(function(e) {
			$(this).val(gioplugin.telefone.encodenum($(this).val()));
		}).focusout(function(e) {
			txp = $(this).val().replace(/\D/g,'');
			if(!txp || txp==null || txp=="") $(this).val("");
			else $(this).val(gioplugin.telefone.encodenum($(this).val()));
		});
	};
})(jQuery)