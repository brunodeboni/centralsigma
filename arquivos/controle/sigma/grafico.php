<html>
  <head>
  	<meta charset="utf-8">
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    
      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['motionchart']});
      
      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);


      // Callback that creates and populates a data table, 
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

	      // Create the data table.
	     /*
	      var data = new google.visualization.DataTable();
	      data.addColumn('string', 'Topping');
	      data.addColumn('number', 'Slices');
	      data.addRows([
	        ['SIGMA 2010', 23],
	        ['SIGMA 2012 Free', 241],
	        ['SIGMA 2012 Enterprise', 154], 
	        ['SIGMA 2012 Professional', 121],
	      ]);
		 
		var data = google.visualization.arrayToDataTable([
			['Mês',        'SIGMA 2010', 'SIGMA 2012 Free', 'SIGMA 2012 Enterprise' , 'SIGMA 2012 Professional'],
			['Janeiro',    1000,           400,                 1170,                     460],
			['Fevereiro',  1170,           460,                 387,                      480],
			['Março',      660,            1120,                1170,                     2460],
			['Abril',      1030,           540,                 1200,                     1360]
		]);                                       		
		*/

		var data = new google.visualization.DataTable();
	      data.addColumn('string', 'Aplicativos');
	      data.addColumn('date', 'Data');
	      data.addColumn('number', 'Downloads');
	      data.addRows([
	        ['SIGMA 2010', new Date (2013, 8, 01), 23],
	        ['SIGMA 2012 Free', new Date (2013, 8, 01), 241],
	        ['SIGMA 2012 Enterprise', new Date (2013, 08, 01), 154], 
	        ['SIGMA 2012 Professional', new Date (2013, 08, 01), 121],
	        
	        ['SIGMA 2010', new Date (2013, 8, 02), 32],
	        ['SIGMA 2012 Free', new Date (2013, 8, 02), 270],
	        ['SIGMA 2012 Enterprise', new Date (2013, 8, 02), 120], 
	        ['SIGMA 2012 Professional', new Date (2013, 8, 02), 150],

	        ['SIGMA 2010', new Date (2013, 8, 03), 40],
	        ['SIGMA 2012 Free', new Date (2013, 8, 03), 380],
	        ['SIGMA 2012 Enterprise', new Date (2013, 8, 03), 157], 
	        ['SIGMA 2012 Professional', new Date (2013, 8, 03), 170],

	        ['SIGMA 2010', new Date (2013, 8, 04), 35],
	        ['SIGMA 2012 Free', new Date (2013, 8, 04), 540],
	        ['SIGMA 2012 Enterprise', new Date (2013, 8, 04), 156], 
	        ['SIGMA 2012 Professional', new Date (2013, 8, 04), 180],
	      ]);

		
	      // Set chart options
	      var options = {'title':'Downloads por aplicativo',
	                     'width':900,
	                     'height':500,
	                     'state': '{"duration":{"timeUnit":"D","multiplier":1},"xZoomedDataMax":4,"orderedByY":false,"sizeOption":"_UNISIZE","xZoomedIn":false,"yAxisOption":"2","orderedByX":true,"yZoomedDataMax":600,"iconType":"VBAR","xAxisOption":"2","xLambda":1,"yZoomedDataMin":0,"yLambda":1,"dimensions":{"iconDimensions":["dim0"]},"showTrails":false,"xZoomedDataMin":0,"iconKeySettings":[{"key":{"dim0":"SIGMA 2012 Professional"}},{"key":{"dim0":"SIGMA 2010"}},{"key":{"dim0":"SIGMA 2012 Enterprise"}},{"key":{"dim0":"SIGMA 2012 Free"}}],"nonSelectedAlpha":0.5,"playDuration":15000,"time":"2013-09-01","uniColorForNonSelected":false,"colorOption":"_UNIQUE_COLOR","yZoomedIn":false}'};
			
	      // Instantiate and draw our chart, passing in some options.
	      var chart = new google.visualization.MotionChart(document.getElementById('chart_div'));
	      chart.draw(data, options);
	}
    </script>
  </head>

  <body>
<!--Div that will hold the pie chart-->
    <div id="chart_div" style="width:400; height:300"></div>
  </body>
</html>
