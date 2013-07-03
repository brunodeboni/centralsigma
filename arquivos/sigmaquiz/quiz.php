<?php
if(!isset($_SESSION)) session_start();
if(isset($_POST["nome"])){
	require("./sistema/ControleGeral.php");
	$cg = new ControleGeral();
	$cg->login();
}

if(!isset($_SESSION["id"])) header("Location: index.php");
require_once("./sistema/ClassQuiz.php");
$classQuiz = new ClassQuiz();
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>SigmaQuiz - Inicio</title>
<link rel="stylesheet" href="./css/layout.css">
<script type="text/javascript" src="./js/jquery.js"></script>
<script type="text/javascript">
function parar_de_falar(){}
function falar(texto){/* * /if(typeof sayText != 'undefined') sayText(texto,5,6,2);/* */}

var quizzes_info = [];
var pergunta_atual = {};

function AtualizarPerguntas(data){
	if(!data.perguntas){alert("Erro...");return;}
	var quiz_info = data;
	pergunta_atual = {};
	var pergunta_atual_index = 0;
	quizzes_info[quiz_info.id_quiz] = quiz_info;
	
	var pl = quiz_info.perguntas.length;
	for( var i=0; i<pl; i++ ){
		if(quiz_info.perguntas[i].id_resposta==0){
			pergunta_atual = quiz_info.perguntas[i];
			pergunta_atual_index = i+1;
			break;
			}
		}
	
	if(pergunta_atual.respostas){
		var rr = pergunta_atual.respostas;
		var rl = rr.length;
		var rh = "";
		for( var i=0; i<rl; i++ ){
			rh += "<label>";
			rh += '<input type="radio" name="quiz_resposta" value="'+rr[i].id+'"> ';
			rh += rr[i].resposta;
			rh += "</label>";
			}
		}
	else{
		gotoQuiz(quiz_info.id_quiz);
		}
	
	AtualizarQuizStatus();
	
	// Falar
	//parar_de_falar();
	if(arguments[1]==true){
		falar(pergunta_atual.pergunta);
		// Atualizar os textos
		setTimeout(function(){
			$("#sq-title").html("Sigma QUIZ: "+quiz_info.nome_quiz);
			$("#quizPergunta").html("<span class=\"qpg\">Pergunta "+pergunta_atual_index+":</span> "+pergunta_atual.pergunta);
			$("#quizRespostas").html(rh);
			$("#btResponder").attr("disabled",false);
			},1);
		}
	}

function AtualizarQuizConcluido(data){
	
	}

function gotoClear(){
	$(".quiz-menu-button").removeClass("current");
	$("#quiz-container").css("display","none");
	$("#quiz-concluido-container").css("display","none");
	}

function gotoInicio(){
	pergunta_atual = {};
	gotoClear();
	$("#left-menu-button-inicio").addClass("current");
	}

function gotoQuiz(qid){
	if(!quizzes_info[qid]) return;
	gotoClear();
	
	$(".quiz-menu-button").each(function(index, element) {
		var elemattr = $(element).find(".quiz-status").attr("data-qid");
        if(elemattr && elemattr==qid) $(element).addClass("current");
		else $(element).removeClass("current");
    	});
	
	if(quizzes_info[qid].perguntas_respondidas<quizzes_info[qid].perguntas_totais){
		$("#quiz-container").css("display","block");
		AtualizarPerguntas(quizzes_info[qid],true);
		}
	else{
		$("#quiz-concluido-container").css("display","block");
		AtualizarQuizConcluido(quizzes_info[qid]);
		}
	}

function bodyAppendScript(url){
	var script   = document.createElement("script");
	script.type  = "text/javascript";
	script.src   = url;
	document.body.appendChild(script);
	document.body.removeChild(script);
	}

function addQuizInfo(qid){
	if(quizzes_info[qid]) return;
	//var newScript = $('<script type="text/javascript" src="./AjaxQuiz.php?action=pegarQuizStatus&id_quiz='+qid+'&callback=Result_addQuizInfo"><'+'/script>');
	//$("body").append(newScript);
	url = "./sistema/AjaxQuiz.php?action=pegarQuizStatus&id_quiz="+qid+"&callback=Result_addQuizInfo";
	bodyAppendScript(url);
	}

function Result_addQuizInfo(quiz_info){
	quizzes_info[quiz_info.id_quiz] = quiz_info;
	AtualizarQuizStatus();
	}

function getQuizInfo(qid){
	if(quizzes_info[qid]) return quizzes_info[qid];
	else return false;
	}

