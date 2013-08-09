<?php
//Conexões ao banco de dados
try {
	$db_02 = new PDO(
    	'mysql:host=mysql.centralsigma.com.br;dbname=centralsigma02', 
        'webadmin', 'webADMIN', 
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
    $db_02->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
} catch ( PDOException $e ) {
	echo 'PDO Exception: '.$e->getMessage();
}

try {
	$db_04 = new PDO(
    	'mysql:host=mysql.centralsigma.com.br;dbname=centralsigma04', 
        'webadmin', 'webADMIN', 
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
    );
    $db_04->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
} catch ( PDOException $e ) {
	echo 'PDO Exception: '.$e->getMessage();
}


?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Controle de Estatísticas SIGMA</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/jquery.maskedinput.js"></script>
	<script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/bruno.js"></script>
	<link rel="stylesheet" href="default.css" type="text/css">
</head>
<body>

<!-- Últimos 100 Downloads -->
<div class="wrapper">
<h1>Últimos 100 Downloads do SIGMA</h1>

<div class="tabela">
	<table id="dados">
		<thead class="header">
			<tr class="firstline">
			    <th>Data/Hora</th>
			    <th>Origem</th>
			    <th>País</th>
			    <th>UF</th>
			    <th>Nome</th>
			    <th>Telefone</th>
			    <th>Celular</th>
			    <th>E-Mail</th>
			    <th>Empresa</th>
			    <th>Downloads</th>
			    <th>Obs</th>
			    <th>Agenda</th>
			    <th>Responsável</th>
			</tr>
		</thead>
		<tbody>
<?php 

if( isset($_GET['limite_d']) ){
    $limite_d = (int) $_GET["limite_d"];
}else{
	//padrão
    $limite_d = 100;
}

$sql1 = "select m.cod, m.id_arquivo, date_format(m.data, '%d/%m/%Y %H:%i') as datahora, m.origem, m.pais, m.uf, m.arquivo, m.nome, 
	m.email, m.empresa, m.telefone, m.celular, c.obs, date_format(c.agenda, '%d/%m/%Y') as agenda, c.responsavel
	
	from downloads_meta as m
	left join downloads_contato as c on m.cod = c.id_download
	order by c.agenda desc, m.data desc limit :limite_d";
$query = $db_02->prepare($sql1);
$query->bindValue(':limite_d', $limite_d, PDO::PARAM_INT);
$query->execute();
$resultado = $query->fetchAll(); 

$row = 0;
foreach ($resultado as $res) {
	$class = ($row++%2==1) ? "firstline" : "secondline";
	
	echo "<tr class=\"$class\">";
               
		//echo "<td>$res[cod]</td>";
		echo "<td>$res[datahora]</td>";
		echo "<td>$res[origem]</td>";
		echo "<td>$res[pais]</td>";
		echo "<td><a href=\"pesq_empresa.php?uf=".$res['uf']."\">$res[uf]</a></td>";
		echo "<td>$res[nome]</td>";
		echo "<td>$res[telefone]</td>";
		echo "<td>$res[celular]</td>";
		echo "<td>$res[email]</td>";
		echo "<td><a href=\"pesq_empresa.php?empresa=".$res['empresa']."\">$res[empresa]</a></td>";
                       
		$arquivo = $res["id_arquivo"];
	                 
	    switch($arquivo){
			default: echo "<td>Sigma 2010</td>"; break;
			case 1: echo "<td>Sigma 2012 Free</td>"; break;
			case 2: echo "<td>Sigma 2012 Professional</td>"; break;
			case 3: echo "<td>Sigma 2012 Enterprise</td>"; break;
		}
		
		echo "<td><input type=\"text\" class=\"obs aj\" id=\"$res[cod]\"  value=\"$res[obs]\"></td>";
		echo "<td><input type=\"text\" class=\"agenda aj\" id=\"$res[cod]\"  value=\"$res[agenda]\"></td>";
		echo "<td><input type=\"text\" class=\"responsavel aj\" id=\"$res[cod]\"  value=\"$res[responsavel]\"></td>";
	echo "</tr>";
}

?>
		</tbody>
	</table>
<script>
$(document).ready(function() {
	$('.agenda').mask('99/99/9999');
});

$('.aj').pressEnter(function(){
	var obj = $(this).attr('class');
	
	if (obj == 'obs aj') {
		var classe = 'obs';
	}else if (obj == 'agenda aj') {
		var classe = 'agenda';
	}else if (obj == 'responsavel aj') {
		var classe = 'responsavel';
	}
	
	var valor = $(this).val();
	var id = $(this).attr('id');

	$.post('ajax_downloads.php', {id: id, classe: classe, valor: valor}, function(data) {
		if (data == 'sucesso') {
			alert('Alteração realizada com sucesso!');
		}else {
			alert('Erro ao executar sua alteração. Por favor, clique na caixa desejada e pressione Enter novamente.');
		}
	});

});

</script>
</div>
<br>
<a class="btn" href="?limite_d=10000">Mostrar todos</a>
<a class="btn" href="relatorio_ultimos_downloads.php" target="_blank">Gerar Relatório em PDF</a>
<a class="btn" href="grafico_ultimos_downloads.php">Gráficos</a>
<br>
</div>

<br>

<!-- Estatísticas de Downloads -->
<div class="wrapper">
	<h1>Estatísticas de Downloads do SIGMA</h1>
	<form action="#" method="post">
		<span>Exibir Ano:
			<input type="text" name="ano" size="4" maxlength="4" placeholder="aaaa">
			<button type="submit" class="btn">Pesquisar</button>
		</span>
	</form>
	<br/>
	<table>
		<thead class="header">
		    <tr class="firstline">
		    	<th>Downloads/Mês</th>
		        <th>Janeiro</th>
		        <th>Fevereiro</th>
		        <th>Março</th>
		        <th>Abril</th>
		        <th>Maio</th>
		        <th>Junho</th>
		        <th>Julho</th>
		        <th>Agosto</th>
		        <th>Setembro</th>
		        <th>Outubro</th>
		        <th>Novembro</th>
		        <th>Dezembro</th>
		        <th>Total</th>
		     </tr>
		</thead>
		<tbody>	   
<?php 

if (isset ($_POST['ano'])) {
	$ano = $_POST['ano'];
}else {
	$ano = date("Y");
}

echo "<p class=\"ano\">&nbsp;".$ano."</p>";

$sql2 = "select distinct(id_arquivo) as licenca from downloads_meta";
$query2 = $db_02->query($sql2);
$resultado2 = $query2->fetchAll();

$row = 0;
foreach ($resultado2 as $res) {
	$class = ($row++%2==1) ? "firstline" : "secondline";
	
	//Linha de cada tipo de arquivo
	switch ($res['licenca']) {
		case 1: $licenca = 'SIGMA 2012 Free'; break;
		case 2: $licenca = 'SIGMA 2012 Professional'; break;
		case 3: $licenca = 'SIGMA 2012 Enterprise'; break;
		default: $licenca = 'SIGMA 2010'; break;
	}
	
	echo '<tr class="'.$class.'">';
	echo "<td class=\"firstcol\">".$licenca."</td>";
	
	//Primeiro verifica as null (SIGMA 2010)
	if ($licenca == 'SIGMA 2010') {
		//Uma coluna a cada mês
		for ($i=1; $i<=12; $i++) {
			$sql3 = "select count(cod) as licenca_mes from downloads_meta 
				where id_arquivo is null 
				and month(data) = :mes and year(data) = :ano";
			$query3 = $db_02->prepare($sql3);
			$query3->bindValue(':ano', $ano, PDO::PARAM_INT);
			$query3->bindValue(':mes', $i, PDO::PARAM_INT);
			$query3->execute();
			$resultado3 = $query3->fetchAll();
			foreach ($resultado3 as $res3) {
				echo "<td>".$res3['licenca_mes']."</td>";
			}
		}
		//E uma coluna com o total de cada licença no ano, para o final da linha
		$sql4 = "select count(cod) as licenca_mes from downloads_meta 
					where id_arquivo is null and year(data) = :ano";
		$query4 = $db_02->prepare($sql4);
		$query4->bindValue(':ano', $ano, PDO::PARAM_INT);
		$query4->execute();
		$resultado4 = $query4->fetchAll();
		foreach ($resultado4 as $res4) {
				echo "<td>".$res4['licenca_mes']."</td>";
		}
	}else {
		//Depois as outras licenças
		//Uma coluna a cada mês
		for ($i=1; $i<=12; $i++) {
			$sql3 = "select count(cod) as licenca_mes from downloads_meta 
				where id_arquivo = :licenca
				and month(data) = :mes and year(data) = :ano";
			$query3 = $db_02->prepare($sql3);
			$query3->bindValue(':ano', $ano, PDO::PARAM_INT);
			$query3->bindValue(':mes', $i, PDO::PARAM_INT);
			$query3->bindValue(':licenca', $res['licenca'], PDO::PARAM_INT);
			$query3->execute();
			$resultado3 = $query3->fetchAll();
			foreach ($resultado3 as $res3) {
				echo "<td>".$res3['licenca_mes']."</td>";
			}
		}
		//E uma coluna com o total de cada licença no ano, para o final da linha
		$sql4 = "select count(cod) as licenca_mes from downloads_meta 
					where id_arquivo = :licenca and year(data) = :ano";
		$query4 = $db_02->prepare($sql4);
		$query4->bindValue(':ano', $ano, PDO::PARAM_INT);
		$query4->bindValue(':licenca', $res['licenca'], PDO::PARAM_INT);
		$query4->execute();
		$resultado4 = $query4->fetchAll();
		foreach ($resultado4 as $res4) {
				echo "<td>".$res4['licenca_mes']."</td>";
		}
	}
	
	echo "</tr>";
		
}
//Linha de total de uma licença em cada mês
$class = ($row++%2==1) ? "firstline" : "secondline";
echo "<tr class=\"$class\">";
echo "<td class=\"firstcol\">Total</td>";
for ($i=1; $i<=12; $i++) {
	$sql2 = "select count(cod) as c from downloads_meta 
	where month(data) = :mes and year(data) = :ano";
	$query2 = $db_02->prepare($sql2);
	$query2->bindValue(':ano', $ano, PDO::PARAM_INT);
	$query2->bindValue(':mes', $i, PDO::PARAM_INT);
	$query2->execute();
	$resultado2 = $query2->fetchAll();
	foreach ($resultado2 as $res) {
		echo "<td>".$res['c']."</td>";
	}
}
//Coluna com total do ano, no final da linha
$sql2 = "select count(cod) as c from downloads_meta 
	where year(data) = :ano";
$query2 = $db_02->prepare($sql2);
$query2->bindValue(':ano', $ano, PDO::PARAM_INT);
$query2->execute();
$resultado2 = $query2->fetchAll();
foreach ($resultado2 as $res) {
	echo "<td>".$res['c']."</td>";
}
echo "</tr>";
?> 
		</tbody>	
	</table>
	<br>
	<a class="btn" href="relatorio_estatisticas_downloads.php?ano=<?php echo $ano; ?>" target="_blank">Gerar Relatório em PDF</a>
	<br>
</div>
<br>

<!-- Total de Downloads -->
<div class="wrapper">
	<h1>Total de Downloads do SIGMA</h1>
	<?php 
		$qry = $db_02->query("select downloads from downloads");
		$resultad = $qry->fetchAll();
	
		$antigos = 312255;
		$soma=0;
		foreach($resultad as $res){
			$soma += $res["downloads"];
		}
		$total = $antigos + $soma;
		$total = substr($total,0,strlen($total)-3).".".substr($total,strlen($total)-3,3);
		
		echo '<div id="nmro">'.$total.'</div>';
	?>
</div>
<br>

<!-- Últimos 100 acessos -->
<div class="wrapper">
	<h2>Últimos 100 Acessos ao SIGMA</h2>
	
	<div class="tabela">
	<table id="dados">
		<thead class="header">
			<tr class="firstline">
			    <th>Data/Hora</th>
			    <th>Empresa</th>
			    <th>Negocio</th>
			    <th>Aplicativo</th>
			    <th>Nome-PC</th>
			    <th>IP</th>
			    <th>Versão</th>
			    <th>Licença</th>
			</tr>
		</thead>
		<tbody>
<?php 
if( isset($_GET['limite_a']) ){
    $limite_a = (int) $_GET["limite_a"];
}else{
	//padrão
    $limite_a = 100;
}

//Pesquisa os 100 últimos acessos ao Sigma
$sql1 = "select ACESCLI_ID, ACESCLI_EMPRESA, ACESCLI_IPMICRO, ACESCLI_NOMEMICRO, 
ACESCLI_NEGOCIO, ACESCLI_APLICATIVO, ACESCLI_VERSAO, ACESCLI_LICENCA, DATE_FORMAT(ACESCLI_DTHORA, '%d/%m/%Y %H:%i') as data_hora 
from ACESSO_CLIENTE order by ACESCLI_DTHORA desc limit :limite_a";
$qry1 = $db_04->prepare($sql1);
$qry1->bindParam(':limite_a', $limite_a, PDO::PARAM_INT);
$qry1->execute();
$resultado = $qry1->fetchAll();

$row = 0;
foreach ($resultado as $res) {
		$class = ($row++%2==1) ? 'firstline' : 'secondline';
		
        //Nomeia as licenças
		switch($res["ACESCLI_LICENCA"]){
			default: $licenca = "Desconhecida"; break;
			case 1: $licenca = "SIGMA 2010"; break;
			case 2: $licenca = "Trial 2012 Inicial"; break;
			case 3: $licenca = "Paga 2012 Inicial"; break;
            case 4: $licenca = "SIGMA 2012 Free"; break;
			case 5: $licenca = "SIGMA 2012 Professional"; break;
			case 6: $licenca = "SIGMA 2012 Enterprise"; break;
		}
		
		//Tabela com os acessos
		echo "<tr class=\"$class\">";
			//echo "<td>$res[ACESCLI_ID]</td>";
			echo "<td>$res[data_hora]</td>";
			echo "<td>$res[ACESCLI_EMPRESA]</td>";
			echo "<td>$res[ACESCLI_NEGOCIO]</td>";
			echo "<td>$res[ACESCLI_APLICATIVO]</td>";
			echo "<td>$res[ACESCLI_NOMEMICRO]</td>";
			echo "<td>$res[ACESCLI_IPMICRO]</td>";
			echo "<td>$res[ACESCLI_VERSAO]</td>";
			echo "<td>$licenca</td>";
		echo "</tr>";

}
?>		
		</tbody>
	</table>
	</div>
<br>
<a class="btn" href="?limite_a=10000">Mostrar todos</a>
<a class="btn" href="relatorio_ultimos_acessos.php" target="_blank">Gerar Relatório em PDF</a>
<br>
</div>
<br>

<!-- Novos usuários -->
<div class="wrapper">
	<h2>Novos usuários acessando o SIGMA</h2>
	
	<form action="#" method="post">
		<span>Exibir Ano:
			<input type="text" name="ano_usuario" value="" size="4" maxlength="4" placeholder="aaaa">
			<button class="btn" type="submit">Pesquisar</button>
		</span>
	</form>
	<br>
	
	<table>
		<thead class="header">
    		<tr class="firstline">
		        <th>Janeiro</th>
		        <th>Fevereiro</th>
		        <th>Março</th>
		        <th>Abril</th>
		        <th>Maio</th>
		        <th>Junho</th>
		        <th>Julho</th>
		        <th>Agosto</th>
		        <th>Setembro</th>
		        <th>Outubro</th>
		        <th>Novembro</th>
		        <th>Dezembro</th>
		        <th>Total</th>
    		</tr>
    	</thead>
    	<tbody>
<?php 
if (empty ($_POST['ano_usuario'])) $ano_usuario = date('Y');
else $ano_usuario = (int) $_POST['ano_usuario'];
    
echo "<p class=\"ano\">&nbsp;".$ano_usuario."</p>";

//Tabela novos usuários a cada mês
echo "<tr class=\"secondline\">";
for ($mes = 1; $mes <= 12; $mes++) {
	$sql = "select count(distinct(ACESCLI_NOMEMICRO)) as micros 
	from acesso_cliente where month(ACESCLI_DTHORA)=:mes
	and year(ACESCLI_DTHORA)=:ano_usuario order by ACESCLI_DTHORA";
    $pesquisa = $db_04->prepare($sql);
    $pesquisa->execute(array(':mes' => $mes, ':ano_usuario' => $ano_usuario));
    $array = $pesquisa->fetchAll();
    foreach ($array as $val) {
       	echo "<td>".$val['micros']."</td>";
    }
}
//Total no ano
$sql = "select count(distinct(ACESCLI_NOMEMICRO)) as micros 
	from acesso_cliente where year(ACESCLI_DTHORA)=:ano_usuario 
	order by ACESCLI_DTHORA";
$pesquisa = $db_04->prepare($sql);
$pesquisa->execute(array(':ano_usuario' => $ano_usuario));
$array = $pesquisa->fetchAll();
foreach ($array as $val) {
	echo "<td>".$val['micros']."</td>";
}
echo "</tr>";

?>
    	</tbody>
    </table>
    <br>
    <a class="btn" href="relatorio_novos_usuarios.php" target="_blank">Gerar Relatório em PDF</a>
    <br>
</div>
<br>

<!-- Estatísticas de Acesso -->
<div class="wrapper">
	<h2>Estatísticas de Acesso ao SIGMA</h2>
	
	<form action="#" method="post">
		<span>Exibir Ano:
			<input type="text" name="ano_estatisticas" value="" size="4" maxlength="4" placeholder="aaaa">
			<button class="btn" type="submit">Pesquisar</button>
		</span>
	</form>
	<br>
	
	<table>
		<thead class="header">
		    <tr class="firstline">
		        <th>Quantidade de<br/> Acessos Registrados</th>
		        <th>Janeiro</th>
		        <th>Fevereiro</th>
		        <th>Março</th>
		        <th>Abril</th>
		        <th>Maio</th>
		        <th>Junho</th>
		        <th>Julho</th>
		        <th>Agosto</th>
		        <th>Setembro</th>
		        <th>Outubro</th>
		        <th>Novmebro</th>
		        <th>Dezembro</th>
		        <th>Total</th>
		    </tr>
		</thead>
		<tbody>
<?php 
if (empty ($_POST['ano_estatisticas'])) $ano_estatisticas = date('Y');
else $ano_estatisticas = (int) $_POST['ano_estatisticas'];
       
echo "<p class=\"ano\">&nbsp;".$ano_estatisticas."</p>";

//Pesquisa as licenças existentes
$sql = "SELECT distinct(ACESCLI_LICENCA) from ACESSO_CLIENTE 
		order by ACESCLI_LICENCA";
$pesq = $db_04->query($sql);
$re = $pesq->fetchAll();

$row = 0;
foreach ($re as $res) {
    $class = ($row++%2==1) ? 'firstline' : 'secondline';
    
	//Nomeia as licenças
	switch($res["ACESCLI_LICENCA"]){
		default: $licenca = "Desconhecida"; break;
		case 1: $licenca = "SIGMA 2010"; break;
		case 2: $licenca = "Trial 2012 Inicial"; break;
		case 3: $licenca = "Paga 2012 Inicial"; break;
        case 4: $licenca = "SIGMA 2012 Free"; break;
		case 5: $licenca = "SIGMA 2012 Professional"; break;
		case 6: $licenca = "SIGMA 2012 Enterprise"; break;
	}
	
	//Tabela das licenças utilizadas por mês
    echo "<tr class=\"$class\">";
    echo "<td class=\"firstcol\">$licenca</td>";
    for ($mes = 1; $mes <= 12; $mes++) { //loop de licenças por mês
    	$pesq1 = "select count(ACESCLI_LICENCA) as licenca from ACESSO_CLIENTE 
    	where ACESCLI_LICENCA=:licenca and month(ACESCLI_DTHORA)=:mes 
    	and year(ACESCLI_DTHORA)=:ano_estatisticas";
        $query1 = $db_04->prepare($pesq1);
        $query1->execute(array(
        	':licenca' => $res["ACESCLI_LICENCA"],
        	':mes' => $mes,
        	':ano_estatisticas' => $ano_estatisticas
        ));
        $result = $query1->fetchAll();
        foreach ($result as $resu) {
        	echo "<td>".$resu['licenca']."</td>";
        }
     }
    //Coluna com total de cada licença no ano
	$pesq2 = "select count(ACESCLI_LICENCA) as licenca from ACESSO_CLIENTE 
    	where ACESCLI_LICENCA=:licenca and year(ACESCLI_DTHORA)=:ano_estatisticas";
    $query12 = $db_04->prepare($pesq2);
    $query12->execute(array(
        ':licenca' => $res["ACESCLI_LICENCA"],
        ':ano_estatisticas' => $ano_estatisticas
    ));
    $result12 = $query12->fetchAll();
    foreach ($result12 as $resu1) {
        echo "<td>".$resu1['licenca']."</td>";
    }
    echo "</tr>";
    
        	
}
//Linha com total de acessos por mês
$class = ($row++%2==1) ? 'firstline' : 'secondline'; 
echo "<tr class=\"$class\">";
echo "<td class=\"firstcol\">Total</td>";
for ($mes = 1; $mes <= 12; $mes++) {
	$sql = "select count(ACESCLI_LICENCA) as licenca from ACESSO_CLIENTE 
    	where month(ACESCLI_DTHORA)=:mes and year(ACESCLI_DTHORA)=:ano_estatisticas";
	$query = $db_04->prepare($sql);
    $query->execute(array(
    	':mes' => $mes,
        ':ano_estatisticas' => $ano_estatisticas
    ));
    $result = $query->fetchAll();
    foreach ($result as $res) {
        echo "<td>".$res['licenca']."</td>";
    }
}
//Coluna com total de acessos no ano
$sql = "select count(ACESCLI_LICENCA) as licenca from ACESSO_CLIENTE 
    	where year(ACESCLI_DTHORA)=:ano_estatisticas";
$query = $db_04->prepare($sql);
$query->execute(array(':ano_estatisticas' => $ano_estatisticas));
$result = $query->fetchAll();
foreach ($result as $res) {
   echo "<td>".$res['licenca']."</td>";
}

echo "</tr>";
?>
		</tbody>
	</table>
	<br>
	<a class="btn" href="relatorio_estatistica.php?ano='.$ano_estatisticas.'" target="_blank">Gerar Relatório em PDF</a><br>
	<br>	    
</div>
<br>

<!-- Novos computadores -->
<div class="wrapper">
	<h2>Novos computadores acessando nos últimos 3 meses</h2>
	
	<div class="tabela">
		<table>
			<thead class="header">
				<tr class="firstline">
				    <th>Data/Hora</th>
				    <th>Empresa</th>
				    <th>Nome-PC</th>
				    <th>Licença</th>
		    	</tr>
		    </thead>
		    <tbody>
<?php 
//Pesquisa dados da tabela agrupando pelos 'nomes de computador' únicos e mostrando resultado dos últimos 3 meses
$sql = "select ACESCLI_EMPRESA, ACESCLI_NOMEMICRO, ACESCLI_LICENCA, ACESCLI_DTHORA, 
	date_format(ACESCLI_DTHORA, '%d/%m/%Y %H:%i') as datahora 
	from acesso_cliente group by ACESCLI_NOMEMICRO 
	having ACESCLI_DTHORA BETWEEN SYSDATE() - INTERVAL 3 MONTH AND SYSDATE() 
	order by ACESCLI_DTHORA desc";		
$pesquisa = $db_04->query($sql);	
$result = $pesquisa->fetchAll();

$row = 0;
foreach ($result as $res) {
	$class = ($row++%2==1) ? 'firstline' : 'secondline';
	
    //Nomeia as licenças
    switch($res["ACESCLI_LICENCA"]){
		default: $licenca = "Desconhecida"; break;
		case 1: $licenca = "SIGMA 2010"; break;
		case 2: $licenca = "Trial 2012 Inicial"; break;
		case 3: $licenca = "Paga 2012 Inicial"; break;
        case 4: $licenca = "SIGMA 2012 Free"; break;
		case 5: $licenca = "SIGMA 2012 Professional"; break;
		case 6: $licenca = "SIGMA 2012 Enterprise"; break;
	}
        
	//Tabela	
    echo "<tr class=\"$class\">";
	echo "<td>$res[datahora]</td>";
	echo "<td>$res[ACESCLI_EMPRESA]</td>";
	echo "<td>$res[ACESCLI_NOMEMICRO]</td>";
	echo "<td>$licenca</td>";
	echo "</tr>"; 
}
?>
		    </tbody>
		</table>
	</div>
	<br>
	<a class="btn" href="relatorio_novos_computadores.php" target="_blank">Gerar Relatório em PDF</a>
	<br>
</div>
<br>

<div class="wrapper">

	<h2>Ranking de Acesso aos Aplicativos SIGMA</h2>

	<form action="#" method="post">
		<span>Exibir Ano:
			<input type="text" name="ano_ranking" value="" size="4" maxlength="4" placeholder="aaaa">
			<button class="btn" type="submit">Pesquisar</button>
		</span>
	</form>
	<br>
	
	<table>
		<thead class="header">
			<tr class="firstline">
				<th>Aplicativos</th>
		        <th>Janeiro</th>
		        <th>Fevereiro</th>
		        <th>Março</th>
		        <th>Abril</th>       
		        <th>Maio</th>
		        <th>Junho</th>
		        <th>Julho</th>
		        <th>Agosto</th>
		        <th>Setembro</th>
		        <th>Outubro</th>
		        <th>Novembro</th>
		        <th>Dezembro</th>
		        <th>Total</th>
			</tr>
		</thead>
		<tbody>
<?php 

if (empty ($_POST['ano_ranking'])) $ano_ranking = date('Y');
else $ano_ranking = (int) $_POST['ano_ranking'];
    
echo "<p class=\"ano\">&nbsp;".$ano_ranking."</p>";

//Pesquisa os tipos de aplicativos para criar o loop da tabela
$sql = "select distinct(ACESCLI_APLICATIVO) from acesso_cliente 
	where ACESCLI_APLICATIVO is not null";
$pesq = $db_04->query($sql);
$r = $pesq->fetchAll();

$row = 0;
$apli = array(); //array com todos os dados da tabela
$count = 0; //inicializa contador de aplicativos
foreach ($r as $res) {
	$class = ($row++%2==1) ? 'firstline' : 'secondline';
	
	$aplicativo = $res["ACESCLI_APLICATIVO"];
         
    $apli[$count] = array(); //adiciona o contador de aplicativos como índice do array
    $apli[$count]["id"] = $aplicativo; //cada aplicativo 
    $apli[$count]["meses"] = array(); //array dos meses
    
    $pesquisa_sql  = "select month(ACESCLI_DTHORA) as month 
	    from acesso_cliente where ACESCLI_APLICATIVO=:aplicativo 
	    and year(ACESCLI_DTHORA) = :ano_ranking";
	$pesquisa = $db_04->prepare($pesquisa_sql);
	$pesquisa->execute(array(
		':aplicativo' => $aplicativo, 
		':ano_ranking' => $ano_ranking
	));
	$pesq_res = $pesquisa->fetchAll();
	
	for ($mes = 1; $mes <= 12; $mes++) { //loop de aplicativos acessados por mês	
		//Conta os aplicativos acessados por mês e por ano
		$apli[$count]["meses"][$mes] = 0; //monta array com os acessos de cada mês
	}
		
	foreach($pesq_res as $resck){
		$shsh = (int) $resck['month'];
		$apli[$count]["meses"][$shsh]++;
	}
	
	$count++; //contador de aplicativos 
		
	//Total de aplicativos acessados por ano
	// Para cada app diferente
    foreach($apli as &$mapp){
    	$mtotal = 0; // total é zero
        // Para cada mês desse app
        foreach($mapp["meses"] as $mapm){
        	$mtotal += $mapm; // adiciona o mês atual no total
        }
    
        // adiciona $apli["total"]
        $mapp["total"] = $mtotal;
	}
}

//Ordenar o total de acessos de cada mês em forma de ranking
$function = create_function('$a, $b', 'return $b[\'total\'] - $a[\'total\'];');
usort($apli, $function);

$count = 0; //inicializa contador de aplicativos

for ($conterm = 0; $conterm <= 16; $conterm++) {

	//Nomeia os aplicativos
    switch($apli[$conterm]["id"]){
		case 'SIGMA': $app = "SIGMA"; break;
		case 'LP.EXE': $app = "LP"; break;
		case 'LD.EXE': $app = "LD"; break;
		case 'APROVASS.EXE': $app = "APROVASS"; break;
        case 'ALERTA.EXE': $app = "ALERTA"; break;
		case 'MONITORAMENTO_ONLINE.EXE': $app = "MONITORAMENTO ONLINE"; break;
		case 'SOFTOS.EXE': $app = "SOFTOS"; break;
        case 'SS.EXE': $app = "SS"; break;
		case 'ESCALATRABALHO.EXE': $app = "ESCALA DE TRABALHO"; break;
		case 'LEMBRETE.EXE': $app = "LEMBRETE"; break;
		case 'EWO.EXE': $app = "EWO"; break;
        case 'OS.EXE': $app = "OS"; break;
		case 'SMARTOS.EXE': $app = "SMARTOS"; break;
		case 'SIGMASMS.EXE': $app = "SIGMASMS"; break;
        case 'SOLICITACAO.EXE': $app = "SOLICITACAO"; break;
		case 'INTEGRASIGMA.EXE': $app = "INTEGRASIGMA"; break;
        case 'SIGMANR13.EXE': $app = "SIGMANR13"; break;
        case 'SIGMAWEB': $app = "SIGMAWEB"; break;
	}
	
	//Tabela
	echo "<tr class=\"$class\">";
    echo "<td class=\"firstcol\">".$app."</td>";
    for ($mes = 1; $mes <= 12; $mes++) { //loop de aplicativos acessados por mês
    	echo "<td>".$apli[$conterm]["meses"][$mes]."</td>";
	}
		
    $count++;
    echo "<td>".$apli[$conterm]["total"]."</td>";
    echo "</tr>"; 

}

?>
		</tbody>
	</table>	        
	<br>
	<a class="btn" href="relatorio_ranking.php?ano='.$ano_ranking.'" target="_blank">Gerar Relatório em PDF</a>
	<br>
</div>
<br>

</body>
</html>
