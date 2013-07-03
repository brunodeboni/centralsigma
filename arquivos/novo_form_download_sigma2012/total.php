<?php
	/****************************************************************************
	*** URL ANTIGA PARA MOSTRAR TOTAL DE DOWNLOADS
	*** http://www.redeindustrial.com.br/central_sigma/contadorDonwloads.php
	****************************************************************************/
	
	require '../../conexoes.inc.php';
	$db = Database::instance('centralsigma02');
	
	$qry = $db->query("SELECT downloads FROM downloads");
	$resultado = $qry->fetchAll();
	$antigos = 312255;
	$soma=0;
	foreach($resultado as $res){
		$soma += $res["downloads"];
	}
	$total = $antigos + $soma;
	$total = substr($total,0,strlen($total)-3).".".substr($total,strlen($total)-3,3);
?>
<!DOCTYPE HTML>
<html>
<head><title>Total de Downloads do SIGMA</title>
<style type="text/css">
	a,a:link,a:visited{color:#036;text-decoration:none;}
	a:hover,a:focus{color:#003;}
	body{/*background:#33CCFF;*/}
</style></head>
<body>
<div style="text-align:center;">
<span style="color:#036;font-weight:bold;font-size:28px;"><?php echo $total; ?></span>
<br/>

<a href="http://centralsigma.com.br/index.php?option=com_content&view=article&id=852&Itemid=893" target="_parent">[Download do Sigma]</a>
</div>
</body>
</html>