<?php
if(!isset($_POST["conteudo"],$_POST["autor"])) exit;
require("./conexao.php");

$autor    = mysql_real_escape_string($_POST["autor"]);
$conteudo = mysql_real_escape_string($_POST["conteudo"]);

$sql1 = "insert into noticias (autor, noticia) values ('$autor','$conteudo');";
mysql_query($sql1,$conn) or die("Erro ao tentar gravar Query");
die("Noticia adicionada com sucesso!");
?>