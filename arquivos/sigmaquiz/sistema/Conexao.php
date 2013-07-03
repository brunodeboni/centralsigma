<?php
if(!isset($_SESSION)) session_start();
class Conexao
{
	private $db;
	
	public function __construct()
	{
		$this->db = array();
		/* * /
		$this->db["host"]  = "localhost";
		$this->db["login"] = "root";
		$this->db["pass"]  = "";
		$this->db["db"]    = "sigmaquiz";
		/* */
		$this->db["host"]  = "mysql.centralsigma.com.br";
		$this->db["login"] = "centralsigma02";
		$this->db["pass"]  = "S4k813042012";
		$this->db["db"]    = "centralsigma02";
		/* */
	}
	
	public function __destruct()
	{
		unset($this->db);
	}
	
	public function conectar()
	{
		$conexao = @mysql_connect($this->db["host"],$this->db["login"],$this->db["pass"]);
		if(!$conexao) die("ERRO: Impossivel conectar ao banco de dados");
		mysql_select_db($this->db["db"],$conexao);
		mysql_set_charset("utf8",$conexao);
		
		return $conexao;
	}
}