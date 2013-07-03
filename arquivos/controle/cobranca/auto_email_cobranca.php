<?php
//Conexão banco de dados
$db = new PDO(
         'mysql:host=mysql.centralsigma.com.br;dbname=controle', 
         'webadmin', 'webADMIN', 
         array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
);

//Busca a coluna de vencimentos em todos os registros das notas
$sql = "select id, vencimento from cob_nota_fiscal";
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

//Calcula data + 1, 5 e 15 dias
$hoje = date('d-m-Y');
$amanha = date('d-m-Y', strtotime("+1 days",strtotime($hoje)));
$cinco_dias = date('d-m-Y', strtotime("+5 days",strtotime($hoje)));
$quinze_dias = date('d-m-Y', strtotime("+15 days",strtotime($hoje)));

//Verifica se há algum vencimento em 1, 5 ou 15 dias depois
$beta = array();
foreach ($alpha as $id_nota => $smth) {
	foreach ($smth as $date) {
		if ($amanha == $date || $cinco_dias == $date || $quinze_dias == $date) {
			$beta[$id_nota] = $date;
		}
	}

}

//Com o id da nota fiscal, busca informações da cobrança e envia e-mail
foreach ($beta as $id_nota_fiscal => $vencimento) {
	$vencimento = str_ireplace('-', '/', $vencimento);

	//Busca os dados da cobrança
	$sql = "select n.nro_nota, n.emitente, n.cnpj_emitente, n.produto, n.valor,
	n.forma_pagto, n.ordem_compra, date_format(cobr.data_postagem, '%d/%m/%Y') as data_postagem, cobr.localizador_postagem,
	cli.razao_social, cli.responsavel, cli.setor, cli.email
	
	from cob_nota_fiscal as n
	left join cob_clientes as cli on cli.id = n.id_cliente 
	left join cob_conta_cobranca as cobr on cobr.id_nota_fiscal = n.id
	
	where n.id = :id_nota_fiscal";
	$query = $db->prepare($sql);
	$query->execute(array(':id_nota_fiscal' => $id_nota_fiscal));
	$resultado = $query->fetchAll();
	
	foreach ($resultado as $res) {
		
		$nro_nota = $res['nro_nota'];
		$emitente = $res['emitente'];
		$cnpj_emitente = $res['cnpj_emitente'];
		$produto = $res['produto'];
		$valor = $res['valor'];
		$forma_pagto = $res['forma_pagto'];
		$ordem_compra = $res['ordem_compra'];
		$data_postagem = $res['data_postagem'];
		$localizador_postagem = $res['localizador_postagem'];
		$razao_social = $res['razao_social'];
		$responsavel = $res['responsavel'];
		$setor = $res['setor'];
		$email = $res['email'];
	
		$headers = 'MIME-Version: 1.0'."\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
		$headers .= 'From: Rede Industrial <administrativo2@redeindustrial.com.br>'."\r\n";
		$headers .= 'CC: <carolina.lima@redeindustrial.com.br>,<administrativo2@redeindustrial.com.br>'."\r\n";
		$headers .= 'Disposition-Notification-To: administrativo2@redeindustrial.com.br'."\r\n";
		
		$destinatario = $email;
		$assunto = 'Faturamento Rede Industrial - NF nº '.$nro_nota;
		$mensagem = '
	<!doctype html>
	<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body style="width: 550px;">
		<p><pre style="font-family:Arial, Tahoma, sans-serif; font-size:14px;">
À '.$razao_social.'
A/C Sr(a). '.$responsavel.' - '.$setor.'
	
Prezado Cliente,
	
Para melhor comunicação da Rede Industrial com seus clientes, enviamos esta notificação como um lembrete do vencimento da Nota Fiscal emitida conforme dados abaixo:
	
NF nº '.$nro_nota.'
Emitente: '.$emitente.' - '.$cnpj_emitente.'
Referente a: '.$produto.'
Valor: R$ '.$valor.'
Vencimento: '.$vencimento.'
Forma de pagamento: '.$forma_pagto.'
Ordem de compra nº: '.$ordem_compra.'
	
A Nota Fiscal original foi enviada via Correios no dia '.$data_postagem.', aos seus cuidados. O rastreamento da entrega pode ser feito pelo localizador '.$localizador_postagem.' no site http://www.correios.com.br .
	
Em caso de dúvidas, entre em contato conosco pelos contatos abaixo:
	
Callcenter: (11) 4062-0139
Telefone: (54) 3281-1724
E-mail: administrativo2@redeindustrial.com.br
	
	
Atenciosamente,
	
Marisabel Cavallin
Contas a Receber
Rede Industrial
		</pre></p>
	</body>
	</html>';
	
		mail($destinatario, $assunto, $mensagem, $headers);
		
	} 
}
?>