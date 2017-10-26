<?php

namespace InvClasses\Services;

use InvClasses\DB\IConn;
use InvClasses\Tables\IEquipamento;

class ServiceEquipamento implements IServiceEquipamento
{
    //Atributos:
    private $db;
    private $equipamento;
    private $message;

    ##### CONSTRUTOR #####

    //Método Construtor para Setar os Atributos:
    public function __construct(IConn $db, IEquipamento $equipamento)
    {
        $this->db = $db->connect();
        $this->equipamento = $equipamento;
    }

    ##### INSERT #####

    //Método de Inserção de Equipamento:
    public function insertEquipamento()
    {
        $err = 0;

        //Validação:
        if (empty($this->equipamento->getCodBarras())) {
            $err = 1;
            echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Preencha o Campo Código de Barras<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }

        if (empty($this->equipamento->getNumSerie())) {
            $err = 1;
            echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Preencha o Campo Número de Série<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }

        if ($this->equipamento->getNumSerie() == "-" || $this->equipamento->getNumSerie() == "." || $this->equipamento->getNumSerie() == "/" || $this->equipamento->getNumSerie() == "\\" || $this->equipamento->getNumSerie() == "|" || $this->equipamento->getNumSerie() == " ") {
            $err = 1;
            echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Crie um Número de Série<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }

        if (empty($this->equipamento->getItem())) {
            $err = 1;
            echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Preencha o Campo Item<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }

        if (empty($this->equipamento->getImagem())) {
            $err = 1;
            echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Preencha o Campo Imagem<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }

        if (empty($this->equipamento->getMarca())) {
            $this->equipamento->setMarca("-");
        }

        if (empty($this->equipamento->getModelo())) {
            $this->equipamento->setModelo("-");
        }

        if (empty($this->equipamento->getPatrimonio())) {
            $this->equipamento->setPatrimonio("-");
        }

        if (empty($this->equipamento->getOrigem())) {
            $this->equipamento->setOrigem("-");
        }

        if (empty($this->equipamento->getCodEfap())) {
            $this->equipamento->setCodEfap("-");
        }

        if ($err != 0) {
            //Retorno:
            return false;
        }

        //Tratamento de Erros:
        try {
            //Query SQL:
            $sql = "SELECT numSerie, codBarras FROM equipamentos WHERE codBarras = :codBarras AND numSerie = :numSerie";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':codBarras', $this->equipamento->getCodBarras());
            $stmt->bindValue(':numSerie', $this->equipamento->getNumSerie());

            //Executando o Statment:
            $stmt->execute();

            $x = true;

            if ($stmt->rowCount() > 0) {
                throw new \Exception("Número de Série e Código de Barras já Cadastrado");
            }

        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            exit();
        } catch (\Exception $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            exit();
        }

        //Tratamento de Erros:
        try {
            //Query SQL:
            $sql = "INSERT INTO equipamentos(numSerie, codBarras, item, marca, modelo, patrimonio, origem, sala, `local`, obs, imagem, codEfap, orgao, equipeResponsavel, doc, tipo) VALUES(:numSerie, :codBarras, :item, :marca, :modelo, :patrimonio, :origem, :sala, :local, :obs, :imagem, :codEfap, :orgao, :equipeResponsavel, :doc, :tipo)";

            //Criando um Statment:
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':numSerie', $this->equipamento->getNumSerie());
            $stmt->bindValue(':codBarras', $this->equipamento->getCodBarras());
            $stmt->bindValue(':item', $this->equipamento->getItem());
            $stmt->bindValue(':marca', $this->equipamento->getMarca());
            $stmt->bindValue(':modelo', $this->equipamento->getModelo());
            $stmt->bindValue(':patrimonio', $this->equipamento->getPatrimonio());
            $stmt->bindValue(':origem', $this->equipamento->getOrigem());
            $stmt->bindValue(':sala', $this->equipamento->getSala());
            $stmt->bindValue(':local', $this->equipamento->getLocal());
            $stmt->bindValue(':obs', $this->equipamento->getObs());
            $stmt->bindValue(':imagem', $this->equipamento->getImagem());
            $stmt->bindValue(':codEfap', $this->equipamento->getCodEfap());
            $stmt->bindValue(':orgao', $this->equipamento->getOrgao());
            $stmt->bindValue(':equipeResponsavel', $this->equipamento->getEquipeResponsavel());
            $stmt->bindValue(':doc', $this->equipamento->getDoc());
            $stmt->bindValue(':tipo', $this->equipamento->getTipo());

