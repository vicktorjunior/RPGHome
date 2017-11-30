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
if(isset($nomemissao) && $acao == 'insercao'){
    $dados[0] = $nomemissao;
    $dados[1] = $qtdpersonagens;
    $dados[2] = $mapa;
    $dados[3] = $descricao;
    $db->execute("INSERT INTO missoes(nome_missao, qtd_personagens,id_mapa, descricao) VALUES (?,?,?,?)", $dados);
}
//deletar
if(isset($id) && $acao == 'deletar'){
    $dados[0] = $id;
    $db->execute("DELETE FROM missoes WHERE id_missao=?",$dados);
}
$dadosTemp['nome_missao'] = '';
$dadosTemp['qtd_personagens'] = '';
$dadosTemp['mapa'] = '';
$dadosTemp['descricao'] = '';


//Verifica se é uma requisição para realmente atualizar os dados
if(isset($acao) && $acao == 'atualizarFim'){
    $dados[0] = $nomemissao;
    $dados[1] = $qtdpersonagens;
    $dados[2] = $mapa;
    $dados[3] = $descricao;
    $dados[4] = $id;
    $id = null; //Libera o formulario para inserção
    $db->execute("UPDATE missoes SET nome_missao=?, qtd_personagens=?, id_mapa=?, descricao=? WHERE id_missao=?", $dados);
}

//A primeira vez que clica em atualizar carrega os dados para o array dadosTemp
//que permite
if(isset($acao) && $acao == 'atualizar'){
    $consulta = $db->query("SELECT * FROM missoes m 
                          INNER JOIN mapas a on a.id_mapa = m.id_mapa
                          WHERE m.id_missao = $id
                          GROUP BY m.id_missao, m.id_mapa,m.nome_missao,m.qtd_personagens,m.descricao,a.id_mapa,a.nome_mapa,a.tipo_terreno
                          ORDER BY m.id_missao");
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
            <h1>Medieval RPG - CRUD de Missões</h1>
        </div>
    </header>
    <div role="main">
        <ul class="list-group">
            <li class="list-group-item">
                <form class="" action="missoes.php?acao=<?= $acao?>&id=<?=$id?>" method="post">
                    <div class="row">
                        <div class="col-md-6">Nome da Missão: <input type="text" name="nomemissao" placeholder="Nome da Missao" required value="<?= $dadosTemp['nome_missao']?>"></div>
                        <div class="col-md-6">Qtd. de Participantes: <input type="number" required min="1" name="qtdpersonagens" value="<?= $dadosTemp['qtd_personagens']?>" placeholder="Qtd. Participantes">
                        </div>
                    </div>

                    <div class="col-md-6">Mapa:
                        <select name="mapa" required>
                            <?php $consulta = $db->query("select * from mapas");
                            foreach ($consulta as $linha) {
                                echo '<option value="'.$linha['id_mapa'].'">'.$linha['nome_mapa'].'</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        Descrição da Missão: <input type="text" name="descricao" placeholder="Descrição" value="<?=$dadosTemp['descricao']?>">
                    </div>
                    <input type="submit" value="Cadastro da Missão">
                </form>
            </li>
            <li class="list-group-item"> <button class='btn-default' onclick="location.href='prod.php'">Voltar</button>
                <button class="btn-default" onclick="location.href='deslogar.php'">LOGOUT</button></li>
            <ul class="list-group>
            <?php
            $consulta = $db->query("SELECT * FROM missoes ORDER BY id_missao DESC");
            foreach ($consulta as $linha) {
            ?>
                <li class="list-group-item"><?= $linha['nome_missao']?>
            <a href="?id=<?= $linha['id_missao']?>&acao=deletar">Deletar</a>
            <a href="?id=<?= $linha['id_missao']?>&acao=atualizar">Atualizar</a>
            </li>
            <?php
            }
            ?>
        </ul>
    </div>


</body>
</html>
