

<div class="novos">
<h1>Ranking de Acesso aos aplicativos</h1>
<form action="#" method="post">
<span>Exibir Ano:
<input type="text" name="ano_ranking" value="" size="4" maxlength="4"/>
<button type="submit">Pesquisar</button>
</span>
</form>
<br/>
<table>
      <tr class="firstline">
	<td>Aplicativos</td>
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
        <td>Novembro</td>
        <td>Dezembro</td>
        <td>Total</td>
    </tr>

<?php

     
    //Pesquisa os tipos de aplicativos para criar o loop da tabela
    $sql = "SELECT DISTINCT(ACESCLI_APLICATIVO) FROM acesso_cliente WHERE ACESCLI_APLICATIVO IS NOT NULL";
    $pesq = $db_04->query($sql);
    $r = $pesq->fetchAll();
        
    //Pega o 'post' do ano
    if (empty ($_POST['ano_ranking'])) {
        $ano_ranking = date('Y');
    
    }else $ano_ranking = (int) $_POST['ano_ranking'];
    
    echo "<p class=\"ano\">&nbsp;".$ano_ranking."</p>";
    
    $rowq = false; //Classe para as cores das linhas
	     
    $apli = array(); //array com todos os dados da tabela
    $count = 0; //inicializa contador de aplicativos
    
     //Enquanto tiver aplicativos no banco... loop
     foreach ($r as $res) {
         $aplicativo = $res["ACESCLI_APLICATIVO"];
         
         $apli[$count] = array(); //adiciona o contador de aplicativos como índice do array
         $apli[$count]["id"] = $aplicativo; //cada aplicativo 
         $apli[$count]["meses"] = array(); //array dos meses
        
		
		$pesquisa_sql  = "SELECT month(ACESCLI_DTHORA) as month FROM acesso_cliente WHERE ACESCLI_APLICATIVO=:aplicativo ";
		//$pesquisa_sql .= "AND month(ACESCLI_DTHORA)='$mes' AND year(ACESCLI_DTHORA)='$ano_pesq'";
		$pesquisa_sql .= "AND year(ACESCLI_DTHORA) = :ano_ranking";
		$pesquisa = $db_04->prepare($pesquisa_sql);
		$pesquisa->execute(array(':aplicativo' => $aplicativo, ':ano_ranking' => $ano_ranking));
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
        
        //Classe para as cores das linhas
        if($rowq) $class = "secondline";
		else $class = "firstline";
		$rowq = !$rowq;
        
        //Tabela
		
        echo "<tr class=\"$class\">";
        echo "<td>".$app."</td>";
        for ($mes = 1; $mes <= 12; $mes++) { //loop de aplicativos acessados por mês
            echo "<td>".$apli[$conterm]["meses"][$mes]."</td>";
                   
        }
		
        $count++;
        echo "<td>".$apli[$conterm]["total"]."</td>";
        echo "</tr>"; 
		
    }
    
    
    echo '</table>'; 
    echo '<a class="mostrar" href="relatorio_ranking.php?ano='.$ano_ranking.'" target="_blank">Gerar Relat&oacute;rio em PDF</a><br>';
    unset($_POST['ano_ranking']);
        
		
        
       
               
?>


</div>


