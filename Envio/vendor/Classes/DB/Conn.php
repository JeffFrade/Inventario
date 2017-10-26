<?php
	
	//Declarando namespace:
	namespace InvClasses\DB;
	
	//Classe que Efetua Conexão ao Banco de Dados (Via PDO) e Implementação de Sua Interface:
	class Conn implements IConn
	{
		//Atributos de Conexão:
		private $host;
		private $dbname;
		private $user;
		private $pass;
		
		//Método Construtor que Inicializa os Parâmetros de Conexão:
		public function __construct($host, $dbname, $user, $pass)
		{
			//Passando os Valores dos Parâmetros para os Atributos:
			$this->host = $host;
			$this->dbname = $dbname;
			$this->user = $user;
			$this->pass = $pass;
		}
		
		//Método que Efetua a Conexão:
		public function connect()
		{
			//Tratamento de Erros do Tipo PDOException:
			try {
				//Iniciando a Sessão (Caso Ela Não Exista):
				if (!isset($_SESSION)) {
					//Inicia a Sessão:
					session_start();
				}
				
				//Retorno da Conexão (PDO):
				return new \PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->user, $this->pass);
			} catch (\PDOException $e) {
				//Retorno do Erro:
				return $e->getMessage();
			}
		}
	}
