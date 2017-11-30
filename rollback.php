<?php
require 'db/DB.class.php';
$db = new DB('02080123',                    //usuario
    '3Ka7ktok',                           //senha
    '02080123',                   //banco
    'webacademico.canoas.ifrs.edu.br'//servidor
);
$db->begin();
$dados = ["padrao1"];
$e1 = $db->execute("insert into categoria (nome_categoria) VALUES (?)",$dados);
$e2 = $db->execute("insert into orientador (nome_orientador) VALUES (?)",$dados);
$e3 = $db->execute("insert into palavra_chave (palavra_chave) VALUES (?)", $dados);
$e4 = $db->execute("insert into area_conhecimento (nome_area) VALUES (?)", $dados);
if (!($e1 && $e2 && $e3 && $e4)) {
    $db->rollback();
}
$data[0] = $db->lastInsertId('categoria_id_categoria_seq');
$data[1] = $db->lastInsertId('orientador_id_orientador_seq');
$data[2] = $db->lastInsertId('area_conhecimento_id_area_seq');
$data[3] = "nome1";
$e5 = $db->execute("insert into trabalhos (id_categoria, id_orientador, id_area, titulo_trabalho) VALUES (?,?,?,?)", $data);
if (!$e5) {
    $db->rollback();
}
$db->commit();


