<?php
require '../fpdf/fpdf_plus.php';

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
$pdf->Cell(0, 0, utf8_decode('Relatório de Inscritos por Curso'), 0, 0, 'C');

//Tabela
$pdf->SetFont('Arial','B',12);
$pdf->SetY('30'); //localização no eixo Y
$pdf->SetWidths(array(120,30)); //Largura de cada coluna
$pdf->SetFillColor('250', '235', '215');

$pdf->Row(array("Curso", "Inscritos"));

//Totatl de inscritos por curso
$sql2 = "SELECT count(inscritos.id) as total_inscritos, inscritos.id_turma, turmas.id_curso, cursos.nome as nome_curso
FROM cw_cursos_inscritos as inscritos
left join cw_cursos_turmas as turmas on turmas.id=inscritos.id_turma
left join cw_cursos as cursos on turmas.id_curso=cursos.id
group by turmas.id_curso";
$query2 = mysql_query($sql2, $conn);


while ($res2 = mysql_fetch_assoc($query2)) {
	$inscritos = $res2['total_inscritos'];
	$curso = $res2['nome_curso'];

	$pdf->SetFont('Arial','',12);
	$pdf->SetFillColor('250', '240', '230');
	$pdf->Row(array("$curso", "$inscritos"));
}

//Total de inscritos
$sql = "SELECT count(id) as inscritos FROM cw_cursos_inscritos";
$query = mysql_query($sql, $conn);

$result = mysql_fetch_assoc($query);

$total_inscritos = $result['inscritos'];

$pdf->Ln();
$pdf->SetFont('Arial','B',12);
$pdf->Cell(40, 0, 'Total inscritos:', 0, 0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(0, 0, $total_inscritos, 0, 0);

$pdf->Output(); //sugerido nome do arquivo, envia para o browser e dá opção de salvar
?>