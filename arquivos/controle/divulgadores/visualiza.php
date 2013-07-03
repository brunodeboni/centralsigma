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
	body{font-size:14px; font-family: Arial, Helvetica, sans-serif;}
	.firstline {background-color: #FAF0E6; width: 250px;}
	.secondline {background-color: #FAEBD7; width: 250px;}
	.mostrar {font-weight:bold;}
	.divulgadores{
		margin:10px auto;
		padding:5px;
		width:600px;
		background:#F7F7FF;
	}
	h1{
		margin-bottom:5px;
		text-align:center;
		padding:5px;
		font-size:18px;
		background:#B03060;
		
		color:#FFF;
	}
	h2{
		margin-bottom:5px;
		text-align:center;
		padding:5px;
		font-size:18px;
		background:#369;
		color:#FFF;
	}
	table{
		margin-bottom:5px;
		width:100%;
		border-collapse:collapse;
		border-bottom:2px solid #6969AF;
	}
	table thead tr{
		background:#6969AF;		
	}
	table th, table td{
		padding:10px;
		text-align:right;
		font-weight: bold;
	}
	
	</style>
</head>
<body>
<div class="divulgadores">
<h1>Divulgador <?php echo $codigo; ?></h1>
<table>
	<tr class="firstline">
		<td>Empresa</td>
		<td>Produto / Serviço</td>
		<td>Proposta</td>
		<td>Valor em Negociação</td>
		<td>Premiação (em %)</td>
	</tr>
<?php 

//Conexão com mysql
include '../../../conexoes.inc.php';
$db = Database::instance('centralsigma02');
    
$sql = "select empresa, produto, proposta, valor, premiacao from dv_divulgador_empresas where codigo = :codigo";
$query = $db->prepare($sql);
$query->execute(array(':codigo' => $codigo));
$resultado = $query->fetchAll();

$rowq = true; //Classe para cores das linhas
foreach ($resultado as $res) {
	//Classe para cores das linhas
    if($rowq) $class = "secondline";
	else $class = "firstline";
	$rowq = !$rowq;
		
	$empresa = $res['empresa'];
	$produto = $res['produto'];
	$proposta = $res['proposta'];
	$valor = $res['valor'];
	$premiacao = $res['premiacao'];
	
	echo '
	<tr class="'.$class.'">
		<td>'.$empresa.'</td>
		<td>'.$produto.'</td>
		<td>'.$proposta.'</td>
		<td>R$ '.$valor.'</td>
		<td>'.$premiacao.'</td>
	</tr>';
}

?>
</table>

<a href="divulgadores.php"><< Voltar</a>
</div>
</body>
</html>
