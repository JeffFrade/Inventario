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

    require_once '../../vendor/autoload.php';

    use InvClasses\Tables\Equipamento;
    use InvClasses\Services\ServiceEquipamento;

    require_once 'connect.php';

    //Tabela de Equipamentos:
    $equipamentos = new Equipamento;

    //Serviço de Equipamentos:
    $sEquipamento = new ServiceEquipamento($db, $equipamentos);

    $filename = date('dmyhis').'.xls';

    $sql = "SELECT numSerie, item, marca, modelo, patrimonio, obs, responsavel FROM externo WHERE usuario = :usuario";

    $stmt = $db->connect()->prepare($sql);

    $stmt->bindValue(':usuario', $_SESSION['user']);

    $stmt->execute();

    //Criando um Array Para Atribuir os Dados:
    $reg = $stmt->fetch(\PDO::FETCH_ASSOC);
    $linha = 0;
    $dados = array();

    do {
        $dados[$linha]= array('PATRIMÔNIO'=>$reg['patrimonio'], 'NÚMERO DE SÉRIE'=>$reg['numSerie'], 'ITEM'=>$reg['item'], 'MARCA'=> $reg['marca'], 'MODELO'=> $reg['modelo'], 'RESPONSÁVEL'=>$reg['responsavel']);
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
    foreach ($dados as $numero_array => $valor) {
    //Pega os dados a serem processados (Segundo array.... exp: $dados[0]=>(PEGANDO ESTE ARRAY))
    $valores = array_values($valor);
    $detalhes_tabela.= '<tr><td>'.utf8_decode(implode('</td><td>',$valores)).'</td></tr>';
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