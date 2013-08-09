<?php
//Verifica se usuário está logado
session_start();
if(!isset($_SESSION['usuario'])) die("<strong>Acesso Negado!</strong>");

if (isset ($_GET['codigo'])) {
	$codigo = $_GET['codigo'];

?>
<!doctype> 
<html>
<head>
    <meta charset="utf-8" />
	<title>Painel de Ocorrências</title>
	<link rel="stylesheet" href="default.css">
	<style>
	.ocorrencias{
		width:700px;
	}
	</style>
</head>
<body>
<div class="ocorrencias">
	<h1>Painel de Registros de Ocorrência</h1>
<?php 

//Conexão com mysql
require '../../conexoes.inc.php';
$db = Database::instance('centralsigma02');

$sql = "select o.codigo, date_format(o.dh_registro, '%d/%m/%Y %h:%m') as dh_registro, 
o.responsavel, o.dia_ocorrencia, o.hora_ocorrencia, o.colaboradores, o.assunto, 
o.ocorrencia, e.erro, o.erros_descricao, o.sugestao, p.problema, o.problemas_descricao, 
o.clientes, o.envolvido, o.ciencia_cliente, o.status
from bo_ocorrencias as o 
left join bo_ocorrencias_erros as e on e.id = o.erros
left join bo_ocorrencias_problemas as p on p.id = o.problemas
where o.codigo = :codigo";
 
$query = $db->prepare($sql);
$query->execute(array(':codigo' => $codigo));
$resultado = $query->fetchAll();

foreach ($resultado as $res) {

	$dh_registro = $res['dh_registro'];
	$responsavel = $res['responsavel'];
	$data_ocorrencia = $res['dia_ocorrencia']." ".$res['hora_ocorrencia'];
	$colaboradores = $res['colaboradores'];
	$assunto = $res['assunto'];
	$ocorrencia = $res['ocorrencia'];
	$erro = $res['erro'];
	$erros_descricao = $res['erros_descricao'];
	$sugestao = $res['sugestao'];
	$problema = $res['problema'];
	$problemas_descricao = $res['problemas_descricao'];
	$clientes = $res['clientes'];
	$envolvido = $res['envolvido'];
	$ciencia_cliente = $res['ciencia_cliente'];
	$status = $res['status'];	
	
	if ($status == '1') {
		$sql = "select solucao, date, responsavel_solucao 
		from bo_solucao where cod_ocorrencia = :codigo";
		$query = $db->prepare($sql);
		$query->bindValue(':codigo', $codigo, PDO::PARAM_INT);
		$query->execute();
		$resultado = $query->fetchAll();
		
		foreach ($resultado as $res) {
			$solucao = $res['solucao']; 
			$date = $res['date'];
			$responsavel_solucao = $res['responsavel_solucao']; 
		}
	}else {
		$solucao = 'Pendente'; 
		$date = 'Pendente';
		$responsavel_solucao = 'Pendente'; 
	}
	
	echo '
	<table>
		<tr class="firstline">
			<td>Código da Ocorrência</td>
			<td>'.$codigo.'</td>
		</tr>
		<tr class="secondline">
			<td>Data e Hora do Registro</td>
			<td>'.$dh_registro.'</td>
		</tr>
		<tr class="firstline">
			<td>Responsável pelo Registro</td>
			<td>'.$responsavel.'</td>
		</tr>
		<tr class="secondline">
			<td>Data e Hora da Ocorrência</td>
			<td>'.$data_ocorrencia.'</td>
		</tr>
		<tr class="firstline">
			<td>Colaboradores envolvidos</td>
			<td>'.$colaboradores.'</td>
		</tr>
		<tr class="secondline">
			<td>Assunto</td>
			<td>'.$assunto.'</td>
		</tr>
		<tr class="firstline">
			<td>Descrição do ocorrido</td>
			<td>'.$ocorrencia.'</td>
		</tr>
		<tr class="secondline">
			<td>O que está errado/fora do padrão</td>
			<td>'.$erro.'</td>
		</tr>
		<tr class="secondline">
			<td>Descrição do erro</td>
			<td>'.$erros_descricao.'</td>
		</tr>
		<tr class="firstline">
			<td>Como deveria ser</td>
			<td>'.$sugestao.'</td>
		</tr>
		<tr class="secondline">
			<td>Quais problemas este erro gerou</td>
			<td>'.$problema.'</td>
		</tr>
		<tr class="secondline">
			<td>Descrição dos problemas</td>
			<td>'.$problemas_descricao.'</td>
		</tr>
		<tr class="firstline">
			<td>Esta ocorrência está relacionada a algum cliente?</td>
			<td>'.$clientes.'</td>
		</tr>
		<tr class="secondline">
			<td>Qual?</td>
			<td>'.$envolvido.'</td>
		</tr>
		<tr class="firstline">
			<td>Esta ocorrência chegou ao conhecimetno do cliente? Explique.</td>
			<td>'.$ciencia_cliente.'</td>
		</tr>
		<tr class="secondline">
			<td>Solução</td>
			<td>'.$solucao.'</td>
		</tr>
		<tr class="firstline">
			<td>Data da solução</td>
			<td>'.$date.'</td>
		</tr>
		<tr class="secondline">
			<td>Responsável pela solução</td>
			<td>'.$responsavel_solucao.'</td>
		</tr>
		 
	</table>';
}

?>
	<div id="voltar"><a href="painel.php">Voltar</a></div>
</div>
</body>
</html>
<?php }else echo '&Eacute; necess&aacute;rio especificar um c&oacute;digo de ocorr&ecirc;ncia!'; ?>