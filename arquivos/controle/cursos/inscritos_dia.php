<?php
// Conexão com mysql
include '../../../conexoes.inc.php';
$db = Database::instance('centralsigma02');

if (!isset ($_GET['dia'])) {
	die('&Eacute; necess&aacute;rio especificar uma data.'); 
} else {
	$dia = $_GET['dia'];
}

// Informa qual o conjunto de caracteres ser� usado.
//header('Content-Type: text/html; charset=utf-8');



?>

<!doctype html> 
<html>
<head>
	<meta charset="utf-8">
    <title>Inscritos</title>
    <style type="text/css">
    body {font-family:Arial, Tahoma, sans-serif;}
	.firstline {background-color: #F5DEB3;}
	.secondline {background-color: #F5F5DC;}
	</style>
</head>
<body>
<div>
	<table>
		<tr class="firstline">
			<td><b>Id</b>
			<td><b>Data/Hora</b>
			<td><b>Nome</b>
			<td><b>Empresa</b>
			<td><b>Cargo</b>
			<td><b>Telefone</b>
			<td><b>Celular</b>
			<td><b>E-mail</b>
			<td><b>Curso</b>
			<td><b>Per&iacute;odo</b>
			<td><b>Turno</b>
			<td><b>Como <br>conheceu</b>

<?php 
//Pesquisa os dados dos inscritos no dia desejado
$sql = "SELECT usuarios.id, date_format(inscritos.dh_inscrito, '%d/%m/%Y %H:%i') as datahora, usuarios.nome as nome, usuarios.empresa, 
usuarios.cargo, usuarios.telefone, usuarios.celular, usuarios.email, inscritos.id_turma,
usuarios.como_conheceu, turmas.periodo, turmas.turno, turmas.id_curso, cursos.nome as nome_curso
FROM cwk_users as usuarios

LEFT JOIN cw_cursos_inscritos as inscritos on usuarios.id=inscritos.id_user
LEFT JOIN cw_cursos_turmas as turmas on inscritos.id_turma=turmas.id
LEFT JOIN cw_cursos as cursos on turmas.id_curso=cursos.id
WHERE DATE_FORMAT(inscritos.dh_inscrito,'%d/%m/%Y') = :dia
order by usuarios.dh_inscrito";
$query = $db->prepare($sql);
$query->execute(array(':dia' => $dia));
$resultado = $query->fetchAll();

$rowq = true; // cores das linhas
$i=0;

foreach ($resultado as $res) {
	$datahora = $res['datahora'];
	$id_inscrito = $res['id'];
	$nome = $res['nome'];
	$empresa = $res['empresa'];
	$cargo = $res['cargo'];
	$telefone = $res['telefone'];
	$celular = $res['celular'];
	$email = $res['email'];
	$curso = $res['nome_curso'];
	$periodo = $res['periodo'];
	$turno = $res['turno'];
	$como_conheceu = $res['como_conheceu'];
	
	//classe das cores das linhas
	if($rowq) $class = "secondline";
	else $class = "firstline";
	$rowq = !$rowq;
	
	$i++;
	
	echo "
		<tr class=\"$class\">
				<td>$i
				<td>$datahora
				<td>$nome
				<td>$empresa
				<td>$cargo
				<td>$telefone
				<td>$celular
				<td>$email
				<td>$curso
				<td>$periodo
				<td>$turno
				<td>$como_conheceu
	";
}

?>
</table>
</div>
<br>
<a href="controle_turmas.php">Voltar</a>
</body>
</html>
