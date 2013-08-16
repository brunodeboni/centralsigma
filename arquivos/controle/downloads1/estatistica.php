

<div class="estatisticas">
<h1>Estat&iacute;sticas</h1>
<form action="#" method="post">
<span>Exibir Ano:
<input type="text" name="ano_estatisticas" value="" size="4" maxlength="4"/>
<button type="submit">Pesquisar</button>
</span>
</form>
<br/>
<table>
    <tr class="firstline">
        <td>Quantidade de<br/> Acessos Registrados</td>
        <td>Janeiro</td>
        <td>Fevereiro</td>
        <td>Mar&ccedil;o</td>
        <td>Abril</td>
        <td>Maio</td>
        <td>Junho</td>
        <td>Julho</td>
        <td>Agosto</td>
        <td>Setembro</td>
        <td>Outubro</td>
        <td>Novmebro</td>
        <td>Dezembro</td>
    </tr>
        
<?php
     //Pega o 'post' do ano 
    if (empty ($_POST['ano_estatisticas'])) {
        $ano_estatisticas = date('Y');
    
       }else $ano_estatisticas = $_POST['ano_estatisticas'];
       
       echo "<p class=\"ano\">&nbsp;".$ano_estatisticas."</p>";
       
       //Pesquisa as licenças existentes
       $sql = "SELECT distinct(ACESCLI_LICENCA) FROM ACESSO_CLIENTE order by ACESCLI_LICENCA";
       $pesq = $db_04->query($sql);
       $re = $pesq->fetchAll();
       
       $rowq = false; //Classe das cores das linhas
       
       //Enquanto houver licenças no banco... loop
       foreach ($re as $res) {
       
            $licenca = $res["ACESCLI_LICENCA"];
                //Nomeia as licenças
		switch($licenca){
			default: $nome_licenca = "0 - Desconhecida"; break;
			case 1: $nome_licenca = "1 - Gratuita 2010"; break;
			case 2: $nome_licenca = "2 - Trial 2012 Inicial"; break;
			case 3: $nome_licenca = "3 - Paga 2012 Inicial"; break;
            case 4: $nome_licenca = "4 - Free 2012"; break;
			case 5: $nome_licenca = "5 - Professional 2012"; break;
			case 6: $nome_licenca = "6 - Enterprise 2012"; break;
		}
        
            //Classe das cores das linhas       
            if($rowq) $class = "secondline";
		else $class = "firstline";
		$rowq = !$rowq;
        
            //Tabela das licenças utilizadas por mês
            echo "<tr class=\"$class\">";
            echo "<td>$nome_licenca</td>";
            for ($mes = 1; $mes <= 12; $mes++) { //loop de licenças por mês
                $pesq1 = mysql_query('SELECT count(ACESCLI_LICENCA) FROM ACESSO_CLIENTE WHERE ACESCLI_LICENCA='.$licenca.' AND month(ACESCLI_DTHORA)='.$mes.' AND year(ACESCLI_DTHORA)='.$ano_estatisticas.'', $conn) or die ('Não foi possível realizar a pesquisa.');
                $array = mysql_fetch_array($pesq1);
                echo "<td>".$array[0]."</td>";
            }  
            echo "</tr>";
       }
       
       //Total dos acessos do mês de todas as licenças
        echo "<tr class=\"$class\">";
        echo "<td>Total</td>";
        for ($mes = 1; $mes <= 12; $mes++) { //loop de licenças por mês
        	$sql1 = "SELECT count(ACESCLI_LICENCA) as quant FROM ACESSO_CLIENTE WHERE month(ACESCLI_DTHORA) = :mes AND year(ACESCLI_DTHORA) = :ano_estatisticas";
            $pesq1 = $db_04->prepare($sql);
            $pesq1->execute(array(':mes' => $mes, ':ano_estatisticas' => $ano_estatisticas));
            $r = $pesq1->fetchAll();
            
            foreach ($r as $rr) {
				echo "<td>".$rr['quant']."</td>";
            }
        }  
        echo "</tr>";
        echo "</table>";
        echo '<a class="mostrar" href="relatorio_estatistica.php?ano='.$ano_estatisticas.'" target="_blank">Gerar Relat&oacute;rio em PDF</a><br>';
        
        unset($_POST['ano_estatisticas']);   
?>

</div>

