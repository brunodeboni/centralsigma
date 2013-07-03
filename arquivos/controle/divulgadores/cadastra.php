<?php

session_start();
if(!isset($_SESSION['5468usuario'])) die("<strong>Acesso Negado!</strong>");

//Pega o código do divulgador
	if (!isset ($_GET['codigo'])) {
		echo "&Eacute; necess&aacute;rio definir um divulgador.";	
	}else {
		$codigo = $_GET['codigo']; 
	}
?>
<!doctype> 
<html>
<head>
    <meta charset="utf-8" />
	<title>Divulgadores SIGMA</title>
	<style>
	.divulgadores{
		margin:10px auto;
		padding:5px;
		width:500px;
		background:#F7F7FF;
	}
	.firstline {background-color: #FAF0E6;}
	.secondline {background-color: #FAEBD7;}
	h1{
		margin-bottom:5px;
		text-align:center;
		padding:5px;
		font-size:18px;
		background:#B03060;
		
		color:#FFF;
	}
	label{
		font-weight: bold;
	}
	input,select{
		padding:5px;
		font-size:16px;
		border:1px solid #CCC;
		outline:0;
	}
	input:focus,select:focus{
		background:#FFFFCC;
	}

	.block{
		width:100%;
		margin:auto;
		display:block;
	}
	
	button{
		background: #B0C4DE; 
		padding:10px 40px; 
		color: #163F55; 
		font-weight: bold;
	}
	#enviado {
		font-weight: bold;
		margin: 10px auto;
	}
	</style>
</head>
<body>
<div class="divulgadores">
<h1>Divulgador <?php echo $codigo; ?></h1>

<form action="" method="post">
	<label>
		<span>Nome da Empresa:</span><br>
		<input type="text" name="empresa" class="block">
	</label>
	<label>
		<span>Produto / Serviço</span><br>
		<input type="text" name="produto" class="block">
	</label>
	<label>
		<span>Número da Proposta:</span><br>
		<input type="text" name="proposta" class="block">
	</label>
	<label>
		<span>Valor em Negociação:</span><br>
		<input type="text" name="valor" class="block">
	</label>
	<label>
		<span>Premiação (em %):</span><br>
		<input type="text" name="premiacao" class="block"><br>
	</label>
	
	<button type="submit">Enviar</button>
</form>

<?php 

//Conexão com mysql
include '../../../conexoes.inc.php';
$db = Database::instance('centralsigma02');
    
if (isset ($_POST['empresa'])) {
	
	$sql = "insert into dv_divulgador_empresas (codigo, empresa, produto, proposta, valor, premiacao) values (:codigo, :empresa, :produto, :proposta, :valor, :premiacao)";
	$query = $db->prepare($sql);
	$query->execute(array(
		':codigo' => $codigo,
		':empresa' => $_POST['empresa'],
		':produto' => $_POST['produto'], 
		':proposta' => $_POST['proposta'], 
		':valor' => $_POST['valor'], 
		':premiacao' => $_POST['premiacao']
	));
	
	echo '<div id="enviado">Dados enviados!</div>';
	
}

?>

<a href="divulgadores.php"><< Voltar</a>
</div>
</body>
</html>