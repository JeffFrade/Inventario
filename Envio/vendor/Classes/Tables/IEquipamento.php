<?php

namespace InvClasses\Tables;


interface IEquipamento
{
    public function getNumSerie();
    public function setNumSerie($numSerie);
    public function getCodBarras();
    public function setCodBarras($codBarras);
    public function getItem();
    public function setItem($item);
    public function getMarca();
    public function setMarca($marca);
    public function getModelo();
    public function setModelo($modelo);
    public function getPatrimonio();
    public function setPatrimonio($patrimonio);
    public function getOrigem();
    public function setOrigem($origem);
    public function getSala();
    public function setSala($sala);
    public function getLocal();
    public function setLocal($local);
    public function getObs();
    public function setObs($obs);
    public function getImagem();
    public function setImagem($imagem);
    public function getResponsavel();
    public function setResponsavel($responsavel);
    public function getCodEfap();
    public function setCodEfap($codEfap);
    public function getEquipeResponsavel();
    public function setEquipeResponsavel($equipeResponsavel);
    public function getOrgao();
    public function setOrgao($orgao);
    public function getDoc();
    public function setDoc($doc);
    public function getTipo();
    public function setTipo($tipo);
    //Remover:
    public function getIdEvento();
    public function setIdEvento($idEvento);
    public function setId($id);
    public function getId();
}
