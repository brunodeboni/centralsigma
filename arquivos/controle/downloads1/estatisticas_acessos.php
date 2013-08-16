<?php
//session_start();
//if(!isset($_SESSION['5468usuario'])) die("<strong>Acesso Negado!</strong>");

// Conexão com mysql
include '../../../conexoes.inc.php';
$db_04 = Database::instance('centralsigma04');

?>
<!DOCTYPE html> 
<html>
<head>
    <meta charset="utf-8">
    <title>Estat&iacute;sticas dos Acessos do Sigma 2012</title>
    <style>
    	body {font-size: 12px; font-family:Verdana, sans-serif;}
        h1 {font-size:20px; color: #CD5C5C;}
        .ultimos {
          border:2px; width:100%; height:378px; overflow:auto;  
        }
        .mostrar {font-weight:bold;}
        .ano {color: gray; margin-bottom: -3px;}
        .firstline {background-color: #FAF0E6;}
        .secondline {background-color: #FAEBD7;}
	.novos_usu {
          border:2px; width:1000; height:378px; overflow:auto; 
        }
    </style>
    
</head>
<body>
    <h1>&Uacute;ltimos 100 Acessos ao Sigma</h1>

<div>
<table>
<tr class="firstline">
    
    <td width="45">ID</td>
    <td width="75">Data/Hora</td>
    <td width="120">Empresa</td>
    <td width="190">Negocio</td>
    <td width="120">Aplicativo</td>
    <td width="100">Nome-PC</td>
    <td width="100">IP</td>
    <td width="100">Versao</td>
    <td width="100">Licen&ccedil;a</td>
</tr>
</table>
</div>
<div class="ultimos">
<table>
<?php

if( isset($_GET['limite']) ){
    $limite = $_GET["limite"];
}else{
// padrão
    $limite = 100;
}

//Pesquisa os 100 últimos acessos ao Sigma
$sql1 = "select ACESCLI_ID, ACESCLI_EMPRESA, ACESCLI_IPMICRO, ACESCLI_NOMEMICRO, 
ACESCLI_NEGOCIO, ACESCLI_APLICATIVO, ACESCLI_VERSAO, ACESCLI_LICENCA, DATE_FORMAT(ACESCLI_DTHORA, '%d/%m/%Y %H:%i') as data_hora 
from ACESSO_CLIENTE order by ACESCLI_DTHORA desc limit :limite";
$qry1 = $db_04->prepare($sql1);
$qry1->bindParam(':limite', $limite, PDO::PARAM_INT);
$qry1->execute();
$resultado = $qry1->fetchAll();
       
        $rowq = true; //Classe para cores das linhas
        
        //Enquanto houver dados do banco... loop
	foreach($resultado as $res) {
    	set_time_limit(0);
            
        //Classe para cores das linhas
    	if($rowq) $class = "secondline";
		else $class = "firstline";
		$rowq = !$rowq;
		
      
        $licenca = $res["ACESCLI_LICENCA"];
        //Nomeia as licenças
		switch($licenca){
			default: $licenca = "0 - Desconhecida"; break;
			case 1: $licenca = "1 - Gratuita 2010"; break;
			case 2: $licenca = "2 - Trial 2012 Inicial"; break;
			case 3: $licenca = "3 - Paga 2012 Inicial"; break;
            case 4: $licenca = "4 - Free 2012"; break;
			case 5: $licenca = "5 - Professional 2012"; break;
			case 6: $licenca = "6 - Enterprise 2012"; break;
		}
		
        //Tabela com os acessos
		echo "<tr class=\"$class\">";
			echo "<td width=\"45\">$res[ACESCLI_ID]</td>";
			echo "<td width=\"75\">$res[data_hora]</td>";
			echo "<td width=\"120\">$res[ACESCLI_EMPRESA]</td>";
			echo "<td width=\"190\">$res[ACESCLI_NEGOCIO]</td>";
			echo "<td width=\"120\">$res[ACESCLI_APLICATIVO]</td>";
			echo "<td width=\"100\">$res[ACESCLI_NOMEMICRO]</td>";
			echo "<td width=\"100\">$res[ACESCLI_IPMICRO]</td>";
			echo "<td width=\"100\">$res[ACESCLI_VERSAO]</td>";
			echo "<td width=\"100\">$licenca</td>";
		echo "</tr>";     

        }
        
?>
    
</table>
</div>
<a class="mostrar" href="?limite=10000">Mostrar todos</a>
<br>
<br>
<?php 
echo '<a class="mostrar" href="relatorio_acessos.php" target="_blank">Gerar Relat&oacute;rio em PDF</a><br>';
include 'novo_usuario.php'; 
echo "<br /><br />";
include 'estatistica.php';
echo "<br />";
include 'novo_comp.php'; 
echo "<br />";
include 'ranking.php';
echo "<br />";
?>
<a class="mostrar" href="relatorio_geral.php" target="_blank">Gerar Relat&oacute;rio Geral em PDF</a>
</body>
</html>