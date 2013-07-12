<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<title>Perfil CPCM/Planejadores de Manutenção SIGMA</title>
	<style>
	body{font-size:14px; font-family: Arial, Helvetica, sans-serif;}
	.firstline {background-color: #FAF0E6; width: 250px;}
	.secondline {background-color: #FAEBD7; width: 250px;}
	#container {
		padding: 10px;
		width: 500px;
		margin: auto;
		background:#F7F7FF;
	}
	form {
		padding: 10px;
	}
	b {
		color: #369;
	}
	h1{
		margin-bottom: 5px;
		text-align: center;
		padding: 5px;
		font-size: 18px;
		background: #B03060;
		color: #FFF;
	}
	h2{
		margin-bottom:5px;
		text-align:center;
		padding:5px;
		font-size:18px;
		background:#369;
		color:#FFF;
	}
	table{
		margin-bottom:5px;
		width:100%;
		border-collapse:collapse;
		border-bottom:2px solid #6969AF;
	}
	table thead tr{
		background:#6969AF;		
	}
	table th, table td{
		width: 50%;
		padding:10px;
		text-align:right;
		font-weight: bold;
	}
	.block{
		width:100%;
		margin:auto;
		display:block;
	}
	#btn{
		margin: 10px auto;
		background: #B03060; 
		padding: 10px 40px; 
		color: #FFF; 
		font-weight: bold;
		font-size: 14px;
		border: 0;
		text-decoration: none;
	}
	</style>
</head>
<body>
<div id="container">
	<h1>Consulta de Perfil</h1>
	<form id="form_consulta_perfil" action="" method="post">
		<span>Escolha <b>uma</b> das opções de pesquisa:</span><br><br>
		
		<input type="radio" name="pesquisar" id="name" value="name"><b>Nome:</b>
		<input type="text" name="nome" id="nome" class="block" disabled><br>
		
		<input type="radio" name="pesquisar" id="company" value="company"><b>Empresa:</b>
		<input type="text" name="empresa" id="empresa" class="block" disabled><br>
		
		<input type="radio" name="pesquisar" id="state" value="state"><b>Estado:</b>
		<select name="uf" id="uf" class="block" disabled>
			<option value="">Selecione...</option>
			<option value="AC">Acre</option>
            <option value="AL">Alagoas</option>
            <option value="AP">Amapá</option>
            <option value="AM">Amazonas</option>
            <option value="BA">Bahia</option>
            <option value="CE">Ceará</option>
            <option value="DF">Distrito Federal</option>
            <option value="ES">Espírito Santo</option>
            <option value="GO">Goiás</option>
            <option value="MA">Maranhão</option>
            <option value="MT">Mato Grosso</option>
            <option value="MS">Mato Grosso do Sul</option>
        	<option value="MG">Minas Gerais</option>
            <option value="PA">Pará</option>
            <option value="PB">Paraíba</option>
            <option value="PR">Paraná</option>
            <option value="PE">Pernambuco</option>
            <option value="PI">Piauí</option>
            <option value="RJ">Rio de Janeiro</option>
            <option value="RN">Rio Grande do Norte</option>
            <option value="RS">Rio Grande do Sul</option>
            <option value="RO">Rondônia</option>
            <option value="RR">Roraima</option>
            <option value="SC">Santa Catarina</option>
            <option value="SP">São Paulo</option>
            <option value="SE">Sergipe</option>
            <option value="TO">Tocantins</option>
		</select>
		<br><br>
		
		<button type="button" id="btn">Pesquisar</button>
		<a id="btn" href="../controle.php">Voltar</a>
	</form>
	<script>
	$('#name').click(function() {
		$('#nome').removeAttr('disabled');
		$('#empresa').attr('disabled', 'true').val('');
		$('#uf').attr('disabled', 'true').val('');
	});

	$('#company').click(function() {
		$('#empresa').removeAttr('disabled');
		$('#nome').attr('disabled', 'true').val('');
		$('#uf').attr('disabled', 'true').val('');
	});

	$('#state').click(function() {
		$('#uf').removeAttr('disabled');
		$('#empresa').attr('disabled', 'true').val('');
		$('#nome').attr('disabled', 'true').val('');
	});

	$('#btn').click(function() {
		if (!$('input:checked').val()) {alert('Selecione uma opção de pesquisa.'); return false;}
		if ($('#nome').val() == "" 
			&& $('#empresa').val() == "" 
			&& $('#uf').val() == "") {
				alert('Informe os dados para pesquisa.'); return false;
		}

		$('#form_consulta_perfil').submit();
	});
	
	</script>
<?php 

if (isset($_POST['pesquisar'])) {
	
	include '../../../conexoes.inc.php';
	$db = Database::instance('centralsigma02');
	
	if (isset ($_POST['nome'])) {
		$nome = $_POST['nome'];
		$where = "where u.nome like :nome";
		$prep = array(':nome' => '%'.$nome.'%');
	}else if (isset ($_POST['empresa'])) {
		$empresa = $_POST['empresa'];
		$where = "where u.empresa like :empresa";
		$prep = array(':empresa' => '%'.$empresa.'%');
	}else if (isset ($_POST['uf'])) {
		$uf = $_POST['uf'];
		$where = "where p.uf = :uf";
		$prep = array(':uf' => $uf);
	}
	
	$sql = "select u.nome, u.empresa, u. telefone, u.celular, u.email, 
		p.nascimento, p.endereco, p.cidade, p.uf, p.planejador from cw_perfil as p 
		left join cwk_users as u on u.id = p.id_user ";
	$sql .= $where;
	$query = $db->prepare($sql);
	$query->execute($prep);
	
	if ($query->rowCount() > 0) {
		$resultado = $query->fetchAll();
		foreach ($resultado as $res) {
			
			echo '<table>
				<tr class="firstline">
					<td>Nome</td>
					<td>'.$res["nome"].'</td>
				</tr>
				<tr class="secondline">
					<td>Empresa</td>
					<td>'.$res["empresa"].'</td>
				</tr>
				<tr class="firstline">
					<td>Data de Nascimento</td>
					<td>'.$res["nascimento"].'</td>
				</tr>
				<tr class="secondline">
					<td>Endereço</td>
					<td>'.$res["endereco"].'</td>
				</tr>
				<tr class="firstline">
					<td>Cidade</td>
					<td>'.$res["cidade"].'</td>
				</tr>
				<tr class="secondline">
					<td>Estado</td>
					<td>'.$res["uf"].'</td>
				</tr>
				<tr class="firstline">
					<td>Telefone</td>
					<td>'.$res["telefone"].'</td>
				</tr>
				<tr class="secondline">
					<td>Celular</td>
					<td>'.$res["celular"].'</td>
				</tr>
				<tr class="firstline">
					<td>E-mail</td>
					<td>'.$res["email"].'</td>
				</tr>
				<tr class="secondline">
					<td>Está no mapa?</td>
					<td>'.$res["planejador"].'</td>
				</tr>
			</table>
			';
		}
	}else {
		echo 'Nenhum resultado encontrado.';
	}
}


?>
</div>
</body>
</html>
