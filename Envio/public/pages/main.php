<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    //Verificando se as Sessões do Inventário Existem:
    if (isset($_SESSION['sala']) || isset($_SESSION['local'])) {
        //Destrói as Sessões:
        unset($_SESSION['sala']);
        unset($_SESSION['local']);
    }

    require_once 'logado.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistemas</title>
    <link href="../img/icon.ico" rel="shortcut icon"/>
    <link href="../css/font-awesome.min.css" rel="stylesheet"/>
    <link href="../css/bootstrap.min.css" rel="stylesheet"/>
    <link href="../css/style.css" rel="stylesheet"/>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<header>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarCollapse" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a href="main.php" class="navbar-brand menu-text">Portal de Ferramentas Internas</a>
            </div>
            <div id="navbarCollapse" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="menu-text dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-user"></i> <?= $_SESSION['name']?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="../systems/Usuarios/public/index.php"><?= ($_SESSION['profile'] == "ADM")?'<i class="fa fa-fw fa-users"></i> Usuários':'<i class="fa fa-fw fa-user"></i> Perfil'?></a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="../index.php"><i class="fa fa-fw fa-power-off"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main>
    <section>
        <div class="container-fluid">
            <div class="row espaco">
                <div class="col-xs-12 top">
                    <a href="../systems/Inventario/public/index.php" class="btn btn-primary btn-lg btn-block">Controle de Equipamentos</a>
                </div>
            </div>
        </div>
    </section>
</main>

<footer class="navbar navbar-inverse navbar-fixed-bottom">
    <h4 class="text-center">
        Data: <?= date('d/m/Y');?> -  Feito Por: Jefferson Frade
    </h4>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>