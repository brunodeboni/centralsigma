<?php
require '../fpdf/fpdf_plus.php';

// Conexão com mysql
$conn = mysql_connect("aulasweb.com.br","webadmin","webADMIN") or die("Sem conexão com o Banco de Dados");
mysql_select_db("aulasweb",$conn) or die("Não foi possivel selecionar o Banco de Dados");

//Abre o PDF
$pdf = new PDF('P', 'mm', 'A4'); //formato retrato, medida mm, tamanho A4
$pdf->Open();
$pdf->AddPage();
$pdf->SetTitle('Relatorio', 'true'); //título do documento, is_utf-8

//Título da página
$pdf->SetY('15');
$pdf->SetFont('Arial','B',22);
$pdf->Cell(0, 0, utf8_decode('Relatório de Inscritos por Data'), 0, 0, 'C');

//Tabela
$pdf->SetFont('Arial','B',12);
$pdf->SetY('30'); //localização no eixo Y
$pdf->SetWidths(array(30,40,40)); //Largura de cada coluna
$pdf->SetFillColor('250', '235', '215');

$pdf->Row(array("Data", "Inscritos", "Cadastrados"));

//Total de inscritos por dia
$sql1 = 'select
date_format(dh_inscrito, \'%d/%m/%Y\') as dia,
count(id) as num_inscritos

from cw_cursos_inscritos as inscritos

group by 1 order by dh_inscrito desc';
$query1 = mysql_query($sql1, $conn);
	
while ($res = mysql_fetch_assoc($query1)) {

	$dia = $res['dia'];
	$num_inscritos = $res['num_inscritos'];
	
	//Total de novos inscritos por dia
	$sql2 = "select
	count(id) as num_users
		
	from cwk_users
		
	where date_format(dh_inscrito, '%d/%m/%Y')='".$dia."'";
	$query2 = mysql_query($sql2, $conn);
	$res2 = mysql_fetch_assoc($query2);
	$num_users = $res2['num_users'];
	
	
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor('250', '240', '230');
	$pdf->Row(array("$dia", "$num_inscritos", "$num_users"));
	
	
}

//Total de inscritos
$sql = "SELECT count(id) as inscritos FROM cw_cursos_inscritos";
$query = mysql_query($sql, $conn);

$result = mysql_fetch_assoc($query);

$total_inscritos = $result['inscritos'];

$pdf->Ln();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(33, 0, 'Total inscritos:', 0, 0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(40, 0, $total_inscritos, 0, 0);

//Total de cadastrados
$sql2 = "SELECT count(id) as cadastrados FROM cwk_users";
$query2 = mysql_query($sql2, $conn);

$result2 = mysql_fetch_assoc($query2);

$total_cadastrados = $result2['cadastrados'];

$pdf->SetX('60');
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40, 0, 'Total cadastrados:', 0, 0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0, 0, $total_cadastrados, 0, 0);

$pdf->Output(); //sugerido nome do arquivo, envia para o browser e dá opção de salvar
