<?php
if(!isset($_SESSION)) session_start();
require_once("Conexao.php");
class ClassQuiz
{
	protected $ClasseConexao,$mysql;
	
	// Construtor e Destrutor:
	public function __construct(){
		$this->ClasseConexao = new Conexao();
		$this->mysql = $this->ClasseConexao->conectar();
		}
	
	public function __destruct(){
		unset($this->ClasseConexao);
		@mysql_close($this->mysql);
		unset($this->mysql);
		}
	
	// Private functions:
	private function _pegarUsuarioQuiz($dados){
		if(is_array($dados)) $sql1 = "select id,nome,email,celular from quiz_usuarios where email = '$dados[email]'";
		else                 $sql1 = "select id,nome,email,celular from quiz_usuarios where id = $dados";
		$qry1 = mysql_query($sql1,$this->mysql);
		$res1 = mysql_fetch_assoc($qry1);
		return $res1;
		}
	
	private function _criarUsuarioQuiz($dados){
		$sql1 = "insert into quiz_usuarios (nome,email,celular) values ('$dados[nome]','$dados[email]','$dados[celular]')";
		$qry1 = mysql_query($sql1,$this->mysql) or die("ERRO: Os dados para cadastro são inválidos");
		$mid = mysql_insert_id($this->mysql);
		
		return $this->_pegarUsuarioQuiz($mid);
		}
	
	private function _pegarUsuarioRespostas($id_usuario, $id_quiz, $retorno_completo=false){
		$retorno = array();
		$count = 0;
		
		$sql1 = "select
					p.id as id_pergunta,
					u.id_respostas as id_resposta
				from
					quiz_perguntas as p
				left join quiz_usuarios_respostas as u on p.id = u.id_perguntas
				where u.id_usuarios = $id_usuario and p.id_quiz = $id_quiz;";
		$qry1 = mysql_query($sql1,$this->mysql);
		
		while($res1 = mysql_fetch_assoc($qry1)){
			$retorno[] = $res1;
			$count++;
			}
		
		if(!$retorno_completo) return $res1;
		else return array("respostas"=>$retorno,"count"=>$count);
		}
	
	// Public functions
	public function pegarUsuarioQuiz($dados){
		/*$dados = array(
			"nome"     => mysql_real_escape_string($_REQUEST["nome"]),
			"email"    => mysql_real_escape_string($_REQUEST["email"]),
			"celular"  => mysql_real_escape_string($_REQUEST["celular"]),
			);*/
		$userQuiz = array();
		
		$pegarQuiz = $this->_pegarUsuarioQuiz($dados);
		if(!$pegarQuiz){
			$userQuiz = $this->_criarUsuarioQuiz($dados);
			$userQuiz["EXISTENTE"] = false;
			}
		else{
			$userQuiz = $pegarQuiz;
			$userQuiz["EXISTENTE"] = true;
			}
		
		return $userQuiz;
		}
	
	public function pegarListaQuizzes(){
		$sql1 = "select id,nome from quiz_quiz";
		$qry1 = mysql_query($sql1,$this->mysql);
		
		$retorno = array();
		
		while($res1 = mysql_fetch_row($qry1)){
			$qid = $res1[0];
			$qnm = $res1[1];
			$retorno[] = array("id"=>$qid,"nome"=>$qnm);
			}
		
		return $retorno;
		}
	
	public function pegarPerguntasQuiz($id_quiz,$pegar_respostas=true,$retorno_completo=false){
		$retorno = array();
		$count = 0;
		
		$sql1 = "select id,pergunta from quiz_perguntas where id_quiz = $id_quiz order by id asc";
		$qry1 = mysql_query($sql1,$this->mysql);
		
		while($res1 = mysql_fetch_row($qry1)){
			$retorno[$count] = array("id_pergunta"=>$res1[0],"pergunta"=>$res1[1]);
			
			if($pegar_respostas){
				$sql2 = "select id, correta, resposta from quiz_respostas where id_perguntas = $res1[0]";
				$qry2 = mysql_query($sql2,$this->mysql);
				
				$rcount = 0;
				$rcorreta = -1;
				$retorno[$count]["respostas"] = array();
				
				while($res2 = mysql_fetch_assoc($qry2)){
					$retorno[$count]["respostas"][$rcount] = $res2;
					if($res2["correta"] == 1) $rcorreta = $res2["id"];
					$rcount++;
					}
				$retorno[$count]["id_resposta_correta"] = $rcorreta;
				}
			$count++;
			}
		
		if(!$retorno_completo) return $retorno;
		else return array("count"=>$count,"perguntas"=>$retorno);
		}
	
