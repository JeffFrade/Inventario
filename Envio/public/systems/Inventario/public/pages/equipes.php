<?php
require_once 'topo.php';
?>
<body class="branco">

<div id="wrapper">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand menu-text" href="../../../../pages/main.php"><i class="fa fa-home"></i> Portal</a>
            </div>

            <ul class="nav navbar-nav navbar-right margin-right">
                <li class="menu-text"><a href="cadastrar.php"><i class="fa fa-plus"></i> Cadastrar</a></li>
                <li class="menu-text"><a href="../index.php"><i class="fa fa-search"></i> Consultar</a></li>
                <li class="menu-text"><a href="relatorio.php"><i class="fa fa-table"></i> Relatório</a></li>
                <li class="menu-text active"><a href="dashboard.php"><i class="fa fa-bar-chart"></i> Gráficos</a></li>
            </ul>

            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav dash">
                    <li>
                        <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Geral</a>
                    </li>
                    <li>
                        <a href="graficos.php"><i class="fa fa-fw fa-bar-chart-o"></i> Equipamentos</a>
                    </li>
                    <li class="active">
                        <a href="equipes.php"><i class="fa fa-fw fa-area-chart"></i> Equipes</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Estatísticas do Inventário
                    </h1>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Gráfico das Equipes Responsáveis</h3>
                        </div>
                        <div class="panel-body">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../js/lightbox.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/vue.min.js"></script>
<script src="../js/Chart.min.js"></script>
<script src="../js/script.js"></script>
<script src="../js/app.js"></script>
<script>
    var ctx = document.getElementById("myChart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($sEquipamento->arrEquipe()); ?>,
            datasets: [{
                label: 'Equipamentos das Equipes',
                data: <?= json_encode($sEquipamento->graphEquipe()); ?>,
                backgroundColor: [
                    'rgba(238, 180, 180, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(0, 100, 0, 1)',
                    'rgba(47, 79 ,79, 1)',
                    'rgba(165, 42, 42, 1)',
                    'rgba(25, 25, 112, 1)',
                    'rgba(144, 238, 144, 1)',
                    'rgba(0, 0, 0, 1)',
                    'rgba(255, 0, 0, 1)'
                ],
                borderColor: [
                    'rgba(238, 180, 180, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(0, 100, 0, 1)',
                    'rgba(47, 79 ,79, 1)',
                    'rgba(165, 42, 42, 1)',
                    'rgba(25, 25, 112, 1)',
                    'rgba(144, 238, 144, 1)',
                    'rgba(0, 0, 0, 1)',
                    'rgba(255, 0, 0, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>
<script type="text/javascript">
    $(".form-control").bind("keypress", function(e) {
        if($(this).prop('id')==='FinderSearch'){
            return true;
        }
        if (e.keyCode == 13) {
            var inps = $("input, select"); //add select too
            for (var x = 0; x < inps.length; x++) {
                if (inps[x] == this) {
                    while ((inps[x]).name == (inps[x + 1]).name) {
                        x++;
                    }
                    if ((x + 1) < inps.length) $(inps[x + 1]).focus();
                }
            }   e.preventDefault();
        }
    });
</script>
</body>
</html>