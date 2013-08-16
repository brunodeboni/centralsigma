
<div>
<h1>Novos computadores acessando nos &uacute;ltimos 3 meses</h1>
<table>

      <tr class="firstline">
    <td width="120">Data/Hora</td>
    <td width="500">Empresa</td>
    <td width="180">Nome-PC</td>
    <td width="155">Licen&ccedil;a</td>
    </tr>
</table>
<div class="novos_usu">
<table>

<?php
   
//Pesquisa dados da tabela agrupando pelos 'nomes de computador' únicos e mostrando resultado dos últimos 3 meses
$sql = "SELECT ACESCLI_EMPRESA, ACESCLI_NOMEMICRO, ACESCLI_LICENCA, date_format(ACESCLI_DTHORA, '%d/%m/%Y %H:%i') as datahora FROM acesso_cliente group by ACESCLI_NOMEMICRO having ACESCLI_DTHORA BETWEEN SYSDATE() - INTERVAL 3 MONTH AND SYSDATE() order by ACESCLI_DTHORA desc";		
$pesquisa = $db_04->query($sql);	
$result = $pesquisa->fetchAll();
 
$rowq = false; //Classe para cores das linhas
    
//Enquanto houver dados do banco... loop
foreach ($result as $res) {
	set_time_limit(0);
                        
    //Classe para cores das linhas            
	if($rowq) $class = "secondline";
	else $class = "firstline";
	$rowq = !$rowq;
	
	$datahora = $res['datahora'];	
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
        
	//Tabela	
    echo "<tr class=\"$class\">";
	echo "<td width=\"120\">$datahora</td>";
	echo "<td width=\"500\">$res[ACESCLI_EMPRESA]</td>";
	echo "<td width=\"180\">$res[ACESCLI_NOMEMICRO]</td>";
	echo "<td width=\"155\">$licenca</td>";
	echo "</tr>"; 
                
} 
                
               
              
               
?>

</table>
</div>
</div>




