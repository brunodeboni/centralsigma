<?php
//Verifica se usuário está logado
session_start();
if(!isset($_SESSION['usuario'])) die("<strong>Acesso Negado!</strong>");

?>
<!doctype> 
<html>
<head>
    <meta charset="utf-8" />
	<title>Consulta de Ocorrências</title>
	<link rel="stylesheet" href="default.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
</head>
<body>
<div class="ocorrencias">
	<h1>Consulta de Ocorrências</h1>
	<form action="" method="post">
		<p>Consulte ocorrências através de um dos filtros abaixo:</p>
		
		<span>Código da Ocorrência:</span>
		<input type="text" name="codigo" id="codigo" class="block"><br>
		
		<span>Colaborador envolvido:</span>
		<input type="text" name="colaborador" id="colaborador" class="block"><br>
		
		<span>Status da Ocorrência:</span>
		<select name="status" id="status" class="block">
			<option value="">Selecione...</option>
			<option value="0">Pendente</option>
			<option value="1">Solucionada</option>
		</select><br>
		
		<a id="clear" class="btn">Limpar</a>
		<button id="btn">Pesquisar</button>
	</form>
	
	<script>
	$('#codigo').focus(function() {
		$('#colaborador').val('');
		$('#colaborador').attr('disabled', 'true');
		$('#status').val('');
		$('#status').attr('disabled', 'true');
	});

	$('#colaborador').focus(function() {
		$('#codigo').val('');
		$('#codigo').attr('disabled', 'true');
		$('#status').val('');
		$('#status').attr('disabled', 'true');
	});

	$('#status').focus(function() {
		$('#codigo').val('');
		$('#codigo').attr('disabled', 'true');
		$('#colaborador').val('');
		$('#colaborador').attr('disabled', 'true');
	});

	$('#clear').click(function() {
		$('input').removeAttr('disabled');
		$('select').removeAttr('disabled');
		$('input').val('');
		$('select').val('');
	});
	</script>
<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	if (isset($_POST['codigo'])) {
		$where = " where codigo = :codigo order by codigo desc";
		$prep[':codigo'] = $_POST['codigo'];
	}else if (isset($_POST['colaborador'])) {
		$where = " where colaboradores like :colaborador order by codigo desc";
		$prep[':colaborador'] = "%".$_POST['colaborador']."%";
	}else if (isset($_POST['status'])) {
		$where = " where status = :status order by codigo desc";
		$prep[':status'] = $_POST['status'];
	}
	
	//Conexão com mysql
	require '../../conexoes.inc.php';
	$db = Database::instance('centralsigma02');
	
	$sql = "select codigo, date_format(dh_registro, '%d/%m/%Y %h:%m') as dh_registro 
	from bo_ocorrencias".$where;
	$query = $db->prepare($sql);
	$query->execute($prep);
	
	if ($query->rowCount() > 0) {
		$resultado = $query->fetchAll();
		
		echo '<table>';
		echo '<tr id="tr_resultado">
				<td colspan="2">Resultado</td>
			  </tr>';
		$rowq = true; //Classe para cores das linhas
		foreach ($resultado as $res) {
			//Classe para cores das linhas
		    if($rowq) $class = "secondline";
			else $class = "firstline";
			$rowq = !$rowq;
				
			$codigo = $res['codigo'];
			$dh_registro = $res['dh_registro'];
			
			echo '
			<tr class="'.$class.'">
				<td><a href="ocorrencia.php?codigo='.$codigo.'">'.$codigo.'</a></td>
				<td>'.$dh_registro.'</td>
			</tr>';
		}
		echo '</table>';
	}else {
		echo '<p>Nenhum resultado encontrado.</p>';
	}
}
?>
	<div id="logout">
		<a href="painel.php">Voltar</a>
		<a href="index.php">Sair</a>
	</div>
</div>
</body>
</html>
