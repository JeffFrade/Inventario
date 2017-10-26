<?php
    #############################
    # Renomear Para connect.php #
    #############################

	//Utilização do Namespace de Conexão:
	use InvClasses\DB\Conn;
	
	//Cria a Conexão ao Banco de Dados:
	$db = new Conn('host', 'sistemaInventario', 'usuario', 'senha');
?>