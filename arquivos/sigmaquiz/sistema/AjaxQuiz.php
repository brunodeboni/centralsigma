<?php
if(!isset($_SESSION)) session_start();
header("Content-Type: text/plain; charset=UTF-8");

if(!isset($_REQUEST["action"])) die("ERRO: Nenhuma 'action' especificada.");
require_once("ClassQuiz.php");

class AjaxQuiz
{
	private $quiz;
	
	// Construtor e Destrutor
	public function __construct(){
		$this->quiz = new ClassQuiz();
		}
	
	// Public functions
	public function pegarUsuarioQuiz(){
		if(!isset($_REQUEST["nome"],$_REQUEST["email"],$_REQUEST["celular"])) die("ERRO: Faltam dados para executar a função [pegarQuiz]");
		$dados = array(
			"nome"     => mysql_real_escape_string($_REQUEST["nome"]),
			"email"    => mysql_real_escape_string($_REQUEST["email"]),
			"celular"  => mysql_real_escape_string($_REQUEST["celular"]),
			);
		echo json_encode($this->quiz->pegarUsuarioQuiz($dados));
		}
	
	public function pegarListaQuizzes(){
		echo json_encode($this->quiz->pegarListaQuizzes());
		}
	
	public function pegarPerguntasQuiz(){
		$id_quiz          = mysql_real_escape_string($_REQUEST["id_quiz"]);
		$pegar_respostas  = isset($_REQUEST["pegar_respostas"])  ? (boolean) $_REQUEST["pegar_respostas"]  : true;
		$retorno_completo = isset($_REQUEST["retorno_completo"]) ? (boolean) $_REQUEST["retorno_completo"] : false;
		echo json_encode($this->quiz->pegarPerguntasQuiz($id_quiz,$pegar_respostas,$retorno_completo));
		}
	
	public function responderPerguntaQuiz(){
		$usuario  = $_SESSION["id"];
		$quiz     = mysql_real_escape_string($_REQUEST["qid"]);
		$pergunta = mysql_real_escape_string($_REQUEST["pid"]);
		$resposta = mysql_real_escape_string($_REQUEST["rid"]);
		
		$resp = $this->quiz->responderPerguntaQuiz($usuario,$quiz,$pergunta,$resposta);
		if(!$resp) die("ERRO: Houve um erro ao inserir o registro");
		die("1");
		}
	
	public function pegarQuizStatus(){
		$id_quiz = mysql_real_escape_string($_REQUEST["id_quiz"]);
		$retorno = $this->quiz->pegarQuizStatus($id_quiz);
		echo json_encode($retorno);
		}
	
	// FUNÇÕES PARA USO DE ADMINISTRADORES
	public function atualizarPergunta(){
		$pergunta_id  = $_REQUEST["pid"];
		$pergunta_txt = $_REQUEST["ptxt"];
		
		$retorno = $this->quiz->atualizarPergunta($pergunta_id,$pergunta_txt);
		if($retorno) die("1");
		else         die("0");
		}
	
	public function atualizarRespostas(){
		$pergunta_id  = $_REQUEST["pid"];
		$respostas    = is_string($_REQUEST["respostas"])?$_REQUEST["respostas"]:json_encode($_REQUEST["respostas"]);
		
		$retorno = $this->quiz->atualizarRespostas($pergunta_id,$respostas);
		if($retorno) die("1");
		else die("0");
		}
	
	public function adicionarNovaPergunta(){
		$id_quiz     = $_REQUEST["qid"];
		$pergunta    = $_REQUEST["pergunta"];
		$respostas   = is_string($_REQUEST["respostas"])?$_REQUEST["respostas"]:json_encode($_REQUEST["respostas"]);
		
		$retorno = $this->quiz->adicionarNovaPergunta($id_quiz,$pergunta,$respostas);
		if($retorno===true) die("1");
		else die($retorno);
		}
	
	public function deletarPergunta(){
		$id_pergunta = $_REQUEST["pid"];
		$this->quiz->deletarPergunta($id_pergunta);
		die("1");
		}
	
	public function editarNomeQuiz(){
		$id_quiz   = $_REQUEST["qid"];
		$novo_nome = $_REQUEST["qnome"];
		$this->quiz->editarNomeQuiz($id_quiz,$novo_nome);
		die("1");
		}
	
	public function deletarQuiz(){
		$id_quiz = $_REQUEST["qid"];
		$this->quiz->deletarQuiz($id_quiz);
		die("1");
		}
	
	public function adicionarQuiz(){
		$nome = $_REQUEST["qnome"];
		$this->quiz->adicionarQuiz($nome);
		}
}




$metodo = $_REQUEST["action"];
$AjaxQuiz = new AjaxQuiz();
if(method_exists($AjaxQuiz,$metodo))
{
	if(isset($_REQUEST["callback"])) header("Content-Type: text/javascript; charset=UTF-8");
	if(isset($_REQUEST["callback"])) echo "$_REQUEST[callback](";
	$AjaxQuiz->$metodo();
	if(isset($_REQUEST["callback"])) echo ");";
}
unset($AjaxQuiz);