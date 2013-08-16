<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mapa de usuários SIGMA ANDROID</title>
	<style type="text/css">
		* {
			font-family: Arial, sans-serif;
			font-size: 14px;
		}
		#container {
			width: 700px;
			margin: auto;
			height: 100%;
		}
		h1 {
			margin-bottom:5px;
			text-align:center;
			padding:5px;
			font-size:18px;
			background:#B03060;
			color:#FFF;
		}
		#googft-mapCanvas {
			margin: auto;
		  	height: 500px;
		  	width: 680px;
		  	margin-bottom: 10px;
		}
		#btn {
			padding: 10px 30px;
			font-weight: bold;
			background:#B03060;
			color:#FFF;
			text-decoration: none;
			border: 0;
			margin-left: 20px;
		}
	</style>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

	<script type="text/javascript">
		function initialize() {
	    	google.maps.visualRefresh = true;
	    	var map = new google.maps.Map(document.getElementById('googft-mapCanvas'), {
	      		center: new google.maps.LatLng(-14.964268129360427, -50.26117305624996),
	      		zoom: 4,
	      		mapTypeId: google.maps.MapTypeId.ROADMAP
	    	});
	    	map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(document.getElementById('googft-legend'));
	
	    	var layer = new google.maps.FusionTablesLayer({
	      		map: map,
	      		heatmap: { enabled: false },
	      		query: {
			        select: "col2",
			        from: "13Ozdr2Yqo5aZXuZtcSMw-C9rFwNriwEcnZ2kqGo",
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
</head>

<body>
	<div id="container">
		<h1>Mapa de usuários SIGMA ANDROID</h1>
  		<div id="googft-mapCanvas"></div>
  		<br>
  		<a id="btn" href="../controle.php">Voltar</a>
  	</div>
</body>
</html>

