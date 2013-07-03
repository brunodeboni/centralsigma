<?php 
	session_start();
if(!isset($_SESSION['usuario'])) die("<strong>Acesso Negado!</strong>");

// Informa qual o conjunto de caracteres será usado.
	header('Content-Type: text/html; charset=utf-8');

// Conexão com mysql
include '../../../conexoes.inc.php';
$db = Database::instance('centralsigma02');

//Pega o id da turma, do curso e o turno
	if(!isset($_GET['turma']) ) die ('<strong>&Eacute; necess&aacute;rio informar a turma.</strong>');
	if(!isset($_GET['curso']) ) die ('<strong>&Eacute; necess&aacute;rio informar o curso.</strong>');
	if(!isset($_GET['turno']) ) die ('<strong>&Eacute; necess&aacute;rio informar o turno.</strong>');
	
	
	if (isset ($_GET['turma']) && ($_GET['curso']) && ($_GET['turno']) ) {
		$id_turma = $_GET['turma'];
		$id_curso = $_GET['curso'];
		$turno = $_GET['turno'];
	}


 
//Pesquisa o id da turma a partir do curso e turno desejado
$sql = 'SELECT periodo FROM cw_cursos_turmas WHERE id = :id_turma';
$query = $db->prepare($sql);
$query->execute(array(':id_turma' => $id_turma));

$res = $query->fetchAll();
foreach ($res as $resultado) {
	$periodo = $resultado['periodo'];
}

//Pesquisa o nome do curso desejado
$sql1 = 'SELECT nome FROM cw_cursos WHERE id=:id_curso';
$query1 = $db->prepare($sql1);
$query1->execute(array(':id_curso' => $id_curso));

$res1 = $query1->fetchAll();
foreach ($res1 as $resultado1) {
	$curso = $resultado1['nome'];
}

//Pesquisa os dados dos inscritos na turma desejada
$sql2 = "SELECT inscritos.id as id_inscrito, usuarios.nome, 
usuarios.empresa, usuarios.cargo, usuarios.telefone, usuarios.celular, usuarios.email, 
usuarios.como_conheceu, DATE_FORMAT(inscritos.dh_inscrito, '%d/%m/%Y %H:%i') as data_hora
FROM cwk_users as usuarios

left join cw_cursos_inscritos as inscritos
on inscritos.id_user=usuarios.id

WHERE id_turma=:id_turma order by usuarios.dh_inscrito";
$query2 = $db->prepare($sql2);
$query2->execute(array(':id_turma' => $id_turma));
$resultado2 = $query2->fetchAll();
 
echo '<p><b>Curso:</b> '.$curso.'<br> <b>Per&iacute;odo:</b> '.$periodo.'<br> <b>Turno:</b> '.$turno.'</p>';

?>

<!doctype html> 
<html>
<head>
	<meta charset="utf-8">
    <title>Inscritos Aulasweb</title>
    <style type="text/css">
    body {font-family:Arial, Tahoma, sans-serif;}
	.firstline {background-color: #F5DEB3;}
	.secondline {background-color: #F5F5DC;}
	</style>
</head>
<body>
<div>
<form action="transfere_aulasweb.php" method="post" id="checkbox">
	<table>
		<tr class="firstline">
			<td><b>Transferir</b>
			<td><b>Id</b>
			<td><b>Data/Hora</b>
			<td><b>Nome</b>
			<td><b>Empresa</b>
			<td><b>Cargo</b>
			<td><b>Telefone</b>
			<td><b>Celular</b>
			<td><b>E-mail</b>
			<td><b>Como conheceu</b>

<?php 
$rowq = true; // cores das linhas
$i=0;

foreach ($resultado2 as $res) {
	$data_hora = $res['data_hora'];	
	$id_inscrito = $res['id_inscrito'];
	$nome = $res['nome'];
	$empresa = $res['empresa'];
	$cargo = $res['cargo'];
	$telefone = $res['telefone'];
	$celular = $res['celular'];
	$email = $res['email'];
	$conheceu = $res['como_conheceu'];
	
	switch ($conheceu) {
		default: $conheceu = "N&atilde;o informado"; break;
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
	
	//classe das cores das linhas
	if($rowq) $class = "secondline";
	else $class = "firstline";
	$rowq = !$rowq;
	
	$i++;
	
	echo "
		<tr class=\"$class\">
				<td><input type=\"checkbox\" name=\"cb_inscrito[]\" value=\"".$id_inscrito."\">
				<td>$i
				<td>$datahora
				<td>$nome
				<td>$empresa
				<td>$cargo
				<td>$telefone
				<td>$celular
				<td>$email
				<td>$conheceu
	";
}

?>			
	</table>
	<br>
	<span>Transferir para a turma ID</span>
	<input type="text" value="" id="turma" name="turma">
	<button type="submit">Transferir</button>
</form>	
</div>
<a href="controle_turmas.php">Voltar</a>
</body>
</html>