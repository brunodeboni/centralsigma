<?php
require '../../../conexoes.inc.php';
$db_02 = Database::instance('centralsigma02');
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Gráfico Últimos 100 Downloads do SIGMA</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/jquery.maskedinput.js"></script>
	<script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/bruno.js"></script>
	<link rel="stylesheet" href="default.css" type="text/css">
</head>
<body>
<div class="wrapper">
	<h1>Gráfico Últimos 100 Downloads do SIGMA</h1>
	
	<form action="#" method="post">
		<span>Exibir Período de:
			<input type="text" id="inicial_date" name="inicial_date" maxlength="10">
			a
			<input type="text" id="final_date" name="final_date" maxlength="10">
			<button type="submit" class="btn">Pesquisar</button>
		</span>
	</form>
	<br>
	
	<div class="graph">
		<div class="index">
			100<br><br>
			90<br><br>
			80<br><br>
			70<br><br>
			60<br><br>
			50<br><br>
			40<br><br>
			30<br><br>
			20<br><br>
			10<br><br>
			0
		</div>
<?php 
if (isset($_POST['inicial_date']) && isset($_POST['final_date'])) {
	
	$sql = "select count(cod) as quant from downloads_meta 
		where data between str_to_date(:inicial_date, '%d/%m/%Y') and str_to_date(:final_date, '%d/%m/%Y')";
	$query = $db_02->prepare($sql);
	$query->execute(array(
		':inicial_date' => $_POST['inicial_date'],
		':final_date' => $_POST['final_date']
	));
	
	$resultado = $query->fetchAll();
	foreach ($resultado as $res) {
		$total = $res['quant'];
	}
	
	//echo $total;

	$sql = "select count(cod) as quant, id_arquivo, date_format(data, '%d/%m/%Y') as date 
		from downloads_meta 
		where data between str_to_date(:inicial_date, '%d/%m/%Y') and str_to_date(:final_date, '%d/%m/%Y')
		group by id_arquivo, date(data) 
		order by date(data), id_arquivo";
	$query = $db_02->prepare($sql);
	$query->execute(array(
		':inicial_date' => $_POST['inicial_date'],
		':final_date' => $_POST['final_date']
	));
	
	$resultado = $query->fetchAll();
	foreach ($resultado as $res) {
		
		switch ($res['id_arquivo']) {
			default: $arquivo = "SIGMA 2010"; break;
			case 1: $arquivo = "SIGMA 2012 Free"; break;
			case 2: $arquivo = "SIGMA 2012 Professional"; break;
			case 3: $arquivo = "SIGMA 2012 Enterprise"; break;
		}
		
		echo '<div class="dates">'.$res['date'].'</div>';
		/*
		echo $res['quant']." - ";
		echo $arquivo." - ";
		echo $res['date']."<br>";*/
	}	
}


?>
	</div>
</div>
<script>
$(document).ready(function() {
	$('#inicial_date').mask('99/99/9999');
	$('#final_date').mask('99/99/9999');
});
</script>
</body>
</html>