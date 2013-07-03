<?php
require("./conexao.php");

if($_POST["action"]=="salvar")
{
	if(!isset($_POST["conteudo"],$_POST["autor"])) exit;
	
	$autor    = mysql_real_escape_string($_POST["autor"]);
	$conteudo = mysql_real_escape_string($_POST["conteudo"]);
	
	$sql1 = "insert into noticias (autor, noticia) values ('$autor','$conteudo');";
	mysql_query($sql1,$conn) or die("Erro ao tentar executar Query!");
	die("Noticia adicionada com sucesso!");
}
else if($_POST["action"]=="remover"){
	if(!isset($_POST["cod"])) exit;
	
	$cod = mysql_real_escape_string($_POST["cod"]);
	
	$sql1 = "delete from noticias where cod=$cod";
	mysql_query($sql1,$conn) or die("Erro ao tentar executar Query!");
	die("Noticia removida com sucesso!");
}
?>