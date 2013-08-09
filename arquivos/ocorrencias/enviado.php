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
    	body {
	    	color: #24211D; 
	    	font-size: 14px; 
	    	font-family:Arial, sans-serif; 
	    	background: #FFFAF0;
    	}
    	#container {
    		width: 900px;
    		margin: auto;
    		padding: 5px;
    		text-align: center;
    	}
    	h1{
			display:block;
			margin-bottom:20px;
			text-align:center;
			padding:10px;
			font-size:16px;
			background: #315D81;
			color:#FFF;
			-webkit-border-radius: 5px;
	    	border-radius: 5px;
		}
		i {
			color: #1f5799;
		}
		#button{
			padding:10px 30px;
	    	background:#315D81;
	    	color: #FFF;
	    	font-weight: bold;
	    	text-decoration: none;
	    	
	    	border: 0;
	    	-webkit-border-radius: 5px;
	    	border-radius: 5px;
    	}
    </style>
</head>

<body>
<div id="container">
	<h1>Sucesso</h1>
	<b>Sua ocorrência foi registrada com sucesso. O código da ocorrência é: <i><?php echo $codigo; ?></i></b>
	<br><br><br>
	<a href="painel.php" id="button">Voltar</a>
	<a href="index.php" id="button">Sair</a>
</div>
</body>
</html>
