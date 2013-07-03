<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Remover Noticia</title>
<style type="text/css">
*{margin:0;padding:0;}
body{
	//background:url(./arquivos/background.jpg) repeat-x;
	font-family:Tahoma, Geneva, sans-serif;
	font-size:14px;
}
.container{
	width:98%;
	margin:auto;
	padding:5px;
	//background:#EEF;
}
.center{text-align:center;display:block;}
.titulo{font-weight:bold;font-size:16px;color:#014;}

tr.autor{font-size:90%;font-weight:bold;color:#036;background:#83C0FE;}
tr.autor td{padding:5px;}
tr.noticia td{padding-bottom:30px;}
</style>
<script src="./arquivos/jquery.js" type="text/javascript"></script>
<script type="text/javascript">

if(typeof jQuery == 'undefined'){
	var headID = document.getElementsByTagName("head")[0];         
	var newScript = document.createElement('script');
	newScript.type = 'text/javascript';
	newScript.src = './arquivos/jquery.js';
	headID.appendChild(newScript);
}

function removerNoticia(cod)
{
	$.post("./arquivos/ajaxnoticias.php",{action:"remover",cod:cod},function(data){alert(data);});
}

function hideClass(class_name)
{
	$("."+class_name).slideUp();
}
</script>
</head>
<body>

<div class="container" id="container">
<table style="width:100%;">
<?php

require("./arquivos/conexao.php");

$sql1 = "select * from noticias order by cod desc";
$qry1 = mysql_query($sql1,$conn) or die("query invalida");

while($res1 = mysql_fetch_assoc($qry1))
{
	echo "<tr class='autor ncod$res1[cod]'><td>Autor: $res1[autor]<span style='float:right;'>";
	echo "<a href='javascript:void(0);' onClick='removerNoticia($res1[cod]);hideClass(\"ncod$res1[cod]\");'>[Remover]</a></span></td></tr>";
	echo "<tr class='noticia ncod$res1[cod]'><td>".str_replace("\\","",$res1["noticia"])."</td></tr>";
}

?>
</table>
</div>

</body>
</html>