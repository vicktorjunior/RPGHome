<?php
include_once "sessao.php";
require 'db/DB.class.php';
//inicia a conexão
$db = new DB('02080123',                    //usuario
    '3Ka7ktok',                           //senha
    '02080123',                   //banco
    'webacademico.canoas.ifrs.edu.br'//servidor
);
extract($_GET);
$dados2[0] = $id;
$db->execute("DELETE FROM personagens WHERE id_usuario=?",$dados2);
$op = $db->execute("DELETE FROM usuario WHERE id_usuario=?",$dados2);

header('location:crudusuario.php');
?>