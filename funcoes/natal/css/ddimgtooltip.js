/* Image w/ description tooltip v2.0
* Created: April 23rd, 2010. This notice must stay intact for usage 
* Author: Dynamic Drive at http://www.dynamicdrive.com/
* Visit http://www.dynamicdrive.com/ for full source code
*/


var ddimgtooltip={

	tiparray:function(){
		var tooltips=[]
		//define each tooltip below: tooltip[inc]=['path_to_image', 'optional desc', optional_CSS_object]
		//For desc parameter, backslash any special characters inside your text such as apotrophes ('). Example: "I\'m the king of the world"
		//For CSS object, follow the syntax: {property1:"cssvalue1", property2:"cssvalue2", etc}

		
		tooltips[0]=["img/0.png", "Rogerio Saldanha <br/> Ferreira International - RJ", {background:"white", font:"bold 12px Arial"}]
		tooltips[1]=["img/1.png", "Adriano Moreira<br/> Marfrig - SP", {background:"white", font:"bold 12px Arial"}]
		tooltips[2]=["img/2.png", "Andr\u00E9 Ismael <br/> Cooperativa Pia - RS", {background:"white", font:"bold 12px Arial"}]
		tooltips[3]=["img/3.png", "Eduardo Aguiar <br/> Celupa Mellita - RS", {background:"white", font:"bold 12px Arial"}]
		tooltips[4]=["img/4.png", "Andr\u00E9 Rodrigues <br/> Mextra Eng. Extrat. Metais - SP", {background:"white", font:"bold 12px Arial"}]
		tooltips[5]=["img/5.png", "Jefferson Tameir\u00E3o <br/> Coats Correntes - SP", {background:"white", font:"bold 12px Arial"}]
		tooltips[6]=["img/6.png", "Elias Domingos <br/> TV Gazeta - ES", {background:"white", font:"bold 12px Arial"}]
		tooltips[7]=["img/7.png", "Josu\u00E9 <br/> Caet\u00E9 Embalagens - RS", {background:"white", font:"bold 12px Arial"}]
		tooltips[8]=["img/8.png", "Otto Beck <br/> Irwin Tools - RS", {background:"white", font:"bold 12px Arial"}]
		tooltips[9]=["img/9.png", "Michel Castro <br/> Cellsoft - RJ", {background:"white", font:"bold 12px Arial"}]
		tooltips[10]=["img/10.png", "Vanesca Borges <br/> Refinaria Riograndense - RS", {background:"white", font:"bold 12px Arial"}]
		tooltips[11]=["img/11.png", "Abrah\u00E3o Lima <br/> Diretor Rede Industrial <br/> <font size= '1'>Mensagem:<br/> Colegas, mais um ano se passa e com ele <br/>o sentimento de dever cumprido. <br/>Agrade\u00E7o \u00E0 Deus por fazer parte, com voc\u00EAs,<br/> desta miss\u00E3o de gerar prosperidade ,  riqueza e paz <br/>para homens e mulheres ligados \u00E0 Rede Industrial. <br/>Feliz Natal a todos , Paz e sucesso na Fam\u00EDlia!</font>", {background:"white", font:"bold 12px Arial"}]
		tooltips[12]=["img/12.png", "Davi Utzig<br/> Analista de Suporte SIGMA - RS <br/> <font size= '1'>Mensagem:<br/> Feliz Natal e um Pr\u00F3spero Ano Novo a todos! Boas Festas!</font>", {background:"white", font:"bold 12px Arial"}]
		tooltips[13]=["img/13.png", "Josias Boone <br/> Analista de Suporte SIGMA - RS<br/> <font size= '1'>Mensagem:<br/>Um Feliz Natal e uma Ano Novo repleto de novas conquistas<br/> a todos os Planejadores de Manuten\u00E7\u00E3o</font> ", {background:"white", font:"bold 12px Arial"}]
		tooltips[14]=["img/14.png", "Aline Mariel Arend <br/> Setor Comercial SIGMA", {background:"white", font:"bold 12px Arial"}]
		tooltips[15]=["img/15.png", "Ederson <br/> Minera\u00E7\u00E3o Jundu - SP", {background:"white", font:"bold 12px Arial"}]
		tooltips[16]=["img/16.png", "Anderson Sch\u00F6n <br/> Minera\u00E7\u00E3o Montividiu - GO", {background:"white", font:"bold 12px Arial"}]
		tooltips[17]=["img/17.png", "Samuel Pereira da Concei\u00E7\u00E3o<br/> Marfrig Promiss\u00E3o II - SP", {background:"white", font:"bold 12px Arial"}]
		tooltips[18]=["img/18.png", "Ricardo Azevedo<br/> Marfrig Bataguassu - MS", {background:"white", font:"bold 12px Arial"}]
		tooltips[19]=["img/19.png", "Geraldo Gomes<br/> Ourolac - GO", {background:"white", font:"bold 12px Arial"}]
		tooltips[20]=["img/20.png", "Rafael Lima <br/> Traterra Terraplanagem - PA", {background:"white", font:"bold 12px Arial"}]
		tooltips[21]=["img/21.png", "Edson Pinheiro <br/> SENAI - ES", {background:"white", font:"bold 12px Arial"}]
		tooltips[22]=["img/22.png", "Samuel Amorin Junior <br/> AGV Log\u00EDstica - SP", {background:"white", font:"bold 12px Arial"}]
		tooltips[23]=["img/23.png", "Matheus Mendes Neves <br/> Videplast - GO", {background:"white", font:"bold 12px Arial"}]
		tooltips[24]=["img/24.png", "Douglas G. Mantuan <br/> Durancho - PE", {background:"white", font:"bold 12px Arial"}]
		tooltips[25]=["img/25.png", "Ademir Teixeira<br/> Proativa Manuten\u00E7\u00E3o - SP<br/> <font size= '1'>Mensagem:<br/>Que todos aqueles que buscam a \u00E9tica e a honestidade<br/> em tudo o que faz, tenha a satisfa\u00E7\u00E3o de comemorar<br/> um lindo Natal e grandes conquistas<br/> para o ano de 2013.</font>", {background:"white", font:"bold 12px Arial"}]
		tooltips[26]=["img/26.png", "Luciano Sussumu Takahashi <br/> Alujet Industrial e Comercial Ltda- SP <br/> <font size= '1'>Mensagem:<br/> Mais um ano estamos terminando, <br/>\u00E9 um desejo de meu cora\u00E7\u00E3o <br/>que a paz do Natal reine em cada cora\u00E7\u00E3o. <br/>O Natal significa nascimento, ent\u00E3o <br/>que o aniversariante Jesus esteja em cada <br/>mente e cora\u00E7\u00E3o. Feliz Natal! </font>", {background:"white", font:"bold 12px Arial"}]
		tooltips[27]=["img/27.png", "Robson Pereira Feitosa <br/> Engefort Obras e Terraplanagem - MG <br/> <font size= '1'>Mensagem:<br/>Feliz Natal a todos e que possamos<br/>compartilhar momentos e conhecimentos.</font>", {background:"white", font:"bold 12px Arial"}]
		tooltips[28]=["img/28.png", "Carlos Henrique da concei\u00E7\u00E3o Seabra <br/>SENAI - PA", {background:"white", font:"bold 12px Arial"}]
		tooltips[29]=["img/29.png", "Davi Elias P. Filho<br/>Traterra - PA <br/> <font size= '1'>Mensagem:<br/>Natal \u00E9 o salvador dizendo a cada<br/> um de n\u00F3s, amai-vos um aos<br/> outros como eu voz amei, neste tempo de <br/>confraterniza\u00E7\u00E3o a TRATERRA<br/> deseja a todos um FELIZ NATAL e um ano novo <br/>cheio de realiza\u00E7\u00F5es e prosperidade.</font>", {background:"white", font:"bold 12px Arial"}]
		tooltips[30]=["img/30.png", "Esio Vargas<br/>Integral Automo\u00E7\u00E3o - RN <br/> <font size= '1'>Mensagem:<br/>Desejo a todos um natal muito feliz<br/> e que o motivo do <br/>natal seja lembrar<br/> aquele que viveu e morreu<br/> por um prop\u00F3sito.Que tenhamos<br/> tamb\u00E9m uma vida com prop&oacute;sito.</font>", {background:"white", font:"bold 12px Arial"}]
		tooltips[31]=["img/31.png", "Nelson Barbosa Filho<br/>Igarass\u00FA - PE<br/><font size= '1'>Mensagem:<br/>Feliz Natal e um ano repleto de realiza\u00E7\u00F5es", {background:"white", font:"bold 12px Arial"}]
		tooltips[32]=["img/32.png", "Tarc\u00EDsio de Lima<br/>Serra - MT<br/><font size= '1'>Mensagem:<br/>Natal \u00E9 tempo de solidariedade.<br/> Tempo de relembrar o nascimento Deste que <br/>nasceu ha mais de dois mil anos,<br/> e \u00E9 lembrado em todos os cantos do mundo.<br/>Tempo de amar como Jesus amou. E Ele amou<br/> de tal forma, que deu<br/> sua pr\u00F3pria vida por n\u00F3s.", {background:"white", font:"bold 12px Arial"}]
		tooltips[33]=["img/33.png", "JEFFERSON Alexandre da Silva <br/>Santa Rita - PB <br/><font size= '1'>Mensagem:<br/>	Um bom natal e um ano novo <br/>de muitas b\u00EAn\u00E7\u00E3os a todos.", {background:"white", font:"bold 12px Arial"}]
		tooltips[34]=["img/34.png", "Paulo Evandro<br/>Campinas - SP<br/><font size= '1'>Mensagem:<br/>	Gostaria de agradecer ao pessoal<br/> do Sigma por nos proporcionar mais essa parceria,<br/> e aproveito para desejar a todos um Feliz Natal<br/> e um Pr\u00F3Ano Novo. Grande abra\u00E7o e obrigado!<br/>", {background:"white", font:"bold 12px Arial"}]
		tooltips[35]=["img/35.png", "Miguel Eduardo Berger de Almeida<br/>Tel\u00EAmaco Borba - PR<br/><font size= '1'>Mensagem:<br/>Que neste Natal que se aproxima , Deus<br/> conceda a todos sentirem nascer a ESPERAN\u00C7A<br/> no cora\u00E7\u00E3o , para que 2013 seja<br/> um ano de Paz , Conquistas e Prosperidade !!!!!!!", {background:"white", font:"bold 12px Arial"}]
		tooltips[36]=["img/36.png", "M&aacute;rcio de Oliveira Piedade<br/>Hospital Escola de Itajub&aacute; - MG<br/><font size= '1'>Mensagem:<br/>Desejo a todos os usu&aacute;rios e representantes do SIGMA,<br> um feliz 2013, cheio de boas oportunidades e sucesso!", {background:"white", font:"bold 12px Arial"}]
		tooltips[37]=["img/37.png", "Pedro Igor do Nascimento Rodrigues<br/>Mextra Engenharia Extrativa de Metais Ltda. - SP<br/><font size= '1'>Mensagem:<br/>Feliz Natal", {background:"white", font:"bold 12px Arial"}]
                
                return tooltips //do not remove/change this line
	}(),

	tooltipoffsets: [20, -30], //additional x and y offset from mouse cursor for tooltips

	//***** NO NEED TO EDIT BEYOND HERE

	tipprefix: 'imgtip', //tooltip ID prefixes

	createtip:function($, tipid, tipinfo){
		if ($('#'+tipid).length==0){ //if this tooltip doesn't exist yet
			return $('<div id="' + tipid + '" class="ddimgtooltip" />').html(
				'<div style="text-align:center"><img src="' + tipinfo[0] + '" /></div>'
				+ ((tipinfo[1])? '<div style="text-align:left; margin-top:5px">'+tipinfo[1]+'</div>' : '')
				)
			.css(tipinfo[2] || {})
			.appendTo(document.body)
		}
		return null
	},

	positiontooltip:function($, $tooltip, e){
		var x=e.pageX+this.tooltipoffsets[0], y=e.pageY+this.tooltipoffsets[1]
		var tipw=$tooltip.outerWidth(), tiph=$tooltip.outerHeight(), 
		x=(x+tipw>$(document).scrollLeft()+$(window).width())? x-tipw-(ddimgtooltip.tooltipoffsets[0]*2) : x
		y=(y+tiph>$(document).scrollTop()+$(window).height())? $(document).scrollTop()+$(window).height()-tiph-10 : y
		$tooltip.css({left:x, top:y})
	},
	
	showbox:function($, $tooltip, e){
		$tooltip.show()
		this.positiontooltip($, $tooltip, e)
	},

	hidebox:function($, $tooltip){
		$tooltip.hide()
	},


	init:function(targetselector){
		jQuery(document).ready(function($){
			var tiparray=ddimgtooltip.tiparray
			var $targets=$(targetselector)
			if ($targets.length==0)
				return
			var tipids=[]
			$targets.each(function(){
				var $target=$(this)
				$target.attr('rel').match(/\[(\d+)\]/) //match d of attribute rel="imgtip[d]"
				var tipsuffix=parseInt(RegExp.$1) //get d as integer
				var tipid=this._tipid=ddimgtooltip.tipprefix+tipsuffix //construct this tip's ID value and remember it
				var $tooltip=ddimgtooltip.createtip($, tipid, tiparray[tipsuffix])
				$target.mouseenter(function(e){
					var $tooltip=$("#"+this._tipid)
					ddimgtooltip.showbox($, $tooltip, e)
				})
				$target.mouseleave(function(e){
					var $tooltip=$("#"+this._tipid)
					ddimgtooltip.hidebox($, $tooltip)
				})
				$target.mousemove(function(e){
					var $tooltip=$("#"+this._tipid)
					ddimgtooltip.positiontooltip($, $tooltip, e)
				})
				if ($tooltip){ //add mouseenter to this tooltip (only if event hasn't already been added)
					$tooltip.mouseenter(function(){
						ddimgtooltip.hidebox($, $(this))
					})
				}
			})

		}) //end dom ready
	}
}

//ddimgtooltip.init("targetElementSelector")
ddimgtooltip.init("*[rel^=imgtip]")