<div class="novos">
<h1>Novos usu&aacute;rios do Sistema</h1>
<form action="#" method="post">
<span>Exibir Ano:
<input type="text" name="ano_usuario" value="" size="4" maxlength="4"/>
<button type="submit">Pesquisar</button>
</span>
</form>
<br/>
<table>
      <tr class="firstline">
	<td>Novos <br/> usu&aacute;rios</td>
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
    </tr>

<?php
     
    //Pega o 'post' do ano 
    if (empty ($_POST['ano_usuario'])) {
        $ano_usuario = date('Y');
    
    }else $ano_usuario =$_POST['ano_usuario'];
    
    echo "<p class=\"ano\">&nbsp;".$ano_usuario."</p>";
    
    //Tabela
    echo "<tr class=\"secondline\">";
    echo "<td></td>";
    for ($mes = 1; $mes <= 12; $mes++) { //loop dos novos usu�rios por m�s
        $sql = "SELECT count(DISTINCT ACESCLI_NOMEMICRO) as micros FROM acesso_cliente WHERE month(ACESCLI_DTHORA)=:mes AND year(ACESCLI_DTHORA)=:ano_usuario order by ACESCLI_DTHORA";
    	$pesquisa = $db_04->prepare($sql);
    	$pesquisa->execute(array(':mes' => $mes, ':ano_usuario' => $ano_usuario));
    	$array = $pesquisa->fetchAll();
        foreach ($array as $val) {
        	echo "<td>".$val['micros']."</td>";
        }
    }
    echo "</tr>";	
		 
    unset($_POST['ano_usuario']);
?>

</table>
</div>




