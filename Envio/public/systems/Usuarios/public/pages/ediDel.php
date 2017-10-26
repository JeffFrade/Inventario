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

    //Verificando Login:
    require_once  'logado.php';

    if ($_SESSION['profile'] == 'ADM') {
        $id = $_GET['id'];
    }

    if ($_SESSION['profile'] == 'ADM') {
        $dados = $sLogin->findUser($id);
        $user = $dados['user'];
        $name = $dados['name'];
        $pass = $dados['pass'];
        $profile = $dados['profile'];
        $setor = $dados['setor'];
    } else {
        $id = $_SESSION['id'];
        $user = $_SESSION['user'];
        $name = $_SESSION['name'];
        $pass = $_SESSION['pass'];
        $profile = $_SESSION['profile'];
        $setor = $_SESSION['setor'];
    }
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

<body>
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
                    <?php if ($_SESSION['profile'] == 'ADM') : ?>
                        <h1 class="text-center">Editar/Deletar Usuário</h1>
                    <?php else : ?>
                        <h1 class="text-center">Editar Dados</h1>
                    <?php endif; ?>
                    <hr/>

                    <form id="frmEdiDelUsu" name="frmEdiDelUsu" method="post" action="">
                        <div class="form-group">
                            <label for="txtUsu">Usuário:</label>
                            <input type="text" id="txtUsu" name="txtUsu" class="form-control" placeholder="Usuário" disabled="disabled" value="<?= $user;?>">
                        </div>

                        <div class="form-group">
                            <label for="txtNome">Nome:</label>
                            <?php if ($_SESSION['profile'] == 'ADM') : ?>
                                <input type="text" id="txtNome" name="txtNome" class="form-control" placeholder="Nome" value="<?= $name;?>">
                            <?php else : ?>
                                <input type="text" id="txtNome" name="txtNome" class="form-control" placeholder="Nome" disabled="disabled" value="<?= $name;?>">
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="txtSenha">Senha:</label>
                            <input type="password" id="txtSenha" name="txtSenha" class="form-control" placeholder="Senha">
                        </div>

                        <?php if ($_SESSION['profile'] == 'ADM'): ?>
                            <div class="form-group">
                                <label for="cmbPerfil">Perfil:</label>
                                <select id="cmbPerfil" name="cmbPerfil" class="form-control">
                                    <option id="ADM" <?= ($profile == "ADM"?'selected="selected"':"")?>>ADM</option>
                                    <option id="Usuário" <?= ($profile == "Usuário"?'selected="selected"':"")?>>Usuário</option>
                                </select>
                            </div>
                        <?php endif;?>

                        <?php if ($_SESSION['profile'] == 'ADM'): ?>
                            <div class="form-group">
                                <label for="cmbSetor">Setor:</label>
                                <select id="cmbSetor" name="cmbSetor" class="form-control">
                                    <option id="Central de Operações" <?= ($setor == "Central de Operações"?'selected="selected"':"")?>>Central de Operações</option>
                                    <option id="Estúdio JR" <?= ($setor == "Estúdio JR"?'selected="selected"':"")?>>Estúdio JR</option>
                                    <option id="Estúdio Arouche" <?= ($setor == "Estúdio Arouche"?'selected="selected"':"")?>>Estúdio Arouche</option>
                                    <option id="Auditório" <?= ($setor == "Auditório"?'selected="selected"':"")?>>Auditório</option>
                                </select>
                            </div>
                        <?php endif;?>

                        <button type="submit" id="btnEdi" name="btnEdi" class="btn btn-warning" onclick="return edi();">Editar</button>
                        <?php if ($_SESSION['profile'] == 'ADM'): ?>
                            <button type="submit" id="btnDel" name="btnDel" class="btn btn-danger" onclick="return del();">Deletar</button>
                        <?php endif;?>
                    </form>
                    <br/>
                    <?php
                        if (isset($_POST['btnEdi'])) {
                            if ($_SESSION['profile'] != 'ADM') {
                                $login->setId($id);
                                if (!empty($_POST['txtSenha'])) {
                                    $login->setPass($_POST['txtSenha']);
                                } else {
                                    $login->setPassNoMd5($pass);
                                }
                                $login->setName($name);
                                $login->setProfile($profile);
                                $login->setSetor($setor);
                            } else {
                                $login->setId($id);
                                $login->setPass($_POST['txtSenha']);
                                $login->setName($_POST['txtNome']);
                                $login->setProfile($_POST['cmbPerfil']);
                                $login->setSetor($_POST['cmbSetor']);
                            }

                            echo $sLogin->updateUser();
                        }

                        if (isset($_POST['btnDel'])) {
                            $login->setId($id);

                            echo $sLogin->deleteUser($login->getId());
                        }
                    ?>
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