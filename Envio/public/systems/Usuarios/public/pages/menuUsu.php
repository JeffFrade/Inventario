<?php
function menu($menu)
{
    if ($menu == 'consultar.php') {
        return '<header>
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
                            <li class="menu-text active"><a href="ediDel.php"><i class="fa fa-pencil-square-o"></i> Editar Dados</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>';
    }
}
?>