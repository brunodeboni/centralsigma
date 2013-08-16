<?php
session_start();
if(!isset($_SESSION['5468usuario'])) die("<strong>Acesso Negado!</strong>");

// Conexão com mysql
$conn = mysql_connect("cloud1.redeindustrial.com.br","webadmin","webADMIN") or die("Sem conexão com o Banco de Dados");
mysql_select_db("centralsigma02",$conn) or die("Não foi possivel selecionar o Banco de Dados");


?>
<!doctype html> 
<html>
<head>
    <meta charset="utf-8">
    <style>
    	body {font-size: 12px; font-family:Verdana, sans-serif;}
        h1 {font-size:20px; color: #CD5C5C;}
		.mostrar {font-weight:bold;}
		.relatorio {font-size: 14px; font-weight:bold; text-decoration: none; color: #B03060;}
        .tabela {
          border:2px; width:100%; height:378px; overflow:auto;  
        }
		.ano {color: gray; margin-bottom: -3px;}
        .firstline {background-color: #FAF0E6;}
        .secondline {background-color: #FAEBD7;}
    </style>
    
</head>
<body>
    <h1>&Uacute;ltimos 100 Downloads</h1>

<div class="tabela">
<table id="dados">
<tr class="firstline">
    
    <td>Data/Hora
    <td>Origem
    <td>Pa&iacute;s
    <td>UF
    <td>Nome
    <td>Telefone
    <td>Celular
    <td>E-Mail
    <td>Empresa
    <td>Downloads
	</tr>
<?php

if( isset($_GET['limite']) ){
    $limite = $_GET["limite"];
}else{
// padrão
    $limite = 100;
}

$sql1 = "select cod, id_arquivo, data, origem, pais, uf, arquivo, nome, 
	email, empresa, telefone, celular from downloads_meta 
	order by data desc limit $limite";
$qry1 = mysql_query($sql1,$conn);

        $rowq = true;
	while($res = mysql_fetch_assoc($qry1)) {
        set_time_limit(0);
            
            
        if($rowq) $class = "secondline";
		else $class = "firstline";
		$rowq = !$rowq;
		
               
		$datahora = mysql_fetch_row(mysql_query("SELECT DATE_FORMAT('$res[data]','%d/%m/%Y %H:%i')"));
		$datahora = $datahora[0];
		
      
                
		echo "<tr class=\"$class\">";
               
			//echo "<td>$res[cod]</td>";
			echo "<td>$datahora";
			echo "<td>$res[origem]";
			echo "<td>$res[pais]";
			echo "<td><a href=\"pesq_empresa.php?uf=".$res['uf']."\">$res[uf]</a>";
			echo "<td>".utf8_encode($res['nome']);
			echo "<td>$res[telefone]";
			echo "<td>$res[celular]";
			echo "<td>$res[email]";
			echo "<td><a href=\"pesq_empresa.php?empresa=".$res['empresa']."\">$res[empresa]</a>";
                       
                $arquivo = $res["id_arquivo"];
                 
                switch($arquivo){
				default: echo "<td>Sigma 2012 Free"; break;
				case 1: echo "<td>Sigma 2012 Free"; break;
				case 2: echo "<td>Sigma 2012 Professional"; break;
				case 3: echo "<td>Sigma 2012 Enterprise"; break;
				}   
                        
                 
                
                  

        }
        
?>
    
</table>
</div>
<a class="mostrar" href="?limite=10000">Mostrar todos</a>
<br><br>
<div>
<h1>Estat&iacute;sticas</h1>
<form action="#" method="post">
<span>Exibir Ano:
<input type="text" name="ano" value="" size="4" maxlength="4"/>
<button type="submit">Pesquisar</button>
</span>
</form>
<br/>
<table>
    <tr class="firstline">
        <td>Downloads/M&ecirc;s
        <td>Janeiro
        <td>Fevereiro
        <td>Mar&ccedil;o
        <td>Abril
        <td>Maio
        <td>Junho
        <td>Julho
        <td>Agosto
        <td>Setembro
        <td>Outubro
        <td>Novembro
        <td>Dezembro
     </tr>   
<?php
// Conexão com mysql
$conn = mysql_connect("cloud1.redeindustrial.com.br","webadmin","webADMIN") or die("Sem conexão com o Banco de Dados");
mysql_select_db("centralsigma02",$conn) or die("Não foi possivel selecionar o Banco de Dados");

	//Pega o 'post' do ano
    if (empty ($_POST['ano'])) 
        $ano_pesq = 2013;
    else $ano_pesq = mysql_real_escape_string($_POST['ano']);
    
	echo "<p class=\"ano\">&nbsp;".$ano_pesq."</p>";
	
	$rowq = true; //Classe das cores das linhas
	
	//Pesquisa as licenças existentes
	$pesq = 'SELECT distinct(id_arquivo) FROM downloads_meta' or die ('Não foi possível encontrar as licenças.');
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
		
		//Classe das cores das linhas       
        if($rowq) $class = "secondline";
		else $class = "firstline";
		$rowq = !$rowq;
		
		//Tabela das licenças baixadas em cada mês
        echo "<tr class=\"$class\">";
       	echo "<td>$nome_licenca";
        for ($mes = 1; $mes <= 12; $mes++) { //loop de licenças por mês
            $pesq1 = mysql_query('SELECT count(id_arquivo) FROM downloads_meta WHERE id_arquivo='.$licenca.' AND month(data)='.$mes.' AND year(data)='.$ano_pesq.'', $conn) or die ('Não foi possível realizar a pesquisa.');
            $array = mysql_fetch_array($pesq1);
            echo "<td>".$array[0];
        }  
	}
    
    //Total das licenças baixadas por mês
	echo "<tr class=\"$class\">";
    echo "<td>Total";
    for ($mes = 1; $mes <= 12; $mes++) { //loop de licenças por mês
        $pesq1 = mysql_query('SELECT count(id_arquivo) FROM downloads_meta WHERE month(data)='.$mes.' AND year(data)='.$ano_pesq.'', $conn) or die ('N�o foi poss�vel realizar a pesquisa.');
        $array = mysql_fetch_array($pesq1);
        echo "<td>".$array[0];
        }
              
?>

</table>
<br>
<a class="relatorio" href="relatorio_estatisticas.php?ano=<?php echo $ano_pesq; ?>" target="_blank">Gerar Relat&oacute;rio em PDF</a>
<br>
</div>
<br>
<div>
<h1>Pesquisa</h1>
<form action="#" method="post">
	<span>Pesquise por nome da empresa:</span>
	<input name="empresa">
	<button type="submit">Pesquisar</button>
</form>
<br><br>
<form action="#" method="post">
	<span>Pesquise por UF da empresa:&nbsp;&nbsp;&nbsp;</span>
	<input name="uf">
	<button type="submit">Pesquisar</button>
</form>
<br>
<?php 
if (isset($_POST['empresa']) ) {
	$empresa = mysql_real_escape_string($_POST['empresa']);
	
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
				<td><b>Celular</b>
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
		$celular = $res['celular'];
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
				<td>'.$celular.'
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

if (isset($_POST['uf']) ) {
	$uf = mysql_real_escape_string($_POST['uf']);
	
	echo '<a class="relatorio" href="relatorio.php?uf='.$uf.'" target="_blank">Gerar Relat&oacute;rio em PDF</a><br>';
	
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
			default: echo "<td>Sigma 2012 Free"; break;
			case 1: echo "<td>Sigma 2012 Free"; break;
			case 2: echo "<td>Sigma 2012 Professional"; break;
			case 3: echo "<td>Sigma 2012 Enterprise"; break;
		}
	}
	echo '</table>';
	
	
}else echo '';

?>
</div>
<br>
<div>
	<h1>Total de Downloads</h1>
	<?php include 'total.php'; ?>
</div>
<div>
	<?php include 'estatisticas_acessos.php'; ?>
</div>
</body>
</html>