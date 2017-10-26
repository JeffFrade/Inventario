<?php

	//Declarando o Namespace:
	namespace InvClasses\Services;
	
	//Utilização de Namespaces:
	use InvClasses\DB\IConn;
	use InvClasses\Tables\ILogin;
	
	//Arquivo de Interface:
	require_once 'IServiceLogin.php';
	
	//Classe do Serviço de Login, Responsável Pelas Ações no Banco de Dados e Implementação de Sua Interface:
	class ServiceLogin implements IServiceLogin
	{
		//Atributos que Serão Correspondentes as Classes:
		private $db;
		private $login;
		
		//Método Construtor Que Obtém as Interfaces Das Classes da Tabela de Login e da Classe de Conexão:
		public function __construct(IConn $db, ILogin $login)
		{
			$this->db = $db->connect();
			$this->login = $login;
		}
		
		//Método que Efetua o Login:
		public function login()
		{
			//Tratamento de Erros:
			try {
				//Query SQL:
				$sql = "SELECT id, user, pass, `name`, `profile`, setor FROM tblogin WHERE user = :user AND pass = :pass";
				
				//Criando o Statment (Preparando a Query):
				$stmt = $this->db->prepare($sql);
				
				//Adicionando as Variáveis:
				$stmt->bindValue(':user', $this->login->getUser());
				$stmt->bindValue(':pass', $this->login->getPass());
				
				//Executando a Query:
				$stmt->execute();
				
				//Jogando Tudo em um Array Associativo:
				$dados = $stmt->fetch(\PDO::FETCH_ASSOC);
				
				//Verificando se o Login Está Correto:
				if ($dados['user'] == $this->login->getUser() && $dados['pass'] == $this->login->getPass()) {
					//Caso o Login estja correto:
					
					//Joga os Valores do Array na Sessão:
					$_SESSION['id'] = $dados['id'];
					$_SESSION['user'] = $dados['user'];
					$_SESSION['name'] = $dados['name'];
					$_SESSION['pass'] = $dados['pass'];
					$_SESSION['profile'] = $dados['profile'];
					$_SESSION['setor'] = $dados['setor'];
					
					//Exibe uma Mensagem e Redireciona o Usuário para a Página Geral:
					echo "<div class='alert alert-success alert-dismissible' role='alert'>Logado! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
					echo "<script type='text/javascript'>setTimeout(function(){ location.href='pages/main.php'; }, 500);</script>";
					
					//Retorno:
					return $_SESSION;
				} else {
					//Caso o Login Estja Incorreto:
					
					//Destrói as Sessões:
					unset($_SESSION['user']);
					unset($_SESSION['pass']);
					
					//Exibe uma Mensagem ao Usuário:
					echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Usuário ou Senha Incorretos <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
					//Retorno:
					return false;
				}
			} catch (\PDOException $e) {
				//Caso Haja Erro:
				return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> ".$e->getMessage()." <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
			}
		}

        //Método de Cadastro de Usuário:
        public function insertUser()
        {
            //Tratamento de Erros:
            try {
                //Query SQL:
                $sql = "INSERT INTO tblogin(user, pass, `name`, `profile`, setor) VALUES (:user, :pass, :name, :profile, :setor)";

                //Criando um Statment:
                $stmt = $this->db->prepare($sql);

                $err = 0;
                //Validações:
                if (empty($this->login->getUser())) {
                    echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Preencha o Campo Usuário <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                    $err = 1;
                }

                if (empty($this->login->getName())) {
                    echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Preencha o Campo Nome <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                    $err = 1;
                }

                if ($this->login->getPass() == md5("")) {
                    echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Preencha o Campo Senha <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                    $err = 1;
                }

                //Caso Haja Erro:
                if ($err != 0) {
                    return false;
                }

                //Adicionando as Variáveis:
                $stmt->bindValue(':user', $this->login->getUser());
                $stmt->bindValue(':pass', $this->login->getPass());
                $stmt->bindValue(':name', $this->login->getName());
                $stmt->bindValue(':profile', $this->login->getProfile());
                $stmt->bindValue(':setor', $this->login->getSetor());

                //Verificando se o Statment foi Executado:
                if ($stmt->execute() == true) {
                    //Caso Seja:
                    return "<div class='alert alert-success alert-dismissible' role='alert'>Usuário Cadastrado com Sucessso! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                }

                //Caso Não Seja:
                return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Erro ao Cadastrar Usuário <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            } catch (\PDOException $e) {
                //Caso Haja Erro:
                return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> ".$e->getMessage()." <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }
        }

        //Método de Consulta de Usuario:
        public function selectUser()
        {
            //Tratamento de Erros:
            try {
                //Query SQL:
                $sql = "SELECT id, user, `name`, `profile`, setor FROM tblogin";

                //Criando um Statment:
                $stmt = $this->db->prepare($sql);

                //Execuando o Statment:
                $stmt->execute();

                //Tabela:
                $table = "";

                //Jog ando Tudo em um Array Associativo:
                $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

                //Loop Para Exibir os Dados;
                do {
                    $table.= "<tr>";
                    $table.= "<td class='text-center'>".$dados['user']."</td>";
                    $table.= "<td class='text-center'>".$dados['name']."</td>";
                    $table.= "<td class='text-center'>".$dados['profile']."</td>";
                    $table.= "<td class='text-center'>".$dados['setor']."</td>";
                    $table.= "<td class='text-center'><a href='ediDel.php?id=".$dados['id']."' class='btn btn-success'><span class='glyphicon glyphicon-search'></span></a></td>";
                    $table.= "</tr>";
                } while($dados = $stmt->fetch(\PDO::FETCH_ASSOC));

                //Retorno:
                return $table;
            } catch (\PDOException $e) {
                //Caso Haja Erro:
                return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> ".$e->getMessage()." <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }
        }

        //Método de Filtro de Usuário:
        public function findUser($id)
        {
            //Tratamento de Erros:
            try {
                //Query SQL:
                $sql = "SELECT id, user, `name`, `profile`, pass, setor FROM tblogin WHERE id = :id";

                //Criando um Statment:
                $stmt = $this->db->prepare($sql);

                //Adicionando as Variáveis:
                $stmt->bindValue(':id', $id);

                //Executando a Query:
                $stmt->execute();

                //Jogando Tudo em um Array Associativo:
                $dados = $stmt->fetch(\PDO::FETCH_ASSOC);

                //Retorno:
                return $dados;
            } catch (\PDOException $e) {
                //Caso Haja Erro:
                return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> ".$e->getMessage()." <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }
        }

        //Método de Edição de Usuário:
        public function updateUser()
        {
            //Tratamento de Erros:
            try {
                //Query SQL:
                $sql = "UPDATE tblogin SET `name` = :name, pass = :pass, `profile` = :profile, setor = :setor WHERE id = :id";

                //Criando um Statment:
                $stmt = $this->db->prepare($sql);

                $err = 0;
                //Validações:
                if (empty($this->login->getName())) {
                    echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Preencha o Campo Nome <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                    $err = 1;
                }

                if ($this->login->getPass() == md5("")) {
                    echo "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Preencha o Campo Senha <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                    $err = 1;
                }

                //Caso Haja Erro:
                if ($err != 0) {
                    return false;
                }

                //Adicionando as Variáveis:
                $stmt->bindValue(':pass', $this->login->getPass());
                $stmt->bindValue(':name', $this->login->getName());
                $stmt->bindValue(':profile', $this->login->getProfile());
                $stmt->bindValue(':setor', $this->login->getSetor());
                $stmt->bindValue(':id', $this->login->getId());

                //Verificando se o Statment Foi Executado:
                if ($stmt->execute() == true) {
                    //Caso Seja:
                    return "<div class='alert alert-success alert-dismissible' role='alert'>Dados do Usuário Editados com Sucessso! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                }

                //Caso Não Seja:
                return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Erro ao Editar Dados do Usuário <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";

            } catch (\PDOException $e) {
                //Caso Haja Erro:
                return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> ".$e->getMessage()." <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }
        }

        //Método de Exclusão de Usuário:
        public function deleteUser($id)
        {
            //Tratamento de Erros:
            try {
                //Query SQL:
                $sql = "DELETE FROM tblogin WHERE id = :id";

                //Criando um Statment:
                $stmt = $this->db->prepare($sql);

                //Adicionando as Variáveis:
                $stmt->bindValue(':id', $id);

                //Verificando se o Statment foi Executado:
                if ($stmt->execute() == true) {
                    //Caso Seja:
                    return "<div class='alert alert-success alert-dismissible' role='alert'>Dados do Usuário Deletados com Sucessso! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                }

                //Caso Não Seja:
                return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Erro: </b>Erro ao Deletar Dados do Usuário <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            } catch (\PDOException $e) {
                //Caso Haja Erro:
                return "<div class='alert alert-danger alert-dismissible' role='alert'><b>Error: </b> ".$e->getMessage()." <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }
        }
	}
?>