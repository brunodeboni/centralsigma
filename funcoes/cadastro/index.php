<?php ini_set('default_charset','UTF-8'); if(!isset($_GET['redeindustrial']))exit; ?>
<html>
<head>
	<title>SMS</title>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<style type="text/css">
*{padding:0;margin:0;}
button{padding:5px 10px}
	.stable{
		background:#EEEEEE;
		font-size:14px;
		display:block;
	}
	.stable th{
		background:#CCCCCC;
		padding:0px 15px;
	}
	.stable td{
		border-bottom:1px solid #666666;
		border-right:1px dotted #AAAAAA;
	}
	.stable tr:hover{
		background:#FFFFFF;
		cursor:default;
	}
		label{cursor:default;}
	
	.bt_toogle{
		padding:5px;
		width:10%;
		margin:auto;
		font-weight:bold;
		background:#EEEEEE;
	}
	.bt_toogle:hover, .bt_toogle:focus{
		background:#E0E0E0;
	}
	.bt_toogle.active{
		font-weight:normal;
		background:#FFFFFF;
	}
</style>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
function InitSite(){
	window.AllAlunos = $("#alunosdiv").html();
}

function HideColumn(col_no){
	if(arguments[1]){
		bt=arguments[1];
		$("#"+bt).toggleClass('active');
	}
	
	do_show = $('#coltable td:nth-child('+col_no+')').css("display");
	if(col_no==1)return;
	if(do_show!="none"){
		$('#coltable td:nth-child('+col_no+'),th:nth-child('+col_no+')').hide();
	}else{
		$('#coltable td:nth-child('+col_no+'),th:nth-child('+col_no+')').show();
	}
}

function getAlunos(){
	curso_id = $("#pcursos").val();
	if(curso_id == ""){$("#alunosdiv").html(window.AllAlunos);return;}
	$("#alunosdiv").html("Carregando...");
	$.post("./smsajax.php",{action:'getAlunos',cursoid:curso_id},function(data){$("#alunosdiv").html(data)});
}

function enviarMsg(){
	cbs = document.getElementsByName('cb_alunos');
	chk = "";
	mens = $("#txtmsg").val();
	if(mens==""){alert("A mensagem não pode estar em branco!");return;}
	$("#bt_enviarmsg").attr("disabled",true);
	pagchk = document.getElementById('cb_pag').checked?1:0;
	
	for(i=0;i<cbs.length;i++){
		if(cbs[i].checked==true){
			chk="cbs";
			var smsg = $.post("./smsajax.php",{action: 'enviarSMS', para: cbs[i].value, msg: mens, pag: pagchk});
		}
	}
	smsg.success(function(data){alert(data);$("#txtmsg").val("");});
	
	$("#bt_enviarmsg").attr("disabled",false);
}
</script>
</head>
<body onLoad="InitSite()">

<?php
/*
$conn = mysql_connect("mysql.centralsigma.com.br","centralsigma02","a2q3pdt140212") or die("Sem conexao com o banco de dados!");
		mysql_select_db('centralsigma02',$conn);
*/

$mysqli = new mysqli("mysql.centralsigma.com.br","centralsigma02","S4k813042012","centralsigma02");
$sql = "SELECT * FROM `ck_formularios` ORDER BY `index_id` DESC LIMIT 50";

$res = $mysqli->query($sql);
$fields = $res->fetch_fields();
$i=2;
foreach($fields as $field){
		echo "<button class='bt_toogle' onClick='HideColumn($i, this.id)' id='bt_$field->name'>";
		echo $field->name;
		echo "</button>";
		$i++;
}
?>
<br /><br /><br />
<div style="width:300px;margin:auto;padding:10px;background:#EEEEEE;border:2px solid #E0E0E0;">
<table style="width:100%;text-align:center;"><tr>
<td>Curso ID:</td><td><input type="text" id="pcursos"><button onClick="getAlunos()">&raquo;</button></td>
</tr>

<tr>
<td>Mensagem:</td><td><textarea style="width:99%;height:100px;" id='txtmsg'></textarea></td>
</tr><tr>
<td colspan="2"><label><input type="checkbox" id="cb_pag" /> Mensagem de pagamento</label></td>
</tr><tr>
<td colspan="2"><button onClick="enviarMsg()" id="bt_enviarmsg">Enviar Mensagem</button></td>
</tr>

</table>
</div>

<br /><br />
<div style='padding:15px;' id='alunosdiv'>
<?php
echo "<table class='stable' id='coltable' cellpadding='1' cellspacing='0'><tr>";
echo "<th>-</th>";
$i=0;
foreach($fields as $field){
	$stth="";
	if($field->name == "sms") $stth="padding:5px 140px !important;";
	else if($field->name == "nome") $stth="padding:5px 80px !important;";
	else if($field->name == "empresa") $stth="padding:5px 80px !important;";
	else if($field->name == "data_cadastro") $stth="padding:5px 25px !important;";
	echo "<th style='$stth' name='Col0$i' onclick='HideColumn(".($i+2).", \"bt_$field->name\")'>".$field->name."</th>";
	$i++;
}
echo "</tr>";

while($nfields = $res->fetch_row()){
	$i=0;
	$cbid="cb_".$nfields[0];
	echo "<tr>";
	echo "<td><input type='checkbox' id='$cbid' name='cb_alunos' value='$nfields[0]' /></td>";
	foreach($nfields as $field){
		echo "<td style='padding-left:5px;' name='Col0$i'><label for='$cbid' style='display:block;'>$field</label></td>";
		$i++;
	}
	echo "</tr>";
}

echo "</table>";
?>
</div>
</body>
</html>