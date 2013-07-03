<?php 

$conexao = mysql_connect('mysql.centralsigma.com.br', 'centralsigma02', 'S4k813042012') or die ('Não pode se conectar porque ' . mysql_error());
mysql_select_db('centralsigma02', $conexao);

$page_id = mysql_real_escape_string($_POST['page_id']);

function buscaPresente ($conexao,$page_id) {
    // Monta uma consulta SQL (query) para procurar o status do presente
    $sql = "SELECT status, id_presente, contpess_id FROM presentes_unicos WHERE id_presentes_unicos = '$page_id' LIMIT 1";
    $query = mysql_query($sql,$conexao) or die(mysql_error());
	
	if(mysql_num_rows($query)>0){
		$resultad = mysql_fetch_row($query);
		$resultado = $resultad;
	}else{
		$resultado = false;
	}
	
	return $resultado;
}

$resultado = buscaPresente($conexao,$page_id);
if(!isset($resultado[0])) die("<!-- Presente nao encontrado -> pagina $page_id -->");

$status = $resultado[0];
$id_presente = $resultado[1];
$contpess_id = $resultado[2];

/*
// Pegar descrição do presente
$sql = "SELECT descricao FROM presentes WHERE id_presente = ".$id_presente." LIMIT 1";
$query1 = mysql_query($sql);
$resultado1 = mysql_fetch_array($query1);
$presente = $resultado1[0];
*/

if($status==2){
	$sql2 = "SELECT contpess_nome, contpess_cidade FROM contato_pessoa WHERE contpess_id = ".$contpess_id." LIMIT 1";
	$query2 = mysql_query($sql2,$conexao);
	$resultado2 = mysql_fetch_row($query2);
	$nome = $resultado2[0];
	$cidade = $resultado2[1];
}


$resultado_mensagem = "";

if ($status == 0) { //disponivel
    $resultado_mensagem = "Parab&eacute;ns! Voc&ecirc; encontrou um presente surpresa. Clique sobre a caixa do presente para receb&ecirc;-lo.";
} if ($status == 1) { //em analise
    $resultado_mensagem = 'Foi por pouco! Este presente j&aacute; foi encontrado por outra pessoa. Continue procurando!';  
} if ($status == 2) { //cadastro ok
    $resultado_mensagem = "Foi por pouco! Este presente j&aacute; foi encontrado por ".$nome." da cidade de ".$cidade."";
}

?>   
    <style type="text/css">
    .tabela {
    background-color: white;
    height: 50px;
    width: 220px;
    border-color: blue;
    border-width: thick;
    font-family: Helvetica, Verdana, sans-serif;
    font-size: 12px;
    font-weight: bold;
    color:#A52A2A;
    
    border-radius: 1em;
    box-shadow:  0.2em 0.2em 0.1em #000000;
    -webkit-box-shadow: 0.2em 0.2em 0.1em #000000;
    -moz-box-shadow: 0.2em 0.2em 0.1em #000000;
   
    position:absolute;
    left:20px;
    top:-77px;
    }
    
    #tooltip-presente{
    position:relative;
    }
    </style>


 <div id="tooltip-presente">
    <?php
    $presente_html = '<img src="/arquivos/presentes/presente_de_natal_3.png" height="50" width="50" />';
	if($status==0){ ?><a id="tooltip-presente-link" href="javascript:window.open('/arquivos/presentes/form.php?page_id=<?php echo $_POST['page_id']; ?>','formpopup','status=0,toolbar=0,location=0,menubar=0,directories=0,resizable=1,scrollbars=1,height=500,width=750')">
    <?php echo $presente_html; ?>
    </a><?php } else echo $presente_html; ?>
    <table id="tooltip-presente-tooltip" class="tabela">
        <tr>
            <td><img src="/arquivos/presentes/presente_de_natal_3.png" height="50" width="50"></td>
            <td><?php echo $resultado_mensagem; ?></td>
        </tr>
    </table>
    <?php echo '<!--Página ID: '.$page_id.'-->'; ?>
</div>
    

