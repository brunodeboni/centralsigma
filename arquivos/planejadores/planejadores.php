<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Planejadores de Manutenção SIGMA</title>
</head>
<body>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<div style="padding: 5px 10px 30px 10px; color: #00688B; background: #A6D0E7; font-family: Verdana, sans-serif; font-size: 16px;">
	<h1 style="text-align:center;">Rede de Planejadores de Manutenção SIGMA</h1>
	<div>
		<span>Faça também parte desta Rede. Cadastre-se como usuário no nosso portal CPCM e crie seu perfil público para trocar contatos com outros Planejadores de Manutenção SIGMA e empresas em busca de Planejadores de Manutenção:</span><br>
		<br>
		<a href="http://www.centralsigma.com.br/cpcm/auth/login" target="_blank" style="
		
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #0ad3f7), color-stop(1, #0c9fcc) );
	background:-moz-linear-gradient( center top, #0ad3f7 5%, #0c9fcc 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#0ad3f7', endColorstr='#0c9fcc');
	background-color:#0ad3f7;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;
	border:1px solid #f0f0f0;
	display:inline-block;
	color:#2d6985;
	font-family:arial;
	font-size:15px;
	font-weight:bold;
	padding:6px 24px;
	text-decoration: none;">Cadastre-se</a>
	</div>
	<div style="margin-top: 40px;">
		<span><b>Veja quem já faz parte da nossa Rede:</b></span><br><br>
		 
		<div id="map-canvas" style="border: 1px solid #fff;	width:680px; height: 500px;"></div>
			
	</div>
</div>
<script>
function initialize() {
	var map = new google.maps.Map(document.getElementById('map-canvas'), {
		center: new google.maps.LatLng(-14.964268129360427, -46.26117305624996),
		zoom: 4,
		mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(document.getElementById('googft-legend'));

    layer = new google.maps.FusionTablesLayer({
		map: map,
		heatmap: { enabled: false },
     	query: {
        	select: "col2",
        	from: "1yAM4n2bIFsOfv70zz6E4fRq6yvf_WFmFw2vEhM0",
        	where: ""
      	},
      	options: {
        	styleId: 2,
        	templateId: 2
      	}
    });
}

  google.maps.event.addDomListener(window, 'load', initialize);
</script>
</body>
</html>
