<?php

session_start();
if(!isset($_SESSION['5468usuario'])) die("<strong>Acesso Negado!</strong>");

require '../../../conexoes.inc.php';
$db = Database::instance('centralsigma02');

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Cadastrar Notícias no Slider</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<style>
	body {
		font-size:14px; 
		font-family: Arial, Helvetica, sans-serif;
	}
	#container {
		padding: 10px;
		width: 500px;
		margin: auto;
		background:#F7F7FF;
	}
	h1 {
		text-align: center;
		padding: 5px;
		background: #B03060;
		color:#FFF;
	}
	h2 {
		text-align: center;
		padding: 5px;
		background: #369;
		color:#FFF;
	}
	.block{
		width:100%;
		margin:auto;
		display:block;
	}
	
	#btn{
		background: #B03060; 
		padding: 10px 40px; 
		color: #FFF; 
		font-weight: bold;
		font-size: 14px;
		border: 0;
		text-decoration: none;
	}
	#div_erro {
		display: none;
		margin-bottom:10px;
		width:90%;
		padding:5px;
		background:#FEE;
		color:#900;
	}
	.div_erro2 {
		margin-top:10px;
		width:90%;
		padding:5px;
		background:#FEE;
		color:#900;
	}
	#div_sucesso {
		margin-top:10px;
		width:90%;
		padding:5px;
		background:#FAF0E6;
		color:#D2691E;
		font-weight: bold;
	}
	</style>
</head>
<body>
<div id="container">
	<h1>Cadastro de Notícias no Slider</h1>
	
	<form id="form_news_slider" action="" method="post" enctype="multipart/form-data">
		<span>Título</span>
		<input type="text" class="block" id="titulo" name="titulo">
		<span>Máximo de caracteres permitidos: 67</span><br>
		<div id="count_titulo"></div><br>
		<br>
		
		<span>Trecho da notícia</span>
		<textarea class="block" rows="7" id="noticia" name="noticia"></textarea>
		<span>Máximo de caracteres permitidos: 400</span><br>
		<div id="count_noticia"></div><br>
		<br>
		
		<span>Link para a notíca completa</span>
		<input type="text" class="block" id="link" name="link">
		<br>
		
		<span>Upload da Imagem (deve ter 580px largura por 200px altura)</span>
		<input type="file" class="block" id="imagem" name="imagem">
		<br>
		
		<div id="div_erro"></div><br>
		
		<button type="button" id="btn">Enviar</button>
	</form>

<script>
$('#btn').click(function() {
	if ($('#titulo').val() == "") {$('#div_erro').show(); $('#div_erro').html('Informe o título da notícia.'); return false;}
	if ($('#titulo').val().length > 67) {$('#div_erro').show(); $('#div_erro').html('Título muito longo.'); return false;}
	if ($('#noticia').val() == "") {$('#div_erro').show(); $('#div_erro').html('Informe um trecho da notícia.'); return false;}
	if ($('#noticia').val().length > 400) {$('#div_erro').show(); $('#div_erro').html('Trecho da notícia muito longo.'); return false;}
	if ($('#link').val() == "") {$('#div_erro').show(); $('#div_erro').html('Informe o link onde está a notícia completa.'); return false;}
	if ($('#imagem').val() == "") {$('#div_erro').show(); $('#div_erro').html('Selecione uma imagem para a notícia.'); return false;}

	$('#form_news_slider').submit();
});

$('#titulo').keyup(function() {
	$('#count_titulo').html('Caracteres digitados: ' + $(this).val().length );
});

$('#noticia').keyup(function() {
	$('#count_noticia').html('Caracteres digitados: ' + $(this).val().length );
});
</script>

<?php 
function tiracento($texto){
	$trocarIsso = array('à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ü','ú','ÿ','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','O','Ù','Ü','Ú','Ÿ', ' ',);
	$porIsso = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','0','U','U','U','Y', '-',);
	$titletext = str_replace($trocarIsso, $porIsso, $texto);
	return $titletext;
}

if (isset ($_POST['titulo'])) {
		
	if ($_FILES["imagem"]["error"] > 0) {
		echo "Erro: " . $_FILES["imagem"]["error"] . "<br>";
	}else {
		//upload do arquivo
		$unique = rand(00000, 99999); //adidiona números aleatórios para não substituir arquivos com mesmo nome
		$file_name = tiracento($_FILES["imagem"]["name"]); //retira caracteres especiais do nome do arquivo
		$file_path = "E:/Inetpub/vhosts/cpro12924.publiccloud.com.br/joomla31/arquivos/slider/img/".$unique.$file_name;
		if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $file_path)) {
			//checar a altura e largura, se não for a desejada, deleta a imagem
			list($w, $h) = getimagesize($file_path); 
		    if ($w != 580 || $h != 200) {
		        unlink($file_path);
		        echo '<div class="div_erro2">As dimensões da imagem não estão corretas.</div>';
		    }else {
				$file_insert = "http://joomla31.centralsigma.com.br/arquivos/slider/img/".$unique.$file_name;
				
				$sql = "insert into news_slider (titulo, noticia, img, link) 
					values (:titulo, :noticia, :img, :link)";
				$query = $db->prepare($sql);
				$success = $query->execute(array(
					':titulo' => $_POST['titulo'], 
					':noticia' => $_POST['noticia'], 
					':img' => $file_insert, 
					':link' => $_POST['link']
				));
				
				if ($success) echo '<div id="div_sucesso">Notícia cadastrada com sucesso.</div>';
				else echo '<div class="div_erro2">Erro ao cadastrar notícia. Por favor, tente novamente.</div>';
		    }
		}

	}
	
}

?>
</div>	
</body>
</html>