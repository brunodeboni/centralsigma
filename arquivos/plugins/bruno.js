//Função que executa ação ao pressionar tecla enter em caixa de texto
$.fn.pressEnter = function(fn) {  

	return this.each(function() {  
    	$(this).bind('enterPress', fn);
        $(this).keyup(function(e) {
            if (e.keyCode == 13) {
              $(this).trigger("enterPress");
            }
        });
	});  
};