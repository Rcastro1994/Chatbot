<html>
    <head>
        <!--Load the AJAX API-->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">

            // Load the Visualization API and the corechart package.
            google.charts.load('current', {'packages': ['corechart']});

            // Set a callback to run when the Google Visualization API is loaded.
            google.charts.setOnLoadCallback(drawChart);

            // Callback that creates and populates a data table,
            // instantiates the pie chart, passes in the data and
            // draws it.
            function drawChart() {

                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Sintoma');
                data.addColumn('number', 'Porcentaje');
                data.addRows([
                    ['Estrés', 30],
                    ['Ansiedad', 8],
                    ['Depresión', 2],
                    ['Baja Autestima', 5],
                    ['Falta de energía y cansancio', 4]
                ]);

                // Set chart options
                var options = {
                    'width': 600,
                    'height': 300};

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }

        </script>
    </head>

    <body>
        <h3>Diagnóstico Inicial de <?= $_SESSION['identity']->nombre_apellidos ?></h3>
        <!--Div that will hold the pie chart-->
        <div class="row">
            <div class="col-md-6" id="chart_div"></div>
            <div class="col-md-6">
                <img src="../assets/images/diagnostico.jpg" width="450" height="300"/>
            </div>
        </div>
    </body>
</html>
