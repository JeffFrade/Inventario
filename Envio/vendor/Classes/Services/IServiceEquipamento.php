<?php

namespace InvClasses\Services;

use InvClasses\DB\IConn;
use InvClasses\Tables\IEquipamento;

interface IServiceEquipamento
{
    //Método Construtor para Setar os Atributos:
    public function __construct(IConn $db, IEquipamento $equipamento);
    //Método de Inserção de Equipamento:
    public function insertEquipamento();
    //Método de Exibição do Equipamento:
    public function selectEquipamento();
    //Método de Retorno dos Equipamentos de uma Determindada Sala:
    public function selectAllEquipamento($sala, $local);
    //Método de Contagem de Equipamentos:
    public function countEquipamentos($sala, $local);
    //Método de Busca de Equipamento:
    public function findEquipamento($contorle);
    //Método de Verificação do Equipamento:
    public function verifyEquipamento($salaOrigem, $sala, $numSerie, $item, $marca, $modelo, $localOrigem, $origem, $local);
    //Método Complementar de verifyEquipamento:
    public function verifyInsertEquipamento($numSerie, $item, $marca, $modelo, $origem, $local, $atributos, $salaOrigem);
    //Método de Edição do Equipamento:
    public function updateEquipamento($numSerie = "");
    //Método de Exclusão do Documento:
    public function deleteDoc();
    //Método que Limpa a Lista:
    public function cleanEquipamento();
    //Método de Exclusão de Equipamento:
    public function deleteEquipamento();
    //Método de Remoção da Lista de Escaneados:
    public function removeEquipamento();
    //Seta a Mensagem:
    public function message($msg, $attr);
    //Exibe a Mensagem:
    public function showMessage();
    //Conta de Equipamentos da Central de Operações:
    public function countCentral();
    //Conta de Equipamentos das Gerações:
    public function countGeracao();
    //Método de Retorno das Salas:
    public function returnSalas();
    //Método que Monta o Gráfico da Central de Operações:
    public function graphicCentral();
    //Método que Monta o Gráfico das Gerações:
    public function graphicGeracao();
    //Método que Pega a Marca Todos os Equipamentos de um Determinado Tipo:
    public function arrTipo();
    //Método que Pega a Marca Todas as Equipes Responsáveis:
    public function arrEquipe();
    //Método que Pega o Item Todos os Equipamentos de um Determinado Tipo:
    public function arrItem();
    //Método que Pega o Item Todos os Modelos de um Determinado Tipo:
    public function arrModelo();
    //Método que Constrói Gráficos da Central de Operações (Baseado em Marca):
    public function graphItemGeral();
    //Método que Constrói Gráficos das Gerações (Baseado em Marca):
    public function graphItemGeracao();
    //Método que Monta o Gráfico (Doughnut) de Equipamentos e Seus Modelos:
    public function graphDoughnut();
    //Método que Pega os Títulos do Gráfico em Rosquinha (Doughnut):
    public function titleDoughnut();
    //Método que Monta o Gráfico da Equipe Responsável:
    public function graphEquipe();
    //Método que Conta os Equipamentos de Determinado Tipo na Central de Operações:
    public function countTipoCentral();
    //Método que Conta as Ocorrências/Anomalias:
    public function countOcorrenciasAnomalias();
    //Método que Conta os Equipamentos de Determinado Tipo nas Gerações:
    public function countTipoGeracao();
}