            try {
                if ($stmt->execute() == true) {
                    return "<div class='alert alert-success alert-dismissible' role='alert'>Equipamento Cadastrado com Sucessso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                } else {
                    return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b>" . print_r($stmt->errorInfo()) . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                }
            } catch (\PDOException $e) {
                //Caso Haja Erro:
                return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    ##### SELECT ######

    //Método de Exibição do Equipamento:
    public function selectEquipamento()
    {
        try {
            //Quey SQL:
            $sql = "SELECT numSerie, item, marca, origem, `local`, attr, sala FROM temp WHERE usuario = :usuario AND attr = 'danger'";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':usuario', $_SESSION['user']);

            //Executando o Statment:
            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                //Criando um Array Para Atribuir os Dados:
                $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

                $tabela = "";

                //Loop de Exibição:
                do {
                    $tabela .= "<tr>";
                    $tabela .= "<td class='text-center " . $dados['attr'] . "'>" . $dados['numSerie'] . "</td>";
                    $tabela .= "<td class='text-center " . $dados['attr'] . "'>" . $dados['item'] . "</td>";
                    $tabela .= "<td class='text-center " . $dados['attr'] . "'>" . $dados['marca'] . "</td>";
                    $tabela .= "<td class='text-center " . $dados['attr'] . "'>" . $dados['local'] . "</td>";
                    $tabela .= "<td class='text-center " . $dados['attr'] . "'>" . $dados['sala'] . "</td>";
                    $tabela .= "<td class='text-center " . $dados['attr'] . "'><a class='btn btn-primary' href='pages/ediDel.php?numSerie=" . $dados['numSerie'] . "'><span class='glyphicon glyphicon-search'></span></td>";
                    $tabela .= "</tr>";
                } while ($dados = $stmt->fetch(\PDO::FETCH_ASSOC));

                //Retorno:
                return $tabela;
            }
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }


    //Método de Retorno dos Equipamentos de uma Determindada Sala:
    public function selectAllEquipamento($sala, $local)
    {
        if (empty($sala)) {
            return "";
        }

        //Tratamento de Erros:
        try {
            //Quey SQL:
            $sql = "SELECT numSerie, item, marca, origem, `local`, attr FROM temp WHERE usuario = :usuario";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':usuario', $_SESSION['user']);

            //Executando o Statment:
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $selecionado = [];
                //Criando um Array Para Atribuir os Dados:
                while ($dados = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                    $selecionado[$dados['numSerie']] = $dados['attr'];
                }
            }

            //Query SQL:
            $sql = "SELECT numSerie, item, marca, modelo, patrimonio, origem, sala, `local`, obs, equipeResponsavel FROM equipamentos WHERE `local` = :local AND sala = :sala ORDER BY item";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':sala', $sala);
            $stmt->bindValue(':local', $local);

            //Executando o Statment:
            $stmt->execute();

            $table = "";

            //Jogando os Dados em um Array:
            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

            do {
                if (empty($dados)) {
                    return "";
                }

                $table .= "<tr>";
                $table .= "<td class='text-center " . (empty($selecionado[$dados['numSerie']]) ? "" : $selecionado[$dados['numSerie']]) . "'><a class='btn btn-primary' href='pages/ediDel.php?numSerie=" . $dados['numSerie'] . "'><span class='glyphicon glyphicon-search'></span></td>";
                $table .= "<td class='text-center " . (empty($selecionado[$dados['numSerie']]) ? "" : $selecionado[$dados['numSerie']]) . "'>" . $dados['numSerie'] . "</td>";
                $table .= "<td class='text-center " . (empty($selecionado[$dados['numSerie']]) ? "" : $selecionado[$dados['numSerie']]) . "'>" . $dados['item'] . "</td>";
                $table .= "<td class='text-center " . (empty($selecionado[$dados['numSerie']]) ? "" : $selecionado[$dados['numSerie']]) . "'>" . $dados['marca'] . "</td>";
                $table .= "<td class='text-center " . (empty($selecionado[$dados['numSerie']]) ? "" : $selecionado[$dados['numSerie']]) . "'>" . $dados['modelo'] . "</td>";
                $table .= "<td class='text-center " . (empty($selecionado[$dados['numSerie']]) ? "" : $selecionado[$dados['numSerie']]) . "'>" . $dados['patrimonio'] . "</td>";
                $table .= "<td class='text-center " . (empty($selecionado[$dados['numSerie']]) ? "" : $selecionado[$dados['numSerie']]) . "'>" . $dados['origem'] . "</td>";
                $table .= "<td class='text-center " . (empty($selecionado[$dados['numSerie']]) ? "" : $selecionado[$dados['numSerie']]) . "'>" . $dados['local'] . "</td>";
                $table .= "<td class='text-center " . (empty($selecionado[$dados['numSerie']]) ? "" : $selecionado[$dados['numSerie']]) . "'>" . $dados['sala'] . "</td>";
                $table .= "<td class='text-center " . (empty($selecionado[$dados['numSerie']]) ? "" : $selecionado[$dados['numSerie']]) . "'>" . $dados['equipeResponsavel'] . "</td>";
                $table .= "<td class='text-center " . (empty($selecionado[$dados['numSerie']]) ? "" : $selecionado[$dados['numSerie']]) . "'>" . $dados['obs'] . "</td>";
                $table .= "</tr>";
            } while ($dados = $stmt->fetch(\PDO::FETCH_ASSOC));