function AtualizarQuizStatus(){
	$(".quiz-status").each(function(index, element) {
        var qid = $(element).attr("data-qid");
		if(!qid) return;
		
		var qat = getQuizInfo(qid);
		if(!qat){addQuizInfo(qid);return;};
		
		var qh = "";
		if(qat.perguntas_totais<=qat.perguntas_respondidas) qh = "Concluído";
		else qh = qat.perguntas_respondidas+"/"+qat.perguntas_totais;
		$(element).html(qh);
    	});
	}

function responderPerguntaQuiz(){
	var qid = $(".quiz-menu-button.current .quiz-status").attr("data-qid");
	if(!qid) return;
	var pid = pergunta_atual.id_pergunta;
	if(!pid) return;
	var rid = $("input[name=quiz_resposta]:checked").attr("value");
	if(!rid){alert("Você deve selecionar uma resposta");return;}
	
	/* * /
	alert("qid: "+qid+"\npid: "+pid+"\nrid: "+rid);
	return;
	/* */
	
	$.ajax({type:"POST",
		url:"./sistema/AjaxQuiz.php",
		data: {action:"responderPerguntaQuiz",qid:qid,pid:pid,rid:rid},
		success: function(data){
			if(data!="1"){alert(data);return;}
			var quiz_atual = getQuizInfo(qid);
			if(!quiz_atual) return;
			var pergunta_atual_index = -1;
			for(var i=0;i<quiz_atual.perguntas.length;i++){
				if(quiz_atual.perguntas[i].id_pergunta==pid){
					pergunta_atual_index = i;
					break;
					}
				}
			if(pergunta_atual_index<0)return;
			quiz_atual.perguntas_respondidas++;
			quiz_atual.perguntas[pergunta_atual_index].id_resposta = rid;
			
			quizzes_info[qid] = quiz_atual;
			AtualizarPerguntas(quiz_atual,true);
			}
		});
	}
</script>
</head>
<body>

<div id="sq-container">
	<nav id="sq-left-bar" class="inline-block">
    	<ul>
        	<li class="quiz-menu-button current" id="left-menu-button-inicio"><a href="javascript:void(0);" onclick="gotoInicio()">Início</a></li>
            <li class="sair"><a href="logout.php">Sair</a></li>
            <?php
				$quizzes = $classQuiz->pegarListaQuizzes();
				$primeiro_quiz_id = 0;
				foreach($quizzes as $quiz_atual){
					if($primeiro_quiz_id == 0) $primeiro_quiz_id = $quiz_atual["id"];
					echo "
						<li class=\"quiz-menu-button\"><a href=\"javascript:void(0);\" onclick=\"gotoQuiz($quiz_atual[id])\">
							$quiz_atual[nome]
							<div class=\"quiz-status\" data-qid=\"$quiz_atual[id]\"></div>
						</a></li>
						";
				}
			?>
        </ul>
    </nav><!-- /#sq-left-bar --><div id="sq-main-content" class="inline-block">
    	
        <div id="quiz-container" style="display:none;padding:10px;">
    		<h1 id="sq-title"></h1><!-- /#sq-title -->
        	<div id="sq-speaker" class="inline-block">
        		<script language="JavaScript" type="text/javascript" src="https://vhss.oddcast.com/vhost_embed_functions_v2.php?acc=3077602&js=1"></script>
				<script language="JavaScript" type="text/javascript">AC_VHost_Embed(3077602,225,300,'',1,1, 2271749, 0,1,0,'58124f94904e9edb96da691f3dceacfa',9);</script>
        	</div><!-- /#sq-speaker --><div id="sq-content" class="inline-block">
            	<div style="display:block;padding:0 10px;">
					<script type="text/javascript" src="./sistema/AjaxQuiz.php?action=pegarQuizStatus&id_quiz=<?php echo $primeiro_quiz_id; ?>&callback=Result_addQuizInfo"></script>
					<div id="quizPergunta">Carregando...</div>
        	    	<div id="quizRespostas"></div>
        	    	<div id="resp-bts"><button id="btResponder" disabled onclick="responderPerguntaQuiz()">Responder</button></div>
                </div><!-- /[style] -->
        	</div><!-- /#sq-content -->
        </div><!-- /#quiz-container -->
        
        <div id="quiz-concluido-container" style="display:none;padding:10px;">
        	<br><br>Concluido!<br><br>
        </div>
        
    </div><!-- /#sq-main-content -->
</div>
</body>
</html>