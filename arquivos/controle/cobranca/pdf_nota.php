<?php
require '../fpdf/fpdf_plus.php';

if (isset ($_GET['cnpj'])) {
	$cnpj_cliente = $_GET['cnpj'];
	$where = "where cli.cnpj = :cnpj_cliente";
	$prep = array(':cnpj_cliente' => $cnpj_cliente);
} else if (isset ($_GET['nro_nota'])) {
	$nro_nota = $_GET['nro_nota'];
	$where = "where n.nro_nota = :nro_nota";
	$prep = array(':nro_nota' => $nro_nota);
}else if (isset ($_GET['liquidacao'])) {
	$liquidacao = $_GET['liquidacao'];
		
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
	}else if ($liquidacao == 'liquidadas') {
		$where = "where ";
		$i = 0;
		foreach ($pagas as $id_nota) { 
			$where .= "n.id = :id_nota$i or ";
			$prep[':id_nota'.$i] = $id_nota;
			$i++;
		}
		$where = trim($where, 'or ');
	}else if ($liquidacao == 'nao_liquidadas') {
		$where = "where ";
		$i = 0;
		foreach ($beta as $id_nota) { 
			$where .= "n.id = :id_nota$i or ";
			$prep[':id_nota'.$i] = $id_nota;
			$i++;
		}
		$where = trim($where, 'or ');
	}
}else if (isset ($_GET['data_vencimento'])) {
	$data_vencimento = $_GET['data_vencimento'];
		
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
	}

}else if (isset ($_GET['cnpj_emitente'])) {
	$cnpj_emitente = $_GET['cnpj_emitente'];
	$where = "where n.cnpj_emitente = :cnpj_emitente";
	$prep = array(':cnpj_emitente' => $cnpj_emitente);

}else if (isset ($_GET['forma_pagto'])) {
	$forma_pagto = $_GET['forma_pagto'];
	$where = "where n.forma_pagto = :forma_pagto";
	$prep = array(':forma_pagto' => $forma_pagto);
	
}else if (isset ($_GET['ordem_compra'])) {
	$ordem_compra = $_GET['ordem_compra'];
	$where = "where n.ordem_compra = :ordem_compra";
	$prep = array(':ordem_compra' => $ordem_compra);
	
}else if (isset ($_GET['valor'])) {
	$valor = $_GET['valor'];
	$where = "where n.valor = :valor";
	$prep = array(':valor' => $valor);
	
}else if (isset ($_GET['data_postagem'])) {
	$data_postagem = $_GET['data_postagem'];
	$where = "where date_format(cob.data_postagem, '%d/%m/%Y') = :data_postagem";
	$prep = array(':data_postagem' => $data_postagem);
	
}

header('Content-Type: text/html; charset=utf-8');

//Banco de dados
include '../../../conexoes.inc.php';
$pdo_controle = Database::instance('controle');

//Abre o PDF
$pdf = new PDF('P', 'mm', 'A4'); //formato retrato, medida mm, tamanho A4
$pdf->Open();
$pdf->AddPage();
$pdf->SetTitle('Relatorio', 'true'); //título do documento, is_utf-8

//Título da página
$pdf->SetY('15');
$pdf->SetFont('Arial','B',22);
$pdf->Cell(0, 0, utf8_decode('Demonstrativo de Nota Fiscal'), 0, 0, 'C');

//Tabela
$pdf->SetFont('Arial','B',12);
$pdf->SetY('30'); //localização no eixo Y
$y = '30';
$pdf->SetWidths(array(95,95)); //Largura de cada coluna
$pdf->SetFillColor('250', '235', '215');

$sql = "select n.nro_nota, n.emitente, n.cnpj_emitente, n.valor, n.vencimento, 
	n.produto, n.forma_pagto, n.ordem_compra, cli.cnpj as cnpj_cliente, cli.razao_social, cli.responsavel,
	cli.setor, cli.email, cli.telefone, date_format(cob.data_postagem, '%d/%m/%Y') as data_postagem, 
	cob.localizador_postagem, date_format(cob.data_liquidacao, '%d/%m/%Y') as data_liquidacao
	from cob_nota_fiscal as n
	left join cob_clientes as cli on cli.id = n.id_cliente
	left join cob_conta_cobranca as cob on cob.id_nota_fiscal = n.id ";
$sql .= $where." order by n.id";
$query = $pdo_controle->prepare($sql);
$query->execute($prep);

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
		$data_liquidacao = $res['data_liquidacao'];
	}
			
	$vencimentos = str_replace('-', '/', $res['vencimento']);
	
	$pdf->Row(array(utf8_decode("Número da Nota Fiscal"), $res["nro_nota"]));
	$pdf->Row(array(utf8_decode("Emitente"), utf8_decode($res["emitente"])));
	$pdf->Row(array("CNPJ do Emitente", $res["cnpj_emitente"]));
	$pdf->Row(array("Valor", $res["valor"]));
	$pdf->Row(array("Vencimentos", $vencimentos));
	$pdf->Row(array(utf8_decode("Produto / Serviço"), utf8_decode($res["produto"])));
	$pdf->Row(array("Forma de Pagamento", utf8_decode($res["forma_pagto"])));
	$pdf->Row(array("Ordem de Compra", utf8_decode($res["ordem_compra"])));
	$pdf->Row(array("CNPJ do Cliente", $res["cnpj_cliente"]));
	$pdf->Row(array(utf8_decode("Razão Social"), utf8_decode($res["razao_social"])));
	$pdf->Row(array(utf8_decode("Responsável"), utf8_decode($res["responsavel"])));
	$pdf->Row(array("Setor", utf8_decode($res["setor"])));
	$pdf->Row(array("E-mail", $res["email"]));
	$pdf->Row(array("Telefone", $res["telefone"]));
	$pdf->Row(array("Data da Postagem", utf8_decode($data_postagem)));
	$pdf->Row(array("Localizador da Postagem", utf8_decode($res["localizador_postagem"])));
	$pdf->Row(array(utf8_decode("Data da Liquidação"), utf8_decode($data_liquidacao)));
	
	$y += 100;
	$pdf->SetY($y); //localização no eixo Y
	
}

$pdf->Output(); //sugerido nome do arquivo, envia para o browser e dá opção de salvar
?>
