<!doctype html>
<html>
<head>
	<title>Parceiros</title>
	<meta charset="utf-8">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="../plugins/bxslider/jquery.bxslider.min.js"></script>
	<link href="../plugins/bxslider/jquery.bxslider.css" rel="stylesheet" />
	<style>
	#container {
		background-color: #fff;
		padding: 10px 0 20px 40px;
		height: 110px;
		-webkit-border-radius: 5px;
		border-radius: 5px;
	}
	.bx-wrapper .bx-viewport {
		border: 0;
		-webkit-box-shadow: 0 0 0;
		box-shadow: 0 0 0;
	}
	.bxslider {
		margin-top: auto;
		border: 0;
	}
	.bxslider li img {
		padding: 10px;
		border: 1px solid #E6E6E6;
		-webkit-box-shadow: 1px 1px 1px #E6E6E6;
		box-shadow: 1px 1px 1px #E6E6E6;
		max-height:100px;
	}
	</style>
</head>
<body>
<div id="container">
<ul class="bxslider">
	<li><img src="logos/agv_log.jpg" class="logo" width="100" height="100%"></li>
	<li><img src="logos/coop_pia.jpg" class="logo" width="100" height="100%"></li>
	<li><img src="logos/senai.png" class="logo" width="100" height="100%"></li>
</ul>
</div>
<script>

$(document).ready(function(){
	//Slider de logos
	$('.bxslider').bxSlider({
		slideWidth: 300,
		mode: 'horizontal',
		responsive: false, //não muda de tamanho
		pager: false, //sem marcador de página embaixo
		controls: false, //sem controles next e prev
		auto: true, //passa imagens automaticamente
		autoHover: true, //pára slider quando passa o mouse
		maxSlides: 3,
		slideMargin: 20
	});

	/*
	$('.logo').each(function() { 
		var h = $(this).height();
		console.log(h);
		$(this).css('margin-top', (27-h)+'px');
	});
	*/
});


</script>

</body>
</html>
