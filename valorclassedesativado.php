<?php
include_once 'sessao.php';
include 'db/DB.class.php';

$db = new DB('02080123',                    //usuario
    '3Ka7ktok',                           //senha
    '02080123',                   //banco
    'webacademico.canoas.ifrs.edu.br'//servidor
);

$nome = htmlspecialchars($_POST['nome']);
$id = htmlspecialchars($_POST['classe']);

$classe = $db->query("select nome_classe from classes where id_classe = $id");

foreach ($classe as $linha) {
    $nomedaclasse = $linha['nome_classe'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <title>RPG-BD</title>
</head>
<body>
<div class="container-fluid">
    <header class="row">
        <div class="col-md-12">
            <h1>Medieval RPG - CADASTRO PERSONAGEM</h1>
        </div>
        <script>
            var maximo = 10;
            var forca = 10;
            var agilidade = 10;
            var inteligencia = 10;
            var vontade = 10;
            $(document).ready(function() {
                $("#maximo").val(maximo);
                $("#forca").val(forca);
                $("#agilidade").val(agilidade);
                $("#inteligencia").val(inteligencia);
                $("#vontade").val(vontade);
                dif = maximo;

                $("#forca").on('change',function () {
                    if($("#maximo").val()>0) {
                        dif = dif + (forca - ($("#forca").val()));
                        forca=$("#forca").val();

                        $("#maximo").val(dif);
                    } else if($("#maximo").val() == 0) {
                        dif = dif + (forca -($("#forca").val()));

                        forca=$("#forca").val();
                        $("#maximo").val(dif);

                    }

                })

                $("#agilidade").on('change',function () {
                    if($("#maximo").val()>0) {
                        dif = dif + (agilidade - ($("#agilidade").val()));
                        agilidade=$("#agilidade").val();

                        $("#maximo").val(dif);
                    } else if($("#maximo").val() == 0) {
                        dif = dif + (agilidade -($("#agilidade").val()));
                        agilidade=$("#agilidade").val();

                        $("#maximo").val(dif);
                    }

                    // }

                })

                $("#inteligencia").on('change',function () {
                    if($("#maximo").val()>0) {
                        dif = dif + (inteligencia - ($("#inteligencia").val()));
                        inteligencia = $("#inteligencia").val();

                        $("#maximo").val(dif);
                    } else if($("#maximo").val() == 0) {
                        dif = dif + (inteligencia -($("#inteligencia").val()));
                        inteligencia = $("#inteligencia").val();

                        $("#maximo").val(dif);
                    }

                    // }

                })

                $("#vontade").on('change',function () {
                    if($("#maximo").val()>0) {
                        dif = dif + (vontade - ($("#vontade").val()));
                        vontade=$("#vontade").val();

                        $("#maximo").val(dif);
                    } else if($("#maximo").val() == 0) {
                        dif = dif + (vontade -($("#vontade").val()));
                        vontade=$("#vontade").val();

                        $("#maximo").val(dif);
                    }

                    // }

                })


            })
        </script>
    </header>
    <div role="main">
        <?php echo "<h2>Bem vindo $nome, você é $nomedaclasse! Escolha seus atributos!</h2>"; ?>
        <form method="post" action="valorclassedesativado.php">
            <div class="row"><div class="col-md-12">Pontos disponíveis: <input type="number" name="maximo" id="maximo" disabled min = "0"></div></div>
            <div class="row"><div class="col-md-12">Força: <input type="number" min="0" max="20" value="10" name="forca" id="forca"></div></div>
            <div class="row"><div class="col-md-12">Agilidade: <input type="number" min="0" max="20" value="10" name="agilidade" id="agilidade"></div></div>
            <div class="row"><div class="col-md-12">Inteligência: <input type="number" min="0" max="20" value="10" name="inteligencia" id="inteligencia"></div></div>
            <div class="row"><div class="col-md-12">Vontade: <input type="number" min="0" value="10" max="20" name="vontade" id="vontade"></div></div>

            <div class="row"><button class="btn-default">Continuar</button></div>
        </form>
        <button class='btn-default' onclick='window.history.back()'>Voltar</button>


    </div>
    <footer class="row">
        <h6>RN Dev &copy; Todos os direitos reservados</h6>
    </footer>
</div>

<script href="js/bootstrap.min.js"></script></body>
