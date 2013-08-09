<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<div id="count_mapa" style="font-family: Arial, sans-serif; font-size: 12px;"></div>
<br>
<div id="map-canvas" style="border: 1px solid #fff;	width:680px; height: 500px;"></div>
<script>
$(document).ready(function() { 
	 $.post('/arquivos/planejadores/totalmap.php', {}, function(data) {
	    $('#count_mapa').html('Total de planejadores cadastrados: ' + data);
	 });
});

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

<h3 style="color:008B8B; font-family:Arial, sans-serif;">Formas de recebimento do KIT</h3>

<div style="font-family:Arial, sans-serif; font-size: 12px;">
	<h4 style="color:008B8B;">KIT GRATUITO</h4>
	<p>Para todos os participantes de treinamentos pagos ministrados pela equipe de consultores SIGMA em Batalhões de Implantação, treinamentos incompany, online ou em nossas turmas regulares. Também receberão gratuitamente todos os planejadores de manutenção SIGMA de empresas que possuem contrato de manutenção com a Rede Industrial*.</p>
	
	<p style="font-size: 10px;">* Será disponibilizado apenas 1 kit gratuito por empresa. Caso haja necessidade de disponibilizar mais de 1 kit, em função de haver mais planejadores, a empresa poderá adquirir os mesmos pelo preço de custo + frete.</p>
	
	<h4 style="color:008B8B;">KIT PAGO</h4> 
	<p>Pelo preço de custo, o KIT está disponível para todos os alunos de cursos gratuitos ministrados pelo CPCM ou em nossos centros de treinamentos, nos valores abaixo:</p>
	
	<p>
		- KIT Camisa + Crachá: R$ 30,00 + frete<br>
		- Crachá: R$ 10,00 + frete<br>
		- Camisa: R$ 25,00 + frete 
	</p>
	<p>
		- KIT Camisa + Crachá: R$ 30,00 + frete<br>
		- Crachá: R$ 10,00 + frete<br>
		- Camisa: R$ 25,00 + frete
	</p>
</div>