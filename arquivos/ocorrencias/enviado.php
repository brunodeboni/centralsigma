<?php 
$codigo = $_GET['c'];
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Ocorrência Enviada</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/gioplugin.js"></script>
    <style>
    	body {color: #1f5775; font-size: 14px; font-family:Arial, sans-serif; text-align:center;}
    	h1{
			display:block;
			margin-right:-10px;
			margin-bottom:20px;
			padding:10px;
			border:1px solid #BBB;
			background:#F7F7F7;
			color:#666;
			text-align:center;
			font-size:18px;
		}
		i {
			color: #1f5799;
		}
		#button{padding:10px 70px; background:#DDF; text-decoration:none; color: #1f5775;}
    </style>
</head>

<body>
	<h1>Sucesso</h1>
	<b>Sua ocorrência foi registrada com sucesso. O código da ocorrência é: <i><?php echo $codigo; ?></i></b>
	<br><br>
	<a href="http://www.centralsigma.com.br" id="button">Home</a>
</body>
</html>
