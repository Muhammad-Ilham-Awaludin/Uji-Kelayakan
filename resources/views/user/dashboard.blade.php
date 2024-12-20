<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

</head>
<body>

  <div id="chart"></div>
  
<script>
 options = {
  chart: {
    type: 'bar'
  }, 
  series: [{
    data: [{
      x: 'Report',
      y: 2
    }, {
      x: 'Response',
      y:1
    }]
  }]
}

var chart = new ApexCharts(document.querySelector("#chart"), options);

chart.render();
</script>
</body>
</html>