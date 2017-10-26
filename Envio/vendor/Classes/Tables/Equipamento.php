<?php
    namespace InvClasses\Tables;

    class Equipamento implements  IEquipamento
    {
        //Atributos:
        private $numSerie;
        private $codBarras;
        private $item;
        private $marca;
        private $modelo;
        private $patrimonio;
        private $origem;
        private $sala;
        private $local;
        private $obs;
        private $imagem;
        private $responsavel;
        private $codEfap;
        private $equipeResponsavel;
        private $orgao;
        private $doc;
        private $tipo;
        private $idEvento;
        private $id;

        public function getNumSerie()
        {
            return $this->numSerie;
        }

        public function setNumSerie($numSerie)
        {
            $this->numSerie = $numSerie;
        }

        public function getCodBarras()
        {
            return $this->codBarras;
        }

        public function setCodBarras($codBarras)
        {
            $this->codBarras = $codBarras;
        }

        public function getItem()
        {
            return $this->item;
        }

        public function setItem($item)
        {
            $this->item = ucfirst(strtolower($item));
        }

        public function getMarca()
        {
            return $this->marca;
        }

        public function setMarca($marca)
        {
            $encoding = mb_internal_encoding();
			$this->marca = mb_strtoupper($marca, $encoding);
        }

        public function getModelo()
        {
            return $this->modelo;
        }

        public function setModelo($modelo)
        {
            $this->modelo = ucfirst($modelo);
        }

        public function getPatrimonio()
        {
            return $this->patrimonio;
        }

        public function setPatrimonio($patrimonio)
        {
            $this->patrimonio = ucfirst($patrimonio);
        }

        public function getOrigem()
        {
            return $this->origem;
        }

        public function setOrigem($origem)
        {
            $this->origem = ucfirst(strtolower($origem));
        }

        public function getSala()
        {
            return $this->sala;
        }

        public function setSala($sala)
        {
            $this->sala = ucfirst($sala);
        }

        public function getLocal()
        {
            return $this->local;
        }

        public function setLocal($local)
        {
            $this->local = ucfirst($local);
        }

        public function getObs()
        {
            return $this->obs;
        }

        public function setObs($obs)
        {
            $this->obs = ucfirst($obs);
        }

        public function getImagem()
        {
            return $this->imagem;
        }

        public function setImagem($imagem)
        {
            $this->imagem = $imagem;
        }

        public function getResponsavel()
        {
            return $this->responsavel;
        }

        public function setResponsavel($responsavel)
        {
            $this->responsavel= $responsavel;
        }

        public function getCodEfap()
        {
            return $this->codEfap;
        }

        public function setCodEfap($codEfap)
        {
            $this->codEfap = $codEfap;
        }

        public function getEquipeResponsavel()
        {
            return $this->equipeResponsavel;
        }

        public function setEquipeResponsavel($equipeResponsavel)
        {
            $this->equipeResponsavel = $equipeResponsavel;
        }

        public function getOrgao()
        {
            return $this->orgao;
        }

        public function setOrgao($orgao)
        {
            $this->orgao = $orgao;
        }

        public function getDoc()
        {
            return $this->doc;
        }

        public function setDoc($doc)
        {
            $this->doc = $doc;
        }

        public function getTipo()
        {
            return $this->tipo;
        }

        public function setTipo($tipo)
        {
            $this->tipo = $tipo;
        }

        public function getIdEvento()
        {
            return $this->idEvento;
        }

        public function setIdEvento($idEvento)
        {
            $this->idEvento = $idEvento;
        }
		
		public function setId($id) {
			$this->id = $id;
		}
		
		public function getId() {
			return $this->id;
		}
    }