	public function responderPerguntaQuiz($usuario,$quiz,$pergunta,$resposta){
		$sql1 = "select id_quiz,id from quiz_perguntas where id = (select id_perguntas from quiz_respostas where id = $resposta)";
		$qry1 = mysql_query($sql1,$this->mysql);
		$res1 = mysql_fetch_row($qry1);
		if(!$res1 || $res1[0]!=$quiz || $res1[1]!=$pergunta) die("ERRO: A resposta selecionada é inválida");
		
		$sql2 = "insert into quiz_usuarios_respostas (id_usuarios,id_respostas) values ($usuario,$resposta)";
		$qry2 = mysql_query($sql2,$this->mysql);
		
		if(!$qry2) return false;
		else       return true;
		}
	
	public function pegarQuizStatus($id_quiz,$id_usuario=NULL){
		/* [{
				id_quiz: 1,
				nome_quiz: 'xxxxx',
				perguntas_respondidas: 2,
				perguntas_totais: 4,
				perguntas:
				[
					{id_pergunta: 1, id_resposta: 2, id_resposta_correta: 1, pergunta: 'xxxxx?', respostas: [{...},{...}]},
					{id_pergunta: 3, id_resposta: 5, id_resposta_correta: 2, pergunta: 'xxxxx?', respostas: [{...},{...}]},
					{id_pergunta: 4, id_resposta: 0, id_resposta_correta: 8, pergunta: 'xxxxx?', respostas: [{...},{...}]},
					{id_pergunta: 5, id_resposta: 0, id_resposta_correta: 7, pergunta: 'xxxxx?', respostas: [{...},{...}]}
				]
			}]
		*/
		$retorno = array();
		$id_usuario = ($id_usuario==NULL)?$_SESSION["id"]:$id_usuario;
		
		$sql1 = "select id, nome from quiz_quiz where id = $id_quiz";
		$qry1 = mysql_query($sql1,$this->mysql);
		$res1 = mysql_fetch_row($qry1);
		if(!$res1) return false;
		
		$retorno["id_quiz"]   = $res1[0];
		$retorno["nome_quiz"] = $res1[1];
		
		$rpguntas = $this->pegarPerguntasQuiz($res1[0],true,true);
		$perguntas        = $rpguntas["perguntas"];
		$perguntas_count  = $rpguntas["count"];
		
		$upguntas = $this->_pegarUsuarioRespostas($id_usuario,$res1[0],true);
		$prespostas       = $upguntas["respostas"];
		$prespostas_count = $upguntas["count"];
		
		$retorno["perguntas_totais"]      = $perguntas_count;
		$retorno["perguntas_respondidas"] = $prespostas_count;
		
		foreach($perguntas as &$pergunta){
			$pergunta["id_resposta"] = 0;
			foreach($prespostas as $upk => $presposta){
				if($presposta["id_pergunta"]==$pergunta["id_pergunta"]){
					$pergunta["id_resposta"] = $presposta["id_resposta"];
					unset($prespostas[$upk]);
					break;
					}
				}
			}
		
		$retorno["perguntas"] = $perguntas;
		
		return $retorno;
		}
	
	// FUNÇÕES PARA USO DE ADMINISTRADORES
	public function atualizarPergunta($pid,$ptxt){
		$pid  = mysql_real_escape_string($pid);
		$ptxt = mysql_real_escape_string($ptxt);
		
		$sql1 = "update quiz_perguntas set pergunta = '$ptxt' where id = $pid";
		$qry1 = @mysql_query($sql1,$this->mysql);
		if(mysql_affected_rows($this->mysql)<=0) return false;
		else return true;
		}
	
