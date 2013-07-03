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

<?php 

//Conexão com mysql
include '../../../conexoes.inc.php';
$db = Database::instance('centralsigma02');
    
$sql = "select codigo, nome, telefone, celular, email, endereco, bairro, cep, 
cidade, uf, cpf, banco, agencia, conta from dv_divulgadores_sigma 
where codigo = :codigo";
$query = $db->prepare($sql);
$query->execute(array(':codigo' => $codigo));

$resultado = $query->fetchAll();
foreach ($resultado as $res) {
		
	$nome = $res['nome'];
	$telefone = $res['telefone'];
	$celular = $res['celular'];
	$email = $res['email'];
	$endereco = $res['endereco'];
	$bairro = $res['bairro'];
	$cep = $res['cep'];
	$cidade = $res['cidade'];
	$uf = $res['uf'];
	$cpf = $res['cpf'];
	$banco = $res['banco'];
	$conta = $res['conta'];
	$agencia = $res['agencia'];
		
	
	echo '
	<tr class="firstline">
		<td>Nome</td>
		<td>'.$nome.'</td>
	</tr>
	<tr class="secondline">
		<td>Telefone</td>
		<td>'.$telefone.'</td>
	</tr>
	<tr class="firstline">
		<td>Celular</td>
		<td>'.$celular.'</td>
	</tr>
	<tr class="secondline">
		<td>E-mail</td>
		<td>'.$email.'</td>
	</tr>
	<tr class="firstline">
		<td>Endereço</td>
		<td>'.$endereco.'</td>
	</tr>
	<tr class="secondline">
		<td>Bairro</td>
		<td>'.$bairro.'</td>
	</tr>
	<tr class="firstline">
		<td>CEP</td>
		<td>'.$cep.'</td>
	</tr>
	<tr class="secondline">
		<td>Cidade</td>
		<td>'.$cidade.'</td>
	</tr>
	<tr class="firstline">
		<td>Estado</td>
		<td>'.$uf.'</td>
	</tr>
	<tr class="secondline">
		<td>CPF</td>
		<td>'.$cpf.'</td>
	</tr>
	<tr class="firstline">
		<td>Banco</td>
		<td>'.$banco.'</td>
	</tr>
	<tr class="secondline">
		<td>Agência</td>
		<td>'.$agencia.'</td>
	</tr>
	<tr class="firstline">
		<td>Conta</td>
		<td>'.$conta.'</td>
	</tr>
	';
}

?>
</table>

<a href="divulgadores.php"><< Voltar</a>
</div>
</body>
</html>
