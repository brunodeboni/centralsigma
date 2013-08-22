<?php
session_start();
if(!isset($_SESSION['5468usuario'])) die("<strong>Acesso Negado!</strong>");
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Páginas de Controle</title>
	<style>
	*{      
	font-family:Tahoma, Geneva, sans-serif;
	padding:0;
	margin:0;
	font-size:12px;
	}
	div {
	margin:10px auto;
	padding:5px;
	width:350px;
	background:#F7F7FF;
	}
	h1{
	margin-bottom:5px;
	text-align:center;
	padding:5px;
	font-size:18px;
	background:#B03060;
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
			padding:10px;
			text-align: center;
			font-weight: bold;
	}
	.firstline {background-color: #FAF0E6; width: 250px;}
	.secondline {background-color: #FAEBD7; width: 250px;}
	a, a:link, a:visited {text-decoration: none;}
	a:hover, a.over {text-decoration: none; background-color: #F7F7FF;}
	#logout {
		padding: 5px 30px;
		font-weight: bold;
		color: #FFF;
		background-color: #6969AF;
	}
	</style>
</head>
<body>
	<div>
		<h1>Controle de estat&iacute;sticas</h1>
		<table>
				<tr class="firstline"><td><a href="downloads/index.php">Estatísticas do SIGMA</a></td></tr>
				<tr class="secondline"><td><a href="cursos/controle_turmas.php">Controle do Curos Web</a></td></tr>
				<tr class="firstline"><td><a href="cursos/controle_turmas_aulasweb.php">Controle do Aulasweb</a></td></tr>
				<tr class="secondline"><td><a href="sms/sms.php">SMS's enviados</a></td></tr>
				<tr class="firstline"><td><a href="divulgadores/divulgadores.php">Divulgadores SIGMA</a></td></tr>
				<tr class="secondline"><td><a href="empresas/cadastrar.php">Empresas por Segmento</a></td></tr>
				<tr class="firstline"><td><a href="perfil/index.php">Perfil CPCM/Planejadores de Manutenção SIGMA</a></td></tr>
				<tr class="secondline"><td><a href="news/index.php">Controle de Notícias</a></td></tr>
				<tr class="firstline"><td><a href="sites-fora-do-ar/index.php">Verifica sites no ar</a></td></tr>
				<tr class="secondline"><td><a href="sigmaandroid/mapa.php">Mapa de usuários SIGMA ANDROID</a></td></tr>
		</table>
		<br>
		<?php if ($_SESSION['6542role'] == '2') {?>
			<h1>Controle de cobranças</h1>
			<table>
				<tr class="firstline"><td><a href="cobranca/cadastra.php">Cadastrar cobranças</a></td></tr>
				<tr class="secondline"><td><a href="cobranca/edita.php">Editar cobranças</a></td></tr>
				<tr class="firstline"><td><a href="cobranca/consulta.php">Consultar cobranças</a></td></tr>			
			</table>
		<?php } ?>
		<div><a id="logout" href="index.php">Sair</a></div>
	</div>
</body>
</html>