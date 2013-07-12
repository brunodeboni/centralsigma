<?php
class smsactions{
	public $action;
	public $mysqli;
	public $cursoid;
	
	public function __construct(){
		if(!$_REQUEST['action']) exit;
		$this->mysqli = new mysqli("mysql.centralsigma.com.br","centralsigma02","S4k813042012","centralsigma02");
		$this->mysqli->set_charset("utf8");
	}
	public function __destruct(){
		$this->mysqli->close();
	}
	
	private function createTable($sql){
		$res = $this->mysqli->query($sql);
		$fields = $res->fetch_fields();
		echo "<table class='stable' id='coltable' cellpadding='1' cellspacing='0'><tr>";
		echo "<th>-</th>";
		$i=0;
		foreach($fields as $field){
			$stth="";
			if($field->name == "sms") $stth="padding:5px 140px !important;";
			else if($field->name == "nome") $stth="padding:5px 80px !important;";
			else if($field->name == "empresa") $stth="padding:5px 80px !important;";
			else if($field->name == "data_cadastro") $stth="padding:5px 25px !important;";
			echo "<th style='$stth' width='130' name='Col0$i' onclick='HideColumn(".($i+2).", \"bt_$field->name\")'>".$field->name."</th>";
			$i++;
		}
		echo "</tr>";
		
		while($nfields = $res->fetch_row()){
			$i=0;
			echo "<tr>";
			$cbid="cb_".$nfields[0];
			echo "<td><input type='checkbox' id='$cbid' name='cb_alunos' value='$nfields[0]' /></td>";
			foreach($nfields as $field){
				echo "<td style='padding-left:5px;' name='Col0$i'><label for='$cbid' style='display:block;'>$field</label></td>";
				$i++;
			}
			echo "</tr>";
		}
		echo "</table>";
	}
	
	public function getAlunos(){
		//$this->cursoid = mysql_real_escape_string($_REQUEST['cursoid']);
		$cursoal = $_REQUEST['cursoid'];
		$sql = "SELECT * FROM `ck_formularios` WHERE `idcurso`='$cursoal' ORDER BY `index_id` DESC";
		$qry = $this->mysqli->query($sql);
		//while($res = $qry->fetch_assoc()){
		//	echo "<p>".$res->nome."</p>";
		//}
		$this->createTable($sql);
	}
	public function enviarSMS(){
		$para = $_REQUEST['para'];
		$msg = $_REQUEST['msg'];
		$pag = $_REQUEST['pag'];
		
		$sql2 = "SELECT celular FROM ck_formularios WHERE index_id = $para";
		$qry2 = $this->mysqli->query($sql2);
			if(!$qry2) die("Invalid Query! 2");
		$res2 = $qry2->fetch_assoc();
		$cell = $res2["celular"];
		if($cell==NULL || $cell=="") die("Erro!<br />\nContato: $para<br />\nNão é possível enviar mensagem ao contato pois este não tem número de celular!");
		
		if($pag==1){
			$sqlp = "UPDATE ck_formularios SET pagamento = $pag WHERE index_id = $para";
			$qryp = $this->mysqli->query($sqlp);
		}
		
		$sql1 = "INSERT INTO ck_mensagens (index_id,mensagem) VALUES ('$para','$msg')";
		$qry1 = $this->mysqli->query($sql1);
			if(!$qry1) die("Invalid Query! 1");
		
		$sql3 = "INSERT INTO SMS (CELULAR_DESTINO, MENSAGEM, STATUS, USUARIO, DATA_CADASTRO) VALUES ('$cell','$msg',1,151,NOW())";
		$qry3 = $this->mysqli->query($sql3);
			if(!$qry3) die("Invalid Query! 3");
		die("Mensagem enviada com sucesso!");
	}
}

$obj = new smsactions();
if($_REQUEST['action']) $obj->$_REQUEST['action']();
$obj = NULL;
?>