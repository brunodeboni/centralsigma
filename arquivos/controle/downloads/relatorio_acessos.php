<?php

require '../fpdf/fpdf_plus.php';

if(isset ($_GET['uf'])) $uf = $_GET['uf'];
else exit;

// Conexão com mysql
$conn = mysql_connect("cloud1.redeindustrial.com.br","webadmin","webADMIN") or die("Sem conexão com o Banco de Dados");
mysql_select_db("centralsigma02",$conn) or die("Não foi possivel selecionar o Banco de Dados");

//Abre o PDF
$pdf = new PDF('P', 'mm', 'A4'); //formato retrato, medida mm, tamanho A4
$pdf->Open();
$pdf->AddPage();
$pdf->SetTitle('Relatorio', 'true'); //título do documento, is_utf-8

//Título da página
$pdf->SetY('15');
$pdf->SetFont('Arial','B',22);
$pdf->Cell(0, 0, utf8_decode('Relatório de Downloads no Estado de '.strtoupper($uf)), 0, 0, 'C');

//Tabela
$pdf->SetFont('Arial','B',12);
$pdf->SetY('30'); //localização no eixo Y
$pdf->SetWidths(array(24,45,10,12,40,26,35)); //Largura de cada coluna
$pdf->SetFillColor('250', '235', '215');

$pdf->Row(array("Data","Empresa","UF",utf8_decode("País"), "Nome", "Telefone", "Download"));

$sql = "select date_format(downloads.data, '%d/%m/%Y') as data, downloads.empresa, 
		downloads.uf, downloads.pais, downloads.nome, downloads.telefone, 
		downloads.email, downloads.id_arquivo
		from downloads_meta as downloads
		where downloads.uf='".$uf."' order by downloads.data desc";
$query = mysql_query($sql, $conn);

while ($res = mysql_fetch_assoc($query)) {
	$empresa = $res['empresa'];
	$uf = $res['uf'];
	$pais = $res['pais'];
	$nome = $res['nome'];
	$telefone = $res['telefone'];
	$email = $res['email'];
	$data = $res['data'];
	$arquivo = $res["id_arquivo"];
		
	switch($arquivo){
		default: $arquivo = "Sigma 2012 Free"; break;
		case 1: $arquivo = "Sigma 2012 Free"; break;
		case 2: $arquivo = "Sigma 2012 Professional"; break;
		case 3: $arquivo = "Sigma 2012 Enterprise"; break;
	}
	
	
	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor('250', '240', '230');
	$pdf->Row(array("$data",utf8_decode("$empresa"),"$uf","$pais", utf8_decode("$nome"), "$telefone", utf8_decode("$arquivo")));
	
}

$pdf->Output(); //sugerido nome do arquivo, envia para o browser e dá opção de salvar