	public function atualizarRespostas($pid,$respostas){
		$pid = mysql_real_escape_string($pid);
		$respostas = json_decode($respostas);
		
		$missingid = false;
		foreach($respostas as $rv){if(!isset($rv->id))$missingid=true;}
		if($missingid) return false;
		
		/*
		$sql1 = "delete from respostas where id_perguntas = $pid";
		$qry1 = @mysql_query($sql1,$this->mysql);
		if(!$qry1) return false;
		*/
		foreach($respostas as $resp){
			$marg1 = mysql_real_escape_string($resp->correta);
			$marg2 = mysql_real_escape_string($resp->resposta);
			$marg3 = mysql_real_escape_string($resp->id);
			
			/*
			echo "id: ".$marg3."<br>\r\n";
			echo "correta: ".$marg1."<br>\r\n";
			echo "resposta: ".$marg2."<br>\r\n<br>\r\n";
			*/
			
			$sql2 = "update quiz_respostas set correta = '$marg1', resposta = '$marg2' where id = $marg3";
			$qry2 = mysql_query($sql2,$this->mysql);
			}
		return true;
		}
	
	public function adicionarNovaPergunta($id_quiz, $pergunta, $respostas){
		$id_quiz   = mysql_real_escape_string($id_quiz);
		$pergunta  = mysql_real_escape_string($pergunta);
		$respostas = json_decode($respostas);
		
		$tudocerto = true;
		foreach($respostas as $kk=>$resposta){
			if(!isset($resposta->correta,$resposta->resposta)){
				echo "\ntravou em $kk\n";
				$tudocerto = false;
				}
			}
		if(!$tudocerto) return "Não foi possível encontrar a resposta correta";
		
		$sql1 = "insert into quiz_perguntas (id_quiz, pergunta) values ($id_quiz, '$pergunta')";
		$qry1 = @mysql_query($sql1,$this->mysql);
		if(!$qry1) return "Não foi possivel inserir a pergunta - ".mysql_error($this->mysql);
		$id_pergunta = mysql_insert_id($this->mysql);
		
		foreach($respostas as $resposta){
			$cor = (boolean) $resposta->correta;
				(int) $cor = (int) $cor;
			$resp = mysql_real_escape_string($resposta->resposta);
			
			$sql2 = "insert into quiz_respostas (id_perguntas, correta, resposta) values ($id_pergunta, $cor, '$resp')";
			$qry2 = @mysql_query($sql2,$this->mysql);
			}
		
		return true;
		}
	
	public function deletarPergunta($id_pergunta){
		$id_pergunta = mysql_real_escape_string($id_pergunta);
		$sql1 = "delete from quiz_perguntas where id = $id_pergunta";
		$qry1 = mysql_query($sql1,$this->mysql) or die("ERRO: ".mysql_error($this->mysql));
		return mysql_affected_rows($this->mysql);;
		}
	
	public function editarNomeQuiz($id_quiz, $novo_nome){
		$id_quiz   = mysql_real_escape_string($id_quiz);
		$novo_nome = mysql_real_escape_string($novo_nome);
		$sql1 = "update quiz_quiz set nome = '$novo_nome' where id = $id_quiz";
		$qry1 = mysql_query($sql1,$this->mysql);
		return mysql_affected_rows($this->mysql);
		}
	
	public function deletarQuiz($id_quiz){
		$id_quiz = mysql_real_escape_string($id_quiz);
		$sql1 = "delete from quiz_quiz where id = $id_quiz";
		$qry1 = mysql_query($sql1,$this->mysql);
		if(!$qry1) echo "SQL ERROR: ".mysql_error();
		return mysql_affected_rows($this->mysql);
		}
	
	public function adicionarQuiz($nome){
		$nome = mysql_real_escape_string($nome);
		$sql1 = "insert into quiz_quiz (nome) values ('$nome')";
		$qry1 = mysql_query($sql1,$this->mysql);
		return mysql_insert_id($this->mysql);
		}
}


/*
$cl = new ClassQuiz();
echo "<pre class='xdebug-var-dump' dir='ltr'>";
print_r($cl->pegarQuizStatus(1));
echo "</pre>";
*/