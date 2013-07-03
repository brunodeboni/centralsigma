<?php
if(!isset($_SESSION)) session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>SigmaQuiz</title>
<link rel="stylesheet" href="./css/layout.css">
<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(e) {
    init();
});

// JSON stringfy
JSON.stringify=JSON.stringify||function(obj){var t=typeof(obj);if(t!="object"||obj===null){
if(t=="string")obj='"'+obj+'"';return String(obj);}else{var n,v,json=[],arr=(obj&&obj.constructor==Array);
for(n in obj){v=obj[n];t=typeof(v);if(t=="string")v='"'+v+'"';else if(t=="object"&&v!== null)v=JSON.stringify(v);
json.push((arr?"":'"'+n+'":')+String(v));}return(arr?"[":"{")+String(json)+(arr?"]":"}");}};
// fim

ajax_url = "./sistema/AjaxQuiz.php";
quiz_info = {id_quiz:0,perguntas:[]};

function init(){
	$.ajax({type:"GET",
		url:     ajax_url,
		data:    {action:"pegarListaQuizzes"},
		success: function(data){
			data = $.parseJSON(data);
			var html = "";
			for(var i=0; i<data.length; i++){
				html += '<li class="quiz-menu-button" id="quiz-left-menu-item-'+data[i].id+'" data-qid="'+data[i].id+'" data-qnome="'+data[i].nome+'">';
				html += '<a href="javascript:void(0);" onclick="openQuiz('+data[i].id+')">';
				html += data[i].id+" - "+data[i].nome.substr(0,10);
				html += '</a></li>';
				$("#sq-left-bar ul").append(html);
				html="";
				}
			}
		});
	}

function openQuiz(qid){
	focusMenuAtual(qid);
	$("#lista-perguntas").html("<li>Carregando...</li>");
	
	$.ajax({type:"GET",
		url:     ajax_url,
		data:    {action:"pegarPerguntasQuiz", id_quiz:qid, pegar_respostas:1, retorno_completo:0},
		success: function(data){
			data = $.parseJSON(data);
			quiz_info.id_quiz   = qid;
			quiz_info.perguntas = data;
			cancelarEdicao();
			
			var html = "";
			$("#lista-perguntas").html("");
			for(i=0; i<data.length; i++){
				html += '<li class="qpergunta" id="li-lp-prg-id-'+data[i].id_pergunta+'" ';
				html += 'onclick="editarPergunta('+i+','+data[i].id_pergunta+',$(\'#lp-prg-id-'+data[i].id_pergunta+'\').html())">';
				html += (i+1)+' - <span id="lp-prg-id-'+data[i].id_pergunta+'">'+data[i].pergunta+'</span>';
				html += '</li>';
				$("#lista-perguntas").append(html);
				html = '';
				}
			}
		});
	}


function focusMenuAtual(qid){
	clearFocusMenu();
	$(".quiz-menu-button[data-qid="+qid+"]").addClass("current");
	}

function clearFocusMenu(){
	$(".quiz-menu-button").removeClass("current");
	}


function focusPerguntaAtual(pid){
	clearFocusPergunta();
	$("#li-lp-prg-id-"+pid).addClass("selected");
	}
function clearFocusPergunta(){
	$("#eb-pergunta_id").html("");
	$(".qpergunta").removeClass("selected");
	}

function editarPergunta(pidx, pid, pdef){
	cancelarEdicao();
	focusPerguntaAtual(pid);
	$(".eb-bts").attr("disabled",false);
	$("#eb-pergunta_txt").attr("disabled",false);
	$("#eb-pergunta_id").html(pid);
	$("#eb-pergunta_index").html(pidx+1);
	$("#eb-pergunta_txt").val(pdef);
	}

