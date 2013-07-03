<?php

require '../fpdf/fpdf_plus.php';

if(isset ($_GET['uf'])) $uf = $_GET['uf'];
else exit;

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
$pdf->Cell(0, 0, utf8_decode('Relatório de Inscritos no Estado de '.strtoupper($uf)), 0, 0, 'C');

//Tabela
$pdf->SetFont('Arial','B',12);
$pdf->SetY('30'); //localização no eixo Y
$pdf->SetWidths(array(24,45,45,10,30,30)); //Largura de cada coluna
$pdf->SetFillColor('250', '235', '215');

$pdf->Row(array("Data", "Nome", "Empresa", "UF", "Cargo", "Telefone"));

$sql = "select usuarios.nome, usuarios.empresa, usuarios.cargo, usuarios.uf,
		usuarios.telefone, date_format(usuarios.dh_inscrito, '%d/%m/%Y') as data
		from cwk_users as usuarios
		where usuarios.uf='".$uf."'";
$query = mysql_query($sql, $conn);

while ($res = mysql_fetch_assoc($query)) {
	$empresa = $res['empresa'];
	$uf = $res['uf'];
	$nome = $res['nome'];
	$telefone = $res['telefone'];
	$data = $res['data'];
	$cargo = $res['cargo'];

	
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor('250', '240', '230');
	$pdf->Row(array("$data", utf8_decode("$nome"), utf8_decode("$empresa"), "$uf", utf8_decode("$cargo"), "$telefone"));
	
}

$pdf->Output(); //sugerido nome do arquivo, envia para o browser e dá opção de salvar
