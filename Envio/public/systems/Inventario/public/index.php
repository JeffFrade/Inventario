<?php
//Autoload:
require_once '../../../../vendor/autoload.php';

//Utilização de Namespaces:
use InvClasses\Tables\Equipamento;
use InvClasses\Services\ServiceEquipamento;

//Arquivo de Conexão:
require_once '../../connect/connect.php';

//Caso a Sessão Não Exista:
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['sala'])) {
    $_SESSION['sala'] = "";
}

//Verificação de Login:
if (!isset($_SESSION['user']) || !isset($_SESSION['pass'])) {
    echo "<script type='text/javascript'>alert('Você Precisa Estar Logado Para Ter Acesso ao Está Página');location.href='../../../index.php';</script>";
    exit();
}

//Instância de Objetos:
//Tabela de Equipamentos:
$equipamentos = new Equipamento;

//Serviço de Equipamentos:
$sEquipamento = new ServiceEquipamento($db, $equipamentos);

//Verificando se Algum Equipamento foi Escaneado:
if (isset($_POST['btnPesquisar'])) {
    //Caso Seja:
    //Passando o Código de Barras Para o Método que Seta o Código de Barras:
    if (isset($_POST['txtCodBarras'])) {
        $equipamentos->setCodBarras($_POST['txtCodBarras']);
    } else {
        $equipamentos->setNumSerie($_POST['txtNumSerie']);
    }

    //Script:
    echo "<script type='text/javascript'>document.getElementById('txtSalaSelecionada').value = '".$_SESSION['sala']."';</script>";

    //Verificando se o Método de Pegar Código de Barras Está Vazio:
    if (isset($_POST['txtCodBarras'])) {
        if (empty($equipamentos->getCodBarras())) {
            //Caso Esteja:

            //Seta todos os Métodos como Vazio:
            $equipamentos->setCodBarras("");
            $equipamentos->setItem("");
            $equipamentos->setTipo("");
            $equipamentos->setMarca("");
            $equipamentos->setModelo("");
            $equipamentos->setNumSerie("");
            $equipamentos->setPatrimonio("");
            $equipamentos->setOrigem("");
            $equipamentos->setLocal("");
            $equipamentos->setSala("");
            $equipamentos->setObs("");
            $equipamentos->setImagem("");
        } else {
            $sEquipamento->findEquipamento('cb');
        }
    } else {
        if (empty($equipamentos->getNumSerie())) {
            //Caso Esteja:

            //Seta todos os Métodos como Vazio:
            $equipamentos->setCodBarras("");
            $equipamentos->setItem("");
            $equipamentos->setTipo("");
            $equipamentos->setMarca("");
            $equipamentos->setModelo("");
            $equipamentos->setNumSerie("");
            $equipamentos->setPatrimonio("");
            $equipamentos->setOrigem("");
            $equipamentos->setLocal("");
            $equipamentos->setSala("");
            $equipamentos->setObs("");
            $equipamentos->setImagem("");
        } else {
            $sEquipamento->findEquipamento('ns');

            $_SESSION['cod'] = $equipamentos->getNumSerie();
        }
    }
}

//Verificando se a Lista de Equipamentos foi Limpa:
if (isset($_POST['btnLimpar'])) {
    //Caso Seja:
    echo $sEquipamento->cleanEquipamento();
}

if (isset($_SESSION['sala'])) {
    //Script:
    echo "<script type='text/javascript'>document.getElementById('txtSalaSelecionada').value = '" . $_SESSION['sala'] . "';</script>";
}

