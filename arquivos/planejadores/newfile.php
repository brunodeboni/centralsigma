<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<div id="map-canvas" style="border: 1px solid #fff;	width:680px; height: 500px;"></div>
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
