<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link type="text/css" rel="stylesheet" href="../plugins/yahoo-slider/themes/base.css"/>
	<link type="text/css" rel="stylesheet" href="../plugins/yahoo-slider/themes/default/theme.css"/>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
	<script type="text/javascript" src="../plugins/yahoo-slider/jquery.accessible-news-slider.js"></script>
	<script type="text/javascript">
	// when the DOM is ready, convert the feed anchors into feed content
	$(document).ready(function() {
		
		$('#newsslider').accessNews({
			title : "Últimas Notícias SIGMA:",
			//subtitle: currentTime,
			speed : "slow",
			slideBy : 4,
			slideShowInterval: 5000,
			slideShowDelay: 1000
		});
	
	});
	</script>
</head>
<body>
	<ul id="newsslider">
<?php 
require '../../conexoes.inc.php';
$db = Database::instance('centralsigma02');

$sql = "select titulo, noticia, img, link from news_slider";
$query = $db->query($sql);
$resultado = $query->fetchAll();
foreach ($resultado as $res) {
	echo "
		<li>
			<a href=\"$res[link]\" target=\"_parent\">
				<img src=\"$res[img]\" width=\"120\" height=\"50\">
			</a>
			<h3>
				<a href=\"$res[link]\" target=\"_parent\">$res[titulo]</a>
			</h3>
			<p>
				$res[noticia] 
				<br>
				<a href=\"$res[link]\" target=\"_parent\"> &raquo; Leia mais</a>
			</p>
		</li>";
 //580px por 200px
}
?>
	</ul>

</body>
</html>
