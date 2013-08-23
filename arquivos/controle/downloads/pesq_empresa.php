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
require_once '../../../conexoes.inc.php';
$conn = Database::instance('centralsigma02');


if (isset($_GET['empresa']) ) {
	
	$sql = "select date_format(downloads.data, '%d/%m/%Y') as data, downloads.empresa, downloads.uf, downloads.pais, downloads.nome, downloads.telefone, downloads.email, downloads.id_arquivo 
			from downloads_meta as downloads
			where downloads.empresa LIKE :empresa order by downloads.data desc";
	$query = $conn->prepare($sql);
        $query->execute(array(':empresa' => "%".$_GET['empresa']."%"));
        $result = $query->fetchAll();
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
	foreach ($result as $res) {
                $empresa = $res['empresa'];
		$uf = $res['uf'];
		$pais = $res['pais'];
		$nome = $res['nome'];
		$telefone = $res['telefone'];
		$email = $res['email'];
		$data = $res['data'];
		
		
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
				<td>'.$email;
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
	
	$sql = "select date_format(downloads.data, '%d/%m/%Y') as data, downloads.empresa, downloads.uf, downloads.pais, downloads.nome, downloads.telefone, downloads.email, downloads.id_arquivo
			from downloads_meta as downloads
			where downloads.uf = :uf order by downloads.data desc";
	$query = $conn->prepare($sql);
        $query->execute(array(':uf' => $_GET['uf']));
        $result = $query->fetchAll();
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
				<td><b>Download</b>';
	$rowq = true; //Classe das cores das linhas
	foreach ($result as $res) {
                $empresa = $res['empresa'];
		$uf = $res['uf'];
		$pais = $res['pais'];
		$nome = $res['nome'];
		$telefone = $res['telefone'];
		$email = $res['email'];
		$data = $res['data'];
		
		
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