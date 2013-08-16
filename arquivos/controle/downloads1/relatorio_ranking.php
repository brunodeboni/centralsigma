<?php
require '../fpdf/fpdf_plus.php';

if (isset ($_GET['ano'])) $ano = $_GET['ano'];
else $ano = date('Y');

// Conexão com mysql
$conn = mysql_connect("cloud1.redeindustrial.com.br","webadmin","webADMIN") or die("Sem conexão com o Banco de Dados");
mysql_select_db("centralsigma04",$conn) or die("Não foi possivel selecionar o Banco de Dados");
mysql_set_charset("utf8",$conn);

//Abre o PDF
$pdf = new PDF('P', 'mm', 'A4'); //formato retrato, medida mm, tamanho A4
$pdf->Open();
$pdf->AddPage();
$pdf->SetTitle('Relatorio', 'true'); //título do documento, is_utf-8

//Título da página
$pdf->SetY('15');
$pdf->SetFont('Arial','B',22);
$pdf->Cell(0, 0, utf8_decode('Relatório do Ranking de Acesso em '.$ano), 0, 0, 'C');

//Tabela
$pdf->SetFont('Arial','B',8);
$pdf->SetY('30'); //localização no eixo Y
$pdf->SetWidths(array(32,13,15,11,9,9,11,10,12,16,14,16,16,12)); //Largura de cada coluna
$pdf->SetFillColor('250', '235', '215');


$pdf->Row(array("Aplicativos", "Janeiro", "Fevereiro", utf8_decode("Março"), "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro", "Total"));


//Pesquisa os tipos de aplicativos para criar o loop da tabela
$pesq = mysql_query('select distinct(ACESCLI_APLICATIVO) from ACESSO_CLIENTE where ACESCLI_APLICATIVO IS NOT NULL', $conn);

$apli = array(); //array com todos os dados da tabela
$count = 0; //inicializa contador de aplicativos

//Enquanto tiver aplicativos no banco... loop
while ($res = mysql_fetch_assoc($pesq)) {
	$aplicativo = $res["ACESCLI_APLICATIVO"];
	 
	$apli[$count] = array(); //adiciona o contador de aplicativos como índice do array
	$apli[$count]["id"] = $aplicativo; //cada aplicativo
	$apli[$count]["meses"] = array(); //array dos meses
	
	$pesquisa_sql  = "SELECT month(ACESCLI_DTHORA) FROM ACESSO_CLIENTE 
	WHERE ACESCLI_APLICATIVO='$aplicativo' AND year(ACESCLI_DTHORA) = '$ano'";
	$pesquisa = mysql_query($pesquisa_sql, $conn);
	
	for ($mes = 1; $mes <= 12; $mes++) { //loop de aplicativos acessados por mês
			
		//Conta os aplicativos acessados por mês e por ano
		$apli[$count]["meses"][$mes] = 0; //monta array com os acessos de cada mês
	}
	
	while($resck = mysql_fetch_row($pesquisa)){
		$shsh = (int) $resck[0];
		$apli[$count]["meses"][$shsh]++;
	}
	
	$count++; //contador de aplicativos
	
	//Total de aplicativos acessados por ano
	
	// Para cada app diferente
	foreach($apli as &$mapp){
		$mtotal = 0; // total é zero
		// Para cada mês desse app
		foreach($mapp["meses"] as $mapm){
			$mtotal += $mapm; // adiciona o mês atual no total
		}
	
		// adiciona $apli["total"]
		$mapp["total"] = $mtotal;
	}
	
	
}

//Ordenar o total de acessos de cada mês em forma de ranking
$function = create_function('$a, $b', 'return $b[\'total\'] - $a[\'total\'];');
usort($apli, $function);


$count = 0; //inicializa contador de aplicativos

for ($conterm = 0; $conterm <= 16; $conterm++) {

	//Nomeia os aplicativos
	switch($apli[$conterm]["id"]){
		case 'SIGMA': $app = "SIGMA"; break;
		case 'LP.EXE': $app = "LP"; break;
		case 'LD.EXE': $app = "LD"; break;
		case 'APROVASS.EXE': $app = "APROVASS"; break;
		case 'ALERTA.EXE': $app = "ALERTA"; break;
		case 'MONITORAMENTO_ONLINE.EXE': $app = "MONITORAMENTO ONLINE"; break;
		case 'SOFTOS.EXE': $app = "SOFTOS"; break;
		case 'SS.EXE': $app = "SS"; break;
		case 'ESCALATRABALHO.EXE': $app = "ESCALA DE TRABALHO"; break;
		case 'LEMBRETE.EXE': $app = "LEMBRETE"; break;
		case 'EWO.EXE': $app = "EWO"; break;
		case 'OS.EXE': $app = "OS"; break;
		case 'SMARTOS.EXE': $app = "SMARTOS"; break;
		case 'SIGMASMS.EXE': $app = "SIGMASMS"; break;
		case 'SOLICITACAO.EXE': $app = "SOLICITACAO"; break;
		case 'INTEGRASIGMA.EXE': $app = "INTEGRASIGMA"; break;
		case 'SIGMANR13.EXE': $app = "SIGMANR13"; break;
	}
	
	$app_mes = array(); //array para inserir resultados na tabela
	for ($mes = 1; $mes <= 12; $mes++) { //loop de aplicativos acessados por mês
		$app_mes[$mes] = $apli[$conterm]["meses"][$mes];
	}
	$count++;
	$total = $apli[$conterm]["total"];
	
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor('250', '240', '230');
	$pdf->Row(array("$app", "$app_mes[1]", "$app_mes[2]", "$app_mes[3]", "$app_mes[4]", "$app_mes[5]", "$app_mes[6]", "$app_mes[7]", "$app_mes[8]", "$app_mes[9]", "$app_mes[10]", "$app_mes[11]", "$app_mes[12]", "$total"));
	
	
}

$pdf->Output(); 
?>