<?php
	/****************************************************************************
	*** URL ANTIGA PARA MOSTRAR TOTAL DE DOWNLOADS
	*** http://www.redeindustrial.com.br/central_sigma/contadorDonwloads.php
	****************************************************************************/
	
	$conn = mysql_connect("cloud1.redeindustrial.com.br","webadmin","webADMIN") or die("Sem conexão com o Banco de Dados");
	mysql_select_db("centralsigma02",$conn) or die("Não foi possivel selecionar o Banco de Dados");
	$qry = mysql_query("SELECT downloads FROM downloads",$conn);
	$antigos = 312255;
	$soma=0;
	while($res = mysql_fetch_assoc($qry)){
		$soma += $res["downloads"];
	}
	$total = $antigos + $soma;
	$total = substr($total,0,strlen($total)-3).".".substr($total,strlen($total)-3,3);
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Total de Downloads do SIGMA</title>
	<style type="text/css">
	a,a:link,a:visited{color:#036;text-decoration:none;}
	a:hover,a:focus{color:#003;}
	body{/*background:#33CCFF;*/}
	</style>
</head>
<body>
<div style="text-align:center;">
<span style="color:#036;font-weight:bold;font-size:28px;"><?php echo $total; ?></span>
<br>

<a href="http://centralsigma.com.br/index.php?option=com_content&view=article&id=852&Itemid=893" target="_parent">[Download do Sigma]</a>
</div>
</body>
</html>