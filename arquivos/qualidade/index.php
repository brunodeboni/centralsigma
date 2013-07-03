<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<title>Setor de Qualidade</title>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/gioplugin.js"></script>
    <style>
    	body {color: #1f5775; font-size: 14px; font-family:Arial, sans-serif;}
    	button{padding:10px 70px;background:#DDF;}
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
    </style>
</head>

<body>
	<h1>Fale com o Setor de Qualidade</h1>
	A Rede Industrial se preocupa com a qualidade dos seus produtos e serviços ofertados. Use o formulário abaixo para relatar seu problema.
	<br /><br />
	<form action="processa_form.php" method="post" target="_top">
		<span>Urgência:</span>
	    <select name="urgencia" style="margin-left: 45px;" required>
	    	<option value="Alta">Alta</option>
	    	<option value="Media">Média</option>
	    	<option value="Baixa" selected>Baixa</option>
	    </select>
	    <br />
	 	<span>Assunto:</span>
	 	<input type="text" name="assunto" style="margin-left: 50px;" required><br />
	
		<span>Descreva sua questão:</span><br />
		<textarea cols="100" rows="10" name="questao" required></textarea><br />
		<br />
		<span>Nome:</span>
		<input type="text" name="nome" style="margin-left: 65px;" required><br />
		
		<span>Empresa:</span>
		<input type="text" name="empresa" style="margin-left: 48px;" required><br />
		
		<span>Telefone:</span>
		<input type="text" name="telefone" class="telefone" style="margin-left: 45px;" required><br />
		 
		<span>Celular:</span>
		<input type="text" name="celular" class="telefone" style="margin-left: 60px;" required><br />
		 
		<span>E-mail:</span>
		<input type="text" name="email" style="margin-left: 65px;" required><br />
		<br />
		<button type="submit" style="margin-left: 20px;">Enviar</button>
	</form>

	<script>
	$(".telefone").telefone();
	</script>
</body>
</html>