<?php 
session_start();
$_SESSION = array(); // Clears the $_SESSION variable
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<style>
	*{     
	font-family:Tahoma, Geneva, sans-serif;
	padding:0;
	margin:0;
	font-size:12px;
	}

	#form {
    margin: auto;
	width:250px;
	font-weight:bold;
	font-size:12px;
	}
	#erro {
		margin: 10px auto;
		font-weight: bold;
		color: red;
	}

	.block{width:100%;margin:auto;display:block;}
	button{padding:10px 70px;background:#DDF;}

	.clear{clear:both;}
	</style>
</head>
<body>
	<div id="form">
		<br class="clear">
		<form action="" method="post" id="form_login">

		<span class="login">Login</span>:<br>
		<input type="text" name="login" id="login" maxlength="50" class="block"><br>

		<span class="senha">Senha</span>:<br/>
		<input type="password" name="senha" id="senha" maxlength="50" class="block"><br>


		<!-- [Display:Block] -->
		<br class="clear">
		<button type="submit">Entrar</button>
		</form>
	
<?php

// Verifica se um formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Salva duas variáveis com o que foi digitado no formulário
	// Detalhe: faz uma verificação com isset() pra saber se o campo foi preenchido
	$usuario = (isset($_POST['login'])) ? $_POST['login'] : '';
	$senha = (isset($_POST['senha'])) ? $_POST['senha'] : '';
	
	//Pesquisa usuário e senha no banco
	// Conexão com mysql
	include '../../conexoes.inc.php';
	$db_co = Database::instance('controle');
	
	$sql = "select usuario, senha, role from usuarios where usuario = :usuario and senha = :enc_senha";
	$query = $db_co->prepare($sql);
	$query->execute(array(':usuario' => $usuario, ':enc_senha' => md5($senha)));
	
	if ($query->rowCount() > 0) {
		$resultado = $query->fetchAll();
		foreach ($resultado as $res) {
			session_start();
			$_SESSION['5468usuario'] = true;
			$_SESSION['6542id'] = $res['usuario'];
			$_SESSION['6542role'] = $res['role'];
		}
		// O usuário e a senha digitados foram validados, manda pra página interna
		header("Location: controle.php");
	}else {
		// O usuário e/ou a senha são inválidos, manda de volta pro form de login
		echo '<div id="erro">
				Usuário ou senha inválidos.
			</div>';
	}
}
?>
	</div>
</body>
</html>
