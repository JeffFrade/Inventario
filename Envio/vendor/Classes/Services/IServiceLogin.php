<?php

	//Declarando o Namespace:
	namespace InvClasses\Services;

	use InvClasses\DB\IConn;
	use InvClasses\Tables\ILogin;

	//Interface do Serviço de Login:
	interface IServiceLogin
	{
	    //Método Construtor:
        public function __construct(IConn $db, ILogin $login);
		//Método que Efetua o Login:
		public function login();
		//Método de Inserção de Usuário:
        public function insertUser();
        //Método de Consulta de Usuario:
        public function selectUser();
        //Método de Filtro de Usuário:
        public function findUser($id);
        //Método de Edição de Usuário:
        public function updateUser();
        //Método de Exclusão de Usuário:
        public function deleteUser($id);
	}
