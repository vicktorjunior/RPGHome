<?php
require 'db/DB.class.php';
//inicia a conexão
$db = new DB('02080123',                    //usuario
    '3Ka7ktok',                           //senha
    '02080123',                   //banco
    'webacademico.canoas.ifrs.edu.br'//servidor
);
$names = ['Victor','Tainá','Ana','Martha','Camila','Cassiano','Éverton','Bruno','Andressa','Nicolas', 'Felipe', 'Paloma'];
$surnames = ['Júnior','Xavier','Silva','Young','Bertollini','Capeletti','Frederichsen','Bergmann','Peluzzo','Caruzzo', 'Jackson', 'Schevchenko'];
//--------------------//----------------------
extract($_REQUEST); //extract transforma os dados que vem da $_REQUEST em variáveis
//delete
//if (isset($id) && $acao == 'deletar') {
  //  $dados[0] = $id;
    //$db->execute("DELETE FROM personagens WHERE id_personagem=?", $dados);
//}

//update
/*$dadosTemp['name'] = '';

if (isset($acao) && $acao == 'atualizarFim') {
    $dados[0] = $nome;
    $dados[1] = $id;
    $db->execute("UPDATE players SET names=? WHERE id_player=?", $dados);
}

if (isset($acao) && $acao == 'atualizar') {
    $consulta = $db->query("SELECT * FROM players WHERE id_player=$id");
    foreach ($consulta as $linha) {
        $dadosTemp = $linha;
    }
    $acao = 'atualizarFim';
}*/

$insert = 0;
set_time_limit (0);
while ($insert < 10){
    $dados[0] = $names[rand(0,11)].'  '.$surnames[rand(0,11)];
    $dados[1] = 1;
    $dados[2] = 0;
    $dados[3] = 50;
    $dados[4] = 100;
    $dados[5] = 100;
    $dados[6] = 50;
    $dados[7] = 0;
    $dados[8] = 0;
    $dados[9] = 0;
    $dados[10] = 0;
    $dados[11] = 2;
    $dados[12] = 1;
    $db->execute("INSERT INTO personagens (nome_personagem, nivel, experiencia, defesa, stamina, vida, mana, forca,agilidade,inteligencia,vontade,id_classe,id_usuario) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)", $dados);

    $insert++;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Teste gerador de dados</title>
</head>
<body>
<div class="container">
    <table class="table table-striped table-bordered" style="width:400px">
        <thead>
        <tr>
            <th id="cen">ID</th>
            <th id="cen">Nome do Jogador</th>
            <th id="cen">Opção</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $consulta = $db->query("SELECT * FROM personagens ORDER BY id_personagem DESC");
        foreach ($consulta as $linha) {
            ?>
            <tr>
                <td id="cen"> <?= $linha['id_personagem'] ?></td>
                <td id="cen"> <?= $linha['nome_personagem'] ?></td>
                <td id="cen"><a href="?id=<?= $linha['id_personagem'] ?>&acao=deletar">Deletar</a>
                    <a href="?id=<?= $linha['id_personagem'] ?>&acao=atualizar">Atualizar</a></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
