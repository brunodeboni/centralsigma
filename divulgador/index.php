<?php 
session_start();
$_SESSION = array(); // Clears the $_SESSION variable
?>
<!doctype html>
<html>
<head>
	<title>Painel de Controle Divulgadores SIGMA</title>
	<style>
	*{      
		font-family:Tahoma, Geneva, sans-serif;
		padding:0;
		margin:0;
		font-size:12px;
	}
	#container {
		position: relative;
		width: 700px;
		margin: auto;
	}
	#fundo {
		width: 700px;
		position: absolute;
		top: 0;
	}
	#termo {
		position: absolute;
		top: 530px;
		left: 250px;
		width: 100px;
		height: 15px;
	}
	#form {
		position: absolute;
		top: 330px;
		left: 230px;
		width:250px;
		font-weight:bold;
		font-size:12px;
	}
	.block {
		width:100%;
		margin:auto;
		display:block;
	}
	button {
		padding:10px 70px;
		background:#DDF;
	}
	.clear {
		clear:both;
	}
	#erro {
		position: absolute;
		top: 500px;
		left: 230px;
		font-weight: bold;
		color: red;
	}
	
	</style>
</head>
<body>
<div id="container">
	<img src="img/fundo_login.png" id="fundo">
	<a href="Termo_de_Adesao-Divulgador_SIGMA.pdf" target="_blank" id="termo"></a>
	
	<div id="form">
		<br class="clear">
		<form action="" method="post" id="form_login" enctype="multipart/form-data" >

		<span class="login">Login</span>:<br>
		<input type="text" name="login" id="login" maxlength="50" class="block"><br>

		<span class="senha">Senha</span>:<br/>
		<input type="password" name="senha" id="senha" maxlength="50" class="block">

		<!-- [Display:Block] -->
		<br class="clear">
		<button type="submit">Entrar</button>
		
		</form>
		<a href="recuperar.php">Esqueceu sua senha?</a>
	</div>

<?php


// Verifica se um formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Salva duas variáveis com o que foi digitado no formulário
	// Detalhe: faz uma verificação com isset() pra saber se o campo foi preenchido
	$user = (isset($_POST['login'])) ? $_POST['login'] : '';
	$password = (isset($_POST['senha'])) ? $_POST['senha'] : '';
	
	//Conexão com banco de dados
	require '../conexoes.inc.php';
	$db = Database::instance('centralsigma02');
    
	$sql = "select codigo, senha from dv_divulgadores_sigma where codigo = :user";
	$query = $db->prepare($sql);
	$query->execute(array(':user' => $user));
	$resultado = $query->fetchAll();
	
	if ($query->rowCount() > 0) {
		foreach ($resultado as $res) {
			
			$codigo = $res['codigo'];
			$senha = $res['senha'];

			if ($user == $codigo && md5($password) == $senha) {
				session_start();
				$_SESSION['usuario'] = true;
				$_SESSION['codigo'] = $codigo;
				// O usuário e a senha digitados foram validados, manda pra página interna
				header("Location: painel.php");
			} else {
				// O usuário e/ou a senha são inválidos, manda de volta pro form de login
				echo '<div id="erro">
						Usu&aacute;rio ou senha inv&aacute;lidos.
					</div>';
			}
		}
	}else {
		// O usuário e/ou a senha são inválidos, manda de volta pro form de login
		echo '<div id="erro">
				Usu&aacute;rio ou senha inv&aacute;lidos.
			</div>';
	}
}
?>

</div>
</body>
</html>
