<?php
	if (!isset($_SESSION['user']) || !isset($_SESSION['pass'])) {
		echo "<script type='text/javascript'>alert('Você Precisa Estar Logado Para Ter Acesso ao Está Página');location.href='../../../../index.php';</script>";
		exit();
	}
?>