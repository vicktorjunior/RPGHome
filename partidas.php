<?php
include_once "sessao.php";
require 'db/DB.class.php';
//inicia a conexão
$db = new DB('02080123',                    //usuario
    '3Ka7ktok',                           //senha
    '02080123',                   //banco
    'webacademico.canoas.ifrs.edu.br'//servidor
);

$id = ''; //inicia as variaveis de controle vazia.
if(isset($_REQUEST['acao'] )) {
    $acao = $_REQUEST['acao'];
} else {
    $acao='insercao';
}

extract($_REQUEST);//transformando os dados enviados pelo form e pela url em variaveis

//Verifica se é uma requisição de inserção
if(isset($nomepartida) && $acao == 'insercao'){
    $dados[0] = $nomepartida;
    $dados[1] = $idmissao;
    $dados[2] = $datainicio;
    $dados[3] = $datafinal;
    $db->begin();
    $op = $db->execute("INSERT INTO partidas(nome_partida, id_missao, data_inicio_partida, data_final_partida) VALUES (?,?,?,?)", $dados);
    if (!$op) {
        $db->rollback();
    } else {
        $db->commit();
    }
}
//deletar
if(isset($id) && $acao == 'deletar'){
    $dados[0] = $id;
    $db->begin();
    $op=$db->execute("DELETE FROM partidas WHERE id_partida=?",$dados);
    if(!$op) {
        $db->rollback();
    } else {
        $db->commit();
    }
}
$dadosTemp['nome_partida'] = '';
$dadosTemp['idmissao'] = '';
$dadosTemp['data_inicio_partida'] = '';
$dadosTemp['data_final_partida'] = '';

//Verifica se é uma requisição para realmente atualizar os dados
if(isset($acao) && $acao == 'atualizarFim'){
    $dados[0] = $nomepartida;
    $dados[1] = $datainicio;
    $dados[2] = $datafinal;
    $dados[3] = $idmissao;
    $dados[4] = $id;
    $id = null; //Libera o formulario para inserção
    $db->execute("UPDATE partidas SET nome_partida=?, data_inicio_partida=?, data_final_partida=?, id_missao=? WHERE id_partida=?", $dados);
}

//A primeira vez que clica em atualizar carrega os dados para o array dadosTemp
//que permite
if(isset($acao) && $acao == 'atualizar'){
    $id = $_GET['id'];
    $consulta = $db->query("SELECT * FROM partidas p
                          INNER JOIN missoes m ON m.id_missao = p.id_missao
                          where p.id_partida=$id
                          GROUP BY p.id_missao, p.id_partida,p.nome_partida,p.data_inicio_partida,p.data_final_partida,m.id_missao,m.id_mapa,m.nome_missao,m.qtd_personagens,m.descricao
                          ORDER BY p.id_missao");
    foreach ($consulta as $linha) {
        $dadosTemp = $linha;
    }
    $acao = 'atualizarFim';
}


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <title>RPG-BD</title>
</head>
<body>
<div class="container-fluid">
    <header class="row">
        <div class="col-md-12">
            <h1>Medieval RPG - CRUD de Partidas</h1>
        </div>
    </header>
    <div role="main">
        <ul class="list-group">
            <li class="list-group-item">
                <form class="" action="partidas.php?acao=<?= $acao?>&id=<?=$id?>" method="post">
                    <div class="row">
                        <div class="col-md-4">Nome da Partida: <input type="text" required name="nomepartida" value="<?= $dadosTemp['nome_partida']?>"></div>
                        <div class="col-md-4">Data Início: <input type="date" required name="datainicio" value="<?= $dadosTemp['data_inicio_partida'] ?>"></div>
                        <div class="col-md-4">Data Final: <input type="date" required name="datafinal" value="<?= $dadosTemp['data_final_partida'] ?>"></div>
                        </div>
                    <div class="col-md-6">Missão:
                        <select name="idmissao" required>
                            <?php $consulta = $db->query("select * from missoes");
                            foreach ($consulta as $linha) {
                                echo '<option value="'.$linha['id_missao'].'">'.$linha['nome_missao'].'</option>';
                            } ?>
                        </select>
                    </div>
                    <input type="submit" value="Cadastro da Partida">
                </form>
            </li>
            <li class="list-group-item"> <button class='btn-default' onclick="location.href='prod.php'">Voltar</button>
                <button class="btn-default" onclick="location.href='deslogar.php'">LOGOUT</button></li>

            <ul class="list-group>
            <?php
            $consulta = $db->query("SELECT * FROM partidas ORDER BY id_partida DESC");
            foreach ($consulta as $linha) {
            ?>
                <li class="list-group-item"><?= $linha['nome_partida']?>
            <a href="?id=<?= $linha['id_partida']?>&acao=deletar">Deletar</a>
            <a href="?id=<?= $linha['id_partida']?>&acao=atualizar">Atualizar</a>
            </li>
            <?php
            }
            ?>
        </ul>
    </div>
</div>
</body>
</html>
