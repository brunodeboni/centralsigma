<?php
require '../fpdf/fpdf_plus.php';


// Conexão com mysql
include '../../../conexoes.inc.php';
$db = Database::instance('centralsigma02');

//Abre o PDF
$pdf = new PDF('P', 'mm', 'A4'); //formato retrato, medida mm, tamanho A4
$pdf->Open();
$pdf->AddPage();
$pdf->SetTitle('Relatorio', 'true'); //título do documento, is_utf-8

//Título da página
$pdf->SetY('15');
$pdf->SetFont('Arial','B',22);
$pdf->Cell(0, 0, utf8_decode('Relatório de SMS\'s enviados'), 0, 0, 'C');

//Tabela
$pdf->SetFont('Arial','B',12);
$pdf->SetY('30'); //localização no eixo Y
$pdf->SetWidths(array(30,30)); //Largura de cada coluna
$pdf->SetFillColor('250', '235', '215');


$pdf->Row(array("Data", "Quantidade"));

//Pesquisa a quantidade de SMS's enviados por dia
$sql = "select DATE_FORMAT(DATE(DATA_ENVIO), '%d/%m/%Y') AS dia, count(CODIGO) AS quantidade 
		from sms WHERE DATA_ENVIO IS NOT NULL group by DIA order by DATA_ENVIO desc";
$query = $db->prepare($sql);
$query->execute();
$resultado = $query->fetchAll();

foreach ($resultado as $res) {
		
	$dia = $res['dia'];
	$quantidade = $res['quantidade'];	
	
	//Tabela exibe quantidade de SMS's enviados por dia
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor('250', '240', '230');
	$pdf->Row(array("$dia", "$quantidade"));

}

$pdf->Output();
?>