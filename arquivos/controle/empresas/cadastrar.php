<?php 

session_start();
if(!isset($_SESSION['5468usuario'])) die("<strong>Acesso Negado!</strong>");


//Conexão banco de dados
include '../../../conexoes.inc.php';
$db = Database::instance('centralsigma02');

$sql = "select distinct(segmento) from empresas_segmento order by segmento";
$query = $db->prepare($sql);
$query->execute();
$resultado = $query->fetchAll();

$segmento = array();
foreach ($resultado as $res) {
	$segmento[] = $res['segmento'];
}

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Cadastro de Empresas por Segmento</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<style>
	body {
		margin: 0 auto;
		width: 600px;
		font-family:Arial, Tahoma, sans-serif;
		color: #090909;
		font-weight: bold;
		background-color: #F5F5F5;
	}
	h1 {
		font-size: 20px;
		color: #FFF; 
		background-color: #e8280a;
		text-align: center;
		height: 40px;
		padding-top: 15px;
	}
	select, option {
		color: #090909;
		font-weight: bold;
	}
	.block{
		width:100%;
		margin:auto;
		display:block;
	}
	#btn {
		background-color: #e8280a;
		padding: 10px 40px;
		color: #FFF;
		font-weight: bold;
		text-decoration: none;
	}
	</style>
</head>
<body>
	<h1>Cadastro de Empresas por Segmento</h1>
	<form action="" method="post" enctype="multipart/form-data" id="form_segmentos">
		<span>Empresa:</span><br>
		<input type="text" name="empresa" class="block" id="inp_empresa"><br>
		
		<span>Estado:</span><br>
		<select name="uf" class="block" id="inp_uf">
			<option value="">Selecione...</option>
			<option value="AC">Acre</option>
            <option value="AL">Alagoas</option>
            <option value="AP">Amapá</option>
            <option value="AM">Amazonas</option>
            <option value="BA">Bahia</option>
            <option value="CE">Ceará</option>
            <option value="DF">Distrito Federal</option>
            <option value="ES">Espírito Santo</option>
            <option value="GO">Goiás</option>
            <option value="MA">Maranhão</option>
            <option value="MT">Mato Grosso</option>
            <option value="MS">Mato Grosso do Sul</option>
        	<option value="MG">Minas Gerais</option>
            <option value="PA">Pará</option>
            <option value="PB">Paraíba</option>
            <option value="PR">Paraná</option>
            <option value="PE">Pernambuco</option>
            <option value="PI">Piauí</option>
            <option value="RJ">Rio de Janeiro</option>
            <option value="RN">Rio Grande do Norte</option>
            <option value="RS">Rio Grande do Sul</option>
            <option value="RO">Rondônia</option>
            <option value="RR">Roraima</option>
            <option value="SC">Santa Catarina</option>
            <option value="SP">São Paulo</option>
            <option value="SE">Sergipe</option>
            <option value="TO">Tocantins</option>
		</select>
		<br>
		
		<span>Segmento:</span><br>
		<select name="segmento1" class="block" id="inp_segmento">
			<option value="">Selecione...</option>
			<?php foreach ($segmento as $seg) {
				echo '<option value="'.$seg.'">'.$seg.'</option>';
			}?>
		</select>
		
		<span>Outro segmento (que não está na lista):</span><br>
		<input type="text" name="segmento2" class="block" id="sel_segmento"><br>
		
		<span>Link para Site:</span><br>
		<input type="text" name="site" class="block" id="inp_site" onClick="path(this)"><br>
		
		<span>Upload do Logotipo:</span><br>
		<input type="file" name="logo" id="inp_logo"><br>
		
		<br>
		<button id="btn" type="button" onClick="enviar()">Enviar</button>
	</form>
<script>
function path(obj) {
	obj.value = "http://" + obj.value;
}

function enviar() {
	if ($('#inp_empresa').val() == "") {alert('Preencha o campo Empresa'); return false;}
	if ($('#inp_uf').val() == "") {alert('Preencha o campo Estado'); return false;}
	if ($('#inp_segmento').val() == "" && $('#sel_segmento').val() == "") {alert('Preencha o campo Segmento'); return false;}
	if ($('#inp_segmento').val() != "" && $('#sel_segmento').val() != "") {alert('Escolha um segmento da lista ou informe um novo segmento no campo Outro. Não é possível preencher os dois.'); return false;}
	if ($('#inp_site').val() == "") {alert('Preencha o campo Link para Site'); return false;}
	if ($('#inp_logo').val() == "") {alert('Selecione o arquivo de imagem do logotipo da empresa para upload'); return false;}

	$('#form_segmentos').submit();
}
</script>
</body>
</html>
<?php 

function tiracento($texto){
$trocarIsso = array('à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ü','ú','ÿ','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','O','Ù','Ü','Ú','Ÿ', ' ',);
$porIsso = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','0','U','U','U','Y', '-',);
$titletext = str_replace($trocarIsso, $porIsso, $texto);
return $titletext;
}

if (isset ($_POST['empresa'])) {

	$empresa = $_POST['empresa'];
	$uf = $_POST['uf'];
	if ($_POST['segmento1'] != "") {
		$segmento = $_POST['segmento1'];
	}else {
		$segmento = $_POST['segmento2'];
	}
	$site = $_POST['site'];
	
	if ($_FILES["logo"]["error"] > 0) {
		echo "Error: ".$_FILES["logo"]["error"]."<br>";
	}else {
		$unique = rand(00000, 99999); //adidiona números aleatórios para não substituir arquivos com mesmo nome
		$file_name = tiracento($_FILES["logo"]["name"]); //retira caracteres especiais do nome do arquivo
		$logo_path = "E:/Inetpub/vhosts/cpro12924.publiccloud.com.br/joomla31/arquivos/search_empresa/logos/".$unique.$file_name;
		move_uploaded_file($_FILES["logo"]["tmp_name"], $logo_path);
		$logo_insert = "http://joomla31.centralsigma.com.br/arquivos/search_empresa/logos/".$unique.$file_name;
		
		$sql = "insert into empresas_segmento (empresa, segmento, uf, logo, site) values (:empresa, :segmento, :uf, :logo_insert, :site)";
		$query = $db->prepare($sql);
		$success = $query->execute(array(
			':empresa' => $empresa, 
			':segmento' => $segmento, 
			':uf' => $uf, 
			':logo_insert' => $logo_insert, 
			':site' => $site
		));
		
		if ($success) {
			unset($_POST);
			echo 'Empresa cadastrada com sucesso!';
			echo '<br><br><br><a id="btn" href="">Cadastrar outra</a>';
		}else {
			echo 'Erro ao cadastrar empresa.';
		}
	}
}

?>
