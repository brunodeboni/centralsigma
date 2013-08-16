<?php
require '../fpdf/fpdf_plus.php';

if (isset ($_GET['ano'])) $ano = $_GET['ano'];
else $ano = date('Y');

// Conexão com mysql
$conn = mysql_connect("cloud1.redeindustrial.com.br","webadmin","webADMIN") or die("Sem conexão com o Banco de Dados");
mysql_select_db("centralsigma02",$conn) or die("Não foi possivel selecionar o Banco de Dados");
mysql_set_charset("utf8",$conn);

//Abre o PDF
$pdf = new PDF('P', 'mm', 'A4'); //formato retrato, medida mm, tamanho A4
$pdf->Open();
$pdf->AddPage();
$pdf->SetTitle('Relatorio', 'true'); //título do documento, is_utf-8

//Título da página
$pdf->SetY('15');
$pdf->SetFont('Arial','B',22);
$pdf->Cell(0, 0, utf8_decode('Relatório de Downloads em '.$ano), 0, 0, 'C');

//Tabela
$pdf->SetFont('Arial','B',8);
$pdf->SetY('30'); //localização no eixo Y
$pdf->SetWidths(array(32,13,15,11,9,9,11,10,12,16,14,16,16)); //Largura de cada coluna
$pdf->SetFillColor('250', '235', '215');


$pdf->Row(array("Downloads", "Janeiro", "Fevereiro", utf8_decode("Março"), "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"));


//Pesquisa as licenças existentes
$pesq = 'SELECT distinct(id_arquivo) FROM downloads_meta';
$qry = mysql_query($pesq, $conn);


//Enquanto houver licenças no banco... loop
while ($res1 = mysql_fetch_assoc($qry)) {
	$licenca = $res1['id_arquivo'];
		
	if (!$licenca) {
		$licenca = 'NULL';
		$nome_licenca = 'Não especificada';
	}else {
		//Nomeia as licenças
		switch($licenca){ 
			case 1: $nome_licenca = "Sigma 2012 Free"; break;
			case 2: $nome_licenca = "Sigma 2012 Professional"; break;
			case 3: $nome_licenca = "Sigma 2012 Enterprise"; break;
		}
	}
	
	//Tabela das licenças baixadas em cada mês
	$quant = array();
	for ($mes = 1; $mes <= 12; $mes++) { //loop de licenças por mês
		$pesq1 = mysql_query('SELECT count(id_arquivo) FROM downloads_meta WHERE id_arquivo='.$licenca.' AND month(data)='.$mes.' AND year(data)='.$ano.'', $conn);
        $array = mysql_fetch_array($pesq1);
		$quant[$mes] = $array[0];
	}

	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor('250', '240', '230');
	$pdf->Row(array(utf8_decode("$nome_licenca"), "$quant[1]", "$quant[2]", "$quant[3]", "$quant[4]", "$quant[5]", "$quant[6]", "$quant[7]", "$quant[8]", "$quant[9]", "$quant[10]", "$quant[11]", "$quant[12]"));

}
//Linha de Total
$tot = array(); //total de acessos registrados no mês
for ($mes = 1; $mes <= 12; $mes++) { //loop de licenças por mês
	$pesq1 = mysql_query('SELECT count(id_arquivo) FROM downloads_meta 
			WHERE month(data)='.$mes.' AND year(data)='.$ano.'', $conn);
	$array = mysql_fetch_array($pesq1);
	$tot[$mes] = $array[0];
}
$pdf->Row(array("Total", "$tot[1]", "$tot[2]", "$tot[3]", "$tot[4]", "$tot[5]", "$tot[6]", "$tot[7]", "$tot[8]", "$tot[9]", "$tot[10]", "$tot[11]", "$tot[12]"));

$pdf->Output();
?>