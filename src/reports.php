<?PHP
$path = '';
require_once("functions/basic_html_functions.php");
require_once("../config.php");
require_once("functions/database_functions.php");
require_once("functions/generalized_functions.php");
require_once("functions/tables.php");
require("includes/header.php");
?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current');
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        var wrapper = new google.visualization.ChartWrapper({
          chartType: 'LineChart',
          dataSourceUrl: 'http://spreadsheets.google.com/tq?key=pCQbetd-CptGXxxQIG7VFIQ&pub=1',
          query: 'SELECT A,D WHERE D > 100 ORDER BY D',
          options: {'title': 'Countries'},
          containerId: 'vis_div'
        });
        wrapper.draw()

        // No query callback handler needed!
      }
    </script>
  </head>
  <body style="font-family: Arial;border: 0 none;">
    <div id="vis_div" style="width: 600px; height: 400px;"></div>
  </body>
</html>