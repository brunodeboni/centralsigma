<?php
$conn = mysql_connect("mysql.centralsigma.com.br","centralsigma02","S4k813042012") or die("Sem conexao com o banco de dados");
mysql_select_db("centralsigma02",$conn);
mysql_set_charset("utf8",$conn);