function editarRespostas(){
	$(".eb-bts").attr("disabled",true);
	$("#eb-pergunta_txt").attr("disabled",true);
	$("#eb-respostas-container").slideDown();
	
	var pidx = parseInt($("#eb-pergunta_index").html())-1;
	var resp = quiz_info.perguntas[pidx].respostas;
	for(var i=0; i<4; i++){
		$("#eb-resposta-txt-"+(i+1)).val(resp[i].resposta);
		if(resp[i].correta==1) $("#eb-resposta-radio-"+(i+1)).attr("checked",true);
		
		$("#eb-resposta-txt-"+(i+1)).attr("data-default",resp[i].resposta);
		$("#eb-resposta-txt-"+(i+1)).attr("data-rid",resp[i].id);
		}
	
	}

function cancelarRespostas(){
	$(".eb-bts").attr("disabled",false);
	$("#eb-pergunta_txt").attr("disabled",false);
	$("#eb-respostas-container").slideUp();
	$(".eb-resposta-txt").val("");
	}

function cancelarEdicao(){
	clearFocusPergunta();
	cancelarRespostas();
	$(".eb-bts").attr("disabled",true);
	$("#eb-pergunta_txt").attr("disabled",true);
	$("#eb-pergunta_id").html("");
	$("#eb-pergunta_index").html("0");
	$("#eb-pergunta_txt").val("");
	//$("#eb-respostas-container").css("display","none");
	$("#eb-respostas-container").slideUp();
	$(".eb-resposta-txt").val("");
	}

function salvarPergunta(){
	pid  = $("#eb-pergunta_id").html();
	pidx = $("#eb-pergunta_index").html();
	ptxt = $("#eb-pergunta_txt").val();
	
	$("#eb-salvar").attr("disabled",true);
	$.ajax({type:"GET",
		url:     ajax_url,
		data:    {action:"atualizarPergunta", pid:pid, ptxt:ptxt},
		success: function(data){
			if(data=="1"){
				//alert("ptxt: "+ptxt);
				alert("Pergunta alterada");
				}
			else alert("Erro ao alterar pergunta");
			
			//alert(quiz_info.id_quiz+"");
			$("#lp-prg-id-"+pid).html(ptxt);
			return;
			},
		complete: function(data){$("#eb-salvar").attr("disabled",false);}
		});
	setTimeout(function(){cancelarEdicao();},100);
	}

function salvarRespostas(){
	var pid  = $("#eb-pergunta_id").html();
	var pidx = parseInt($("#eb-pergunta_index").html())-1;
	var respostas = [];
	for(var i=0; i<4; i++){
		respostas[i] = {};
		respostas[i].id       = $("#eb-resposta-txt-"+(i+1)).attr("data-rid");
		respostas[i].correta  = $("#eb-resposta-radio-"+(i+1)).attr("checked")?1:0;
		respostas[i].resposta = $("#eb-resposta-txt-"+(i+1)).val();
		}
	//respostas_string = JSON.stringify(respostas);
	
	$("#bt-resposta-salvar").attr("disabled",true);
	$.ajax({type:"POST",
		url:     ajax_url,
		data:    {action:"atualizarRespostas", pid:pid, respostas:respostas},
		success: function(data){
			if(data!="1"){
				alert("Erro: "+data);
				return;
				}
			
			for(i=0; i<4; i++){
				quiz_info.perguntas[pidx].respostas[i].correta  = respostas[i].correta;
				quiz_info.perguntas[pidx].respostas[i].resposta = respostas[i].resposta;
				}
			alert("Respostas editadas com sucesso!");
			cancelarRespostas();
			},
		complete: function(){$("#bt-resposta-salvar").attr("disabled",false);}
		});
	}


function setMode_adicionar(){
	$("#editbar").slideUp();
	$("#addbar").slideDown();
	}

function setMode_editar(){
	$("#editbar").slideDown();
	$("#addbar").slideUp();
	}


