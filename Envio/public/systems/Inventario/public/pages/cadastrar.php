<?php require_once 'topo.php';?>
<body onload="opcoes();" class="branco">
<?php
unset($_SESSION['idEvento']);
unset($_SESSION['responsavel']);
require_once 'menu.php';
menu("cadastrar.php");
?>
<main>
    <section>
        <div id="app" class="container">
            <div class="row">
                <h1 class="text-center">Cadastrar Equipamento</h1>
                <hr/>
                <div class="col-xs-12">
                    <div class="alert alert-warning"><b>Aviso: </b>Para Cadastros Manuais (Sem Leitor) Basta Digitar o Número do Código de Barras e Preencher os Outros Campos Normalmente.</div>
                    <div class="col-xs-12">
                        <br/>
                        <?php
                        if (isset($_POST['btnCadastrar'])) {
                            if (!empty($_FILES['btnDoc']['name'])) {
                                $uploaddir = '../docs/';
                                $uploadfile = $uploaddir . basename($_FILES['btnDoc']['name']);

                                if (!move_uploaded_file($_FILES['btnDoc']['tmp_name'], $uploadfile)) {
                                    echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Erro ao Efetuar Upload do Documento<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                                }
                            }

                            $equipamentos->setCodBarras($_POST['txtCodBarras']);
                            $equipamentos->setItem($_POST['txtItem']);
                            $equipamentos->setMarca($_POST['txtMarca']);
                            $equipamentos->setModelo($_POST['txtModelo']);
                            $equipamentos->setNumSerie($_POST['txtNumSerie']);
                            $equipamentos->setPatrimonio($_POST['txtPat']);
                            $equipamentos->setOrigem($_POST['txtOrigem']);
                            $equipamentos->setLocal($_POST['cmbLocal']);
                            $equipamentos->setSala($_POST['cmbSala']);
                            $equipamentos->setObs($_POST['txtObs']);
                            $equipamentos->setImagem($_POST['txtImg']);
                            $equipamentos->setCodEfap($_POST['txtCodEfap']);
                            $equipamentos->setOrgao($_POST['cmbOrgao']);
                            $equipamentos->setEquipeResponsavel($_POST['cmbEquipe']);
                            if (!empty($_FILES['btnDoc']['name'])) {
                                $equipamentos->setDoc('../docs/' . $_FILES['btnDoc']['name']);
                            } else {
                                $equipamentos->setDoc("-");
                            }
                            if (empty($_POST['txtPat'])) {
                                $equipamentos->setPatrimonio("-");
                            }

                            if (empty($_POST['txtObs'])) {
                                $equipamentos->setObs("-");
                            }
                            $equipamentos->setTipo($_POST['cmbTipo']);

                            echo $sEquipamento->insertEquipamento();
                        }
                        ?>
                    </div>
                    <form id="cadEquipamento" name="cadEquipamento" method="post" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="txtCodBarras">Código de Barras:</label>
                            <input type="text" id="txtCodBarras" name="txtCodBarras" class="form-control" placeholder="Código de Barras"/>
                        </div>

                        <div class="form-group">
                            <div class="{{ classe }}"><b>{{ msg }}</b>{{ err }}</div>
                            <label for="txtNumSerie">Número de Série:</label>
                            <input type="text" id="txtNumSerie" name="txtNumSerie" class="form-control" placeholder="Número de Série" v-model="txt" v-on:keyUp="digitar"/>
                        </div>

                        <div class="form-group">
                            <label for="txtItem">Item:</label>
                            <input type="text" id="txtItem" name="txtItem" class="form-control" placeholder="Item"/>
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
                            <input type="text" id="txtMarca" name="txtMarca" class="form-control" placeholder="Marca"/>
                        </div>

                        <div class="form-group">
                            <label for="txtModelo">Modelo:</label>
                            <input type="text" id="txtModelo" name="txtModelo" class="form-control" placeholder="Modelo"/>
                        </div>

                        <div class="form-group">
                            <label for="txtPat">Patrimônio:</label>
                            <input type="text" id="txtPat" name="txtPat" class="form-control" placeholder="Patrimônio"/>
                        </div>

                        <div class="form-group">
                            <label for="txtCodEfap">Código:</label>
                            <input type="text" id="txtCodEfap" name="txtCodEfap" class="form-control" placeholder="Código"/>
                        </div>

                        <div class="form-group">
                            <label for="cmbOrgao">Orgão:</label>
                            <select id="cmbOrgao" name="cmbOrgao" class="form-control">
                                <option value="D.E.">D.E.</option>
                                <option value="Terceiros" selected="selected">Terceiros</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="txtOrigem">Origem:</label>
                            <input type="text" id="txtOrigem" name="txtOrigem" class="form-control" placeholder="Origem"/>
                        </div>

                        <div class="form-group">
                            <label for="cmbLocal">Local:</label>
                            <select id="cmbLocal" name="cmbLocal" class="form-control"onchange="opcoes();">
                                <option value="Central de Operações">Central de Operações</option>
                                <option value="Estúdio JR I">Estúdio JR I</option>
                                <option value="Estúdio JR II">Estúdio JR II</option>
                                <option value="Estúdio Arouche">Estúdio Arouche</option>
                                <option value="Auditório I">Auditório I</option>
                                <option value="Auditório II">Auditório II</option>
                                <option value="Ocorrências/Anomalias">Ocorrências/Anomalias</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="cmbSala">Sala:</label>
                            <select id="cmbSala" name="cmbSala" class="form-control">

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="cmbEquipe">Equipe Responsável:</label>
                            <select id="cmbEquipe" name="cmbEquipe" class="form-control">
                                <option value="T.I. - Redes">T.I. - Redes</option>
                                <option value="Comunicação">Comunicação</option>
                                <option value="Suporte Remoto">Suporte Remoto</option>
                                <option value="Operações">Operações</option>
                                <option value="EFAP">EFAP</option>
                                <option value="FDE">FDE</option>
                                <option value="Desconhecido">Desconhecido</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="txtObs">Observação:</label>
                            <textarea id="txtObs" name="txtObs" class="form-control" placeholder="Formato Para Data: dd/mm/aaaa" rows="5"></textarea>
                        </div>

                        <div class="alert alert-warning">
                            <b>Aviso: </b>Para Adicionar um Link com o FGO: &lt;a href='http://www.rededosaber.sp.gov.br/fgo/editar.asp?v_cod_ocor=xxxxx' target='blank'&gt;FGO XXXXX&lt;/a&gt;<br/>
                            <b>** </b>Trocar o "X" Pelo Número do Chamado.
                        </div>

                        <div class="form-group">
                            <label for="txtImg">Imagem:</label>
                            <input type="text" id="txtImg" name="txtImg" class="form-control" placeholder="Imagem" v-model="img"/>
                        </div>

                        <div class="col-xs-12">
                            <img src="{{ img }}" class="margin-bottom"/>
                        </div>

                        <div class="form-group">
                            <label for="btnDoc">Documento:</label>
                            <input type="file" id="btnDoc" name="btnDoc" accept="image/*"/>
                            <br/>
                            <div class="alert alert-warning"><b>Aviso: </b>Anexar Somente Imagens <b>JPEG</b>.</div>
                        </div>
                        <button type="submit" class="btn btn-success" id="btnCadastrar" name="btnCadastrar">Cadastrar</button>
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