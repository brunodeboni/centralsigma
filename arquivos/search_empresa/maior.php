<?php 
//Conectar no banco de dados
require '../../conexoes.inc.php';
$db = Database::instance('centralsigma02');

$sql = "select empresa, segmento, uf, logo, site from empresas_segmento order by segmento";
$query = $db->query($sql);
$resultado = $query->fetchAll();

$empresa = array();
foreach ($resultado as $res) {
	$segmento = $res['segmento'];
	$empresa[$segmento][] = $res['empresa'];
}

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Pesquisa de Empresas por Segmento</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="../plugins/bxslider/jquery.bxslider.min.js"></script>
	<link href="../plugins/bxslider/jquery.bxslider.css" rel="stylesheet" />
	<style>
	#container {
		margin: auto;
		width: 500px;
		height: 600px;
		border: 1px solid #090909;
		font-family: Arial, sans-serif;
		-webkit-border-radius: 15px;
		border-radius: 15px;
		box-shadow: 1px 1px 5px #888;
		-webkit-box-shadow: 1px 1px 5px #888;
		background: #f8f8f8;
	}
	#titulo {
		padding: 20px;
		text-align: center;
		background-color: #008B8B;
		font-weight: bold;
		color: #FFF;
		font-size: 18px;
		border-top-right-radius: 13px;
		border-top-left-radius: 13px;
		-webkit-border-top-right-radius: 13px;
		-webkit-border-top-left-radius: 13px;
	}
	#form_segmentos {
		margin-top: 10px;
		margin-left: 30px;
		font-size: 16px;
		font-weight: bold;
		color: #090909;
	}
	select {
		color: #090909;
		font-weight: bold;
		font-family: Arial, sans-serif;
	}
	#btn {
		padding: 5px 30px;
		background-color: #008B8B;
		font-weight: bold;
		color: #FFF;
		font-size: 16px;
		border: 0;
		-webkit-border-radius: 25px;
		border-radius: 25px;
		box-shadow: 2px 2px 5px #888;
		-webkit-box-shadow: 2px 2px 5px #888;
		margin-left: 30px;
	}
	#resultado {
		color: #090909;
		margin: 20px auto;
	}
	.bxslider {
		margin-top: auto;
	}
	</style>
</head>
<body>
<div id="container">
	<div id="titulo">Usuários SIGMA</div>
	<form id="form_segmentos" action="" method="post">
		<span>Selecione um segmento:</span><br>
		<select id="segs" name="segmentos">
			<option value="">Selecione...</option>
			<?php foreach ($empresa as $segmento => $emp) {
				echo '<option value="'.$segmento.'">'.$segmento.'</option>';
			}?>
		</select><br>
		<br>
		
		<span>Selecione um Estado:</span><br>
		<select name="uf">
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
		</select><br>
		<br>
		
		<button type="submit" id="btn">BUSCAR</button>
	</form>
	
	<div id="resultado">
	<?php 
	if (isset($_POST['segmentos']) && $_POST['segmentos'] != "") {
		$segmento = $_POST['segmentos'];
		
		$sql = "select logo, empresa, site from empresas_segmento where segmento = :segmento";
		$prep = array(':segmento' => $segmento);
		if ($_POST['uf'] != "") {
			$uf = $_POST['uf'];
			$sql .= " and uf = :uf";
			$prep[':uf'] = $uf;
		}
		$query = $db->prepare($sql);
		$query->execute($prep);
		$resultado = $query->fetchAll();
		
		if ($query->rowCount() > 0) {
			echo '<ul class="bxslider">';
			foreach ($resultado as $res) {
				//carrossel com os logos
				$logo = $res['logo'];
				$site = $res['site'];
				$empresa = $res['empresa'];
				echo '<li><a href="'.trim($site, "‎‎‎ ").'" target="_blank"><img src="'.$logo.'" width="100%" height="100%" style="border: 0;"></a></li>';
			}
			echo '</ul>';
		}else {
			echo '<div style="padding: 12px;">Não há resultados neste Estado.</div>';
		}
	}else {
		echo '<div style="padding: 12px;">Selecione um segmento para realizar a pesquisa.</div>';
	}
	
	?>
	</div>
</div>
<script>
$(document).ready(function(){
	/*
	//Se o nome do segmento for maior que o espaço
	$('#segs option').each(function() {
		if( $(this).val().length > 27) {
			var new_opt = $(this).val().substring(0, 24) + '...';
			$(this).attr('title', $(this).val());
			$(this).html(new_opt);
		}
	});
	*/
	
	//Slider de logos
	$('.bxslider').bxSlider({
		slideWidth: 300,
		mode: 'horizontal',
		hideControlOnEnd: true,
		infiniteLoop: false,
		adaptiveHeight: true,
		adaptiveHeightSpeed: 200,
		pager: false
	});
});
</script>
</body>
</html>
