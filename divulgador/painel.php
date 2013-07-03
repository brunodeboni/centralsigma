<?php
//Verifica se usuário está logado
session_start();
if(!isset($_SESSION['4359usuario'])) die("<strong>Acesso Negado!</strong>");

//Pega código do usuário
$codigo = $_SESSION['4359codigo'];

?>
<!doctype> 
<html>
<head>
    <meta charset="utf-8" />
	<title>Painel de Indicações SIGMA</title>
	<style>
	body{font-size:14px; font-family: Arial, Helvetica, sans-serif;}
	.firstline {background-color: #0277BE; width: 250px;}
	.secondline {background-color: #A6D0E7; width: 250px;}
	.mostrar {font-weight:bold;}
	.divulgadores{
		margin:10px auto;
		padding:5px;
		width:700px;
		background: #EEEEEE;
	}
	h1{
		margin-bottom:5px;
		text-align:center;
		padding:5px;
		font-size:16px;
		background: #315D81;
		
		color:#FFF;
	}
	h2{
		margin-bottom:5px;
		text-align:center;
		padding:5px;
		font-size:16px;
		background:#369;
		color:#FFF;
	}
	table{
		font-size: 14px;
		margin-bottom:5px;
		width:100%;
		border-collapse:collapse;
		border-bottom:2px solid #315D81;
	}
	table th, table td{
		padding:10px;
		text-align:right;
		font-weight: bold;
	}
	#boas_vindas {
		font-weight: bold;	
	}
	#logout {
		float: right;
		font-weight: bold;	
		margin-top: -15px;
	}
	</style>
</head>
<body>
<div class="divulgadores">
<?php 
//Conexão com mysql
require '../conexoes.inc.php';
$db = Database::instance('centralsigma02');

$sql = "select nome from dv_divulgadores_sigma where codigo = :codigo";
$query = $db->prepare($sql);
$query->execute(array(':codigo' => $codigo));
$resultado = $query->fetchAll();

foreach ($resultado as $res) {
	echo '<div id="boas_vindas">Olá, '.$res['nome'].'!</div>';
	echo '<div id="logout"><a href="index.php">Sair</a></div>';	
}

?>
<h1>Painel de Indicações</h1>
<table>
	<tr class="firstline">
		<td>Empresa</td>
		<td>Produto / Serviço</td>
		<td>Proposta</td>
		<td>Valor em Negociação</td>
		<td>Premiação (em %)</td>
	</tr>
<?php 
    
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

</div>
</body>
</html>

