<?php
require_once 'topo.php';

if (empty($_GET['numSerie'])) {
    header("location: ../index.php");
}

$equipamentos->setNumSerie($_GET['numSerie']);

$sEquipamento->findEquipamento('nsnv');
?>

<body onload="selecionando(document.getElementById('cmbLocal').value, document.getElementById('txtSala').value);" class="branco">
<?php
unset($_SESSION['idEvento']);
unset($_SESSION['responsavel']);
require_once 'menu.php';
menu("ediDel.php");
?>
<main>
    <section>
        <div id="app" class="container">
            <div class="row">
                <h1 class="text-center">Editar/Deletar Equipamento</h1>
                <hr/>
                <div class="col-xs-12">
                    <div class="alert alert-warning">
                        <b>Aviso: </b>Para <u><b><i>Edições</i></b></u> Basta Alterar os Campos e Clicar em Editar.<br/>
                        <b>Aviso: </b>Para <u><b><i>Exclusões</i></b></u> Basta Conferir o Número de Série e Deletar.
                    </div>

                    <div class="col-xs-12">
                        <br/>
                        <?php
                        if (isset($_POST['btnEditar'])) {
                            if (!empty($_FILES['btnDoc']['name'])) {
                                $uploaddir = '../docs/';
                                $uploadfile = $uploaddir . basename($_FILES['btnDoc']['name']);

                                if (!move_uploaded_file($_FILES['btnDoc']['tmp_name'], $uploadfile)) {
                                    echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Erro ao Efetuar Upload do Documento<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                                }
                            }

                            $equipamentos->setCodBarras($_POST['txtCodBarras']);
                            $equipamentos->setNumSerie($_POST['txtNumSerie']);
                            $equipamentos->setItem($_POST['txtItem']);
                            $equipamentos->setMarca($_POST['txtMarca']);
                            $equipamentos->setModelo($_POST['txtModelo']);
                            $equipamentos->setPatrimonio($_POST['txtPat']);
                            $equipamentos->setOrigem($_POST['txtOrigem']);
                            $equipamentos->setLocal($_POST['cmbLocal']);
                            $equipamentos->setSala($_POST['cmbSala']);
                            $equipamentos->setObs($_POST['txtObs']);
                            $equipamentos->setImagem($_POST['txtImg']);
                            $equipamentos->setCodEfap($_POST['txtCodEfap']);
                            $equipamentos->setEquipeResponsavel($_POST['cmbEquipe']);
                            $equipamentos->setOrgao($_POST['cmbOrgao']);
                            if (!empty($_FILES['btnDoc']['name'])) {
                                $equipamentos->setDoc('../docs/' . $_FILES['btnDoc']['name']);
                            } else {
                                $equipamentos->setDoc($_POST['txtDoc']);
                            }
                            $equipamentos->setTipo($_POST['cmbTipo']);

                            echo $sEquipamento->updateEquipamento($_GET['numSerie']);

                            $sEquipamento->findEquipamento('nsnv');
                        }
                        if (isset($_POST['btnDeletar'])) {
                            $equipamentos->setNumSerie($_POST['txtNumSerie']);

                            echo $sEquipamento->deleteEquipamento();
                        }
                        ?>
                    </div>

                    <form id="cadEquipamento" name="cadEquipamento" method="post" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="txtCodBarras">Código de Barras:</label>
                            <input type="text" id="txtCodBarras" name="txtCodBarras" class="form-control" placeholder="Código de Barras" value="<?= $equipamentos->getCodBarras();?>"/>
                        </div>

                        <div class="form-group">
                            <div class="{{ classe }}"><b>{{ msg }}</b>{{ err }}</div>
                            <label for="txtNumSerie">Número de Série:</label>
                            <input type="text" id="txtNumSerie" name="txtNumSerie" class="form-control" placeholder="Número de Série" value="<?= $equipamentos->getNumSerie() ?>" v-model="txt" v-on:keyUp="digitar"/>
                        </div>

                        <div class="form-group">
                            <label for="txtItem">Item:</label>
                            <input type="text" id="txtItem" name="txtItem" class="form-control" placeholder="Item" value="<?= $equipamentos->getItem();?>"/>
                        </div>

                        <div class="form-group">
                            <label for="cmbTipo">Tipo:</label>
                            <select id="cmbTipo" name="cmbTipo" class="form-control">
                                <?php
                                require_once 'tipos.php';
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="txtMarca">Marca:</label>
                            <input type="text" id="txtMarca" name="txtMarca" class="form-control" placeholder="Marca"value="<?= $equipamentos->getMarca();?>"/>
                        </div>

                        <div class="form-group">
                            <label for="txtModelo">Modelo:</label>
                            <input type="text" id="txtModelo" name="txtModelo" class="form-control" placeholder="Modelo" value="<?= $equipamentos->getModelo();?>"/>
                        </div>

                        <div class="form-group">
                            <label for="txtPat">Patrimônio:</label>
                            <input type="text" id="txtPat" name="txtPat" class="form-control" placeholder="Patrimônio" value="<?= $equipamentos->getPatrimonio();?>"/>
                        </div>

                        <div class="form-group">
                            <label for="txtCodEfap">Código:</label>
                            <input type="text" id="txtCodEfap" name="txtCodEfap" class="form-control" placeholder="Código" value="<?= $equipamentos->getCodEfap()?>"/>
                        </div>

                        <div class="form-group">
                            <label for="cmbOrgao">Orgão:</label>
                            <select id="cmbOrgao" name="cmbOrgao" class="form-control">
                                <option value="D.E." <?= ($equipamentos->getOrgao() == "D.E."?" selected='selected'":"")?>>D.E.</option>
                                <option value="Terceiros" <?= ($equipamentos->getOrgao() == "Terceiros"?" selected='selected'":"")?>>Terceiros</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="txtOrigem">Origem:</label>
                            <input type="text" id="txtOrigem" name="txtOrigem" class="form-control" placeholder="Origem" value="<?= $equipamentos->getOrigem();?>"/>
                        </div>

                        <div class="form-group">
                            <label for="cmbLocal">Local:</label>
                            <select id="cmbLocal" name="cmbLocal" class="form-control"onchange="opcoes();">
                                <option value="Central de Operações">Central de Operações</option>
                                <option value="Estúdio JR I" <?= ($equipamentos->getLocal() == "Estúdio JR I"?" selected='selected'":"")?>>Estúdio JR I</option>
                                <option value="Estúdio JR II" <?= ($equipamentos->getLocal() == "Estúdio JR II"?" selected='selected'":"")?>>Estúdio JR II</option>
                                <option value="Estúdio Arouche" <?= ($equipamentos->getLocal() == "Estúdio Arouche"?" selected='selected'":"")?>>Estúdio Arouche</option>
                                <option value="Auditório I" <?= ($equipamentos->getLocal() == "Auditório I"?" selected='selected'":"")?>>Auditório I</option>
                                <option value="Auditório II" <?= ($equipamentos->getLocal() == "Auditório II"?" selected='selected'":"")?>>Auditório II</option>
                                <option value="Ocorrências/Anomalias" <?= ($equipamentos->getLocal() == "Ocorrências/Anomalias"?" selected='selected'":"")?>>Ocorrências/Anomalias</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="hidden" id="txtSala" name="txtSala" class="form-control" placeholder="Sala" value="<?= $equipamentos->getSala();?>" disabled="disabled"/>
                        </div>

                        <div class="form-group">
                            <label for="cmbSala">Sala:</label>
                            <select id="cmbSala" name="cmbSala" class="form-control">

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="cmbEquipe">Equipe Responsável:</label>
                            <select id="cmbEquipe" name="cmbEquipe" class="form-control">
                                <option value="T.I. - Redes" <?= ($equipamentos->getEquipeResponsavel() == "T.I. - Redes"?" selected='selected'":"")?>>T.I. - Redes</option>
                                <option value="Comunicação" <?= ($equipamentos->getEquipeResponsavel() == "Comunicação"?" selected='selected'":"")?>>Comunicação</option>
                                <option value="Suporte Remoto" <?= ($equipamentos->getEquipeResponsavel() == "Suporte Remoto"?" selected='selected'":"")?>>Suporte Remoto</option>
                                <option value="Operações" <?= ($equipamentos->getEquipeResponsavel() == "Operações"?" selected='selected'":"")?>>Operações</option>
                                <option value="EFAP" <?= ($equipamentos->getEquipeResponsavel() == "EFAP"?" selected='selected'":"")?>>EFAP</option>
                                <option value="FDE" <?= ($equipamentos->getEquipeResponsavel() == "FDE"?" selected='selected'":"")?>>FDE</option>
                                <option value="Desconhecido" <?= ($equipamentos->getEquipeResponsavel() == "Desconhecido"?" selected='selected'":"")?>>Desconhecido</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="txtObs">Observação:</label>
                            <textarea id="txtObs" name="txtObs" class="form-control" placeholder="Formato Para Data: dd/mm/aaaa" rows="5"><?= $equipamentos->getObs(); ?></textarea>
                        </div>

                        <div class="alert alert-warning">
                            <b>Aviso: </b>Para Adicionar um Link com o FGO: &lt;a href='http://www.rededosaber.sp.gov.br/fgo/editar.asp?v_cod_ocor=xxxxx' target='blank'&gt;FGO XXXXX&lt;/a&gt;<br/>
                            <b>** </b>Trocar o "X" Pelo Número do Chamado.
                        </div>

                        <div class="form-group">
                            <label for="txtImg">Imagem:</label>
                            <input type="text" id="txtImg" name="txtImg" class="form-control" placeholder="Imagem"  value="<?= $equipamentos->getImagem(); ?>" v-model="img"/>
                        </div>

                        <div class="col-xs-12">
                            <a href="{{ img }}" data-lightbox="roadtrip"><img src="{{ img }}" id="doc" name="doc" class="img-responsive"/></a>
                        </div>

                        <div class="form-group">
                            <label for="btnDoc">Documento:</label>
                            <input type="hidden" value="<?= $equipamentos->getDoc()?>" class="form-control" id="txtDoc" name="txtDoc" placeholder="Documento">
                            <input type="file" id="btnDoc" name="btnDoc" accept="image/jpeg"/>
                            <br/>
                            <div class="alert alert-warning"><b>Aviso: </b>Anexar Somente Imagens <b>JPEG</b>.</div>
                        </div>

                        <div class="form-group">
                            <label>Documento:</label>
                        </div>

                        <div class="col-xs-12">
                            <a href="<?= $equipamentos->getDoc();?>" data-lightbox="roadtrip"><img src="<?= $equipamentos->getDoc(); ?>" id="doc" name="doc" class="img-responsive"/></a>
                        </div>

                        <button type="submit" class="btn btn-warning" id="btnEditar" name="btnEditar" onclick="return confirma('Deseja Editar os Dados?')">Editar</button>
                        <button type="submit" class="btn btn-danger" id="btnDeletar" name="btnDeletar" onclick="return confirma('Deseja Deletar os Dados?')">Deletar</button>
                        <a href="transferencia.php?numSerie=<?= $_GET['numSerie'] ?>" class="btn btn-info" role="button">Transferir Equipamento</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
<?php require_once 'rodape.php'; ?>
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