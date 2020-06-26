<?php include '../html/menu.php';?>

            <main class="dash-content">
                <div class="container-fluid">
                    <h1 class="dash-title">Chart.js</h1>
                    <p class="mb-5"> These charts are made using the Chart.js library. You can find more examples and ways to configure the charts in the <a href="http://chartjs.org" target="_blank">Chart.js Documentation</a>. </p>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card easion-card">
                                <div class="card-header">
                                    <div class="easion-card-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <div class="easion-card-title"> Two bars </div>
                                    <div class="easion-card-menu">
                                        <div class="dropdown show">
                                            <a class="easion-card-menu-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body easion-card-body-chart">
                                    <canvas id="easionChartjsTwoBars"></canvas>
                                    <script>
                                        var ctx = document.getElementById("easionChartjsTwoBars").getContext('2d');
                                        var myChart = new Chart(ctx, {
                                            type: 'bar',
                                            data: {
                                                labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
                                                datasets: [{
                                                    label: 'Blue',
                                                    data: [12, 19, 3, 5, 2],
                                                    backgroundColor: window.chartColors.primary,
                                                    borderColor: 'transparent'
                                                }, {
                                                    label: 'Red',
                                                    data: [4, 12, 11, 2, 14],
                                                    backgroundColor: window.chartColors.danger,
                                                    borderColor: 'transparent'
                                                }]
                                            },
                                            options: {
                                                legend: {
                                                    display: false
                                                },
                                                scales: {
                                                    yAxes: [{
                                                        ticks: {
                                                            beginAtZero: true
                                                        }
                                                    }]
                                                }
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card easion-card">
                                <div class="card-header">
                                    <div class="easion-card-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <div class="easion-card-title"> Line </div>
                                    <div class="easion-card-menu">
                                        <div class="dropdown show">
                                            <a class="easion-card-menu-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body easion-card-body-chart">
                                    <canvas id="easionChartjsLine"></canvas>
                                    <script>
                                        var ctx = document.getElementById("easionChartjsLine").getContext('2d');
                                        var myChart = new Chart(ctx, {
                                            type: 'line',
                                            data: {
                                                labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
                                                datasets: [{
                                                    label: 'Blue',
                                                    data: [12, 19, 3, 5, 2],
                                                    backgroundColor: window.chartColors.primary,
                                                    borderColor: window.chartColors.primary,
                                                    fill: false
                                                }, {
                                                    label: 'Red',
                                                    data: [4, 12, 11, 2, 14],
                                                    backgroundColor: window.chartColors.danger,
                                                    borderColor: window.chartColors.danger,
                                                    fill: false
                                                }]
                                            },
                                            options: {
                                                legend: {
                                                    display: false
                                                }
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card easion-card">
                                <div class="card-header">
                                    <div class="easion-card-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <div class="easion-card-title"> Doughnut </div>
                                    <div class="easion-card-menu">
                                        <div class="dropdown show">
                                            <a class="easion-card-menu-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body easion-card-body-chart">
                                    <canvas id="easionChartjsDougnut"></canvas>
                                    <script>
                                        var ctx = document.getElementById("easionChartjsDougnut").getContext('2d');
                                        var myChart = new Chart(ctx, {
                                            type: 'doughnut',
                                            data: {
                                                labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
                                                datasets: [{
                                                    label: 'Week',
                                                    data: [12, 19, 3, 5, 2],
                                                    backgroundColor: [
                                                        window.chartColors.primary,
                                                        window.chartColors.secondary,
                                                        window.chartColors.success,
                                                        window.chartColors.superwarning,
                                                        window.chartColors.danger,
                                                    ],
                                                    borderColor: '#fff',
                                                    fill: false
                                                }]
                                            },
                                            options: {
                                                legend: {
                                                    display: false
                                                }
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card easion-card">
                                <div class="card-header">
                                    <div class="easion-card-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <div class="easion-card-title"> Polar Area </div>
                                    <div class="easion-card-menu">
                                        <div class="dropdown show">
                                            <a class="easion-card-menu-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body easion-card-body-chart">
                                    <canvas id="easionChartjsPolar"></canvas>
                                    <script>
                                        var ctx = document.getElementById("easionChartjsPolar").getContext('2d');
                                        var myChart = new Chart(ctx, {
                                            type: 'polarArea',
                                            data: {
                                                labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
                                                datasets: [{
                                                    label: 'Week',
                                                    data: [12, 19, 3, 5, 2],
                                                    backgroundColor: [
                                                        window.chartColors.primary,
                                                        window.chartColors.secondary,
                                                        window.chartColors.success,
                                                        window.chartColors.superwarning,
                                                        window.chartColors.danger,
                                                    ],
                                                    borderColor: '#fff'
                                                }]
                                            },
                                            options: {
                                                legend: {
                                                    display: true
                                                }
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="../js/easion.js"></script>
</body>

</html>