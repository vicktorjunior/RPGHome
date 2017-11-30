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
$acao = 'insercao';
extract($_REQUEST);//transformando os dados enviados pelo form e pela url em variaveis

//Verifica se é uma requisição de inserção
if(isset($nomemapa) && $acao == 'insercao'){
    $dados[0] = $nomemapa;
    $dados[1] = $terreno;
    $db->execute("INSERT INTO mapas(nome_mapa, tipo_terreno) VALUES (?, ?)", $dados);
}
//deletar
if(isset($id) && $acao == 'deletar'){
    $dados[0] = $id;
    $db->execute("DELETE FROM mapas WHERE id_mapa=?",$dados);
}
$dadosTemp['nome_mapa'] = '';
$dadosTemp['tipo_terreno'] = '';


//Verifica se é uma requisição para realmente atualizar os dados
if(isset($acao) && $acao == 'atualizarFim'){
    $dados[0] = $nomemapa;
    $dados[1] = $terreno;
    $dados[2] = $id;
    $id = null; //Libera o formulario para inserção
    $db->execute("UPDATE mapas SET nome_mapa=?, tipo_terreno=? WHERE id_mapa=?", $dados);
}

//A primeira vez que clica em atualizar carrega os dados para o array dadosTemp
//que permite
if(isset($acao) && $acao == 'atualizar'){
    $consulta = $db->query("SELECT * FROM mapas
                          WHERE id_mapa = $id");
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
            <h1>Medieval RPG - CRUD de Mapas</h1>
        </div>
    </header>
    <div role="main">
        <ul class="list-group">
            <li class="list-group-item">
                <form class="" action="mapas.php?acao=<?= $acao?>&id=<?=$id?>" method="post">
                    <input type="text" name="nomemapa" placeholder="Nome do Mapa" value="<?= $dadosTemp['nome_mapa']?>">
                    <input type="text" name="terreno" value="<?= $dadosTemp['tipo_terreno']?>" placeholder="Tipo do Terreno">

                    <input type="submit" value="Cadastro do Mapa">
                </form>
            </li>
            <li class="list-group-item"> <button class='btn-default' onclick="location.href='prod.php'">Voltar</button>
                <button class="btn-default" onclick="location.href='deslogar.php'">LOGOUT</button></li>
            <ul class="list-group>
            <?php
            $consulta = $db->query("SELECT * FROM mapas ORDER BY id_mapa DESC");
            foreach ($consulta as $linha) {
            ?>
                <li class="list-group-item"><?= $linha['nome_mapa']?>
            <a href="?id=<?= $linha['id_mapa']?>&acao=deletar">Deletar</a>
            <a href="?id=<?= $linha['id_mapa']?>&acao=atualizar">Atualizar</a>
            </li>
            <?php
            }
            ?>
        </ul>
    </div>


</body>
</html>
