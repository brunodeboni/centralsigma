<?php
error_reporting(E_ALL);
set_time_limit(0);
ob_implicit_flush();

// Inicialização
$service_port = 1239;
$address = "127.0.0.1";
$mensagem = $_REQUEST["msg"];
$aguardar = $_REQUEST["agd"]==1?true:false;


// Conexão
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if($socket === false) die("socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n");
$result = socket_connect($socket, $address, $service_port);
if($result === false) die("socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n");

// Ativar ou desativar debug com a função sdeb
$sdebativar = false;
function sdeb($msg){global $sdebativar; if($sdebativar) echo "debug> ".$msg." \r\n";}


// Tratar mensagem
function sendAndGetMessage($mensagem,$aguardar=false){
	global $socket;
	$bufsize = 2048;
	$mensagem = $mensagem."\n";
	
	sdeb(socket_read($socket,$bufsize));					// Mensagem de boas vindas
	//$in = "AssinarModem:355096030167315\n";
	socket_write($socket, $mensagem, strlen($mensagem));	// Escrever mensagem que queremos enviar
	if($aguardar){
		sdeb(@socket_read($socket,$bufsize));				// Mensagem em resposta à nossa
		echo @socket_read($socket,$bufsize);				// Aguardar próxima mensagem a receber
	}else{
		echo @socket_read($socket,$bufsize);				// Mensagem em resposta à nossa
	}
	@socket_close($socket);
	die();
}

sendAndGetMessage($mensagem,$aguardar);
