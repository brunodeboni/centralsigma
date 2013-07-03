<?php
//Conexão banco de dados
$db = new PDO(
         'mysql:host=mysql.centralsigma.com.br;dbname=controle', 
         'webadmin', 'webADMIN', 
         array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
);

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

//Calcula data + 5 dias
$hoje = date('d-m-Y');
$cinco_dias = date('d-m-Y', strtotime("+5 days",strtotime($hoje)));
	
//Verifica se há algum vencimento em 5 dias
$beta = array();
foreach ($alpha as $id_nota => $smth) {
	foreach ($smth as $date) {
		if (strtotime($date) <= strtotime($cinco_dias) && strtotime($date) >= strtotime($hoje)) {
			//Se há vencimento nessa datas
			$beta[$id_nota] = $date;
		}
			
	}
}

$resultado = array();
foreach ($beta as $id_nota_fiscal => $vencimento) {
	$v_vencimento[$id_nota_fiscal] = str_ireplace('-', '/', $vencimento);

	//Busca os dados da cobrança
	$sql = "select n.id as idnota, n.nro_nota, n.emitente, n.cnpj_emitente, n.valor,
			cli.razao_social, cli.cnpj as cnpj_cliente
				
			from cob_nota_fiscal as n
			left join cob_clientes as cli on cli.id = n.id_cliente
			where n.id = :id_nota_fiscal";
	$query = $db->prepare($sql);
	$query->execute(array(':id_nota_fiscal' => $id_nota_fiscal));
	$resultado[] = $query->fetchAll();
}	

$headers = 'MIME-Version: 1.0'."\r\n";
$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
$headers .= 'From: Rede Industrial <administrativo2@redeindustrial.com.br>'."\r\n";
$headers .= 'CC: <carolina.lima@redeindustrial.com.br>'."\r\n";

$destinatario = 'administrativo2@redeindustrial.com.br';
$assunto = 'Relação de NFs a vencer nos próximos 5 dias';
			
$msg = 'Marisabel,

Esta é uma notificação automática do relatório das Notas Fiscais com vencimento próximo:';

foreach ($resultado as $nota) {
	foreach ($nota as $res) {	
		$idnota = $res['idnota'];			
		$nro_nota = $res['nro_nota'];
		$emitente = $res['emitente'];
		$cnpj_emitente = $res['cnpj_emitente'];
		$valor = $res['valor'];
		$razao_social = $res['razao_social'];
		$cnpj_cliente = $res['cnpj_cliente'];
		
$msg .= '

<b>NF nº '.$nro_nota.'</b>
Emitente: '.$emitente.' - '.$cnpj_emitente.'
Valor: R$ '.$valor.'
Vencimento: '.$v_vencimento[$idnota].'
Empresa: '.$razao_social.' - '.$cnpj_cliente.'	
';
		
	}
}


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
echo $mensagem;
/*
mail($destinatario, $assunto, $mensagem, $headers);
*/
