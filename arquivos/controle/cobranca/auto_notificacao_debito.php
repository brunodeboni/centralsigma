<?php
//Conexão banco de dados
$db = new PDO(
         'mysql:host=mysql.centralsigma.com.br;dbname=controle', 
         'webadmin', 'webADMIN', 
         array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
);

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
			continue;
		}else {
			//Se a data da parcela com vencimento pendente já passou de 3 dias 
			$hoje = date('d-m-Y');
			$tres_dias = date('d-m-Y', strtotime("-3 days",strtotime($hoje)));
			if (strtotime($alpha[$id_nota][$countpagto[$id_nota]]) <= strtotime($tres_dias)) {
				//Coloca no array beta a data que está pendente
				$beta[$id_nota] = $alpha[$id_nota][$countpagto[$id_nota]];
			}else {
				//nenhuma pendente
				continue;
			}
		}
	}else {
		//A data pendente é a primeira do vencimento
		//Se a data da parcela com vencimento pendente (primeira) já passou de 3 dias
		$hoje = date('d-m-Y');
		$tres_dias = date('d-m-Y', strtotime("-3 days",strtotime($hoje)));
		if (strtotime($alpha[$id_nota][0]) <= strtotime($tres_dias)) {
			//Coloca no array beta a data que está pendente
			$beta[$id_nota] = $alpha[$id_nota][0];
		}else {
			//nenhuma pendente
			continue;
		}	
	}
}

$resultado = array();
foreach ($beta as $id_nota_fiscal => $vencimento) { 
	//Busca os dados da cobrança
	$sql = "select n.id as idnota, n.nro_nota, n.emitente, n.cnpj_emitente, n.produto, 
	n.valor, n.forma_pagto, n.ordem_compra, cli.razao_social, cli.cnpj as cnpj_cliente, 
	cli.responsavel, cli.setor, cli.email 
				
	from cob_nota_fiscal as n
	left join cob_clientes as cli on cli.id = n.id_cliente
	where n.id = :id_nota_fiscal";
	$query = $db->prepare($sql);
	$query->execute(array(':id_nota_fiscal' => $id_nota_fiscal));
	$resultado = $query->fetchAll();
	
	foreach ($resultado as $res) {
		$destinatario = $res['email'];
		$vencimento = str_ireplace('-', '/', $beta[$res['idnota']]);
		$nro_nota = $res['nro_nota'];
		$emitente = $res['emitente'];
		$cnpj_emitente = $res['cnpj_emitente'];
		$valor = $res['valor'];
		$forma_pagto = $res['forma_pagto'];
		$ordem_compra = $res['ordem_compra'];
		$razao_social = $res['razao_social'];
		$cnpj_cliente = $res['cnpj_cliente'];
		$responsavel = $res['responsavel'];
		$setor = $res['setor'];
		$produto = $res['produto'];
	}
	
	$headers = 'MIME-Version: 1.0'."\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
	$headers .= 'From: Rede Industrial <administrativo2@redeindustrial.com.br>'."\r\n";
	$headers .= 'CC: <carolina.lima@redeindustrial.com.br>,<administrativo2@redeindustrial.com.br>'."\r\n";
	$headers .= 'Disposition-Notification-To: administrativo2@redeindustrial.com.br'."\r\n";
	
	$assunto = 'Notificação de Débito - NF '.$nro_nota.' - '.$razao_social;
	
	$msg = 'À '.$razao_social.'
A/C Sr(a). '.$responsavel.'  - '.$setor.'

Consta em nossos registros o débito originado pelo(a) '.$produto.', conforme segue:

NF nº '.$nro_nota.'
Emitente: '.$emitente.' - '.$cnpj_emitente.'
Valor: '.$valor.'
Vencimento: '.$vencimento.'
Forma de pagamento: '.$forma_pagto.'
Ordem de compra nº: '.$ordem_compra.'
 
Dessa forma, colocamo-nos à disposição para negociar a melhor forma de regularizarmos a pendência supra, tendo em vista a primazia pelo bom relacionamento comercial entre a REDE INDUSTRIAL e seus clientes. 

Em caso de dúvidas, entre em contato conosco pelos contatos abaixo:
 
Callcenter: (11) 4062-0139
Telefone: (54) 3281-1724
E-mail: administrativo2@redeindustrial.com.br
 
Atenciosamente,
 
Marisabel Cavallin
Contas a Receber
Rede Industrial';
	$mensagem = '
	<!doctype html>
	<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body style="width: 550px;">
		<p><pre style="font-family:Arial, Tahoma, sans-serif; font-size:14px;">'.$msg.'</pre></p>
	</body>
	</html>';
	
	
	mail($destinatario, $assunto, $mensagem, $headers);
	
}	

