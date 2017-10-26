<?php
    require_once '../../../../../vendor/autoload.php';

    //Utilização de Namespaces:
    use InvClasses\Tables\Login;
    use InvClasses\Services\ServiceLogin;

    //Arquivo de Conexão:
    require_once '../../../connect/connect.php';

    //Instanciando Objetos:
    $login = new Login;
    $sLogin = new ServiceLogin($db, $login);
    //Caso a Sessão Não Exista:
    if (!isset($_SESSION)) {
        session_start();
    }

    //Redirecionando Caso o Perfil Seja Diferente de ADM:
    if ($_SESSION['profile'] != 'ADM') {
        header('location:pages/ediDel.php');
    }

    //Verificando Login:
    require_once  'logado.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Usuários</title>
        <link rel="shortcut icon" href="../img/icon.png">
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/font-awesome.min.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body onload="<?php echo $sLogin->selectUser(); ?>">
        <?php
        //Verificando o Perfil:
        if ($_SESSION['profile'] == 'ADM') {
            require_once 'menuAdm.php';
        } else {
            require_once 'menuUsu.php';
        }
        //Exibindo o Menu
        echo menu('consultar.php');
        ?>
        <main>
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <h1 class="text-center">Consultar Usuário</h1>
                            <hr/>

                            <div class="col-xs-12">
                                <div class="panel panel-default height">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="fa fa-users"></i> Consulta de Usuários</h3>
                                    </div>

                                    <div class="panel-body">
                                        <div class="scroll">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Usuário</th>
                                                        <th class="text-center">Nome</th>
                                                        <th class="text-center">Perfil</th>
                                                        <th class="text-center">Setor</th>
                                                        <th class="text-center">Visualizar</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                     <?php
                                                        echo $sLogin->selectUser();
                                                     ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <?php require_once 'rodape.php'; ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/script.min.js"></script>
    </body>
</html>