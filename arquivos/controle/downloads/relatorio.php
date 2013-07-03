<?php

require '../fpdf/fpdf_plus.php';


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
$pdf->Cell(0, 0, utf8_decode('Relatório dos Últimos 100 acessos ao SIGMA'), 0, 0, 'C');

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

$pdf->Output();
?>