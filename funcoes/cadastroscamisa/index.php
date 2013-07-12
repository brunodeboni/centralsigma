<?php
if(!isset($_GET["sigma2012"])) die("<strong>Acesso Negado!</strong>");

$mysql = mysql_connect("mysql.centralsigma.com.br","centralsigma02","S4k813042012");
mysql_select_db("centralsigma02",$mysql);
mysql_set_charset("utf8",$mysql);

$sql1 = "select * from contato_pessoa order by contpess_id desc limit 1000";
$qry1 = mysql_query($sql1,$mysql);

?>
<doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Pessoas que se cadastraram para Camisa</title>
<style type="text/css">
*{padding:0;margin:0;}
#dados{
	width:100%;
	border-collapse:collapse;
	border:0;
	margin-bottom:30px;
	font-size:14px;
}
#dados .titulo{background:#DDE;font-weight:bold;}
#dados .firstline{background:#EEF;}
#dados .secondline{background:#E7E7F7;}
#dados td{padding:5px;}

#infodados{display:block;padding:5px;font-size:14px;background:#FFF;position:fixed;bottom:0px;border-top:2px solid #999;width:100%;}
#infodados span{margin:0 10px;}
</style>
</head>

<body>

<table id="dados">
<tr class="titulo">
	<td>ID</td>
    <td>Nome</td>
    <td>Empresa</td>
    <td>Endereco</td>
    <td>Bairro</td>
    <td>Cidade</td>
    <td>CEP</td>
    <td>Estado</td>
    <td>Regiao</td>
    <td>Telefone1</td>
    <td>Telefone2</td>
    <td>Setor</td>
    <td>e-mail</td>
    <td>Tamanho</td>
    <td>Mensagem</td>
    <td>Imagem anexada</td>
</tr>
<?php
	$rowq = false;
	while($res = mysql_fetch_assoc($qry1)){
		
		if($rowq) $class = "secondline";
		else $class = "firstline";
		$rowq = !$rowq;
		
		//$datahora = mysql_fetch_row(mysql_query("SELECT DATE_FORMAT('$res[ACESCLI_DTHORA]','%d/%m/%Y %H:%i')"));
		//$datahora = $datahora[0];
		
		echo "<tr class=\"$class\">";
			echo "<td>$res[contpess_id]</td>";
			echo "<td>$res[contpess_nome]</td>";
			echo "<td>$res[contpess_empresa]</td>";
			echo "<td>$res[contpess_endereco]</td>";
			echo "<td>$res[contpess_bairro]</td>";
			echo "<td>$res[contpess_cidade]</td>";
			echo "<td>$res[contpess_cep]</td>";
			echo "<td>$res[contpess_uf]</td>";
			echo "<td>$res[contpess_regiao]</td>";
			echo "<td>$res[contpess_telramal]</td>";
			echo "<td>$res[contpess_telcel]</td>";
			echo "<td>$res[contpess_setor]</td>";
			echo "<td>$res[contpess_email]</td>";
			echo "<td>$res[contpess_tamanho]</td>";
			echo "<td>$res[contpess_msgnatal]</td>";
			echo "<td>$res[contpess_camimagem]</td>";
		echo "</tr>";
	}
?>

<div id="infodados">
<span>Número total de linhas: <b><?php echo mysql_num_rows($qry1); ?></b></span>
</div>
</body>
</html>