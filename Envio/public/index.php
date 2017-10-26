<?php
	//Arquivo de Autoload:
	require_once '../vendor/autoload.php';
	
	//Conexão ao Mysql:
	require_once 'systems/connect/connect.php';
	
	//Utilização de Namespaces:
	use InvClasses\Tables\Login;
	use InvClasses\Services\ServiceLogin;
	
	//Instanciando o Objeto que Receberá o Login:
	$login = new Login;
	
	//Instanciando o Objeto que Receberá o Serviço de Login:
	$sLogin = new ServiceLogin($db, $login);
	
	//Destrói as Sessões:
	unset($_SESSION['user']);
	unset($_SESSION['pass']);
?>
<!DOCTYPE html>
<html lang="pt-br">
	 <head>
		<meta charset="utf-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<title>Login</title>
		<link href="img/icon.ico" rel="shortcut icon"/>
		<link href="css/bootstrap.min.css" rel="stylesheet"/>
		<link href="css/font-awesome.min.css" rel="stylesheet"/>
		<link href="css/style.css" rel="stylesheet"/>
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	
	<body id="index">
        <div class="container">
		    <div class="row vertical-offset-100">
		    	<div class="col-md-4 col-md-offset-4">
		    		<div class="panel panel-primary">
					  	<div class="panel-heading">
					    	<h3 class="panel-title"><i class="fa fa-user"></i> Portal de Ferramentas Internas</h3>
					 	</div>
					  	<div class="panel-body">
					    	<form id="frmLogin" name="frmLogin" method="post" action="">
			                    <fieldset>
			                    	<div class="form-group">
							    	  	<div class="input-group">
							    	  		<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							    		    <input class="form-control" placeholder="Usuário" id="txtUsuario" name="txtUsuario" type="text">
							    		</div>
						    		</div>

						    		<div class="form-group">
						    			<div class="input-group">
						    				<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
						    				<input class="form-control" placeholder="Senha" id="txtSenha" name="txtSenha" type="password">
						    			</div>
						    		</div>
						    		
						    		<button type="submit" id="btnLogin" name="btnLogin" class="btn btn-success btn-lg btn-block">Login</button>
						    	</fieldset>
								<br/>
								<?php
									//Caso o Botão btnLogin Seja Pressionado:
									if (isset($_POST['btnLogin'])) {
										//Passa os Valores do Formulário Para Seus Devidos Métodos:
										$login->setUser($_POST['txtUsuario']);
										$login->setPass($_POST['txtSenha']);

										//Chama o Método de Login:
										$sLogin->login();
									}
								?>
					      	</form>
					    </div>
					</div>
                </div>
            </div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>