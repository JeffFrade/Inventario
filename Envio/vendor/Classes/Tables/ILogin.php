<?php

	//Declarando o Namespace:
	namespace InvClasses\Tables;
	
	//Interface da Classe de Login:
	interface ILogin
	{
		//Método para Setar o ID:
		public function setId($id);
		//Método para Pegar o ID:
		public function getId();
		//Método para Setar o Usuário:
		public function setUser($user);
		//Método para Pegar o Usuário:
		public function getUser();
		//Método para Setar a Senha:
		public function setPass($pass);
		//Método para Pegar a Senha:
		public function getPass();
		//Método para Setar o Nome:
		public function setName($name);
		//Método para Pegar o Nome:
		public function getName();
		//Método para Setar o Perfil:
		public function setProfile($profile);
		//Método para Pegar o Perfil:
		public function getProfile();
	}
?>