<?php

require '../fpdf/fpdf_plus.php';

$ano = date('Y');

// Conexão com mysql
$conn = mysql_connect("cloud1.redeindustrial.com.br","webadmin","webADMIN") or die("Sem conexão com o Banco de Dados");
mysql_select_db("centralsigma04",$conn) or die("Não foi possivel selecionar o Banco de Dados");
mysql_set_charset("utf8",$conn);

//Abre o PDF
$pdf = new PDF('P', 'mm', 'A4'); //formato retrato, medida mm, tamanho A4
$pdf->Open();
$pdf->AddPage();
$pdf->SetTitle('Relatorio', 'true'); //título do documento, is_utf-8

//Título 1
$pdf->SetY('15');
$pdf->SetFont('Arial','B',22);
$pdf->Cell(0, 0, utf8_decode('Relatório Geral'), 0, 1, 'C');
$pdf->SetY('25');
$pdf->Cell(0, 0, utf8_decode('Últimos 100 acessos ao SIGMA'), 0, 0, 'C');

//Tabela
$pdf->SetFont('Arial','B',12);
$pdf->SetY('30'); //localização no eixo Y
$pdf->SetWidths(array(24,45,40,25,30,30)); //Largura de cada coluna
$pdf->SetFillColor('250', '235', '215');


$pdf->Row(array("Data/Hora", "Empresa", utf8_decode("Negócio"), "Aplicativo", utf8_decode("Versão"), utf8_decode("Licença")));

$sql = "select date_format(ACESCLI_DTHORA,'%d/%m/%Y %H:%i') as datahora,
		ACESCLI_EMPRESA, ACESCLI_NEGOCIO, ACESCLI_APLICATIVO,
		ACESCLI_VERSAO, ACESCLI_LICENCA
		from ACESSO_CLIENTE order by ACESCLI_DTHORA desc
		limit 100";
$query = mysql_query($sql, $conn);

while ($res = mysql_fetch_assoc($query)) {
	$datahora = $res['datahora'];
	$empresa = $res['ACESCLI_EMPRESA'];
	$negocio = $res['ACESCLI_NEGOCIO'];
	$aplicativo = $res['ACESCLI_APLICATIVO'];
	$versao = $res['ACESCLI_VERSAO'];
	$licenca = $res['ACESCLI_LICENCA'];

	//Nomeia as licenças
	switch($licenca){
		default: $licenca = "0 - Desconhecida"; break;
		case 1: $licenca = "1 - Gratuita 2010"; break;
		case 2: $licenca = "2 - Trial 2012 Inicial"; break;
		case 3: $licenca = "3 - Paga 2012 Inicial"; break;
		case 4: $licenca = "4 - Free 2012"; break;
		case 5: $licenca = "5 - Professional 2012"; break;
		case 6: $licenca = "6 - Enterprise 2012"; break;
	}

	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor('250', '240', '230');
	$pdf->Row(array("$datahora", utf8_decode("$empresa"), utf8_decode("$negocio"), utf8_decode("$aplicativo"), utf8_decode("$versao"), "$licenca"));

}

//Título 2
$pdf->AddPage();
$pdf->SetY('15');
$pdf->SetFont('Arial','B',22);
$pdf->Cell(0, 0, utf8_decode('Acessos registrados em '.$ano), 0, 0, 'C');

//Tabela
$pdf->SetFont('Arial','B',8);
$pdf->SetY('30'); //localização no eixo Y
$pdf->SetWidths(array(32,13,15,11,9,9,11,10,12,16,14,16,16)); //Largura de cada coluna
$pdf->SetFillColor('250', '235', '215');


$pdf->Row(array("Acessos", "Janeiro", "Fevereiro", utf8_decode("Março"), "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"));


//Pesquisa as licenças existentes
$pesq = mysql_query('SELECT distinct(ACESCLI_LICENCA) FROM ACESSO_CLIENTE
		order by ACESCLI_LICENCA', $conn);


//Enquanto houver licenças no banco... loop
while ($res = mysql_fetch_assoc($pesq)) {
	 
	$licenca = $res["ACESCLI_LICENCA"];

	//Nomeia as licenças
	switch($licenca){
		default: $nome_licenca = "0 - Desconhecida"; break;
		case 1: $nome_licenca = "1 - Gratuita 2010"; break;
		case 2: $nome_licenca = "2 - Trial 2012 Inicial"; break;
		case 3: $nome_licenca = "3 - Paga 2012 Inicial"; break;
		case 4: $nome_licenca = "4 - Free 2012"; break;
		case 5: $nome_licenca = "5 - Professional 2012"; break;
		case 6: $nome_licenca = "6 - Enterprise 2012"; break;
	}

	//Tabela das licenças utilizadas por mês
	$quant = array(); //quantidade de acessos registrados no mês
	for ($mes = 1; $mes <= 12; $mes++) { //loop de licenças por mês
		$pesq1 = mysql_query('SELECT count(ACESCLI_LICENCA) FROM ACESSO_CLIENTE
			WHERE ACESCLI_LICENCA='.$licenca.' AND month(ACESCLI_DTHORA)='.$mes.'
			AND year(ACESCLI_DTHORA)='.$ano.'', $conn);
		$array = mysql_fetch_array($pesq1);
		$quant[$mes] = $array[0];
	}

	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor('250', '240', '230');
	$pdf->Row(array("$nome_licenca", "$quant[1]", "$quant[2]", "$quant[3]", "$quant[4]", "$quant[5]", "$quant[6]", "$quant[7]", "$quant[8]", "$quant[9]", "$quant[10]", "$quant[11]", "$quant[12]"));


}
//Linha de Total
$tot = array(); //total de acessos registrados no mês
for ($mes = 1; $mes <= 12; $mes++) { //loop de licenças por mês
	$pesq1 = mysql_query('SELECT count(ACESCLI_LICENCA) FROM ACESSO_CLIENTE
			WHERE month(ACESCLI_DTHORA)='.$mes.'
			AND year(ACESCLI_DTHORA)='.$ano.'', $conn);
	$array = mysql_fetch_array($pesq1);
	$tot[$mes] = $array[0];
}
$pdf->Row(array("Total", "$tot[1]", "$tot[2]", "$tot[3]", "$tot[4]", "$tot[5]", "$tot[6]", "$tot[7]", "$tot[8]", "$tot[9]", "$tot[10]", "$tot[11]", "$tot[12]"));

//Título 3
$pdf->SetY('100');
$pdf->SetFont('Arial','B',22);
$pdf->Cell(0, 0, utf8_decode('Relatório do Ranking de Acesso em '.$ano), 0, 0, 'C');

//Tabela
$pdf->SetFont('Arial','B',8);
$pdf->SetY('115'); //localização no eixo Y
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