function salvarAddPergunta(){
	var qid      = quiz_info.id_quiz;
	if(!qid){
		alert("Você precisa selecionar um Quiz para adicionar a pergunta");
		return;
		}
	var pergunta = $("#ab-pergunta_txt").val();
	if(pergunta==""){
		alert("Você deve digitar uma pergunta para adicionar");
		return;
		}
	
	respostas = [];
	resposta_certa = -1;
	for(var i=0; i<4; i++){
		eidx = i+1;
		respostas[i] = {};
		if($("#ab-resposta-txt-"+eidx).val()==""){
			alert("Você deve preencher todas as respostas para salvar uma pergunta");
			return;
			}
		respostas[i].resposta = $("#ab-resposta-txt-"+eidx).val();
		if($("#ab-resposta-radio-"+eidx).attr("checked")){
			respostas[i].correta = 1;
			resposta_certa = i;
			}
		else{
			respostas[i].correta = 0;
			}
		}
	
	if(resposta_certa<0){
		alert("Você deve marcar uma das respostas como certa");
		return;
		}
	
	//respostas = JSON.stringify(respostas);
	$("#ab-salvar").attr("disabled",true);
	$.ajax({type:"POST",
		url: ajax_url,
		data: {action:"adicionarNovaPergunta", qid:qid, pergunta:pergunta, respostas:respostas},
		success: function(data){
			if(data!="1"){
				alert("Houve um erro no sistema e não foi possível salvar sua pergunta\r\nErro: "+data);
				return;
				}
			alert("Sua pergunta foi salva com sucesso!");
			clearAddPergunta();
			setMode_editar();
			openQuiz(qid);
			return;
			},
		complete: function(){
			$("#ab-salvar").attr("disabled",false);
			}
		});
	}

function deletarPerguntaAtual(){
	if(!confirm("Tem certeza de que você deseja apagar a pergunta selecionada?")) return;
	
	pid = $("#eb-pergunta_id").html();
	if(!pid || pid==""){
		alert("Você deve selecionar uma pergunta para deletar");
		return;
		}
	
	$("#bt-resposta-deletar").attr("disabled",true);
	$("#bt-resposta-cancelar").attr("disabled",true);
	$("#bt-resposta-salvar").attr("disabled",true);
	$("#bt-add-pergunta").attr("disabled",true);
	
	$.ajax({type:"POST",
		url: ajax_url,
		data: {action:"deletarPergunta", pid:pid},
		success: function(data){
			alert("Pergunta deletada com sucesso!");
			qid = quiz_info.id_quiz;
			cancelarEdicao();
			openQuiz(qid);
			return;
			},
		complete: function (){
			$("#bt-resposta-deletar").attr("disabled",false);
			$("#bt-resposta-cancelar").attr("disabled",false);
			$("#bt-resposta-salvar").attr("disabled",false);
			$("#bt-add-pergunta").attr("disabled",false);
			}
		});
	}

function clearAddPergunta(){
	$("#ab-pergunta_txt").val("");
	$(".ab-resposta-txt").val("");
	}

function editarNomeQuiz(){
	qid = quiz_info.id_quiz;
	if(!qid || qid==""){
		alert("Erro, você deve selecionar um quiz para editar");
		return;
		}
	
	qnome = $('#quiz-left-menu-item-'+qid).attr("data-qnome");
	if(!qnome || qnome==""){
		alert("Erro");
		return;
		}
	
	var novo_nome = prompt("Digite o novo nome para o quiz",qnome);
	if(!novo_nome || novo_nome=="") return;
	
	$.ajax({type:"POST",
		url: ajax_url,
		data: {action:"editarNomeQuiz", qid:qid, qnome:novo_nome},
		success: function(data){
			alert("Nome editado com sucesso");
			document.location = document.location;
			}
		});
	}

