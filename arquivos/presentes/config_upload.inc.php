<?php
	//Limitar as extensões? 
	$limitar_ext = "sim";
	
	//extensoes autorizadas
	$extensoes_validas = array(".gif",".jpg",".jpeg",".bmp",".png",".GIF",".JPG",".JPEG",".BMP",".PNG");
	
	//caminho onde serão armazenadas
	$caminho = "/arquivos/contatonatal/imagens";
	$caminho_absoluto = "/home/centralsigma/www/arquivos/contatonatal/imagens";
	$caminho_site = "http://www.centralsigma.com.br".$caminho;
	
	//limitar tamanho do arquivo?
	$limitar_tamanho = "nao";
	
	//tamanho limite do arquivo em bytes
	$tamanho_bytes = "8000000";
	
	//se ja existir o arquivo, sobrescrever?
	$sobrescrever = "sim";
	
	//dados de acesso ao bd mysql centralsigma02
	$host = "mysql.centralsigma.com.br";
	$user = "centralsigma02";
	$pass = "S4k813042012";
	$banco = "centralsigma02";
	
	//dados de email
	$emaildestino = "comercial@redeindustrial.com.br";
	
	
	/*
	// Giovanne
	$caminho = "/repositorio/presentes/trunk/uploads";
	$caminho_absoluto = "C:/wamp/www".$caminho;
	$caminho_site = "http://localhost".$caminho;
	*/
?>