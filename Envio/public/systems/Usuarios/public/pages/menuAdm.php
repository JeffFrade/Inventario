<?php
    function menu($menu)
    {
        if ($menu == 'index.php') {
            echo '<header>
            <nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarCollapse" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
        
                        <a href="../../../pages/main.php" class="navbar-brand menu-text"><i class="fa fa-home"></i> Portal</a>
                    </div>
        
                    <div id="navbarCollapse" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="active menu-text"><a href="index.php"><i class="fa fa-plus"></i> Cadastrar</a></li>
                            <li class="menu-text"><a href="pages/consultar.php"><i class="fa fa-search"></i> Consultar</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>';
        } else {
            echo '<header>
            <nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarCollapse" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
        
                        <a href="../../../../pages/main.php" class="navbar-brand menu-text"><i class="fa fa-home"></i> Portal</a>
                    </div>
        
                    <div id="navbarCollapse" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="menu-text"><a href="../index.php"><i class="fa fa-plus"></i> Cadastrar</a></li>
                            <li class="active menu-text"><a href="consultar.php"><i class="fa fa-search"></i> Consultar</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>';
        }
    }
?>