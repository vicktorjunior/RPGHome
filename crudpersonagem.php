<?php
include_once "sessao.php";
require 'db/DB.class.php';
//inicia a conexão
$db = new DB('02080123',                    //usuario
    '3Ka7ktok',                           //senha
    '02080123',                   //banco
    'webacademico.canoas.ifrs.edu.br'//servidor
);
extract($_REQUEST);//transformando os dados enviados em variaveis


if(isset($_REQUEST['acao'] )) {
    $acao = $_REQUEST['acao'];
} else {
    $acao='insercao';
}

if(isset($nome_personagem) && $acao == 'insercao'){
   // if($acao != 'atualizarFim') {
    $string = "SELECT id_usuario from usuarios where usuario = '$logado'";
    $op = $db->query($string);
    foreach ($op as $row) {
        $iduser = $row['id_usuario'];
    }
    //echo $iduser;
    $dados = array($nome_personagem,$classe,$nivel,$exp,$defesa,$stamina,$vida,$mana,$forca,$agilidade,$inteligencia,$vontade,$iduser);
    $db->execute("INSERT INTO personagens 
                              (nome_personagem,
                              id_classe,
                              nivel,
                              experiencia,
                              defesa,
                              stamina,
                              vida,
                              mana,
                              forca,
                              agilidade,
                              inteligencia,
                              vontade,
                              id_usuario) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)", $dados);

}
//deletar
if(isset($id) && $acao == 'deletar'){
    $dados2[0] = $id;
    $db->execute("DELETE FROM personagens WHERE id_personagem=?",$dados2);
}
$dadosTemp['id'] = '';
$dadosTemp['nome_personagem'] = '';
$dadosTemp['mana'] = '';
$dadosTemp['nivel'] = '';
$dadosTemp['experiencia'] = '';
$dadosTemp['defesa'] = '';
$dadosTemp['stamina'] = '';
$dadosTemp['vida'] = '';
$dadosTemp['forca'] = '';
$dadosTemp['agilidade'] = '';
$dadosTemp['inteligencia'] = '';
$dadosTemp['vontade'] = '';
$dadosTemp['idusuario'] = '';

