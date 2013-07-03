<?php
require '../fpdf/fpdf_plus.php';

if (isset ($_GET['ano'])) $ano = $_GET['ano'];
else $ano = date('Y');

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
$pdf->Cell(0, 0, utf8_decode('Relatório de Origem de Inscritos em '.$ano), 0, 0, 'C');

//Tabela
$pdf->SetFont('Arial','B',8);
$pdf->SetY('30'); //localização no eixo Y
$pdf->SetWidths(array(32,13,15,11,9,9,11,10,12,16,14,16,16,14)); //Largura de cada coluna
$pdf->SetFillColor('250', '235', '215');

$pdf->Row(array("Origem", "Janeiro", "Fevereiro", utf8_decode("Março"), "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro", "Total"));

//Seleciona tipos de origem
$sql = "select distinct(
			case como_conheceu
			when 'amigos' then 'amigos'
			when 'amigo' then 'amigos'
			when 'senai' then 'senai'
			when 'jornal' then 'jornal'
			when 'internet' then 'internet'
			when 'google' then 'google'
			when 'forum_sigma' then 'forum'
			when 'forum' then 'forum'
			when 'forum_rede_industrial' then 'forum'
			when 'facebook' then 'facebook'
			when 'empresa' then 'empresa'
			when 'email' then 'email'
			when 'outro' then 'outro'
			else 'não informado'
			end
		) as como_conheceu
		from cwk_users order by como_conheceu desc";
$query = mysql_query($sql, $conn);

while ($res = mysql_fetch_assoc($query)) {

	$como_conheceu = $res['como_conheceu'];
	
	//Nome a aparecer na tabela
	switch ($como_conheceu) {
		case "não informado": $conheceu = "Não informado"; break;
		case "senai": $conheceu = "Senai"; break;
		case "outro": $conheceu = "Outro"; break;
		case "jornal": $conheceu = "Jornal"; break;
		case "internet": $conheceu = "Internet"; break;
		case "google": $conheceu = "Google"; break;
		case "forum_rede_industrial": $conheceu = "Fórum Rede Industrial"; break;
		case "forum_sigma": $conheceu = "Fórum Sigma"; break;
		case "forum": $conheceu = "Fórum"; break;
		case "facebook": $conheceu = "Facebook"; break;
		case "empresa": $conheceu = "Empresa"; break;
		case "email": $conheceu = "E-mail"; break;
		case "amigos": $conheceu = "Amigos"; break;
		case "amigo": $conheceu = "Amigo"; break;
	}
	
	//Para fazer pesquisa apenas do que é desejado
	switch ($como_conheceu) {
		case "não informado": $como_conheceu = "null, ''"; break;
		case "senai": $como_conheceu = "'senai'"; break;
		case "outro": $como_conheceu = "'outro'"; break;
		case "jornal": $como_conheceu = "'jornal'"; break;
		case "internet": $como_conheceu = "'internet'"; break;
		case "google": $como_conheceu = "'google'"; break;
		case "forum_rede_industrial": $como_conheceu = "'forum_rede_industrial', 'forum_sigma', 'forum'"; break;
		case "forum_sigma": $como_conheceu = "'forum_rede_industrial', 'forum_sigma', 'forum'"; break;
		case "forum": $como_conheceu = "'forum_rede_industrial', 'forum_sigma', 'forum'"; break;
		case "facebook": $como_conheceu = "'facebook'"; break;
		case "empresa": $como_conheceu = "'empresa'"; break;
		case "email": $como_conheceu = "'email'"; break;
		case "amigos": $como_conheceu = "'amigo', 'amigos'"; break;
		case "amigo": $como_conheceu = "'amigo', 'amigos'"; break;
	}
	
	//Tabela de como cada usuário conheceu os cursos em cada mês
	$quant = array(); //Quantidade de inscritos por mês em cada origem
	for ($mes = 1; $mes <= 12; $mes++) { //loop de usuários por mês
		$pesq1 = "SELECT count(como_conheceu) as total_conheceu
		FROM cwk_users
		WHERE como_conheceu in (".$como_conheceu.")
		AND month(dh_inscrito)='".$mes."'
		AND year(dh_inscrito)='".$ano."'";
		$query_pes = mysql_query($pesq1, $conn);
		$result = mysql_fetch_array($query_pes);
		$quant[$mes] = $result[0];
	}
	//Coluna de total de como cada usuário conheceu por ano
	$pesq2 = "SELECT count(como_conheceu) as total_ano
		FROM cwk_users
		WHERE como_conheceu in (".$como_conheceu.")
		AND year(dh_inscrito)='".$ano."'";
	$query_pes2 = mysql_query($pesq2, $conn);
	$r = mysql_fetch_assoc($query_pes2);
	$total_ano = $r['total_ano'];

	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor('250', '240', '230');
	$pdf->Row(array(utf8_decode("$conheceu"), "$quant[1]", "$quant[2]", "$quant[3]", "$quant[4]", "$quant[5]", "$quant[6]", "$quant[7]", "$quant[8]", "$quant[9]", "$quant[10]", "$quant[11]", "$quant[12]", "$total_ano"));
}	

	//Linha de total dos usuários por mês
	for ($mes = 1; $mes <= 12; $mes++) { //loop de usuários por mês
		$p = "select count(como_conheceu) as total_mes
			from cwk_users
			where month(dh_inscrito)='".$mes."'
			and year(dh_inscrito)='".$ano."'";
		$q = mysql_query($p, $conn);
		$re = mysql_fetch_array($q);
		$quant[$mes] = $re[0];
	}
	//Célula com total de usuários no ano
	$pe = "select count(como_conheceu) as total_geral
			from cwk_users
			where year(dh_inscrito)='".$ano."'";
	$qu = mysql_query($pe, $conn);
	$resu = mysql_fetch_assoc($qu);
	$total_geral = $resu['total_geral'];
	
	$pdf->Row(array("Total", "$quant[1]", "$quant[2]", "$quant[3]", "$quant[4]", "$quant[5]", "$quant[6]", "$quant[7]", "$quant[8]", "$quant[9]", "$quant[10]", "$quant[11]", "$quant[12]", "$total_geral"));



$pdf->Output(); //sugerido nome do arquivo, envia para o browser e dá opção de salvar
?>