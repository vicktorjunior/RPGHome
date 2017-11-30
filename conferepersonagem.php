<?php
include_once 'sessao.php';
require 'db/DB.class.php';
//inicia a conexão
$db = new DB('02080123',                    //usuario
    '3Ka7ktok',                           //senha
    '02080123',                   //banco
    'webacademico.canoas.ifrs.edu.br'//servidor
);
extract($_POST);

if(isset($nome)) {
    $string = "SELECT id_usuario from usuarios where usuario = '$logado'";
    $op = $db->query($string);
    foreach ($op as $row) {
        $iduser = $row['id_usuario'];
    }
    //echo $iduser;
    $dados = array($nome,$classe,$nivel,$exp,$defesa,$stamina,$vida,$mana,$forca,$agilidade,$inteligencia,$vontade,$iduser);
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
    $situacao = 1;
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
            <h1>Medieval RPG - CADASTRO</h1>
        </div>
    </header>
    <div class="row">
        <div class="col-md-12">
            <?php if ($situacao == 1) {
                echo "<div role='main'><h4>CADASTRO REALIZADO COM SUCESSO</h4>";
                echo "<button class=\"btn-default\" onclick=\"window.location.href='prod.php';\">Home</button></div>";
            } else {
                echo "<div role='main'><h4>ACONTECEU ALGUM PROBLEMA! Volte e repita a operação.</h4>";
                echo "<button class=\"btn-default\" onclick=\"window.location.href='cadastropersonagem.php';\">Voltar</button></div>";
            }
            ?>
        </div>

    </div>

    <footer class="row">
        <h6>RN Dev &copy; Todos os direitos reservados</h6>
    </footer>
</div>

<script href="js/bootstrap.min.js"></script>