if(isset($acao) && $acao == 'atualizarFim'){
    $string = "SELECT id_usuario from usuarios where usuario = '$logado'";
    $op = $db->query($string);
    foreach ($op as $row) {
        $iduser = $row['id_usuario'];
    }
    $dados[0] = $nome_personagem;
    $dados[1] = $classe;
    $dados[2] = $nivel;
    $dados[3] = $exp;
    $dados[4] = $defesa;
    $dados[5] = $stamina;
    $dados[6] = $vida;
    $dados[7] = $mana;
    $dados[8] = $forca;
    $dados[9] = $agilidade;
    $dados[10] = $inteligencia;
    $dados[11] = $vontade;
    $dados[12] = $iduser;
    $dados[13] = $id;
    $id=null;
    //echo "atualizar fim";
    $db->execute("UPDATE personagens SET nome_personagem=?, 
                                         id_classe=?,
                                         nivel=?, 
                                         experiencia=?, 
                                         defesa=?, 
                                         stamina=?, 
                                         vida=?, 
                                         mana=?, 
                                         forca=?, 
                                         agilidade=?, 
                                         inteligencia=?, 
                                         vontade=?,
                                         id_usuario=?
                                         WHERE id_personagem=?", $dados);

    $acao = '';
}

if(isset($acao) && $acao == 'atualizar'){
    //echo "atualizar";
    $consulta = $db->query("SELECT * FROM personagens p
						INNER JOIN usuarios u ON u.id_usuario = p.id_usuario
						INNER JOIN classes c ON c.id_classe = p.id_classe
						WHERE p.id_personagem = $id
						GROUP BY p.id_personagem, c.id_classe, p.id_classe, p.nome_personagem, p.nivel, p.experiencia,p.defesa, p.stamina, p.vida, p.mana, p.forca, p.agilidade, p.inteligencia, p.vontade, p.id_usuario, u.id_usuario, u.senha, u.usuario, u.email, c.nome_classe, c.historia
						ORDER BY p.id_personagem");

    foreach ($consulta as $linha) {
        $dadosTemp = $linha;
        echo "consulta";
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
            <h1>Medieval RPG - CRUD PERSONAGEM</h1>
        </div>
    </header>
    <div role="main">
    <div>
        <div class="panel panel-default panel-table">

                    <form role="form" action="crudpersonagem.php?acao=<?= $acao?>&id=<?=$id?>"" method="post">

                        <div class="row"><div class="col-md-6">Nome do Personagem: <input type="text" required name="nome_personagem" value="<?=$dadosTemp['nome_personagem']?>"></div>
                            <div class="col-md-6">Classe:
                                <select name="classe" required>
                                    <?php $consulta = $db->query("select * from classes");
                                    foreach ($consulta as $linha) {
                                        echo '<option value="'.$linha['id_classe'].'">'.$linha['nome_classe'].'</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row"><div class="col-md-6">Nível: <input type="text" name="nivel" value="<?=$dadosTemp['nivel']=1?>" readonly></div>
                            <div class="col-md-6">Experiência: <input type="text" name="exp" value="<?=$dadosTemp['experiencia']=0?>" readonly></div></div>
                        <div class="row"><div class="col-md-12">Defesa: <input type="text" name="defesa" value="<?=$dadosTemp['defesa']=50?>" readonly></div></div>
                        <div class="row"><div class="col-md-12">Stamina: <input type="text" name="stamina" value="<?=$dadosTemp['stamina']=10?>" readonly></div></div>
                        <div class="row"><div class="col-md-12">Vida: <input type="text" name="vida" value="<?=$dadosTemp['vida']=100?>" readonly></div></div>
                        <div class="row"><div class="col-md-12">Mana: <input type="text" name="mana" value="<?=$dadosTemp['mana']=0?>" readonly></div></div>
                        <div class="row"><div class="col-md-12">Força: <input type="number" min="0" max="20" value="<?=$dadosTemp['forca']?>" name="forca" id="forca"></div></div>
                        <div class="row"><div class="col-md-12">Agilidade: <input type="number" min="0" max="20" value="<?=$dadosTemp['agilidade']?>" name="agilidade" id="agilidade"></div></div>
                        <div class="row"><div class="col-md-12">Inteligência: <input type="number" min="0" max="20" value="<?=$dadosTemp['inteligencia']?>" name="inteligencia" id="inteligencia"></div></div>
                        <div class="row"><div class="col-md-12">Vontade: <input type="number" min="0" value="<?=$dadosTemp['vontade']?>" max="20" name="vontade" id="vontade"></div></div>
                        <div class="row"><div class="col-md-12"><input hidden name="iduser" value="<?=$dadosTemp['idusuario']?>"></div> </div>
                        <li class="list-group-item"><button type="submit" class="btn-default">Inserir - Atualizar</button></li>
                        <li class="list-group-item"> <button class='btn-default' onclick="location.href='prod.php'">Voltar</button>
                            <button class="btn-default" onclick="location.href='deslogar.php'">LOGOUT</button></li>
                    </form>
            </div>


            <div class="panel-body">
                <table class="table table-striped table-bordered table-list">
                    <thead>
                    <tr>
                        <th><em class="fa fa-cog"></em></th>
                        <th class="hidden-xs">ID</th>
                        <th>Personagem</th>
                        <th>Nível</th>
                        <th>Experiencia</th>
                        <th>Usuário</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $consulta = $db->query("SELECT * FROM personagens p
															INNER JOIN usuarios u ON u.id_usuario = p.id_usuario
															INNER JOIN classes c ON c.id_classe = p.id_classe
															GROUP BY p.id_personagem, c.id_classe, p.id_classe, p.nome_personagem, p.nivel, p.experiencia, p.defesa, p.stamina, p.vida, p.mana, p.forca, p.agilidade, p.inteligencia, p.vontade,p.id_usuario, u.id_usuario, u.senha, u.usuario, u.email, c.nome_classe, c.historia	
															ORDER BY p.id_personagem");
                    foreach ($consulta as $linha) {
                    ?>
                    <tr>
                        <td align="center">
                            <a class="glyphicon glyphicon-refresh" href="?id=<?= $linha['id_personagem']?>&acao=atualizar"><?php $acao='atualizar';?><em class="fa fa-pencil"></em></a>
                            <a class="glyphicon glyphicon-trash" href="?id=<?= $linha['id_personagem']?>&acao=deletar"><em class="fa fa-trash"></em></a>
                        </td>
                        <td class="hidden-xs"><?= $linha['id_personagem']?></td>
                        <td><?= $linha['nome_personagem']?></td>
                        <td><?= $linha['nivel']?></td>
                        <td><?= $linha['experiencia']?></td>
                        <td><?= $linha['id_usuario']?></td>
                        <?php
                        }
                        ?>

                    </tr>
                    </tbody>
                </table>
            </div>


        </div>


    </div>



</div> <!-- end container -->




<!-- All Javascript at the bottom of the page for faster page loading -->

<!-- First try for the online version of jQuery-->
<script src="http://code.jquery.com/jquery.js"></script>

<!-- If no online access, fallback to our hardcoded version of jQuery -->
<script>window.jQuery || document.write('<script src="include/js/jquery-1.8.2.min.js"><\/script>')</script>

<!-- Bootstrap JS -->
<script src="bootstrap/js/bootstrap.min.js"></script>

<!-- Custom JS -->
<!-- <script src="include/js/script.js"></script> -->
<!-- <script src="include/js/formatacampo.js"></script> -->

</body>
</html>




