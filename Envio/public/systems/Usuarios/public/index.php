<?php
    require_once '../../../../vendor/autoload.php';

    //Utilização de Namespaces:
    use InvClasses\Tables\Login;
    use InvClasses\Services\ServiceLogin;

    //Arquivo de Conexão:
    require_once '../../connect/connect.php';

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
    require_once  'pages/logado.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Usuários</title>
        <link rel="shortcut icon" href="img/icon.png">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <?php
            //Verificando o Perfil:
            if ($_SESSION['profile'] == 'ADM') {
                require_once 'pages/menuAdm.php';
            } else {
                require_once 'pages/menuUsu.php';
            }
            //Exibindo o Menu:
            echo menu('index.php');
        ?>
        <main>
            <section>
                <div class="container">
                    <div class="row">
                        <h1 class="text-center">Cadastro de Usuários</h1>
                        <hr/>
                        <form id="frmCadUsuario" name="frmCadUsuario" method="post" action="">
                            <div class="form-group">
                                <label for="txtCadUsu">Usuário:</label>
                                <input type="text" class="form-control" id="txtCadUsu" name="txtCadUsu" placeholder="Usuário"/>
                            </div>

                            <div class="form-group">
                                <label for="txtCadNome">Nome:</label>
                                <input type="text" class="form-control" id="txtCadNome" name="txtCadNome" placeholder="Nome"/>
                            </div>

                            <div class="form-group">
                                <label for="txtCadSenha">Senha:</label>
                                <input type="password" class="form-control" id="txtCadSenha" name="txtCadSenha" placeholder="Senha"/>
                            </div>

                            <div class="form-group">
                                <label for="cmbCadPerfil">Perfil:</label>
                                <select id="cmbCadPerfil" name="cmbCadPerfil" class="form-control">
                                    <option id="ADM">ADM</option>
                                    <option id="Usuário">Usuário</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="cmbCadSetor">Setor:</label>
                                <select id="cmbCadSetor" name="cmbCadSetor" class="form-control">
                                    <option id="Central de Operações">Central de Operações</option>
                                    <option id="Estúdio JR">Estúdio JR</option>
                                    <option id="Estúdio Arouche">Estúdio Arouche</option>
                                    <option id="Auditório">Auditório</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success" id="btnCadastrar" name="btnCadastrar">Cadastrar</button>
                        </form>
                        <br/>
                        <?php
                            if (isset($_POST['btnCadastrar'])) {
                                $login->setUser($_POST['txtCadUsu']);
                                $login->setPass($_POST['txtCadSenha']);
                                $login->setName($_POST['txtCadNome']);
                                $login->setProfile($_POST['cmbCadPerfil']);
                                $login->setSetor($_POST['cmbCadSetor']);

                                echo $sLogin->insertUser();
                            }
                        ?>
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
        <script src="js/bootstrap.min.js"></script>
        <script src="js/script.min.js"></script>
    </body>
</html>