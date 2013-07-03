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
$pdf->Cell(0, 0, utf8_decode('Relatório de Acessos em '.$ano), 0, 0, 'C');

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

$pdf->Output();
?>