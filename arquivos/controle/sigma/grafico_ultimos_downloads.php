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
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
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
	
	
<?php 
if (isset($_POST['inicial_date']) && isset($_POST['final_date'])) {
	
	//Downloads por licença pelo tempo
	$sql = "select count(cod) as quant, date_format(data, '%d/%m/%Y') as data, id_arquivo 
      	from downloads_meta 
		where data between str_to_date(:inicial_date, '%d/%m/%Y') and str_to_date(:final_date, '%d/%m/%Y')
		group by date(data), id_arquivo";
	$query = $db_02->prepare($sql);
	$query->execute(array(
		':inicial_date' => $_POST['inicial_date'],
		':final_date' => $_POST['final_date']
	));
	
	$i = 0;
	$resultado = $query->fetchAll();
	foreach ($resultado as $res) {
		
		switch ($res['id_arquivo']) {
			default: $arquivo = "SIGMA 2010"; break;
			case 1: $arquivo = "SIGMA 2012 Free"; break;
			case 2: $arquivo = "SIGMA 2012 Professional"; break;
			case 3: $arquivo = "SIGMA 2012 Enterprise"; break;
		}
		
		//Cria array com a data como chave de um sub-array com os dados de cada licença baixada no dia 
		$linha[$res['data']][] = array(
			'id_arquivo' => $res['id_arquivo'],
			'licenca' => $arquivo,
			'quantidade' => $res['quant']
		);
		
		$i++;
	}
	
	//Atribuir 0 às licenças que não foram baixadas no dia
	foreach ($linha as $data => $line) {
				
		$free = false;
		$enterprise = false;
		$professional = false;
		$old = false;
		for ($i=0; $i<count($line); $i++) {
			if (in_array('SIGMA 2012 Free', $line[$i])) {
				$free = true;
				continue;
			}	
		}
		for ($i=0; $i<count($line); $i++) {
			if (in_array('SIGMA 2012 Professional', $line[$i])) {
				$professional = true;
				continue;
			}	
		}
		for ($i=0; $i<count($line); $i++) {
			if (in_array('SIGMA 2012 Enterprise', $line[$i])) {
				$enterprise = true;
				continue;
			}	
		}
		for ($i=0; $i<count($line); $i++) {
			if (in_array('SIGMA 2010', $line[$i])) {
				$old = true;
				continue;
			}	
		}
		
		if (!$free) {
			$linha[$data][] = array(
				'id_arquivo' => '1',
				'licenca' => 'SIGMA 2012 Free',
				'quantidade' => '0'
			);
		}
		if (!$professional) {
			$linha[$data][] = array(
				'id_arquivo' => '2',
				'licenca' => 'SIGMA 2012 Professional',
				'quantidade' => '0'
			);
		}
		if (!$enterprise) {
			$linha[$data][] = array(
				'id_arquivo' => '3',
				'licenca' => 'SIGMA 2012 Enterprise',
				'quantidade' => '0'
			);
		}
		if (!$old) {
			$linha[$data][] = array(
				'id_arquivo' => null,
				'licenca' => 'SIGMA 2010',
				'quantidade' => '0'
			);
		}
		
	}//fim do resultado da query por data
	
	//Total de downlads por licença
	$sql2 = "select count(cod) as quant, id_arquivo 
      	from downloads_meta 
		where data between str_to_date(:inicial_date, '%d/%m/%Y') and str_to_date(:final_date, '%d/%m/%Y')
		group by id_arquivo";
	$query2 = $db_02->prepare($sql2);
	$query2->execute(array(
		':inicial_date' => $_POST['inicial_date'],
		':final_date' => $_POST['final_date']
	));
	
	foreach($query2->fetchAll() as $r) {
		
		switch ($r['id_arquivo']) {
			default: $arquivo = "SIGMA 2010"; break;
			case 1: $arquivo = "SIGMA 2012 Free"; break;
			case 2: $arquivo = "SIGMA 2012 Professional"; break;
			case 3: $arquivo = "SIGMA 2012 Enterprise"; break;
		}
		
		$row[$arquivo] = $r['quant'];
	}
        
        //Total de downloads por UF
        $sql3 = "select count(cod) as quant, uf, pais 
                from downloads_meta 
		where data between str_to_date(:inicial_date, '%d/%m/%Y') and str_to_date(:final_date, '%d/%m/%Y')
		group by uf";
	$query3 = $db_02->prepare($sql3);
	$query3->execute(array(
		':inicial_date' => $_POST['inicial_date'],
		':final_date' => $_POST['final_date']
	));
	
	foreach($query3->fetchAll() as $fetch) {
		
                $pais = $fetch['pais'];
                $uf = $fetch['uf'];
                
                if ($pais == 'BR' || $pais == 'PT') {
                    $uf = $pais."-".$uf;
                }
                
		$rrow[$uf] = $fetch['quant'];
	}
?>
<script>
google.load('visualization', '1.0', {'packages':['corechart', 'geochart']});
google.setOnLoadCallback(drawChart);
google.setOnLoadCallback(drawChart2);
google.setOnLoadCallback(drawChart3);

function drawChart() {

    // Create the data table.
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Data');
    data.addColumn('number', 'SIGMA 2012 Free');
    data.addColumn('number', 'SIGMA 2012 Professional');
    data.addColumn('number', 'SIGMA 2012 Enterprise');
    data.addColumn('number', 'SIGMA 2010');
    data.addRows([
<?php foreach ($linha as $data => $info) { 
      echo "['".$data."', ".$info[0]['quantidade'].", ".$info[1]['quantidade'].", ".$info[2]['quantidade'].", ".$info[3]['quantidade']." ],";
 } ?>
 	]);
    // Set chart options
    var options = {'title':'Downloads por licença pelo tempo',
                   'width':900,
                   'height':500
                   };
		
    // Instantiate and draw our chart, passing in some options.
    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}

function drawChart2() {

    // Create the data table.
    var data2 = new google.visualization.DataTable();
    data2.addColumn('string', 'Licença');
    data2.addColumn('number', 'Downloads');
    data2.addRows([
<?php foreach ($row as $licenca => $quantidade) { 
      echo "['".$licenca."', ".$quantidade." ],";
 } ?>
 	]);
    // Set chart options
    var options2 = {'title':'Total de downloads por licença',
                   'width':900,
                   'height':300
                   };
		
    // Instantiate and draw our chart, passing in some options.
    var chart2 = new google.visualization.PieChart(document.getElementById('chart_div2'));
    chart2.draw(data2, options2);
}

function drawChart3() {

    // Create the data table.
    var data3 = new google.visualization.DataTable();
    data3.addColumn('string', 'UF');
    data3.addColumn('number', 'Downloads');
    data3.addRows([
<?php foreach ($rrow as $uf => $quantidade) {
        echo "['".$uf."', ".$quantidade." ],";
 } ?>         
 	]);
    // Set chart options
    var options3 = {'title':'Total de downloads por região',
                   'width':900,
                   'height':600,
                   'displayMode': 'markers',
                   'region': 'BR',
                   'colorAxis': {colors: ['green', 'blue']}
                   };
		
    // Instantiate and draw our chart, passing in some options.
    var chart3 = new google.visualization.GeoChart(document.getElementById('chart_div3'));
    chart3.draw(data3, options3);
}
</script>
	<div id="chart_div" style="margin: auto; width:900; height:500"></div>
	<div id="chart_div2" style="margin: auto; width:900; height:300"></div>
        <div id="chart_div3" style="margin: auto; width:900; height:600"></div>
<?php 
}//fim do $_POST

?>
</div>
<script>
$(document).ready(function() {
	$('#inicial_date').mask('99/99/9999');
	$('#final_date').mask('99/99/9999');
});

</script>
</body>
</html>