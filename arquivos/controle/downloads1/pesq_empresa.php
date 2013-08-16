<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<style>
		body {font-size: 12px; font-family:Verdana, sans-serif;}
        h1 {font-size:20px; color: #CD5C5C;}
        .firstline {background-color: #FAF0E6;}
        .secondline {background-color: #FAEBD7;}
	</style>
</head>
<body>
<div>
<h1>Pesquisa</h1>
<?php

// Conexão com mysql
$conn = mysql_connect("cloud1.redeindustrial.com.br","webadmin","webADMIN") or die("Sem conexão com o Banco de Dados");
mysql_select_db("centralsigma02",$conn) or die("Não foi possivel selecionar o Banco de Dados");


if (isset($_GET['empresa']) ) {
	$empresa = mysql_real_escape_string($_GET['empresa']);

	$sql = "select downloads.data, downloads.empresa, downloads.uf, downloads.pais, downloads.nome, downloads.telefone, downloads.email, downloads.id_arquivo 
			from downloads_meta as downloads
			where downloads.empresa LIKE '%".$empresa."%' order by downloads.data desc";
	$query = mysql_query($sql, $conn);

	echo '
		<table>
			<tr class="firstline">
				<td><b>Data</b>
				<td><b>Empresa</b>
				<td><b>UF</b>
				<td><b>Pa&iacute;s</b>
				<td><b>Nome</b>
				<td><b>Telefone</b>
				<td><b>E-mail</b>
    			<td><b>Download</b>
	';
	$rowq = true; //Classe das cores das linhas
	while ($res = mysql_fetch_assoc($query)) {
	$empresa = $res['empresa'];
		$uf = $res['uf'];
		$pais = $res['pais'];
		$nome = $res['nome'];
		$telefone = $res['telefone'];
		$email = $res['email'];
		
		$data = mysql_fetch_row(mysql_query("SELECT DATE_FORMAT('$res[data]','%d/%m/%Y')"));
		$data = $data[0];
		
		//Classe das cores das linhas
		if($rowq) $class = "secondline";
		else $class = "firstline";
		$rowq = !$rowq;
		
		echo '
			<tr class="'.$class.'">
    			<td>'.$data.'
				<td>'.$empresa.'
          		<td>'.$uf.'
				<td>'.$pais.'
				<td>'.$nome.'
				<td>'.$telefone.'
				<td>'.$email.'
		';
		$arquivo = $res["id_arquivo"];
		 
		switch($arquivo){
			default: echo "<td>Sigma 2012 Free";
			case 1: echo "<td>Sigma 2012 Free"; break;
			case 2: echo "<td>Sigma 2012 Professional"; break;
			case 3: echo "<td>Sigma 2012 Enterprise"; break;
		}
	}
	echo '</table>';
}else echo '';

if (isset($_GET['uf']) ) {
	$uf = mysql_real_escape_string($_GET['uf']);



	$sql = "select downloads.data, downloads.empresa, downloads.uf, downloads.pais, downloads.nome, downloads.telefone, downloads.email, downloads.id_arquivo
			from downloads_meta as downloads
			where downloads.uf='".$uf."' order by downloads.data desc";
	$query = mysql_query($sql, $conn);

	echo '
		<table>
			<tr class="firstline">
				<td><b>Data</b>
				<td><b>Empresa</b>
				<td><b>UF</b>
    			<td><b>Pa&iacute;s</b>
				<td><b>Nome</b>
				<td><b>Telefone</b>
				<td><b>E-mail</b>
				<td><b>Download</b>
	';
	$rowq = true; //Classe das cores das linhas
	while ($res = mysql_fetch_assoc($query)) {
	$empresa = $res['empresa'];
		$uf = $res['uf'];
		$pais = $res['pais'];
		$nome = $res['nome'];
		$telefone = $res['telefone'];
		$email = $res['email'];
		
		$data = mysql_fetch_row(mysql_query("SELECT DATE_FORMAT('$res[data]','%d/%m/%Y')"));
		$data = $data[0];
		
		//Classe das cores das linhas
		if($rowq) $class = "secondline";
		else $class = "firstline";
		$rowq = !$rowq;
		
		echo '
			<tr class="'.$class.'">
				<td>'.$data.'
				<td>'.$empresa.'
          		<td>'.$uf.'
				<td>'.$pais.'
				<td>'.$nome.'
				<td>'.$telefone.'
				<td>'.$email.'
		';
		$arquivo = $res["id_arquivo"];
			
		switch($arquivo){
			default: echo "<td>Sigma 2012 Free";
			case 1: echo "<td>Sigma 2012 Free"; break;
			case 2: echo "<td>Sigma 2012 Professional"; break;
			case 3: echo "<td>Sigma 2012 Enterprise"; break;
		}
	}
	echo '</table>';

}else echo '';


?>
</div>
</body>
</html>