function deletarQuiz(){
	qid = quiz_info.id_quiz;
	if(!qid || qid==""){
		alert("Erro, você deve selecionar um quiz para editar");
		return;
		}
	
	cm  = "TEM CERTEZA DE QUE DESEJA DELETAR O QUIZ?\r\n*** ATENÇÃO *** Não é possível desfazer esta operação ";
	cm += "e todas as perguntas e respostas de usuários relativos a este quiz também serão deletadas";
	if(!confirm(cm)) return;
	
	$.ajax({type:"POST",
		url: ajax_url,
		data: {action:"deletarQuiz", qid:qid},
		success: function(data){
			if(data=="1") alert("Quiz deletado com sucesso");
			else alert("ERRO: "+data);
			document.location = document.location;
			}
		});
	}

function adicionarQuiz(){
	novo_nome = prompt("Digite o nome que deseja dar para o novo Quiz","");
	if(!novo_nome || novo_nome=="") return;
	
	$.ajax({type:"POST",
		url: ajax_url,
		data: {action:"adicionarQuiz", qnome:novo_nome},
		success: function(data){
			alert("Quiz criado com sucesso");
			document.location = document.location;
			}
		});
	}
</script>
<style type="text/css">
.pedicao{display:block;padding:5px;border:1px solid #BBB;background:#F0F0F0;margin-bottom:5px;}
	.eb-title{display:block;font-weight:bold;border-bottom:1px solid #CCC;}
	#eb-pergunta_id{display:none;}
	.pergunta-input{width:500px;padding:3px;}
	.eb-bts,.btdef{padding:5px;cursor:pointer;}
.qpergunta{
	display:block;
	list-style:none;
	padding:5px;
	font-weight:bold;
	font-size:12px;
	cursor:pointer;
}
	.qpergunta:hover{background:#EEF;}
	.qpergunta.selected{background:#DDF;}


#eb-respostas-container{
	display:none;
	margin-top:5px;
	padding:5px;
}
	.eb-resposta{
		margin:10px 0;
	}
	.eb-coluna{
		display:inline-block;
		vertical-align:top;
		width:380px;
	}
		.eb-resposta textarea{
			width:350px;
		}
	#eb-respostas-bts button{
		padding:1px 7px;
		cursor:pointer;
	}

#addbar{display:none;}


#perguntas-container{
	display:block;
	position:relative;
	min-height:400px;
}


#deletebar{
	margin:5px;
	margin-top:60px;
}

.clear{clear:both;}
</style>
</head>
<body>

