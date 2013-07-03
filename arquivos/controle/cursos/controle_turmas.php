<?php 
/*
session_start();
if(!isset($_SESSION['5468usuario'])) die("<strong>Acesso Negado!</strong>");
*/

// Informa qual o conjunto de caracteres será usado.
header('Content-Type: text/html; charset=utf-8');

// Conexão com mysql
include '../../../conexoes.inc.php';
$db = Database::instance('centralsigma02');
	
?>

<!doctype html> 
<html>
<head>
	<meta charset="utf-8">
    <title>Controle de Turmas</title>
    <style type="text/css">
    body {font-family:Arial, Tahoma, sans-serif;}
    .titulo {font-size: 20px; color: #CD5C5C;}
	.firstline {background-color: #F5DEB3;}
	.secondline {background-color: #F5F5DC;}
	.ano {color: gray; margin-bottom: -3px;}
	.mostrar, .mostrar:visited {font-weight:bold; text-decoration: none; color: #B03060}
	.mostrar:hover, .mostrar:active {font-weight:bold; text-decoration: none; color:#CD5C5C;}
	</style>
</head>
<body>
<div>
	<h1 class="titulo">Controle de Turmas</h1>
	<table>
		<tr class="firstline">
			<td><b>Curso</b>
			<td><b>Turno</b>
			<td><b>Per&iacute;odo</b>
			<td><b>Turma</b>
			<td><b>Status</b>
			<td><b>Inscritos</b>

<?php 
if (isset ($_GET['mostrar'])) 
	$mostrar = $_GET['mostrar'];
else 
	$mostrar = 'padrao';

if ($mostrar == 'padrao') {
	$sql = "SELECT curso.id as id_curso,curso.nome as curso, turma.turno as turno, turma.periodo as periodo, turma.id as id_turma, count(inscrito.id) as inscritos, turma.status
	from cw_cursos as curso 
	left join cw_cursos_turmas as turma on curso.id = turma.id_curso
	left join cw_cursos_inscritos as inscrito on turma.id = inscrito.id_turma
	where date_add(turma.data_inicio, interval 3 day) >= current_date
	group by 1,2,3,4,5,7
	order by turma.data_inicio";
	$query = $db->query($sql);
	$resultado = $query->fetchAll();
	
}else if ($mostrar == 'abertas') {
	$sql = "SELECT curso.id as id_curso,curso.nome as curso, turma.turno as turno, turma.periodo as periodo, turma.id as id_turma, count(inscrito.id) as inscritos, turma.status
	from cw_cursos as curso
	left join cw_cursos_turmas as turma on curso.id = turma.id_curso
	left join cw_cursos_inscritos as inscrito on turma.id = inscrito.id_turma
	where date_add(turma.data_inicio, interval 3 day) >= current_date
	and turma.status=0
	group by 1,2,3,4,5,7
	order by turma.data_inicio";
	$query = $db->query($sql);
	$resultado = $query->fetchAll();

}else if ($mostrar == 'encerradas') {
	$sql = "SELECT curso.id as id_curso,curso.nome as curso, turma.turno as turno, turma.periodo as periodo, turma.id as id_turma, count(inscrito.id) as inscritos, turma.status
	from cw_cursos as curso
	left join cw_cursos_turmas as turma on curso.id = turma.id_curso
	left join cw_cursos_inscritos as inscrito on turma.id = inscrito.id_turma
	where date_add(turma.data_inicio, interval 3 day) >= current_date
	and turma.status=1
	group by 1,2,3,4,5,7
	order by turma.data_inicio";
	$query = $db->query($sql);
	$resultado = $query->fetchAll();
	
}else if ($mostrar == 'todas') {
	$sql = "SELECT curso.id as id_curso,curso.nome as curso, turma.turno as turno, turma.periodo as periodo, turma.id as id_turma, count(inscrito.id) as inscritos, turma.status
	from cw_cursos as curso
	left join cw_cursos_turmas as turma on curso.id = turma.id_curso
	left join cw_cursos_inscritos as inscrito on turma.id = inscrito.id_turma
	group by 1,2,3,4,5,7
	order by turma.data_inicio";
	$query = $db->query($sql);
	$resultado = $query->fetchAll();
	
}

$rowq = true; //cores das linhas

foreach ($resultado as $res) {
	$id_curso = $res['id_curso'];
	$curso = $res['curso'];
	$turno = $res['turno'];
	$periodo = $res['periodo'];
	$id_turma = $res['id_turma'];
	$status_turma = $res['status'];
	$inscritos = $res['inscritos'];
	
	switch ($status_turma) {
		case 0: $status_turma = 'Aberta'; break;
		case 1: $status_turma = 'Encerrada'; break;
	}
	
	//cores das linhas
	if($rowq) $class = "secondline";
	else $class = "firstline";
	$rowq = !$rowq;
	
	echo "<tr class=\"$class\">
				<td>$curso
				<td>$turno	
				<td>$periodo
				<td><a href=\"email.php?turma=".$id_turma."\">$id_turma</a>
				<td>$status_turma
				<td><a href=\"controle_inscritos.php?turma=".$id_turma."&curso=".$id_curso."&turno=".$turno." \">$inscritos</a>
	";
}

?>
			
	</table>
	<br>	
	<a class="mostrar" href="?mostrar=abertas">Mostrar somente turmas abertas</a><br>
	<a class="mostrar" href="?mostrar=encerradas">Mostrar somente turmas encerradas</a><br>
	<a class="mostrar" href="?mostrar=padrao">Mostrar turmas abertas e encerradas</a><br>
	<a class="mostrar" href="?mostrar=todas">Mostrar todas as turmas</a><br>

<br>
<br>
<a class="mostrar" href="email_all.php">Enviar e-mail para todos os alunos</a><br>
<a class="mostrar" href="sms_all.php">Enviar SMS para todos os alunos</a><br>
	
<?php 
//Total de inscritos
$sql = "SELECT count(id) as inscritos FROM cw_cursos_inscritos";
$query = $db->query($sql);
$resuultado = $query->fetchAll();

foreach ($resuultado as $result) {
	$total_inscritos = $result['inscritos']; 
}
echo "<br><br><b>Total inscritos:</b> ".$total_inscritos."<br>";

//Total de cadastrados
$sql2 = "SELECT count(id) as cadastrados FROM cwk_users";
$query2 = $db->query($sql2);
$resuultado2 = $query2->fetchAll();

foreach ($resuultado2 as $result2) {
	$total_cadastrados = $result2['cadastrados'];
}

echo "<b>Total cadastrados:</b> ".$total_cadastrados."<br><br>";
?>
<div>
<table>
	<tr class="firstline">
		<td><b>Curso</b>
		<td><b>Inscritos</b>
<?php 

//Totatl de inscritos por curso
$sql22 = "SELECT count(inscritos.id) as total_inscritos, inscritos.id_turma, turmas.id_curso, cursos.nome as nome_curso
FROM cw_cursos_inscritos as inscritos
left join cw_cursos_turmas as turmas on turmas.id=inscritos.id_turma
left join cw_cursos as cursos on turmas.id_curso=cursos.id
group by turmas.id_curso";
$query22 = $db->query($sql22);
$resuultado22 = $query22->fetchAll();

$rowq = true; //classe das cores das linhas

foreach ($resuultado22 as $res2) {
	$inscritos = $res2['total_inscritos'];
	$curso = $res2['nome_curso'];
	
	//cores das linhas
	if($rowq) $class = "secondline";
	else $class = "firstline";
	$rowq = !$rowq;
	
	echo "<tr class=\"$class\">
    		<td>$curso
    		<td>$inscritos
	";
}
?>

</table>
<br>
<a class="mostrar" href="relatorio_cursos.php" target="_blank">Gerar Relat&oacute;rio em PDF</a>
<br>
</div>
<br>
<br>

<?php 

//Total de inscritos por dia
$sql1 = 'select
date_format(dh_inscrito, \'%d/%m/%Y\') as dia,
count(id) as num_inscritos

from cw_cursos_inscritos as inscritos

group by 1 order by dh_inscrito desc';
$query1 = $db->query($sql1);
$resuultado1 = $query1->fetchAll();


	//Tabela
	echo "<table>
			<tr class=\"firstline\">
				<td><b>Data</b>
				<td><b>Inscritos</b>
				<td><b>Cadastrados</b>
		";
	$rowq = true; //cores das linhas
	
foreach ($resuultado1 as $res) {

	$dia = $res['dia'];
	$num_inscritos = $res['num_inscritos'];
	
	//Total de novos inscritos por dia
	$sql2 = "select
	count(id) as num_users
		
	from cwk_users
		
	where date_format(dh_inscrito, '%d/%m/%Y')=:dia";
	$query2 = $db->prepare($sql2);
	$query2->execute(array(':dia' => $dia));
	$ress2 = $query2->fetchAll();
	foreach ($ress2 as $res2) {
		$num_users = $res2['num_users'];
	}
	
	//cores das linhas
	if($rowq) $class = "secondline";
	else $class = "firstline";
	$rowq = !$rowq;
	
	echo "
		<tr class=\"$class\">
			<td><a href=\"inscritos_dia.php?dia=".$dia."\">$dia</a>
			<td>$num_inscritos
			<td>$num_users
		";
}
	echo "</table>";
	echo '<br><a class="mostrar" href="relatorio_data.php" target="_blank">Gerar Relat&oacute;rio em PDF</a><br>';
?>
</div>
<br>
<div>
<form action="#" method="post">
	<span>Ano: </span>
	<input name="ano">
	<button type="submit">Pesquisar</button>
</form>

<table>
<?php	


//Pega o 'post' do ano
    if (empty ($_POST['ano'])) {
        $ano_pesq = date('Y');
    
    }else {$ano_pesq = $_POST['ano'];}
    
    echo "<p class=\"ano\">&nbsp;".$ano_pesq."</p>";
	
	echo '
	<tr class="firstline">
		<td><b>Como conheceu/M&ecirc;s</b>
        <td><b>Janeiro</b>
        <td><b>Fevereiro</b>
        <td><b>Mar&ccedil;o</b>
        <td><b>Abril</b>
        <td><b>Maio</b>
        <td><b>Junho</b>
        <td><b>Julho</b>
        <td><b>Agosto</b>
        <td><b>Setembro</b>
        <td><b>Outubro</b>
        <td><b>Novembro</b>
        <td><b>Dezembro</b>
		<td><b>Total</b>
	';
 
//$sql = "select distinct(como_conheceu) as como_conheceu from cwk_users order by como_conheceu desc" or die('Nope');
$sql = "select distinct(
			case como_conheceu
			when 'amigos' then 'amigos'
			when 'amigo' then 'amigos'
			when 'senai' then 'senai'
			when 'jornal' then 'jornal'
			when 'internet' then 'internet'
			when 'google' then 'google'
			when 'forum_sigma' then 'forum'
			when 'forum' then 'forum'
			when 'forum_rede_industrial' then 'forum'
			when 'facebook' then 'facebook'
			when 'empresa' then 'empresa'
			when 'email' then 'email'
			when 'outro' then 'outro'
			else 'não informado'
			end
		) as como_conheceu
		from cwk_users order by como_conheceu desc";
$query = $db->query($sql);
$query->execute();
$resultado = $query->fetchAll();

$rowq = true; //cores das linhas

foreach ($resultado as $res) {

	$como_conheceu = $res['como_conheceu'];
	
	//Nome a aparecer na tabela
	switch ($como_conheceu) {
		case "não informado": $conheceu = "N&atilde;o informado"; break;
		case "senai": $conheceu = "Senai"; break;
		case "outro": $conheceu = "Outro"; break;
		case "jornal": $conheceu = "Jornal"; break;
		case "internet": $conheceu = "Internet"; break;
		case "google": $conheceu = "Google"; break;
		case "forum_rede_industrial": $conheceu = "F&oacute;rum Rede Industrial"; break;
		case "forum_sigma": $conheceu = "F&oacute;rum Sigma"; break;
		case "forum": $conheceu = "F&oacute;rum"; break;
		case "facebook": $conheceu = "Facebook"; break;
		case "empresa": $conheceu = "Empresa"; break;
		case "email": $conheceu = "E-mail"; break;
		case "amigos": $conheceu = "Amigos"; break;
		case "amigo": $conheceu = "Amigo"; break;
	}
	
	//Para fazer pesquisa apenas do que é desejado
	switch ($como_conheceu) {
		case "não informado": $como_conheceu = "null, ''"; break;
		case "senai": $como_conheceu = "'senai'"; break;
		case "outro": $como_conheceu = "'outro'"; break;
		case "jornal": $como_conheceu = "'jornal'"; break;
		case "internet": $como_conheceu = "'internet'"; break;
		case "google": $como_conheceu = "'google'"; break;
		case "forum_rede_industrial": $como_conheceu = "'forum_rede_industrial', 'forum_sigma', 'forum'"; break;
		case "forum_sigma": $como_conheceu = "'forum_rede_industrial', 'forum_sigma', 'forum'"; break;
		case "forum": $como_conheceu = "'forum_rede_industrial', 'forum_sigma', 'forum'"; break;
		case "facebook": $como_conheceu = "'facebook'"; break;
		case "empresa": $como_conheceu = "'empresa'"; break;
		case "email": $como_conheceu = "'email'"; break;
		case "amigos": $como_conheceu = "'amigo', 'amigos'"; break;
		case "amigo": $como_conheceu = "'amigo', 'amigos'"; break;
	}
	
	
	
	//cores das linhas
	if($rowq) $class = "secondline";
	else $class = "firstline";
	$rowq = !$rowq;
	
	echo "<tr class=\"$class\">";
	echo "<td><b>".$conheceu."</b>";
	
	//Tabela de como cada usuário conheceu os cursos em cada mês
	for ($mes = 1; $mes <= 12; $mes++) { //loop de usuários por mês
		$pesq1 = "SELECT count(como_conheceu) as total_conheceu 
		FROM cwk_users 
		WHERE como_conheceu in (".$como_conheceu.") 
		AND month(dh_inscrito)=:mes 
		AND year(dh_inscrito)=:ano_pesq";
        $query_pes = $db->prepare($pesq1);
        $query_pes->execute(array(
        	':mes' => $mes,
        	':ano_pesq' => $ano_pesq
        ));
		$resulta = $query_pes->fetchAll();
		foreach ($resulta as $result) {
			echo "<td>".$result['total_conheceu'];
		}
	}
	//Coluna de total de como cada usuário conheceu por ano
	$pesq2 = "SELECT count(como_conheceu) as total_ano
		FROM cwk_users
		WHERE como_conheceu in (".$como_conheceu.")
		AND year(dh_inscrito)=:ano_pesq";
	$query_pes2 = $db->prepare($pesq2);
	$query_pes2->execute(array(
		':ano_pesq' => $ano_pesq
	));
	$re = $query_pes2->fetchAll();
	foreach ($re as $r) {
		echo "<td>".$r['total_ano'];
	}
}
	//Linha de total dos usuários por mês
	echo '<tr class="'.$class.'">
			<td><b>Total</b>';
	for ($mes = 1; $mes <= 12; $mes++) { //loop de usuários por mês
		$p = "select count(como_conheceu) as total_mes
				from cwk_users
				where month(dh_inscrito)=:mes 
				and year(dh_inscrito)=:ano_pesq";
		$q = $db->prepare($p);
		$q->execute(array(
			':mes' => $mes,
			':ano_pesq' => $ano_pesq
		));
		$rr = $q->fetchAll();
		foreach ($rr as $re) {
			echo "<td>".$re['total_mes'];
		}
	}
	//Célula com total de usuários no ano
	$pe = "select count(como_conheceu) as total_geral
			from cwk_users
			where year(dh_inscrito)=:ano_pesq";
	$qu = $db->prepare($pe);
	$qu->execute(array(':ano_pesq' => $ano_pesq));
	$res = $qu->fetchAll();
	foreach ($res as $resu) {
		echo "<td>".$resu['total_geral'];
	}

?>       
</table>
<br>
<a class="mostrar" href="relatorio_conheceu.php?ano=<?php echo $ano_pesq?>" target="_blank">Gerar Relat&oacute;rio em PDF</a>
<br>
</div>
 
<br>
<div>
	<form action="#" method="post">
		<span>Pesquise os inscritos por UF:&nbsp;&nbsp;&nbsp;</span>
		<input name="uf">
		<button type="submit">Pesquisar</button>
	</form>
<br>
<?php 

if (isset ($_POST['uf'])) {
	$uf = $_POST['uf'];
	
	echo '<a class="mostrar" href="relatorio_uf.php?uf='.$uf.'" target="_blank">Gerar Relat&oacute;rio em PDF</a><br>';
	
	$cons = "select usuarios.nome, usuarios.empresa, usuarios.cargo, usuarios.uf,
			usuarios.telefone, usuarios.email
			from cwk_users as usuarios
			where usuarios.uf = :uf";
	$consulta = $db->prepare($cons);
	$consulta->execute(array(':uf' => $uf));
	$retorno = $consulta->fetchAll();
	
	if($consulta->rowCount() > 0) {
		echo '
			<table>
				<tr class="firstline">
					<td><b>Nome</b>
					<td><b>Empresa</b>
					<td><b>UF</b>
					<td><b>Cargo</b>
					<td><b>Telefone</b>
					<td><b>E-mail</b>
		';
		
		$rowq = true; //Classe das cores das linhas
		foreach ($retorno as $dados) {
			$nome = $dados['nome'];
			$empresa = $dados['empresa'];
			$cargo = $dados['cargo'];
			$uf = $dados['uf'];
			$cargo = $dados['telefone'];
			$uf = $dados['email'];
			
			//Classe das cores das linhas
			if($rowq) $class = "secondline";
			else $class = "firstline";
			$rowq = !$rowq;
			
			echo '
				<tr class="'.$class.'">
					<td>'.$nome.'
	    			<td>'.$empresa.'
	    			<td>'.$cargo.'
	          		<td>'.$uf.'
					<td>'.$telefone.'
					<td>'.$email.'
			';
		}
		echo '</table>';
	}else echo 'A pesquisa n&atilde;o retornou resultados.';
}else echo ''; //se não foi feita pesquisa por uf

?>
</div>
<div>
<?php include 'parceiros.php'; ?>
</div>

</body>
</html>