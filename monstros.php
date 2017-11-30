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
if(isset($nomemonstro) && $acao == 'insercao'){
    $dados[0] = $nomemonstro;
    $dados[1] = $qtd_experiencia;
    $db->execute("INSERT INTO monstros(nome_monstro, qtd_experiencia) VALUES (?, ?)", $dados);
}
//deletar
if(isset($id) && $acao == 'deletar'){
    $dados[0] = $id;
    $db->execute("DELETE FROM monstros WHERE id_monstro=?",$dados);
}
$dadosTemp['nome_monstro'] = '';
$dadosTemp['qtd_experiencia'] = '';


//Verifica se é uma requisição para realmente atualizar os dados
if(isset($acao) && $acao == 'atualizarFim'){
    $dados[0] = $nomemonstro;
    $dados[1] = $qtd_experiencia;
    $dados[2] = $id;
    $id = null; //Libera o formulario para inserção
    $db->execute("UPDATE monstros SET nome_monstro=?, qtd_experiencia=? WHERE id_monstro=?", $dados);
}

//A primeira vez que clica em atualizar carrega os dados para o array dadosTemp
//que permite
if(isset($acao) && $acao == 'atualizar'){
    $consulta = $db->query("SELECT * FROM monstros
                          WHERE id_monstro = $id");
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
            <h1>Medieval RPG - CRUD de Monstros</h1>
        </div>
    </header>
    <div role="main">
        <ul class="list-group">
            <li class="list-group-item">
                <form class="form-group" action="monstros.php?acao=<?= $acao?>&id=<?=$id?>" method="post">
                    <input type="text" name="nomemonstro" placeholder="Nome do Monstro" value="<?= $dadosTemp['nome_monstro']?>">
                    <input type="number" name="qtd_experiencia" min="0" value="<?= $dadosTemp['qtd_experiencia']?>" placeholder="Exp. ao matar">

                    <input type="submit" value="Cadastro do Monstro">
                </form>
            </li>
            <li class="list-group-item"> <button class='btn-default' onclick="location.href='prod.php'">Voltar</button>
                <button class="btn-default" onclick="location.href='deslogar.php'">LOGOUT</button></li>
        <ul class="list-group>
            <?php
            $consulta = $db->query("SELECT * FROM monstros ORDER BY id_monstro DESC");
            foreach ($consulta as $linha) {
                ?>
                <li class="list-group-item"><?= $linha['nome_monstro']?>
                    <a href="?id=<?= $linha['id_monstro']?>&acao=deletar">Deletar</a>
                    <a href="?id=<?= $linha['id_monstro']?>&acao=atualizar">Atualizar</a>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>


</body>
</html>