if (empty($_SESSION['local'])) {
    $_SESSION['local'] = "";
}
?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Inventário</title>
        <link rel="shortcut icon" href="img/icon.jpg">
        <link href="css/lightbox.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body onload="troca(); selecionando(document.getElementById('cmbLocal').value, document.getElementById('txtSalaSelecionada').value);">
    <?php
    //Arquivo de Menu:
    require_once 'pages/menu.php';
    //Exibindo o Menu:
    menu("index.php");
    ?>
    <main>
        <section>
            <div class="container-fluid">
                <div class="row">
                    <h1 class="text-center">Consultar Equipamentos</h1>
                    <hr/>
                    <div class="col-xs-12">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <h2 class="text-center">Selecionar Local</h2>
                            <hr/>
                            <form id="localEquipamento" name="localEquipamento" method="post" action="">
                                <div class="form-group">
                                    <label for="cmbLocal">Local de Busca:</label>
                                    <select id="cmbLocal" name="cmbLocal" class="form-control" onchange="opcoes()">
                                        <option value="" <?php echo ($_SESSION['local'] == ""?" selected='selected'":"") ?>></option>
                                        <option value="Central de Operações" <?php echo ($_SESSION['local'] == "Central de Operações"?" selected='selected'":"") ?>>Central de Operações</option>
                                        <option value="Estúdio JR I" <?php echo ($_SESSION['local'] == "Estúdio JR I"?" selected='selected'":"") ?>>Estúdio JR I</option>
                                        <option value="Estúdio JR II" <?php echo ($_SESSION['local'] == "Estúdio JR II"?" selected='selected'":"") ?>>Estúdio JR II</option>
                                        <option value="Estúdio Arouche" <?php echo ($_SESSION['local'] == "Estúdio Arouche"?" selected='selected'":"") ?>>Estúdio Arouche</option>
                                        <option value="Auditório I" <?php echo ($_SESSION['local'] == "Auditório I"?" selected='selected'":"") ?>>Auditório I</option>
                                        <option value="Auditório II" <?php echo ($_SESSION['local'] == "Auditório II"?" selected='selected'":"") ?>>Auditório II</option>
                                        <option value="Ocorrências/Anomalias" <?php echo ($_SESSION['local'] == "Ocorrências/Anomalias"?" selected='selected'":"") ?>>Ocorrências/Anomalias</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="cmbSala">Sala:</label>
                                    <select id="cmbSala" name="cmbSala" class="form-control">

                                    </select>
                                </div>

                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="txtSalaSelecionada" name="txtSalaSelecionada" placeholder="Sala" disabled="disabled"/>
                                </div>
                                <button class="btn btn-success" id="btnSelecionar" name="btnSelecionar" type="submit" onclick="seleciona();">Selecionar</button>
                            </form>

                            <h2 class="text-center">Buscar Equipamento</h2>
                            <hr/>

                            <form id="consEquipamento" name="consEquipamento" method="post" action="">
                                <h4 class="text-center preto">Método de Busca:</h4>
                                <div class="form-group">
                                    <label for="rdbCodBarras"><input type="radio" id="rdbCodBarras" name="rdbEscolha" onchange="troca();" checked="checked"/> Código de Barras</label>
                                </div>

                                <div class="form-group">
                                    <label for="rdbNumSerie"><input type="radio" id="rdbNumSerie" name="rdbEscolha" onchange="troca();"/> Número de Série</label>
                                </div>

                                <hr/>

                                <div class="alert alert-warning">
                                    <b>Aviso: </b>Para Pesquisas Manuais (Sem Leitor) Basta Digitar o Número do Código de Barras e Pressionar <b><u>Enter</u></b>, Após Esse Procedimento o Botao Para Editar ou Deletar os Dados do Equipamento (Botão com a Lupa) é Liberado.
                                </div>

                                <!--Exibe a Mensagem-->
                                <?= $sEquipamento->showMessage();?>

                                <div class="form-group">
                                    <label for="txtCodBarras">Código de Barras:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="txtCodBarras" name="txtCodBarras" placeholder="Código de Barras">
                                        <span class="input-group-btn">
                                            <a href="pages/ediDel.php?numSerie=<?= $equipamentos->getNumSerie() ?>" class="btn btn-primary <?= (empty($equipamentos->getNumSerie()) && empty($equipamentos->getCodBarras())?"disabled":"")?>" id="btnBuscaCodBarras" role="button"><span class="glyphicon glyphicon-search icone"></span></a>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="txtNumSerie">Número de Série:</label>
                                    <input class="form-control" id="txtNumSerie" name="txtNumSerie" placeholder="Número de Série" disabled="disabled" value="<?= $equipamentos->getNumSerie(); ?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="txtItem">Item:</label>
                                    <input class="form-control" id="txtItem" name="txtItem" placeholder="Item" disabled="disabled" value="<?= $equipamentos->getItem(); ?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="txtTipo">Tipo:</label>
                                    <input class="form-control" id="txtTipo" name="txtTipo" placeholder="Tipo" disabled="disabled" value="<?= $equipamentos->getTipo(); ?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="txtMarca">Marca:</label>
                                    <input class="form-control" id="txtMarca" name="txtMarca" placeholder="Marca" disabled="disabled" value="<?= $equipamentos->getMarca(); ?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="txtModelo">Modelo:</label>
                                    <input class="form-control" id="txtModelo" name="txtModelo" placeholder="Modelo" disabled="disabled" value="<?= $equipamentos->getModelo(); ?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="txtPatrimonio">Patrimônio:</label>
                                    <input class="form-control" id="txtPatrimonio" name="txtPatrimonio" placeholder="Patrimônio" disabled="disabled" value="<?= $equipamentos->getPatrimonio(); ?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="txtCodEfap">Código:</label>
                                    <input class="form-control" id="txtCodEfap" name="txtCodEfap" placeholder="Código" disabled="disabled" value="<?= $equipamentos->getCodEfap(); ?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="txtOrgao">Orgão:</label>
                                    <input class="form-control" id="txtOrgao" name="txtOrgao" placeholder="Orgão" disabled="disabled" value="<?= $equipamentos->getOrgao(); ?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="txtOrigem">Origem:</label>
                                    <input class="form-control" id="txtOrigem" name="txtOrigem" placeholder="Origem" disabled="disabled" value="<?= $equipamentos->getOrigem(); ?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="txtLocal">Local:</label>
                                    <input class="form-control" id="txtLocal" name="txtLocal" placeholder="Local" disabled="disabled" value="<?= $equipamentos->getLocal(); ?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="txtSala">Sala:</label>
                                    <input class="form-control" id="txtSala" name="txtSala" placeholder="Sala" disabled="disabled" value="<?= $equipamentos->getSala(); ?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="txtEquipe">Equipe Responsável:</label>
                                    <input class="form-control" id="txtEquipe" name="txtEquipe" placeholder="Equipe" disabled="disabled" value="<?= $equipamentos->getEquipeResponsavel(); ?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="txtObs">Observação:</label>
                                    <textarea id="txtObs" name="txtObs" class="form-control" placeholder="Observações" disabled="disabled" rows="5"><?= $equipamentos->getObs(); ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="image">Imagem:</label>
                                    <a href="<?= $equipamentos->getImagem(); ?>" data-lightbox="roadtrip"><img src="<?= $equipamentos->getImagem(); ?>" id="image" name="image" class="img-responsive"/></a>
                                </div>

                                <div class="form-group">
                                    <label>Documento:</label>
                                </div>

                                <?php
                                $equipamentos->setDoc(str_replace('../', '', $equipamentos->getDoc()));
                                ?>

                                <div class="col-xs-12">
                                    <a href="<?= $equipamentos->getDoc();?>" data-lightbox="roadtrip"><img src="<?= $equipamentos->getDoc(); ?>" id="doc" name="doc" class="img-responsive"/></a>
                                </div>

                                <button type="submit" id="btnPesquisar" name="btnPesquisar" class="btn btn-success hide">Pesquisar</button>
                            </form>
                        </div>

                        <h2 class="text-center">Lista de Divergências</h2>
                        <hr/>

                        <div id="tabelaConsulta" class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="text-center">Número de Série</th>
                                    <th class="text-center">Item</th>
                                    <th class="text-center">Marca</th>
                                    <th class="text-center">Local</th>
                                    <th class="text-center">Sala</th>
                                    <th class="text-center">Consultar</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                echo $sEquipamento->selectEquipamento();
                                ?>
                                </tbody>
                            </table>

                            <div class="col-xs-12">
                                <form id="limparLista" name="limparLista" method="post" action="">
                                    <button type="submit" id="btnLimpar" name="btnLimpar" class="btn btn-danger" onclick="return confirma('Ambas as Listas Serão Limpas, Deseja Continuar?');">Limpar Listas</button>
                                </form>
                            </div>
                        </div>

                        <h2 class="text-center">Lista de Equipamentos da Sala</h2>
                        <hr/>
                        Total de: <?= $sEquipamento->countEquipamentos($_SESSION['sala'], $_SESSION['local']); ?> Equipamento(s)
                        <br/>
                        <div id="tabelaSala" class="col-xs-12 col-sm-12 col-md-6 col-lg-6 aumentar">
                            <br/>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="text-center">Consultar</th>
                                    <th class="text-center">Número de Série</th>
                                    <th class="text-center">Item</th>
                                    <th class="text-center">Marca</th>
                                    <th class="text-center">Modelo</th>
                                    <th class="text-center">Patrimônio</th>
                                    <th class="text-center">Origem</th>
                                    <th class="text-center">Local</th>
                                    <th class="text-center">Sala</th>
                                    <th class="text-center">Equipe Responsável</th>
                                    <th class="text-center">Observação</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                echo $sEquipamento->selectAllEquipamento($_SESSION['sala'], $_SESSION['local']);
                                ?>
                                </tbody>
                            </table>
                            <div class="col-xs-12">
                                <a href="pages/inventario.php" class="btn btn-success topo" title="Exportar Lista"><span class="glyphicon glyphicon-export"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php date_default_timezone_set('America/Sao_Paulo');?>
    <footer class="navbar navbar-inverse navbar-fixed-bottom">
        <h4 class="text-center">
            Data: <?= date('d/m/Y');?> -  Feito Por: Jefferson Frade
        </h4>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/lightbox.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
    </body>
    </html>
