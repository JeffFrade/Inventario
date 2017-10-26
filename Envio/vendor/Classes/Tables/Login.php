<?php

	//Declarando o Namespace:
	namespace InvClasses\Tables;
	
	//Arquivo de Interface:
	require_once 'ILogin.php';
	
	//Criando a Classe que Terá os Campos do Banco de Dados Para que Possam Ser Manipulados na Classe de Serviços e Implementação da Interface de Login:
	class Login implements ILogin
	{
		//Atributos (Serão Correspondentes aos Campos da Tabela):
		private $id;
		private $user;
		private $pass;
		private $name;
		private $profile;
		private $setor;
		
		//Método para Setar o ID:
		public function setId($id)
		{
			$this->id = $id;
		}
		
		//Método para Pegar o ID:
		public function getId()
		{
			return $this->id;
		}
		
		//Método para Setar o Usuário:
		public function setUser($user)
		{
			$this->user = $user;
		}
		
		//Método para Pegar o Usuário:
		public function getUser()
		{
			return $this->user;
		}
		
		//Método para Setar a Senha:
		public function setPass($pass)
		{
			$this->pass = md5($pass);
		}
		
		//Método para Pegar a Senha:
		public function getPass()
		{
			return $this->pass;
		}
		
		//Método para Setar o Nome:
		public function setName($name)
		{
			$this->name = $name;
		}
		
		//Método para Pegar o Nome:
		public function getName()
		{
			return $this->name;
		}
		
		//Método para Setar o Perfil:
		public function setProfile($profile)
		{
			$this->profile = $profile;
		}
		
		//Método para Pegar o Perfil:
		public function getProfile()
		{
			return $this->profile;
		}

		//Método para Setar o Setor:
		public function setSetor($setor)
		{
			$this->setor = $setor;
		}

		//Método para Pegar o Setor:
		public function getSetor()
		{
			return $this->setor;
		}
	}
?>