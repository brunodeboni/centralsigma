
<br>
<div>
	<form action="#" method="post">
		<span>Pesquise os acessos por UF:&nbsp;&nbsp;&nbsp;</span>
		<input name="uf">
		<button type="submit">Pesquisar</button>
	</form>
<br>
<?php 
function geoCheckIP($ip)
{
	//verificar, se o IP fornecido é válido...
	if(!filter_var($ip, FILTER_VALIDATE_IP))
	{
		throw new InvalidArgumentException("IP is not valid");
	}

	//contatar ip-servidor
	$response=@file_get_contents('http://www.netip.de/search?query='.$ip);
	if (empty($response))
	{
		throw new InvalidArgumentException("Error contacting Geo-IP-Server");
	}

	//Array contendo todos regex padr�es necess�rios para extrair GeoInfo ip da p�gina
	$patterns=array();
	$patterns["domain"] = '#Domain: (.*?)&nbsp;#i';
	$patterns["country"] = '#Country: (.*?)&nbsp;#i';
	$patterns["state"] = '#State/Region: (.*?)<br#i';
	$patterns["town"] = '#City: (.*?)<br#i';

	//Matriz onde os resultados ser�o armazenados
	$ipInfo=array();

	//resposta de seleção de ipserver para os padr�es acima
	foreach ($patterns as $key => $pattern)
	{
		//armazenar o resultado em array
		$ipInfo[$key] = preg_match($pattern,$response,$value) && !empty($value[1]) ? $value[1] : 'not found';
	}

	return $ipInfo;
}

if (isset ($_POST['uf'])) {
	$uf = mysql_real_escape_string($_POST['uf']);
	
	// Conexão com mysql
	$conn = mysql_connect("cloud1.redeindustrial.com.br","webadmin","webADMIN") or die("Sem conexão com o Banco de Dados");
	mysql_select_db("centralsigma04",$conn) or die("Não foi possivel selecionar o Banco de Dados");
	mysql_set_charset("utf8",$conn);
	
	
	$cons = "select ACESCLI_ID, ACESCLI_DTHORA, ACESCLI_EMPRESA, ACESCLI_IPMICRO, 
	ACESCLI_NOMEMICRO, ACESCLI_NEGOCIO, ACESCLI_APLICATIVO, ACESCLI_VERSAO, 
	ACESCLI_LICENCA from ACESSO_CLIENTE order by ACESCLI_DTHORA desc limit 20";
	$consulta = mysql_query($cons, $conn);
	
	echo '
		<table>
			<tr class="firstline">
				<td><b>ID</b>
				    <td><b>Data/Hora</b>
				    <td><b>Empresa</b>
					<td><b>UF</b>
				    <td><b>Negocio</b>
				    <td><b>Aplicativo</b>
				    <td><b>Nome-PC</b>
				    <td><b>IP</b>
				    <td><b>Versao</b>
				    <td><b>Licen&ccedil;a</b>
	';
	
	$rowq = true; //Classe das cores das linhas
	while ($dados = mysql_fetch_assoc($consulta)) {
		//Formato de data e hora
		$datahora = mysql_fetch_row(mysql_query("SELECT DATE_FORMAT('$dados[ACESCLI_DTHORA]','%d/%m/%Y %H:%i')"));
		$datahora = $datahora[0];
		
		
		$licenca = $dados["ACESCLI_LICENCA"];
		//Nomeia as licen�as
		switch($licenca){
			default: $licenca = "0 - Desconhecida"; break;
			case 1: $licenca = "1 - Gratuita 2010"; break;
			case 2: $licenca = "2 - Trial 2012 Inicial"; break;
			case 3: $licenca = "3 - Paga 2012 Inicial"; break;
			case 4: $licenca = "4 - Free 2012"; break;
			case 5: $licenca = "5 - Professional 2012"; break;
			case 6: $licenca = "6 - Enterprise 2012"; break;
		}
		
		
		$ip= $dados['ACESCLI_IPMICRO'];
		
		
		
		
		
		$uf= print_r(geoCheckIP($ip));
		
		//$uf = $dados['uf'];
		
		//Classe das cores das linhas
		if($rowq) $class = "secondline";
		else $class = "firstline";
		$rowq = !$rowq;
		
		echo "<tr class=\"$class\">
				<td>".$dados['ACESCLI_ID']."
				<td>".$datahora."
				<td>".$dados['ACESCLI_EMPRESA']."
				<td>".$uf."
				<td>".$dados['ACESCLI_NEGOCIO']."
				<td>".$dados['ACESCLI_APLICATIVO']."
				<td>".$dados['ACESCLI_NOMEMICRO']."
				<td>".$dados['ACESCLI_IPMICRO']."
				<td>".$dados['ACESCLI_VERSAO']."
				<td>".$licenca."
		";
		}
		echo '</table>';
}else echo ''; //se não foi feita pesquisa por uf

?>
</div>

