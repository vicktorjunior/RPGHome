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
if(isset($usuario) && $acao == 'insercao'){
    $dados[0] = $senha;
    $dados[1] = $usuario;
    $dados[2] = $email;
    $db->begin();
    $op = $db->execute("INSERT INTO usuarios (senha, usuario, email) VALUES (?,?,?)", $dados);
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
    $op=$db->execute("DELETE FROM usuarios WHERE id_usuario=?",$dados);
    if (!$op) {
        $db->rollback();
    } else {
        $db->commit();
    }
}

$dadosTemp['usuario'] = '';
$dadosTemp['senha'] = '';
$dadosTemp['email'] = '';

//Verifica se é uma requisição para realmente atualizar os dados
if(isset($acao) && $acao == 'atualizarFim'){
    $dados[0] = $senha;
    $dados[1] = $usuario;
    $dados[2] = $email;
    $dados[3] = $id;
    $id = null; //Libera o formulario para inserção
    $db->execute("UPDATE usuarios SET senha=?, usuario=?, email=? WHERE id_usuario=?", $dados);
}

//A primeira vez que clica em atualizar carrega os dados para o array dadosTemp
//que permite
if(isset($acao) && $acao == 'atualizar'){
    $consulta = $db->query("SELECT * FROM usuarios
                        WHERE id_usuario = $id");
    foreach ($consulta as $linha) {
        $dadosTemp = $linha;
    }
    $acao = 'atualizarFim';
}


?>

<!DOCTYPE html>

<html>
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
            <h1>Medieval RPG - Lista de Usuários</h1>
        </div>
    </header>
    <div role="main">
        <div>
            <div>
                <? if(isset($id) && isset($acao)) { ?>
                <form role="form" action="crudusuario.php?acao=<?= $acao?>&id=<?=$id?>" method="post">
                    <? } else { ?>
                    <form role="form" action="empresa.php" method="post">
                        <? } ?>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <input type="text" name="usuario" id="usuario" value="<?=$dadosTemp['usuario']?>" required placeholder="usuário">
                                <input type="email" name="email" id="email" value="<?=$dadosTemp['email']?>" required placeholder="email">
                                <input type="password" name="senha" id="senha" value="<?=$dadosTemp['senha']?>" required placeholder="senha">
                            </li>
                            <li class="list-group-item"><button type="submit" class="btn-default">Inserir - Atualizar</button></li>
                            <li class="list-group-item"> <button class='btn-default' onclick="location.href='prod.php'">Voltar</button>
                                <button class="btn-default" onclick="location.href='deslogar.php'">LOGOUT</button></li>
                        </ul>
            </div>
                </form>


        </div>

            <div class="panel-body">
                <table class="table table-responsive table-hover">
                    <thead>
                    <tr>
                        <th>Botões</th>
                        <th>Usuário</th>
                        <th>E-mail</th>
                    </tr>
                    </thead>
                    <tbody>
                    <ul class="list-group">
                        <?php
                            $consulta = $db->query("SELECT * FROM usuarios ORDER BY id_usuario DESC");
                            foreach ($consulta as $linha) {
                            ?><tr>
                            <td>
                                <a class="glyphicon glyphicon-trash" href="?id=<?= $linha['id_usuario']?>&acao=deletar" onclick="return confirm('O usuário pode ter personagens cadastrados! Tem certeza que deseja deletar os personagens e o usuário?');">Deletar</a>
                                <a class="glyphicon glyphicon-refresh" href="?id=<?= $linha['id_usuario']?>&acao=atualizar">Atualizar</a>
                            </td>
                                    <td align = "center"><?= $linha['usuario']?></td>
                                    <td align = "center"><?= $linha['email']?></td>
                                </li>
                                </tr>
                            <?php
                            }
                            ?>
                    </ul>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<footer class="row">
    <h6>RN Dev &copy; Todos os direitos reservados</h6>
</footer>
</body>
</html>
