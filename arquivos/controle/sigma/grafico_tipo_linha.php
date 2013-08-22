<html>
  <head>
  	<meta charset="utf-8">
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    
      
      google.load('visualization', '1.0', {'packages':['corechart']});
      google.setOnLoadCallback(drawChart);

      function drawChart() {

	      // Create the data table.
	      var data = new google.visualization.DataTable();
	      data.addColumn('string', 'Mês');
	      data.addColumn('number', 'SIGMA 2010');
	      data.addColumn('number', 'SIGMA 2012 Free');
	      data.addColumn('number', 'SIGMA 2012 Enterprise');
	      data.addColumn('number', 'SIGMA 2012 Professional');
	      data.addRows([
	        ['Janeiro',    1000,           400,                 1170,                     460],
			['Fevereiro',  1170,           460,                 387,                      480],
			['Março',      660,            1120,                1170,                     2460],
			['Abril',      1030,           540,                 1200,                     1360]
	      ]);

	      // Set chart options
	      var options = {'title':'Downloads por aplicativo',
	                     'width':900,
	                     'height':500
	                     };
			
	      // Instantiate and draw our chart, passing in some options.
	      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
	      chart.draw(data, options);
	}
    </script>
  </head>

  <body>
<!--Div that will hold the pie chart-->
    <div id="chart_div" style="width:900; height:500"></div>
  </body>
</html>
