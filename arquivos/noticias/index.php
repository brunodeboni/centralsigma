<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Adicionar Noticia</title>
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

tr.autor{font-size:90%;font-weight:bold;color:#036;background:#82bede;}
tr.autor td{padding:5px;}
tr.noticia td{padding-bottom:30px;}
</style>
</head>
<body>

<div class="container" id="container">
<table style="width:100%;">
<?php
	require("./arquivos/conexao.php");
	
	$sql1 = "select cod, autor, noticia, date_format(datahora,'%d/%m/%Y %H:%i') as datahora from noticias order by cod desc limit 20";
	$qry1 = mysql_query($sql1,$conn) or die("query invalida");
	
	while($res1 = mysql_fetch_assoc($qry1))
	{
		echo "<tr class='autor'><td>Autor: $res1[autor]<span style='float:right;'>$res1[datahora]</span></td></tr>";
		echo "<tr class='noticia'><td>".str_replace("\\","",$res1["noticia"])."</td></tr>";
	}
?>
</table>
</div>

</body>
</html>