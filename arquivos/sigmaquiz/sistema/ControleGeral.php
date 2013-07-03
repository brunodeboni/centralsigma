<?php
if(!isset($_SESSION)) session_start();
require_once("Conexao.php");
require_once("ClassQuiz.php");

class ControleGeral
{
	private $ClassConexao, $ClassQuiz, $mysql;
	
	// Construtor e Destrutor:
	public function __construct(){
		$this->ClassConexao = new Conexao();
		$this->ClassQuiz    = new ClassQuiz();
		$this->mysql        = $this->ClassConexao->conectar();
		}
	
	public function __destruct(){
		unset($this->ClassQuiz);
		unset($this->ClassConexao);
		@mysql_close($this->mysql);
		unset($this->mysql);
		}
	
	// Private Functions:
	
	// Public Functions:
	public function login(){
		$nome    = mysql_real_escape_string($_POST["nome"]);
		$email   = mysql_real_escape_string($_POST["email"]);
		$celular = mysql_real_escape_string($_POST["celular"]);
		
		$dados = array("nome"=>$nome,"email"=>$email,"celular"=>$celular);
		$userQuiz = $this->ClassQuiz->pegarUsuarioQuiz($dados);
		
		$_SESSION = $userQuiz;
		header("Location: quiz.php");
		}
	
	public function logout(){
		unset($_SESSION);
		session_destroy();
		header("Location: index.php");
		}
}



if(isset($_REQUEST["action"])){
	$metodo = $_REQUEST["action"];
	$Classe = new ControleGeral();
	if(method_exists($Classe,$metodo)) $Classe->$metodo();
	unset($Classe);
}