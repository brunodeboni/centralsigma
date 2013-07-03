<?php
//conecta com o banco de dados
//$conexao = mysql_connect('localhost', 'root', '') or die ('Não pode se conectar porque ' . mysql_error());
//mysql_select_db('presentes', $conexao);

$conexao = mysql_connect('mysql.centralsigma.com.br', 'centralsigma02', 'S4k813042012') or die ('Não pode se conectar porque ' . mysql_error());
mysql_select_db('centralsigma02', $conexao);

function buscaPresente () {
    // Monta uma consulta SQL (query) para procurar o status do presente
    $sql = "SELECT status, id_presente, contpess_id FROM presentes_unicos WHERE id_presentes_unicos = 3 LIMIT 1";
    $query = mysql_query($sql) or die(mysql_error());
    $resultado = mysql_fetch_array($query);
    return $resultado;
    if(mysql_num_rows($query)>0){
     $resultado = mysql_fetch_array($query);
 }else{
     $resultado = false;
 }
}

$resultado = buscaPresente();

$status = $resultado[0];
$id_presente = $resultado[1];
$contpess_id = $resultado[2];

$sql = "SELECT descricao FROM presentes WHERE id_presente = ".$id_presente." LIMIT 1";
$query1 = mysql_query($sql);
$resultado1 = mysql_fetch_array($query1);
$presente = $resultado1[0];

$sql = "SELECT contpess_nome, contpess_cidade FROM contato_pessoa WHERE contpess_id = ".$contpess_id." LIMIT 1";
$query2 = mysql_query($sql);
$resultado2 = mysql_fetch_array($query2);
$nome = $resultado2[0];
$cidade = $resultado2[1];
 

$resultado_mensagem = "";

if ($status == 0) { //disponÃ­vel
    $resultado_mensagem = "Parab&eacute;ns! Voc&ecirc; Achou o Seguinte Presente: ".$presente.". Clique sobre a caixa do presente para receb&ecirc;-lo.";
} if ($status == 1) { //em anÃ¡lise
    $resultado_mensagem = 'Foi por pouco! Este presente j&aacute; foi encontrado por outra pessoa. Continue procurando!';  
} if ($status == 2) { //cadastro ok
    $resultado_mensagem = "Foi por pouco! Este presente j&aacute; foi encontrado por ".$nome." da cidade de ".$cidade."";
}

?>



<div class="tooltip">
	<?php echo $resultado_mensagem; ?>
</div>