<div id="sq-container">
	<nav id="sq-left-bar" class="inline-block">
    	<ul>
        	<!--<li class="current"><a href="index.php">Início</a></li>-->
        </ul>
    </nav><!-- /#sq-left-bar --><div id="sq-main-content" class="inline-block" style="min-height:auto;"><div style="display:block;padding:10px;">
    	<div id="perguntas-container">
        	<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
        	<!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
            <div id="editbar" class="pedicao">
            	<div id="eb-title" class="eb-title">
                	Edição de perguntas do quiz: <span id="eb-id_quiz"></span>
                	<button class="btdef" id="bt-add-pergunta" onclick="setMode_adicionar()" style="float:right;">Adicionar Pergunta</button>
                    <hr class="clear">
                </div><!-- /#eb-title -->
                
                <span id="eb-pergunta_id"></span>
                Pergunta <span id="eb-pergunta_index">0</span>: <input type="text" id="eb-pergunta_txt" class="pergunta-input" disabled>
                <button class="eb-bts" id="eb-salvar" onclick="salvarPergunta()" disabled>Salvar</button>
                <button class="eb-bts" id="eb-cancelar" onclick="cancelarEdicao()" disabled>Cancelar</button>
                <button class="eb-bts" id="eb-mais" onclick="editarRespostas()" disabled>Mais &nabla;</button>
                
                <div id="eb-respostas-container">
                	<div class="eb-title" style="margin-bottom:5px;">
                    	Edição de respostas
                        <span id="eb-respostas-bts">
                        <button class="bt-resposta" id="bt-resposta-salvar" onclick="salvarRespostas()"><strong>Salvar</strong></button>
                        <button class="bt-resposta" id="bt-resposta-cancelar" onclick="cancelarRespostas()">cancelar</button>
                        <button class="bt-resposta" id="bt-resposta-deletar" onclick="deletarPerguntaAtual()" style="float:right;"><strong>Deletar pergunta</strong></button>
                        </span>
                    </div><!-- /.eb-title -->
                	<div class="eb-coluna">
                    	<div class="eb-resposta">
                		<input type="radio" name="eb-resposta" id="eb-resposta-radio-1">
                    	<textarea class="eb-resposta-txt" id="eb-resposta-txt-1"></textarea>
                        </div>
                        
                        <div class="eb-resposta">
                		<input type="radio" name="eb-resposta" id="eb-resposta-radio-2">
                    	<textarea class="eb-resposta-txt" id="eb-resposta-txt-2"></textarea>
                        </div>
                    </div><!-- /.eb-coluna -->
                    
                    <div class="eb-coluna">
                    	<div class="eb-resposta">
                		<input type="radio" name="eb-resposta" id="eb-resposta-radio-3">
                    	<textarea class="eb-resposta-txt" id="eb-resposta-txt-3"></textarea>
                        </div>
                        
                        <div class="eb-resposta">
                		<input type="radio" name="eb-resposta" id="eb-resposta-radio-4">
                    	<textarea class="eb-resposta-txt" id="eb-resposta-txt-4"></textarea>
                        </div>
                    </div><!-- /.eb-coluna -->
                </div><!-- /#eb-respostas-container -->
            </div><!-- /#editbar -->
            <!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
            <!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
            <div id="addbar" class="pedicao">
            	<div id="ab-title" class="eb-title">
                	ADICIONAR PERGUNTA ao Quiz:
                	<button class="btdef" id="ab-salvar"   onclick="salvarAddPergunta()">Salvar</button>
                	<button class="btdef" id="ab-cancelar" onclick="setMode_editar()">Cancelar</button>
                </div>
                Pergunta: <input type="text" id="ab-pergunta_txt" class="pergunta-input">
                
                <div id="ab-respostas-container">
                    <div class="eb-coluna">
                        <div class="eb-resposta">
                        <input type="radio" name="ab-resposta" id="ab-resposta-radio-1">
                        <textarea class="ab-resposta-txt" id="ab-resposta-txt-1"></textarea>
                        </div><!-- /.eb-resposta -->
                        
                        <div class="eb-resposta">
                        <input type="radio" name="ab-resposta" id="ab-resposta-radio-2">
                        <textarea class="ab-resposta-txt" id="ab-resposta-txt-2"></textarea>
                        </div><!-- /.eb-resposta -->
                    </div><!-- /.eb-coluna -->
                    
                    <div class="eb-coluna">
                        <div class="eb-resposta">
                        <input type="radio" name="ab-resposta" id="ab-resposta-radio-3">
                        <textarea class="ab-resposta-txt" id="ab-resposta-txt-3"></textarea>
                        </div><!-- /.eb-resposta -->
                        
                        <div class="eb-resposta">
                        <input type="radio" name="ab-resposta" id="ab-resposta-radio-4">
                        <textarea class="ab-resposta-txt" id="ab-resposta-txt-4"></textarea>
                        </div><!-- /.eb-resposta -->
                    </div><!-- /.eb-coluna -->
                </div><!-- /#ab-respostas-container -->
                
            </div><!-- /#addbar -->
            <!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
            <!-- xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
            
            <div id="lista-perguntas"></div><!-- /#lista-perguntas -->
            
            
            <div id="deletebar">
            <a href="javascript:void(0);" onclick="adicionarQuiz()">Adicionar Quiz</a> |
            <a href="javascript:void(0);" onclick="deletarQuiz()">DELETAR Quiz</a> |
            <a href="javascript:void(0);" onclick="editarNomeQuiz()">Editar nome do Quiz</a>
            </div><!-- /#deletebar -->
        </div><!-- /#perguntas-container -->
    </div><!-- [style] --></div><!-- /#sq-main-content -->
</div>

</body>
</html>