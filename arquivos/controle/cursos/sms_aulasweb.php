<?php 
if (!isset ($_GET['turma'])) {
	die('&Eacute; necess&aacute;rio especificar uma turma.');
} else {
	$turma = $_GET['turma'];
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Envia SMS</title>
<style type="text/css">
body {font-family:Arial, Tahoma, sans-serif; color: color: #CD5C5C;}
textarea {font-family:Arial, Tahoma, sans-serif; font-size:16px;}
</style>
<script>
function textCounter(){
document.forms[0].caracteres.value=document.forms[0].mensagem_cel.value.length;
}
</script>
</head>
<body>
<div>
<form action="#" method="post" id="form_msg">
<span><b>Envie um SMS para a Turma <?php echo $turma ?></b></span><br><br>
	<span><b>Mensagem:</b></span><br>
	<textarea form="form_msg" name="mensagem_cel" rows="5" cols="40" onkeydown="textCounter()" onkeyup="textCounter()" required></textarea><br>
	<span>Quantidade de caracteres: </span><input name="caracteres" type="text" value="0" style="border:0px;"><br>
	<span>M&aacute;ximo: 160</span><br>
	<button type="submit">Enviar</button>
</form>
</div>


<?php

//Pega a mensagem
if (isset ($_POST['mensagem_cel'])){
	//Pega id da turma
	if (!isset ($_GET['turma'])) {
		die('&Eacute; necess&aacute;rio especificar uma turma.');
	} else {
		$turma = $_GET['turma'];
	}

	function decode_telefone($telefone){
		$telefone = trim($telefone);
		if($telefone=="") return "";
		$nums = "0123456789";
	
		$numsarr = str_split($nums);
		$telsarr = str_split($telefone);
	
		$novo_telefone = "";
	
		foreach($telsarr as $tel){
			$ex = false;
			foreach($numsarr as $num){
				if($tel == $num){
					$ex = true;
					break;
				}
			}
			 
			if($ex) $novo_telefone .= $tel;
		}
	
		return $novo_telefone;
	}

// Conexão com mysql
$conn = mysql_connect("aulasweb.com.br","webadmin","webADMIN") or die("Sem conexão com o Banco de Dados");
mysql_select_db("aulasweb",$conn) or die("Não foi possivel selecionar o Banco de Dados");
	
$conn_r = mysql_connect("cloud1.redeindustrial.com.br","webadmin","webADMIN") or die("Sem conexão com o Banco de Dados");
mysql_select_db("centralsigma02",$conn_r) or die("N&atilde;o foi possivel selecionar o Banco de Dados");

//Para enviar as informações ao banco de dados em UTF-8
mysql_set_charset("utf8");

//Pega os números de celular da turma desejada
$sql1 = "SELECT usuarios.celular
FROM cwk_users as usuarios

left join cw_cursos_inscritos as inscritos
on inscritos.id_user=usuarios.id

WHERE id_turma=".$turma;

$query1 = mysql_query($sql1, $conn);

while ($res = mysql_fetch_assoc($query1)) {
	$celular = $res['celular'];
	$celular = decode_telefone($celular);
	$mensagem = mysql_real_escape_string($_POST['mensagem_cel']);
	
	
	$sql2 = "INSERT INTO `sms` (`CELULAR_REMETENTE`, `CELULAR_DESTINO`, `MENSAGEM`, `CODIGO_CLIENTE`, `STATUS`, `USUARIO`)
		VALUES ('9999999999', '$celular', '$mensagem', '0099503', '1', '151')";
	$query2 = mysql_query($sql2, $conn_r);
	
	if ($query2) //se enviou
		echo "SMS enviado para ".$celular."!<br>";
	else
		echo "Erro ao enviar SMS para ".$celular;
	
}

}else echo ''; //se não há $_post mensagem_cel
?>
<br>
<br>
<a href="email_aulasweb.php?turma=<?php echo $turma;?>">Voltar</a>
</body>
</html>