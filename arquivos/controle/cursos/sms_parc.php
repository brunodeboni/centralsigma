<?php 
if (!isset ($_POST['parceiro'])) {
	die('&Eacute; necess&aacute;rio selecionar um usu&aacute;rio.');
} else {
	$cb_parceiro = $_POST['parceiro'];
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
<span><b>Envie um SMS para o(s) Usu&aacute;rio(s) <?php foreach ($cb_parceiro as $parceiro) echo $parceiro." " ?></b></span><br><br>
	<span><b>Mensagem:</b></span><br>
	<textarea form="form_msg" name="mensagem_cel" rows="5" cols="40" onkeydown="textCounter()" onkeyup="textCounter()" required></textarea><br>
	<span>Quantidade de caracteres: </span><input name="caracteres" type="text" value="0" style="border:0px;"><br>
	<span>M&aacute;ximo: 160</span><br>
	<?php
	//Envia ids dos parceiros selecionados via post
	foreach($cb_parceiro as $parceiro) {
		echo '<input type="hidden" name="parceiro[]" value="'.$parceiro.'">';
	}
	?>
	<button type="submit">Enviar</button>
</form>
</div>


<?php

//Pega a mensagem
if (isset ($_POST['mensagem_cel'])){
	//Pega id dos usu�rios desejados
	if (!isset ($_POST['parceiro'])) {
		die('&Eacute; necess&aacute;rio especificar um usu&aacute;rio.');
	} else {
		$cb_parceiro = $_POST['parceiro'];
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
$conn = mysql_connect("cloud1.redeindustrial.com.br","webadmin","webADMIN") or die("Sem conexão com o Banco de Dados");
mysql_select_db("centralsigma02",$conn) or die("N&atilde;o foi possivel selecionar o Banco de Dados");

//Para enviar as informa��es ao banco de dados em UTF-8
mysql_set_charset("utf8");

//Conex�o teste
$conn_t = mysql_connect("186.202.121.119","webadmin","webADMIN") or die("Sem conex&atilde;o com o Banco de Dados");
mysql_select_db("cpcm_teste",$conn_t) or die("N&atilde;o foi possivel selecionar o Banco de Dados Teste");


foreach ($cb_parceiro as $parceiro) {
	//Pega os números de celular da turma desejada
	$sql1 = "SELECT usuarios.celular
	FROM cwk_users as usuarios
	WHERE usuarios.id=".$parceiro;
	
	$query1 = mysql_query($sql1, $conn_t);
	$res = mysql_fetch_assoc($query1);
	
	$celular = $res['celular'];
	$celular = decode_telefone($celular);
	$mensagem = mysql_real_escape_string($_POST['mensagem_cel']);
	
	
	$sql2 = "INSERT INTO `sms` (`CELULAR_REMETENTE`, `CELULAR_DESTINO`, `MENSAGEM`, `CODIGO_CLIENTE`, `STATUS`, `USUARIO`)
		VALUES ('9999999999', '$celular', '$mensagem', '', '1', '151')";
	$query2 = mysql_query($sql2, $conn);
	
	if ($query2) //se enviou
		echo "SMS enviado para ".$celular."!<br>";
	else
		echo "Erro ao enviar SMS para ".$celular;
	

}
}else echo ''; //se não há $_post mensagem_cel
?>
<br>
<br>
<a href="index.php">Voltar</a>
</body>
</html>
