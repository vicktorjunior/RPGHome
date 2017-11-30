<?php include_once 'sessao.php';
include 'db/DB.class.php';
$db = new DB('02080123',                    //usuario
    '3Ka7ktok',                           //senha
    '02080123',                   //banco
    'webacademico.canoas.ifrs.edu.br'//servidor
);
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
            <h1>Medieval RPG - CADASTRO PERSONAGEM</h1>
        </div>
    </header>
    <div role="main">
       
        <?php
        
        echo"<div class='row'><h5>Cadastre seu personagem, $logado</h5></div>";
        ?>
        <form method="post" action="conferepersonagem.php">
            <div class="row"><div class="col-md-6">Nome do Personagem: <input type="text" required name="nome"></div>
                <div class="col-md-6">Classe:
                    <select name="classe" required>
                    <?php $consulta = $db->query("select * from classes");
                    foreach ($consulta as $linha) {
                        echo '<option value="'.$linha['id_classe'].'">'.$linha['nome_classe'].'</option>';
                    } ?>
                    </select>
                </div>
            </div>
            <div class="row"><div class="col-md-6">Nível: <input type="text" name="nivel" value="1" readonly></div>
            <div class="col-md-6">Experiência: <input type="text" name="exp" value="0" readonly></div></div>
            <div class="row"><div class="col-md-12">Defesa: <input type="text" name="defesa" value="50" readonly></div></div>
            <div class="row"><div class="col-md-12">Stamina: <input type="text" name="stamina" value="100" readonly></div></div>
            <div class="row"><div class="col-md-12">Vida: <input type="text" name="vida" value="100" readonly></div></div>
            <div class="row"><div class="col-md-12">Mana: <input type="text" name="mana" value="50" readonly></div></div>
            <div class="row"><div class="col-md-12">Força: <input type="number" min="0" max="20" value="0" name="forca" id="forca"></div></div>
            <div class="row"><div class="col-md-12">Agilidade: <input type="number" min="0" max="20" value="0" name="agilidade" id="agilidade"></div></div>
            <div class="row"><div class="col-md-12">Inteligência: <input type="number" min="0" max="20" value="0" name="inteligencia" id="inteligencia"></div></div>
            <div class="row"><div class="col-md-12">Vontade: <input type="number" min="0" value="0" max="20" name="vontade" id="vontade"></div></div>
            <div class="row"><div class="col-md-12"><input hidden readonly name="iduser" value="<?php $id?>"></div> </div>
            <div class="row"><button class="btn-default">Continuar</button></div>
        </form>
        <button class='btn-default' onclick="location.href='prod.php'">Voltar</button>
    </div>
    <footer class="row">
        <h6>RN Dev &copy; Todos os direitos reservados</h6>
    </footer>
</div>

<script href="js/bootstrap.min.js"></script>
</body>
</html>

