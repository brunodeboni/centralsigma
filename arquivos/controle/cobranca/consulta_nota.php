<?php
session_start();
if(!isset($_SESSION['5468usuario'])) {
	die("<strong>Acesso Negado!</strong>");
}else if($_SESSION['6542role'] != '2') {
	die("<strong>Acesso Negado!</strong>");
}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf8">
	<title>Consulta de Nota Fiscal</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="http://www.centralsigma.com.br/arquivos/plugins/jquery.maskedinput.js"></script>
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
	.wrap {
		width: 295px;
	}
	.div_wrap {
		width: 295px;
		word-wrap: break-word;
		text-wrap: unrestricted;
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
	<h1>Consulta de Nota Fiscal</h1>
	<form id="form_consulta_nota" action="" method="post">
		<span>Escolha <b>uma</b> das opções de pesquisa:</span><br><br>
		
		<input type="radio" name="pesquisar" id="nota_fiscal" value="nota_fiscal"><b>Número da Nota Fiscal:</b>
		<input type="text" name="nro_nota" id="nro_nota" class="block" disabled><br>
		
		<input type="radio" name="pesquisar" id="cnpj" value="cnpj"><b>CNPJ do Cliente:</b>
		<input type="text" name="cnpj_cliente" id="cnpj_cliente" class="block" disabled><br>
		
		<input type="radio" name="pesquisar" id="liquidacao" value="liquidacao"><b>Liquidação:</b>
		<input type="radio" name="liqui" class="liqui" value="todas" disabled>Todas
		<input type="radio" name="liqui" class="liqui" value="liquidadas" disabled>Liquidadas
		<input type="radio" name="liqui" class="liqui" value="nao_liquidadas" disabled>Não liquidadas
		<br><br>
		
		<input type="radio" name="pesquisar" id="vencimento" value="vencimento"><b>Vencimento:</b>
		<input type="text" name="data_vencimento" id="data_vencimento" class="block" disabled><br>
		
		<input type="radio" name="pesquisar" id="val" value="val"><b>Valor:</b><br>
		&nbsp; R$ &nbsp; <input type="text" name="valor" id="valor" style="width: 91%;" disabled><br><br>
		
		<input type="radio" name="pesquisar" id="emitente" value="emitente"><b>Emitente:</b>
		<select name="cnpj_emitente" id="cnpj_emitente" class="block" disabled>
			<option value="">Selecione...</option>
			<option value="94.212.248/0001-60">MICROCENTER COM. EQUIP. ELETRÔN. LTDA</option>
			<option value="05.155.514/0001-30">SGM MANUTENÇÃO INDUSTRIAL LTDA</option>
		</select><br>
		
		<input type="radio" name="pesquisar" id="forma_pag" value="forma_pag"><b>Forma de pagamento:</b>
		<select name="forma_pagto" id="forma_pagto" class="block" disabled>
			<option value="">Selecione...</option>
			<option value="Boleto Bancário">Boleto Bancário</option>
			<option value="Depósito Banco Itaú Ag. 0293 CC 87167-9">Depósito Banco Itaú Ag. 0293 CC 87167-9</option>
			<option value="Depósito Banco Itaú Ag. 6383 CC 01290-0">Depósito Banco Itaú Ag. 6383 CC 01290-0</option>
		</select><br>
		
		<input type="radio" name="pesquisar" id="ordem" value="ordem"><b>Ordem de Compra:</b>
		<input type="text" name="ordem_compra" id="ordem_compra" class="block" disabled><br>
		
		<input type="radio" name="pesquisar" id="postagem" value="postagem"><b>Data de Postagem:</b>
		<input type="text" name="data_postagem" id="data_postagem" class="block" disabled><br>
		
		<button type="button" id="btn">Pesquisar</button>
		<a id="btn" href="consulta.php">Voltar</a>
	</form>
	
<script>
$(document).ready(function() {
	$('#cnpj_cliente').mask('99.999.999/9999-99');
	$('#data_vencimento').mask('99/99/9999');
	$('#data_postagem').mask('99/99/9999');
});

$('#nota_fiscal').click(function() {
	$('#nro_nota').removeAttr('disabled');
	$('#cnpj_cliente').attr('disabled', 'true').val('');
	$('.liqui').attr('disabled', 'true').removeAttr('checked');
	$('#data_vencimento').attr('disabled', 'true').val('');
	$('#cnpj_emitente').attr('disabled', 'true').val('');
	$('#forma_pagto').attr('disabled', 'true').val('');
	$('#ordem_compra').attr('disabled', 'true').val('');
	$('#valor').attr('disabled', 'true').val('');
	$('#data_postagem').attr('disabled', 'true').val('');
});

$('#cnpj').click(function() {
	$('#cnpj_cliente').removeAttr('disabled');
	$('#nro_nota').attr('disabled', 'true').val('');
	$('.liqui').attr('disabled', 'true').removeAttr('checked');
	$('#data_vencimento').attr('disabled', 'true').val('');
	$('#cnpj_emitente').attr('disabled', 'true').val('');
	$('#forma_pagto').attr('disabled', 'true').val('');
	$('#ordem_compra').attr('disabled', 'true').val('');
	$('#valor').attr('disabled', 'true').val('');
	$('#data_postagem').attr('disabled', 'true').val('');
});

$('#liquidacao').click(function() {
	$('.liqui').removeAttr('disabled');
	$('#cnpj_cliente').attr('disabled', 'true').val('');
	$('#nro_nota').attr('disabled', 'true').val('');
	$('#data_vencimento').attr('disabled', 'true').val('');
	$('#cnpj_emitente').attr('disabled', 'true').val('');
	$('#forma_pagto').attr('disabled', 'true').val('');
	$('#ordem_compra').attr('disabled', 'true').val('');
	$('#valor').attr('disabled', 'true').val('');
	$('#data_postagem').attr('disabled', 'true').val('');
});

$('#vencimento').click(function() {
	$('#data_vencimento').removeAttr('disabled');
	$('.liqui').attr('disabled', 'true').removeAttr('checked');
	$('#cnpj_cliente').attr('disabled', 'true').val('');
	$('#nro_nota').attr('disabled', 'true').val('');
	$('#cnpj_emitente').attr('disabled', 'true').val('');
	$('#forma_pagto').attr('disabled', 'true').val('');
	$('#ordem_compra').attr('disabled', 'true').val('');
	$('#valor').attr('disabled', 'true').val('');
	$('#data_postagem').attr('disabled', 'true').val('');
});

$('#emitente').click(function() {
	$('#cnpj_emitente').removeAttr('disabled');
	$('#data_vencimento').attr('disabled', 'true').val('');
	$('.liqui').attr('disabled', 'true').removeAttr('checked');
	$('#cnpj_cliente').attr('disabled', 'true').val('');
	$('#nro_nota').attr('disabled', 'true').val('');
	$('#forma_pagto').attr('disabled', 'true').val('');
	$('#ordem_compra').attr('disabled', 'true').val('');
	$('#valor').attr('disabled', 'true').val('');
	$('#data_postagem').attr('disabled', 'true').val('');
});

$('#forma_pag').click(function() {
	$('#forma_pagto').removeAttr('disabled');
	$('#cnpj_emitente').attr('disabled', 'true').val('');
	$('#data_vencimento').attr('disabled', 'true').val('');
	$('.liqui').attr('disabled', 'true').removeAttr('checked');
	$('#cnpj_cliente').attr('disabled', 'true').val('');
	$('#nro_nota').attr('disabled', 'true').val('');
	$('#ordem_compra').attr('disabled', 'true').val('');
	$('#valor').attr('disabled', 'true').val('');
	$('#data_postagem').attr('disabled', 'true').val('');
});

$('#ordem').click(function() {
	$('#ordem_compra').removeAttr('disabled');
	$('#forma_pagto').attr('disabled', 'true').val('');
	$('#cnpj_emitente').attr('disabled', 'true').val('');
	$('#data_vencimento').attr('disabled', 'true').val('');
	$('.liqui').attr('disabled', 'true').removeAttr('checked');
	$('#cnpj_cliente').attr('disabled', 'true').val('');
	$('#nro_nota').attr('disabled', 'true').val('');
	$('#valor').attr('disabled', 'true').val('');
	$('#data_postagem').attr('disabled', 'true').val('');
});

$('#val').click(function() {
	$('#valor').removeAttr('disabled');
	$('#ordem_compra').attr('disabled', 'true').val('');
	$('#forma_pagto').attr('disabled', 'true').val('');
	$('#cnpj_emitente').attr('disabled', 'true').val('');
	$('#data_vencimento').attr('disabled', 'true').val('');
	$('.liqui').attr('disabled', 'true').removeAttr('checked');
	$('#cnpj_cliente').attr('disabled', 'true').val('');
	$('#nro_nota').attr('disabled', 'true').val('');
	$('#data_postagem').attr('disabled', 'true').val('');
});

$('#postagem').click(function() {
	$('#data_postagem').removeAttr('disabled');
	$('#valor').attr('disabled', 'true').val('');
	$('#ordem_compra').attr('disabled', 'true').val('');
	$('#forma_pagto').attr('disabled', 'true').val('');
	$('#cnpj_emitente').attr('disabled', 'true').val('');
	$('#data_vencimento').attr('disabled', 'true').val('');
	$('.liqui').attr('disabled', 'true').removeAttr('checked');
	$('#cnpj_cliente').attr('disabled', 'true').val('');
	$('#nro_nota').attr('disabled', 'true').val('');
});

$('#btn').click(function() {
	if (!$('input:checked').val()) {alert('Selecione uma opção de pesquisa.'); return false;}
	if ($('#cnpj_cliente').val() == "" 
		&& $('#nro_nota').val() == "" 
		&& $("input[name=liqui]:checked").length == 0 
		&& $('#data_vencimento').val() == ""
		&& $('#cnpj_emitente').val() == ""
		&& $('#forma_pagto').val() == ""
		&& $('#ordem_compra').val() == ""
		&& $('#valor').val() == ""
		&& $('#data_postagem').val() == "") {
			alert('Informe os dados para pesquisa.'); return false;
	}

	$('#form_consulta_nota').submit();
});
</script>
	
<?php 


if (isset($_POST['pesquisar'])) {
	
	include '../../../conexoes.inc.php';
	$db = Database::instance('controle');
	
	if (isset ($_POST['nro_nota'])) {
		$nro_nota = $_POST['nro_nota'];
		$where = "where n.nro_nota = :nro_nota";
		$prep = array(':nro_nota' => $nro_nota);
		$get = "nro_nota=".$nro_nota;
	}else if (isset ($_POST['cnpj_cliente'])) {
		$cnpj_cliente = $_POST['cnpj_cliente'];
		$where = "where cli.cnpj = :cnpj_cliente";
		$prep = array(':cnpj_cliente' => $cnpj_cliente);
		$get = "cnpj=".$cnpj_cliente;
	}else if (isset ($_POST['liqui'])) {
		$liquidacao = $_POST['liqui'];
		
		$sql = "select n.id, n.vencimento, cob.data_liquidacao 
			from cob_nota_fiscal as n
			left join cob_conta_cobranca as cob on cob.id_nota_fiscal = n.id";
		$query = $db->prepare($sql);
		$query->execute();
		$resultado = $query->fetchAll();

		foreach ($resultado as $res) {
			$id_nota = $res['id'];
			$vencimentos = $res['vencimento'];
	
			//Separa cada registro de vencimentos em um array com o id da nota como chave
			$vencimentos = explode('|', $vencimentos);
			foreach ($vencimentos as $vencimento) {
				$alpha[$id_nota][] = $vencimento;
			}
	
			if ($res['data_liquidacao'] != null) {
				$pagamentos = $res['data_liquidacao'];
				
				//Separa cada registro de pagamentos em um array com o id da nota como chave
				$pagamentos = explode('|', $pagamentos);
				foreach ($pagamentos as $pagamento) {
					$gama[$id_nota][] = $pagamento;
				}
			}else {
				$gama[$id_nota][] = null;
			}

		}

		//Conta as parcelas de vencimento de cada nota
		$countvenc = array();
		foreach ($alpha as $id_nota => $smth) {
			$countvenc[$id_nota] = 0;
			foreach ($smth as $date) {
				$countvenc[$id_nota]++;
			}	
		}
	
		//Conta as parcelas pagas de cada nota
		$beta = array();
		$countpagto = array();
		foreach ($gama as $id_nota => $smth) {
			if ($smth[0] != null) {
				$countpagto[$id_nota] = 0;
				foreach ($smth as $date) {
					$countpagto[$id_nota]++;
				}
				//Conta quantas parcelas de cada nota não foram pagas
				$pendentes = $countvenc[$id_nota] - $countpagto[$id_nota];
				
				if ($pendentes == 0) {
					//todas pagas
					$pagas[] = $id_nota;
				}else {
					//Se a data da parcela com vencimento pendente já passou 
					if (strtotime($alpha[$id_nota][$countpagto[$id_nota]]) < strtotime(date('d-m-Y'))) {
						//Coloca no array beta o id da nota pendentes
						$beta[] = $id_nota;
					}else {
						//nenhuma pendente
						$pagas[] = $id_nota;
					}
				}
			}else {
				//A data pendente é a primeira do vencimento
				$beta[] = $id_nota;	
			}
		}
		
		//Confere qual foi a pesquisa
		if ($liquidacao == 'todas') {
			$where = "";
			$prep = array();
			$get = "liquidacao=todas";
		}else if ($liquidacao == 'liquidadas') {
			$where = "where ";
			$i = 0;
			foreach ($pagas as $id_nota) { 
				$where .= "n.id = :id_nota$i or ";
				$prep[':id_nota'.$i] = $id_nota;
				$i++;
			}
			$where = trim($where, 'or ');
			$get = "liquidacao=liquidadas";
		}else if ($liquidacao == 'nao_liquidadas') {
			$where = "where ";
			$i = 0;
			foreach ($beta as $id_nota) { 
				$where .= "n.id = :id_nota$i or ";
				$prep[':id_nota'.$i] = $id_nota;
				$i++;
			}
			$where = trim($where, 'or ');
			$get = "liquidacao=nao_liquidadas";
		}
	}else if (isset ($_POST['data_vencimento'])) {
		$data_vencimento = $_POST['data_vencimento'];
		
		$sql = "select n.id, n.vencimento, n.nro_nota, n.emitente, n.cnpj_emitente, n.produto, n.valor,
				n.forma_pagto, n.ordem_compra, date_format(cobr.data_postagem, '%d/%m/%Y') as data_postagem, cobr.localizador_postagem,
				cli.razao_social, cli.responsavel, cli.setor, cli.email
				
				from cob_nota_fiscal as n
				left join cob_clientes as cli on cli.id = n.id_cliente 
				left join cob_conta_cobranca as cobr on cobr.id_nota_fiscal = n.id";
		$query = $db->prepare($sql);
		$query->execute();
		$resultado = $query->fetchAll();

		foreach ($resultado as $res) {
			$id_nota = $res['id'];
			$vencimentos = $res['vencimento'];
			
			//Separa cada registro de vencimentos em um array com o id da nota como chave
			$vencimentos = explode('|', $vencimentos);
			foreach ($vencimentos as $vencimento) {
				$alpha[$id_nota][] = $vencimento;
			}
		
		}
		
		//Verifica se há algum vencimento na data pesquisada
		$data_vencimento = str_ireplace('/', '-', $data_vencimento);
		$beta = array();
		foreach ($alpha as $id_nota => $smth) {
			foreach ($smth as $date) {
				if (strtotime($date) == strtotime($data_vencimento)) {
					//Se há vencimento nessa datas
					$beta[] = $id_nota;
				}
					
			}
		}
		
		//Dados para consulta
		if (!$beta) {
			echo 'Nenhum resultado encontrado.';
			exit;
		}else {
			$where = "where ";
			$i = 0;
			foreach ($beta as $id_nota) {
				$where .= "n.id = :id_nota$i or ";
				$prep[':id_nota'.$i] = $id_nota;
				$i++;
			}
			$where = trim($where, 'or ');
			$get = "data_vencimento=".$data_vencimento;
		}

	}else if (isset ($_POST['cnpj_emitente'])) {
		$cnpj_emitente = $_POST['cnpj_emitente'];
		$where = "where n.cnpj_emitente = :cnpj_emitente";
		$prep = array(':cnpj_emitente' => $cnpj_emitente);
		$get = "cnpj_emitente=".$cnpj_emitente;
	}else if (isset ($_POST['forma_pagto'])) {
		$forma_pagto = $_POST['forma_pagto'];
		$where = "where n.forma_pagto = :forma_pagto";
		$prep = array(':forma_pagto' => $forma_pagto);
		$get = "forma_pagto=".$forma_pagto;
	}else if (isset ($_POST['ordem_compra'])) {
		$ordem_compra = $_POST['ordem_compra'];
		$where = "where n.ordem_compra = :ordem_compra";
		$prep = array(':ordem_compra' => $ordem_compra);
		$get = "ordem_compra=".$ordem_compra;
	}else if (isset ($_POST['valor'])) {
		$valor = $_POST['valor'];
		$where = "where n.valor = :valor";
		$prep = array(':valor' => $valor);
		$get = "valor=".$valor;
	}else if (isset ($_POST['data_postagem'])) {
		$data_postagem = $_POST['data_postagem'];
		$where = "where date_format(cob.data_postagem, '%d/%m/%Y') = :data_postagem";
		$prep = array(':data_postagem' => $data_postagem);
		$get = "data_postagem=".$data_postagem;
	}	
	
	//Faz pesquisa de resultados
	$sql = "select n.nro_nota, n.emitente, n.cnpj_emitente, n.valor, n.vencimento, 
		n.produto, n.forma_pagto, n.ordem_compra, cli.cnpj, cli.razao_social, cli.responsavel,
		cli.setor, cli.email, cli.telefone, date_format(cob.data_postagem, '%d/%m/%Y') as data_postagem, 
		cob.localizador_postagem, cob.data_liquidacao
		from cob_nota_fiscal as n
		left join cob_clientes as cli on cli.id = n.id_cliente
		left join cob_conta_cobranca as cob on cob.id_nota_fiscal = n.id ";
	$sql .= $where." order by n.id";
	$query = $db->prepare($sql);
	$query->execute($prep);
	
	if ($query->rowCount() > 0) {
		
		$resultado = $query->fetchAll();
		foreach ($resultado as $res) {
			
			if ($res['data_postagem'] == null) {
				$data_postagem = "Não postado";
			}else {
				$data_postagem = $res['data_postagem'];
			}
			
			if ($res['data_liquidacao'] == null) {
				$data_liquidacao = "Não liquidado";
			}else {
				$data_liquidacao = str_replace('-', '/', $res['data_liquidacao']);
			}
			
			$vencimentos = str_replace('-', '/', $res['vencimento']);
			
			echo '
			<table>
				<tr class="firstline">
					<td>Número da Nota Fiscal</td>
					<td>'.$res["nro_nota"].'</td>
				</tr>
				<tr class="secondline">
					<td>Emitente</td>
					<td>'.$res["emitente"].'</td>
				</tr>
				<tr class="firstline">
					<td>CNPJ do Emitente</td>
					<td>'.$res["cnpj_emitente"].'</td>
				</tr>
				<tr class="secondline">
					<td>Valor</td>
					<td>R$ '.$res["valor"].'</td>
				</tr>
				<tr class="firstline">
					<td>Vencimentos</td>
					<td class="wrap"><div class="div_wrap">'.$vencimentos.'</div></td>
				</tr>
				<tr class="secondline">
					<td>Produto / Serviço</td>
					<td>'.$res["produto"].'</td>
				</tr>
				<tr class="firstline">
					<td>Forma de Pagamento</td>
					<td>'.$res["forma_pagto"].'</td>
				</tr>
				<tr class="secondline">
					<td>Ordem de Compra</td>
					<td>'.$res["ordem_compra"].'</td>
				</tr>
				<tr class="firstline">
					<td>CNPJ do Cliente</td>
					<td>'.$res["cnpj"].'</td>
				</tr>
				<tr class="secondline">
					<td>Razão Social</td>
					<td>'.$res["razao_social"].'</td>
				</tr>
				<tr class="firstline">
					<td>Responsável</td>
					<td>'.$res["responsavel"].'</td>
				</tr>
				<tr class="secondline">
					<td>Setor</td>
					<td>'.$res["setor"].'</td>
				</tr>
				<tr class="firstline">
					<td>E-mail</td>
					<td>'.$res["email"].'</td>
				</tr>
				<tr class="secondline">
					<td>Telefone</td>
					<td>'.$res["telefone"].'</td>
				</tr>
				<tr class="firstline">
					<td>Data da Postagem</td>
					<td>'.$data_postagem.'</td>
				</tr>
				<tr class="secondline">
					<td>Localizador da Postagem</td>
					<td>'.$res["localizador_postagem"].'</td>
				</tr>
				<tr class="firstline" style="text-wrap: unrestricted;">
					<td>Data de Liquidação</td>
					<td class="wrap"><div class="div_wrap">'.$data_liquidacao.'</div></td>
				</tr>
			</table>
			';
		}
		echo '<br><a id="btn" href="pdf_nota.php?'.$get.'" target="_blank">Gerar PDF</a><br>';
	}else {
		echo 'Nenhum resultado encontrado.';
	}
}	
?>

</div>
</body>
</html>
