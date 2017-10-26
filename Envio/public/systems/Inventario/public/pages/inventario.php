<style>
    .topo {
        background-color: #6495ED;
        font-weight: bold;
    }

    table, td {
        border:1px solid black;
        text-align: center;
    }
    table {
        border-collapse:collapse;
        font-family: calibri;
        font-size: 11pt;
    }
</style>
<?php

if (!isset($_SESSION)) {
    session_start();
}

if ($_SESSION['sala'] == "") {
    header("Location: ../index.php");
}

require_once '../../vendor/autoload.php';

use InvClasses\Tables\Equipamento;
use InvClasses\Services\ServiceEquipamento;

require_once 'connect.php';

//Tabela de Equipamentos:
$equipamentos = new Equipamento;

//Serviço de Equipamentos:
$sEquipamento = new ServiceEquipamento($db, $equipamentos);

$filename = date('dmyhis').'.xls';

//Quey SQL:
$sql = "SELECT numSerie, item, marca, modelo, origem, attr FROM temp WHERE usuario = :usuario";

//Criando o Statment:
$stmt = $db->connect()->prepare($sql);

//Adicionando as Variáveis:
$stmt->bindValue(':usuario', $_SESSION['user']);

//Executando o Statment:
$stmt->execute();

$selecionado = [];
if ($stmt->rowCount() > 0) {
    //Criando um Array Para Atribuir os Dados:
    while ($dados = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        $selecionado[$dados['numSerie']] = $dados['attr'];
    }
}

$sql = "SELECT numSerie, item, marca, modelo, patrimonio, obs, sala, origem, `local`, equipeResponsavel, codEfap, orgao FROM equipamentos WHERE sala = :sala";

$stmt = $db->connect()->prepare($sql);

$stmt->bindValue(':sala', $_SESSION['sala']);

$stmt->execute();

//Criando um Array Para Atribuir os Dados:
$reg = $stmt->fetch(\PDO::FETCH_ASSOC);
$linha = 0;
$dados = array();

do {
    $dados[$linha]= array('ORIGEM'=>$reg['origem'], 'LOCAL'=>$reg['local'], 'SALA'=>$reg['sala'], 'ITEM'=>$reg['item'], 'MARCA'=> $reg['marca'], 'CÓDIGO'=>$reg['codEfap'], 'NÚMERO DE SÉRIE'=>$reg['numSerie'], 'MODELO'=> $reg['modelo'], 'PATRIMÔNIO'=>$reg['patrimonio'], 'ORGÃO'=>$reg['orgao'], 'OBSERVAÇÕES'=>$reg['obs'], 'EQUIPE RESPONSÁVEL'=>$reg['equipeResponsavel']);
    $linha++;
} while ($reg = $stmt->fetch(\PDO::FETCH_ASSOC));

//Verifica se existem dados a serem processados
if(empty($dados)) {
    die('Sem dados a serem processados');
}

//Pega o nome das colunas utilizando a posição [0] do array
$nome_colunas = array_keys($dados[0]);

//linha de Header dos dados
$cabeçalho_tabela = '<tr><th class="topo">'.utf8_decode(implode('</th><th class="topo">',$nome_colunas)).'</th></tr>';

$detalhes_tabela = '';
//Dados
$linha = 0;

foreach ($dados as $numero_array => $valor) {
    //Pega os dados a serem processados (Segundo array.... exp: $dados[0]=>(PEGANDO ESTE ARRAY))
    $valores = array_values($valor);
    // class='.(empty($selecionado[$reg['numSerie']])?"":"verde").'
    $detalhes_tabela.= '<tr><td style='.(empty($selecionado[$dados[$linha]['NÚMERO DE SÉRIE']])?"":"background-color:#009900").'>'.utf8_decode(implode('</td><td style='.(empty($selecionado[$dados[$linha]['NÚMERO DE SÉRIE']])?"":"background-color:#009900").'>',$valores)).'</td></tr>';
    $linha++;
}

//Headers para o download Não pode ter saida nenhuma na tela antes disso.
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=".$filename);
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);

//Montando a tabela
echo '<table>';
echo $cabeçalho_tabela;
echo $detalhes_tabela;
echo '</table>';

$sEquipamento->cleanEquipamento();