<?php
//Verificando se o Botão Selecionar foi Pressionado:
if (isset($_POST['btnSelecionar'])) {
    //Caso Seja:
    //Atribui Valor a Sessão:
    $_SESSION['sala'] = $_POST['cmbSala'];
    $_SESSION['local'] = $_POST['cmbLocal'];
    //Verifica se o Local é Vazio:
    if (!empty($_POST['cmbSala'])) {
        //Caso Não Seja:
        //Scripts:
        echo "<script type='text/javascript'>document.getElementById('txtCodBarras').disabled = false;</script>";
        echo "<script type='text/javascript'>consEquipamento.txtCodBarras.focus();</script>";
        echo $sEquipamento->cleanEquipamento();
    }
    //Script:
    echo "<script type='text/javascript'>document.getElementById('txtLocalSelecionado').value = '".$_SESSION['sala']."';</script>";
    echo "<script type='text/javascript'>location.href='index.php';</script>";
}

//Verificando se a Sessão é Vazia:
if (!empty($_SESSION['sala'])) {
    //Caso Não Seja:
    //Scripts:
    echo "<script type='text/javascript'>document.getElementById('txtCodBarras').disabled = false;</script>";
    echo "<script type='text/javascript'>consEquipamento.txtCodBarras.focus();</script>";
    echo "<script type='text/javascript'>document.getElementById('txtSalaSelecionada').value = '".$_SESSION['sala']."';</script>";
}
?>