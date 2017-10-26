<?php
    if (!isset($_SESSION)) {
        session_start();
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

                        <a href="main.php" class="navbar-brand menu-text">Olá <?= $_SESSION['user'];?></a>
                    </div>
                    <div id="navbarCollapse" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="menu-text"><a href="../index.php">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            <h1 class="text-center red">Página Indisponível</h1>
            <hr/>
            <h3 class="text-center">Esta Página Encontra-se Indisponível no Momento</h3>
            <br/>
            <img src="../img/error03.jpg" class="img-responsive center-block"/>
            <br/>
            <h4 class="text-center"><a href="main.php" class="error">Voltar a Página Principal</a></h4>
        </main>

        <footer class="navbar navbar-inverse navbar-fixed-bottom">
            <h4 class="text-center">
                Data: <?= date('d/m/Y');?> -  Feito Por: Jefferson Frade
            </h4>
        </footer>
    </body>
</html>