            return $table;
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método de Contagem de Equipamentos:
    public function countEquipamentos($sala, $local)
    {
        if (empty($sala)) {
            return 0;
        }

        //Tratamento de Erros:
        try {
            $sql = "SELECT numSerie, item, marca, modelo, patrimonio, origem, sala, `local`, obs FROM equipamentos WHERE sala = :sala AND `local` = :local";

            //Criando o Statment:k
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':sala', $sala);
            $stmt->bindValue(':local', $local);

            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

            //Executando o Statment:
            $stmt->execute();

            $total = 0;

            //Loop de Exibição:
            do {
                $total++;
            } while ($dados = $stmt->fetch(\PDO::FETCH_ASSOC));

            //Retorno:
            $total--;
            return $total;
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método de Busca de Equipamento:
    public function findEquipamento($contorle)
    {
        //Tratmaneto de Erros:
        try {
            //Query SQL:
            if ($contorle == 'cb') {
                $sql = "SELECT numSerie, codBarras, item, marca, modelo, patrimonio, origem, sala, `local`, obs, imagem, codEfap, orgao, doc, equipeResponsavel, tipo FROM equipamentos WHERE codBarras = :codBarras";
            } else {
                $sql = "SELECT numSerie, codBarras, item, marca, modelo, patrimonio, origem, sala, `local`, obs, imagem, codEfap, orgao, doc, equipeResponsavel, tipo FROM equipamentos WHERE numSerie = :numSerie";
            }


            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            if ($contorle == 'cb') {
                $stmt->bindValue(':codBarras', $this->equipamento->getCodBarras());
            } else {
                $stmt->bindValue(':numSerie', $this->equipamento->getNumSerie());
            }

            try {
                //Executando o Statment:
                $stmt->execute();
            } catch (\PDOException $e) {
                //Caso Haja Erro:
                return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }

            if ($stmt->rowCount() == 0) {
                $this->equipamento->setCodBarras("");
                echo "<audio src='media/error.mp3' autoplay></audio>";
                $this->message("Equipamento Não Encontrado", "alert alert-danger alert-dismissible");
                return false;
            }

            //Adicionando os Dados num Array:
            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

            //Setando os Métodos:
            $this->equipamento->setCodBarras($dados['codBarras']);
            $this->equipamento->setItem($dados['item']);
            $this->equipamento->setMarca($dados['marca']);
            $this->equipamento->setModelo($dados['modelo']);
            $this->equipamento->setNumSerie($dados['numSerie']);
            $this->equipamento->setPatrimonio($dados['patrimonio']);
            $this->equipamento->setOrigem($dados['origem']);
            $this->equipamento->setLocal($dados['local']);
            $this->equipamento->setSala($dados['sala']);
            $this->equipamento->setObs($dados['obs']);
            $this->equipamento->setImagem($dados['imagem']);
            $this->equipamento->setCodEfap($dados['codEfap']);
            $this->equipamento->setOrgao($dados['orgao']);
            $this->equipamento->setEquipeResponsavel($dados['equipeResponsavel']);
            $this->equipamento->setDoc($dados['doc']);
            $this->equipamento->setTipo($dados['tipo']);

            //Verificando se é a index.php que Está Chamando o Método:
            if ($contorle == 'cb' || $contorle == 'ns') {
                //Caso Seja:
                //Chamando o Método de Verificação do Equipamento (*CHAMADA DE MÉTODO*):
                $this->verifyEquipamento($dados['sala'], $_SESSION['sala'], $dados['numSerie'], $dados['item'],
                    $dados['marca'], $dados['modelo'], $dados['local'], $dados['origem'], $_SESSION['local']);
            }
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método de Verificação do Equipamento:
    public function verifyEquipamento(
        $salaOrigem,
        $sala,
        $numSerie,
        $item,
        $marca,
        $modelo,
        $localOrigem,
        $origem,
        $local
    ) {
        //Verificando se o Local Está Vazio:
        if (empty($sala)) {
            //Caso Esteja:
            //Seta Vazio ao Código de Barras:
            $this->equipamento->setCodBarras("");
            //Exibe uma Mensagem:
            $this->message("Selecione um Local e Sala", "alert alert-danger");
            //Retorna Falso:
            return false;
        }

        //Tratamento de Erros:
        try {
            //Query SQL de Busca:
            $sql = "SELECT numSerie FROM temp WHERE numSerie = :numSerie AND usuario = :usuario";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':numSerie', $numSerie);
            $stmt->bindValue(':usuario', $_SESSION['user']);

            //Executando o Statment:
            $stmt->execute();

            //Verificando se há Registros:
            if ($stmt->rowCount() > 0) {
                //Caso Haja:
                $this->equipamento->setCodBarras("");
                //Scripts:
                $this->message('Equipamento Já Escaneado', 'alert alert-danger');
                echo "<audio src='media/error.mp3' autoplay></audio>";
                echo "<script type='text/javascript'>consEquipamento.txtCodBarras.focus();</script>";
                //Retorno:
                return false;
            }
            //Script:
            echo "<script type='text/javascript'>consEquipamento.txtCodBarras.focus();</script>";
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }

        //Verificando se a Origem do Equipamento é igual a Sala:
        if ($salaOrigem == $sala && $localOrigem == $local) {
            //Caso Seja:
            $atributos = "success";
            echo "<audio src='media/acorde.mp3' autoplay></audio>";
        } else {
            //Caso Não Seja:
            $atributos = "danger";
            echo "<audio src='media/error.mp3' autoplay></audio>";
        }

        //Método de Insert na Tabela Temporária:
        $this->verifyInsertEquipamento($numSerie, $item, $marca, $modelo, $origem, $localOrigem, $atributos,
            $salaOrigem);
    }

    ##### MÉTODOS COMPLEMENATARES #####

    //Método Complementar de verifyEquipamento:
    public function verifyInsertEquipamento($numSerie, $item, $marca, $modelo, $origem, $local, $atributos, $salaOrigem)
    {
        //Tratamento de Erros:
        try {
            //Query SQL de Inserção:
            $sql = "INSERT INTO temp(numSerie, item, marca, modelo, origem, `local`, attr, usuario, sala) VALUES(:numSerie, :item, :marca, :modelo, :origem, :local, :attr,:usuario, :sala)";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':numSerie', $numSerie);
            $stmt->bindValue(':item', $item);
            $stmt->bindValue(':marca', $marca);
            $stmt->bindValue(':modelo', $modelo);
            $stmt->bindValue(':origem', $origem);
            $stmt->bindValue(':attr', $atributos);
            $stmt->bindValue(':local', $local);
            $stmt->bindValue(':usuario', $_SESSION['user']);
            $stmt->bindValue(':sala', $salaOrigem);

            //Executando o Statment:
            $stmt->execute();
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    ##### UPDATE #####

    //Método de Edição do Equipamento:
    public function updateEquipamento($numSerie = "")
    {
        //Tratamento de Erros:
        try {
            //Query SQL:
            $sql = "SELECT numSerie, codBarras FROM equipamentos WHERE codBarras = :codBarras AND numSerie = :numSerie";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':codBarras', $this->equipamento->getCodBarras());
            $stmt->bindValue(':numSerie', $this->equipamento->getNumSerie());

            //Executando o Statment:
            $stmt->execute();

        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }

        //Tratamento de Erros:
        try {
            //Query SQL:
            $sql = "UPDATE equipamentos SET codBarras = :codBarras, numSerie = :numSerie, item = :item, marca = :marca, modelo = :modelo, patrimonio = :patrimonio, origem = :origem, sala = :sala, `local` = :local, obs = :obs, imagem = :imagem, codEfap = :codEfap, equipeResponsavel = :equipeResponsavel, orgao = :orgao, doc = :doc, tipo = :tipo WHERE numSerie = :nSerie";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            $err = 0;

            //Validações:
            if (empty($this->equipamento->getCodBarras())) {
                echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Preencha o Campo Código de Barras<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $err = 1;
            }

            if (empty($this->equipamento->getNumSerie())) {
                echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Preencha o Campo Número de Série<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $err = 1;
            }

            if ($this->equipamento->getNumSerie() == "-" || $this->equipamento->getNumSerie() == "." || $this->equipamento->getNumSerie() == "/" || $this->equipamento->getNumSerie() == "\\" || $this->equipamento->getNumSerie() == "|" || $this->equipamento->getNumSerie() == " ") {
                $err = 1;
                echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Crie um Número de Série<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }

            if (empty($this->equipamento->getItem())) {
                echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Preencha o Campo Item<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $err = 1;
            }

            if (empty($this->equipamento->getMarca())) {
                echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Preencha o Campo Marca<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $err = 1;
            }

            if (empty($this->equipamento->getModelo())) {
                echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Preencha o Campo Modelo<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $err = 1;
            }

            if (empty($this->equipamento->getPatrimonio())) {
                $this->equipamento->setPatrimonio("-");
            }

            if (empty($this->equipamento->getOrigem())) {
                $this->equipamento->setOrigem("-");
            }

            if (empty($this->equipamento->getSala())) {
                echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Preencha o Campo Sala<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $err = 1;
            }

            if (empty($this->equipamento->getLocal())) {
                echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Preencha o Campo Local<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $err = 1;
            }

            if (empty($this->equipamento->getCodEfap())) {
                $this->equipamento->setCodEfap("-");
            }

            //Verificando se há Erros:
            if ($err != 0) {
                //Retorno:
                return false;
            }

            //Adicionando as Variáveis:
            $stmt->bindValue(':nSerie', $numSerie);
            $stmt->bindValue(':codBarras', $this->equipamento->getCodBarras());
            $stmt->bindValue(':numSerie', $this->equipamento->getNumSerie());
            $stmt->bindValue(':item', $this->equipamento->getItem());
            $stmt->bindValue(':marca', $this->equipamento->getMarca());
            $stmt->bindValue(':modelo', $this->equipamento->getModelo());
            $stmt->bindValue(':patrimonio', $this->equipamento->getPatrimonio());
            $stmt->bindValue(':origem', $this->equipamento->getOrigem());
            $stmt->bindValue(':sala', $this->equipamento->getSala());
            $stmt->bindValue(':local', $this->equipamento->getLocal());
            $stmt->bindValue(':obs', $this->equipamento->getObs());
            $stmt->bindValue(':imagem', $this->equipamento->getImagem());
            $stmt->bindValue(':numSerie', $this->equipamento->getNumSerie());
            $stmt->bindValue(':codEfap', $this->equipamento->getCodEfap());
            $stmt->bindValue(':equipeResponsavel', $this->equipamento->getEquipeResponsavel());
            $stmt->bindValue(':orgao', $this->equipamento->getOrgao());
            $stmt->bindValue(':doc', $this->equipamento->getDoc());
            $stmt->bindValue(':tipo', $this->equipamento->getTipo());

            //Tratamento de Erros:
            try {
                if ($stmt->execute() == true) {
                    $this->removeEquipamento();
                    return "<div class='alert alert-success alert-dismissible' role='alert'>Dados do Equipamento Atualizados com Sucessso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                }
            } catch (\PDOException $e) {
                //Caso Haja Erro:
                return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    ##### DELETE #####

    //Método de Exclusão do Documento:
    public function deleteDoc()
    {
        //Tratamento de Erros:
        try {
            //Query SQL:
            $sql = "SELECT doc FROM equipamentos WHERE numSerie = :numSerie";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':numSerie', $this->equipamento->getNumSerie());

            //Executando o Statment:
            $stmt->execute();

            //Jogando os Dados em um Array:
            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

            //Deletando a Imagem:
            chmod('../docs/' . $dados['doc'], 0777);
            unlink('../docs/' . $dados['doc']);
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método que Limpa a Lista:
    public function cleanEquipamento()
    {
        //Tratamento de Erros:
        try {
            //Query SQL:
            $sql = "DELETE FROM temp WHERE usuario = :usuario";

            //Criando Statment:
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':usuario', $_SESSION['user']);

            //Tratamento de Erros:
            try {
                //Verificando se o Statment foi Executado:
                if ($stmt->execute() == true) {
                    //Chamando o Método de Exibição:
                    $this->selectEquipamento();
                }
            } catch (\PDOException $e) {
                //Caso Haja Erro:
                return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método de Exclusão de Equipamento:
    public function deleteEquipamento()
    {
        //Tratatmento de Erros:
        try {
            //Query SQL:
            $sql = "DELETE FROM equipamentos WHERE numSerie = :numSerie";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            $err = 0;

            //Validação:
            if (empty($this->equipamento->getNumSerie())) {
                echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Preencha o Campo Número de Série <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $err = 1;
            }

            //Verificando se há Erros:
            if ($err != 0) {
                return false;
            }

            //Adicionando as Variáveis:
            $stmt->bindValue(':numSerie', $this->equipamento->getNumSerie());

            //Tratamento de Erros:
            try {
                //Verificando se o Statment Foi Executado:
                if ($stmt->execute()) {
                    //Chamada do Método de Remoção da Lista:
                    $this->removeEquipamento();
                    //Chamada de Método de Exclusão da Imagem:
                    //$this->deleteDoc();
                    return "<div class='alert alert-success alert-dismissible' role='alert'>Equipamento Deletado com Sucesso <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                } else {
                    return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Erro ao Deletar Equipamento <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                }
            } catch (\PDOException $e) {
                //Caso Haja Erro:
                return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método de Remoção da Lista de Escaneados:
    public function removeEquipamento()
    {
        //Tratamento de Erros:
        try {
            //Query SQL:
            $sql = "DELETE FROM temp WHERE numSerie = :numSerie";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':numSerie', $this->equipamento->getNumSerie());

            //Tratamento de Erros:
            try {
                $stmt->execute();
            } catch (\PDOException $e) {
                //Caso Haja Erro:
                return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    public function message($msg, $attr)
    {
        $this->message = "<div class='" . $attr . "'>" . $msg . "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    }

    public function showMessage()
    {
        return $this->message;
    }

    //Conta de Equipamentos da Central de Operações:
    public function countCentral()
    {
        //Tratamento de Erros:
        try {
            //Query SQL:
            $sql = "SELECT COUNT(*) FROM equipamentos WHERE `local` = 'Central de Operações'";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Executando o Statment:
            $stmt->execute();

            //Jogando os Dados em um Array:
            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $dados['COUNT(*)'];
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Conta de Equipamentos das Gerações:
    public function countGeracao()
    {
        //Tratamento de Erros:
        try {
            $arrLabels = array(
                0 => "Estúdio JR I",
                1 => "Estúdio JR II",
                2 => "Estúdio Arouche",
                3 => "Auditório I",
                4 => "Auditório II"
            );

            //Query SQL:
            $sql = "SELECT COUNT(*) FROM equipamentos WHERE `local` = :local";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            $soma = 0;
            for ($i = 0; $i < count($arrLabels); $i++) {
                //Adicionando as Variáveis:
                $stmt->bindValue(':local', $arrLabels[$i]);

                //Executando o Statment:
                $stmt->execute();

                //Jogando os Dados em um Array:
                $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

                $soma = $soma + $dados['COUNT(*)'];
            }

            return $soma;
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método de Retorno das Salas:
    public function returnSalas()
    {
        //Tratamento de Erros:
        try {
            //Query SQL:
            $sql = "SELECT sala FROM equipamentos WHERE `local` = 'Central de Operações'";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Executando o Statment:
            $stmt->execute();

            $temp = array();
            $reg = array();
            $i = 0;

            //Loop de Exibição:
            while ($dados = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $temp[$i] = $dados['sala'];
                $i++;
            }

            $temp = array_unique($temp);

            $i = 0;
            foreach ($temp as $item) {
                $reg[$i] = $item;
                $i++;
            }

            //Retorno:
            return $reg;
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método que Monta o Gráfico da Central de Operações:
    public function graphicCentral()
    {
        $t = array();
        //Tratamento de Erros:
        try {
            //Query SQL:
            $sql = "SELECT COUNT(*) FROM equipamentos WHERE sala = :sala";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            $j = 0;
            $arrLabels = array();
            $sala = $this->returnSalas();

            //Loop:
            for ($i = 0; $i < count($sala); $i++) {
                //Adicionando as Variáveis:
                $stmt->bindValue(':sala', $sala[$i]);

                //Executando o Statment:
                $stmt->execute();

                $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

                $t[$j] = $dados['COUNT(*)'];

                $arrLabels[$sala[$i]] = $t[$j];
                $j++;
            }

            //Retorno:
            return $t;
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método que Monta o Gráfico das Gerações:
    public function graphicGeracao()
    {
        $ger = array();
        //Tratamento de Erros:
        try {
            $arrLabels = array(
                0 => "Estúdio JR I",
                1 => "Estúdio JR II",
                2 => "Estúdio Arouche",
                3 => "Auditório I",
                4 => "Auditório II"
            );

            //Query SQL:
            $sql = "SELECT COUNT(*) FROM equipamentos WHERE `local` = :local";

            $stmt = $this->db->prepare($sql);
            $j = 0;

            for ($i = 0; $i < count($arrLabels); $i++) {

                //Adicionando as Variáveis:
                $stmt->bindValue(':local', $arrLabels[$i]);

                //Executando o Statment:
                $stmt->execute();

                $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

                $ger[$i] = $dados['COUNT(*)'];

                $arrLabels[$j] = $ger[$i];
                $j++;
            }

            //Retorno:
            return $arrLabels;
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método que Pega a Marca Todos os Equipamentos de um Determinado Tipo:
    public function arrTipo()
    {
        //Tratamento de Erros:
        try {
            //Query SQL:
            $sql = "SELECT marca FROM equipamentos WHERE tipo = :tipo";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':tipo', $this->equipamento->getTipo());

            //Executando o Statment:
            $stmt->execute();

            $temp = array();
            $reg = array();
            $i = 0;

            //Loop de Exibição:
            while ($dados = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $temp[$i] = $dados['marca'];
                $i++;
            }

            $temp = array_unique($temp);

            $i = 0;
            foreach ($temp as $item) {
                $reg[$i] = $item;
                $i++;
            }

            //Retorno:
            return $reg;

        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método que Pega a Marca Todas as Equipes Responsáveis:
    public function arrEquipe()
    {
        //Tratamento de Erros:
        try {
            //Query SQL:
            $sql = "SELECT equipeResponsavel FROM equipamentos";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Executando o Statment:
            $stmt->execute();

            $temp = array();
            $reg = array();
            $i = 0;

            //Loop de Exibição:
            while ($dados = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                if ($dados['equipeResponsavel'] != null) {
                    $temp[$i] = $dados['equipeResponsavel'];
                    $i++;
                }
            }

            $temp = array_unique($temp);

            $i = 0;
            foreach ($temp as $item) {
                $reg[$i] = $item;
                $i++;
            }

            //Retorno:
            return $reg;

        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método que Pega o Item Todos os Equipamentos de um Determinado Tipo:
    public function arrItem()
    {
        //Tratamento de Erros:
        try {
            //Query SQL:
            $sql = "SELECT item FROM equipamentos WHERE tipo = :tipo";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':tipo', $this->equipamento->getTipo());

            //Executando o Statment:
            $stmt->execute();

            $temp = array();
            $reg = array();
            $i = 0;

            //Loop de Exibição:
            while ($dados = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $temp[$i] = $dados['item'];
                $i++;
            }

            $temp = array_unique($temp);

            $i = 0;
            foreach ($temp as $item) {
                $reg[$i] = $item;
                $i++;
            }

            //Retorno:
            return $reg;

        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método que Pega o Item Todos os Modelos de um Determinado Tipo:
    public function arrModelo()
    {
        //Tratamento de Erros:
        try {
            //Query SQL:
            $sql = "SELECT modelo FROM equipamentos WHERE tipo = :tipo";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':tipo', $this->equipamento->getTipo());

            //Executando o Statment:
            $stmt->execute();

            $temp = array();
            $reg = array();
            $i = 0;

            //Loop de Exibição:
            while ($dados = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $temp[$i] = $dados['modelo'];
                $i++;
            }

            $temp = array_unique($temp);

            $i = 0;
            foreach ($temp as $item) {
                $reg[$i] = $item;
                $i++;
            }

            //Retorno:
            return $reg;

        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método que Constrói Gráficos da Central de Operações (Baseado em Marca):
    public function graphItemGeral()
    {
        //Tratamento de Erros:
        try {

            //Query SQL:
            $sql = "SELECT COUNT(*) FROM equipamentos WHERE marca = :marca AND tipo = :tipo AND sala = :sala";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Arrays:
            $arrLabels = array();
            $item = $this->arrTipo();
            $arrSala = $this->returnSalas();
            $t = array();

            //Adicionando Variáveis:
            $stmt->bindValue(':tipo', $this->equipamento->getTipo());

            //Loop que Percorre o Array de Salas:
            for ($i = 0; $i < count($arrSala); $i++) {
                //Adicionando Variável Conforme o Índice do Array:
                $stmt->bindValue(':sala', $arrSala[$i]);
                //Igualando a Posição a 0:
                $t[$i] = 0;
                //Loop que Percorre o Array de Itens (Marca):
                for ($k = 0; $k < count($item); $k++) {
                    //Adicionando Variáveis:
                    $stmt->bindValue(':marca', $item[$k]);

                    //Executando o Statment:
                    $stmt->execute();

                    //Jogando os Dados no Array:
                    $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

                    //Atribuindo ao Array $t com Índice $i
                    $t[$i] = $t[$i] + $dados['COUNT(*)'];
                }
            }

            //Retorno:
            return $t;
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método que Constrói Gráficos das Gerações (Baseado em Marca):
    public function graphItemGeracao()
    {
        //Tratamento de Erros:
        try {
            $arrLabels = array(
                0 => "Estúdio JR I",
                1 => "Estúdio JR II",
                2 => "Estúdio Arouche",
                3 => "Auditório I",
                4 => "Auditório II"
            );

            //Query SQL:
            $sql = "SELECT COUNT(*) FROM equipamentos WHERE marca = :marca AND `local` = :local AND tipo = :tipo";

            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':tipo', $this->equipamento->getTipo());

            $marca = $this->arrTipo();
            $t = array();

            //Loop de Local:
            for ($i = 0; $i < count($arrLabels); $i++) {
                ;
                //Igualando a Posição $k do Array $t a 0:
                $t[$i] = 0;

                //Loop de Marca:
                for ($j = 0; $j < count($marca); $j++) {
                    //Adicionando Variáveis:
                    $stmt->bindValue(':local', $arrLabels[$i]);
                    $stmt->bindValue(':marca', $marca[$j]);

                    //Executando o Statment:
                    $stmt->execute();

                    //Jogandos os Dados num Array:
                    $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

                    $t[$i] = $t[$i] + $dados['COUNT(*)'];
                }
            }

            //Retorno:
            return $t;
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método que Monta o Gráfico (Doughnut) de Equipamentos e Seus Modelos:
    public function graphDoughnut()
    {
        //Tratamento de Erros:
        try {
            //Query SQL:
            $sql = "SELECT item, marca, modelo, COUNT(item) FROM equipamentos WHERE tipo = :tipo AND item = :item AND marca = :marca AND modelo = :modelo";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':tipo', $this->equipamento->getTipo());

            $arr = array();
            $marca = $this->arrTipo();
            $item = $this->arrItem();
            $modelo = $this->arrModelo();

            for ($i = 0; $i < count($marca); $i++) {
                for ($j = 0; $j < count($item); $j++) {
                    for ($l = 0; $l < count($modelo); $l++) {
                        //Adicionando as Variáveis:
                        $stmt->bindValue(':marca', $marca[$i]);
                        $stmt->bindValue(':item', trim($item[$j]));
                        $stmt->bindValue(':modelo', $modelo[$l]);

                        //Executando o Statment:
                        $stmt->execute();

                        //Jogando os Dados em um Array:
                        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

                        //Verifica se Há Mais de 0 Registros:
                        if ($dados['COUNT(item)'] > 0) {
                            //Caso Haja:
                            //Jogando o Valor no Array:
                            $arr[$dados['marca'] . " " . trim($dados['item']) . " Modelo: " . $dados['modelo']] = $dados['COUNT(item)'];
                        }
                    }
                }
            }

            $reg = array();
            $keys = array_keys($arr);

            $k = 0;
            $titulos = $this->titleDoughnut();
            for ($i = 0; $i < count($titulos); $i++) {
                for ($j = 0; $j < count($keys); $j++) {
                    if ($titulos[$i] == $keys[$j]) {
                        $reg[$k] = $arr[$keys[$j]];
                        $k++;
                    }
                }
            }

            return $reg;
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método que Pega os Títulos do Gráfico em Rosquinha (Doughnut):
    public function titleDoughnut()
    {
        //Tratamento de Erros:
        try {
            //Query SQL:
            $sql = "SELECT COUNT(*) FROM equipamentos WHERE tipo = :tipo AND item = :item AND marca = :marca AND modelo = :modelo";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':tipo', $this->equipamento->getTipo());

            $arr = array();
            $marca = $this->arrTipo();
            $item = $this->arrItem();
            $modelo = $this->arrModelo();
            $k = 0;

            for ($i = 0; $i < count($marca); $i++) {
                $stmt->bindValue(':marca', $marca[$i]);
                for ($j = 0; $j < count($item); $j++) {
                    $stmt->bindValue(':item', $item[$j]);
                    for ($l = 0; $l < count($modelo); $l++) {
                        //Adicionando as Variáveis:


                        $stmt->bindValue(':modelo', $modelo[$l]);

                        //Executando o Statment:
                        $stmt->execute();

                        //Jogando os Dados em um Array:
                        $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

                        //Verifica se Há Mais de 0 Registros:
                        if ($dados['COUNT(*)'] > 0) {
                            //Caso Haja:
                            //Jogando o Valor no Array:
                            $arr[$k] = $marca[$i] . " " . trim($item[$j]) . " Modelo: " . $modelo[$l];

                            //Incremento:
                            $k++;
                        }
                    }
                }
            }

            $temp = array_unique($arr);
            $reg = array();
            $i = 0;
            foreach ($temp as $item) {
                $reg[$i] = $item;
                $i++;
            }

            //Retorno:
            return $reg;
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método que Monta o Gráfico da Equipe Responsável:
    public function graphEquipe()
    {
        //Tratamento de Erros:
        try {
            //Query SQL:
            $sql = "SELECT COUNT(*) FROM equipamentos WHERE equipeResponsavel = :equipeResponsavel";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            $arr = array();
            $j = 0;
            $equipe = $this->arrEquipe();

            //Loop Para Adicionar as Variáveis:
            for ($i = 0; $i < count($equipe); $i++) {
                //Adicionado as Variáveis:
                $stmt->bindValue(':equipeResponsavel', $equipe[$i]);

                //Executando o Statment:
                $stmt->execute();

                if ($equipe[$i] != null) {
                    //Jogando os Dados num Array:
                    $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

                    $arr[$j] = $dados['COUNT(*)'];
                    $j++;
                }
            }

            //Retorno:
            return $arr;
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método que Conta os Equipamentos de Determinado Tipo na Central de Operações:
    public function countTipoCentral()
    {
        //Tratamento de Erros:
        try {
            //Query SQL:
            $sql = "SELECT COUNT(*) FROM equipamentos WHERE `local` = :local AND tipo = :tipo";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':local', 'Central de Operações');
            $stmt->bindValue(':tipo', $this->equipamento->getTipo());

            //Executando o Statment:
            $stmt->execute();

            //Jogando os Dados em um Array:
            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

            //Retorno:
            return $dados['COUNT(*)'];
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método que Conta as Ocorrências/Anomalias:
    public function countOcorrenciasAnomalias()
    {
        try {
            //Query SQL:
            $sql = "SELECT COUNT(*) FROM equipamentos WHERE `local` = 'Ocorrências/Anomalias'";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Executando o Statment:
            $stmt->execute();

            //Jogando os Dados num Array:
            $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

            //Retorno:
            return $dados['COUNT(*)'];
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }

    //Método que Conta os Equipamentos de Determinado Tipo nas Gerações:
    public function countTipoGeracao()
    {
        //Tratamento de Erros:
        try {
            $arrLabels = array(
                0 => "Estúdio JR I",
                1 => "Estúdio JR II",
                2 => "Estúdio Arouche",
                3 => "Auditório I",
                4 => "Auditório II"
            );

            //Query SQL:
            $sql = "SELECT COUNT(*) FROM equipamentos WHERE `local` = :local AND tipo = :tipo";

            //Criando o Statment:
            $stmt = $this->db->prepare($sql);

            //Adicionando as Variáveis:
            $stmt->bindValue(':tipo', $this->equipamento->getTipo());

            $val = 0;

            //Loop para Atribuição das Variáveis:
            for ($i = 0; $i < count($arrLabels); $i++) {
                //Adicionando as Variáveis:
                $stmt->bindValue(':local', $arrLabels[$i]);

                //Executando o Statment:
                $stmt->execute();

                //Jogando os Dados em um Array:
                $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

                $val = $val + $dados['COUNT(*)'];
            }

            //Retorno:
            return $val;
        } catch (\PDOException $e) {
            //Caso Haja Erro:
            return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> " . $e->getMessage() . " <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
        }
    }
}
