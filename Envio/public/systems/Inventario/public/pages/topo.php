<?php
    //Autoload:
    require_once '../../../../../vendor/autoload.php';

    //Utilização de Namespaces:
    use InvClasses\Tables\Equipamento;
    use InvClasses\Services\ServiceEquipamento;

    //Arquivo de Conexão:
    require_once '../../../connect/connect.php';

    //Caso a Sessão Não Exista:
    if (!isset($_SESSION)) {
        session_start();
    }

    //Verificação de Login:
    require_once 'logado.php';

    //Instância de Objetos:
    //Tabela de Equipamentos:
    $equipamentos = new Equipamento;

    //Serviço de Equipamentos:
    $sEquipamento = new ServiceEquipamento($db, $equipamentos);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventário</title>
    <link rel="shortcut icon" href="../img/icon.jpg">
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../css/lightbox.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/sb-admin.css" rel="stylesheet">
    <link href="../css/icomoon.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>