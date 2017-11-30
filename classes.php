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
if(isset($nomeclasse) && $acao == 'insercao'){
    $dados[0] = $nomeclasse;
    $dados[1] = $historia;
    $db->begin();
    $op = $db->execute("INSERT INTO classes(nome_classe, historia) VALUES (?, ?)", $dados);
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
    $op=$db->execute("DELETE FROM classes WHERE id_classe=?",$dados);

    if (!$op) {
        $db->rollback();
    } else {
        $db->commit();
    }
}
$dadosTemp['nome_classe'] = '';
$dadosTemp['historia'] = '';


//Verifica se é uma requisição para realmente atualizar os dados
if(isset($acao) && $acao == 'atualizarFim'){
    $dados[0] = $nomeclasse;
    $dados[1] = $historia;
    $dados[2] = $id;
    $id = null; //Libera o formulario para inserção
    $db->execute("UPDATE classes SET nome_classe=?, historia=? WHERE id_classe=?", $dados);
}

//A primeira vez que clica em atualizar carrega os dados para o array dadosTemp
//que permite
if(isset($acao) && $acao == 'atualizar'){
    $consulta = $db->query("SELECT * FROM classes
                          WHERE id_classe = $id");
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
            <h1>Medieval RPG - CRUD de Classes</h1>
        </div>
    </header>
    <div role="main">
        <ul class="list-group">
            <li class="list-group-item"> <form class="" action="classes.php?acao=<?= $acao?>&id=<?=$id?>" method="post">
                <input type="text" name="nomeclasse" placeholder="Nome da Classe" value="<?= $dadosTemp['nome_classe']?>">
                <input type="text" name="historia" value="<?= $dadosTemp['historia']?>" placeholder="História">

                <input type="submit" value="Cadastro da Classe">
            </form>
        </li>
            <li class="list-group-item"> <button class='btn-default' onclick="location.href='prod.php'">Voltar</button>
           <button class="btn-default" onclick="location.href='deslogar.php'">LOGOUT</button></li>
        <ul class="list-group>
            <?php
            $consulta = $db->query("SELECT * FROM classes ORDER BY id_classe DESC");
            foreach ($consulta as $linha) {
                ?>
                <li class="list-group-item"><?= $linha['nome_classe']?>
                    <a href="?id=<?= $linha['id_classe']?>&acao=deletar">Deletar</a>
                    <a href="?id=<?= $linha['id_classe']?>&acao=atualizar">Atualizar</a>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>


</body>
</html>
