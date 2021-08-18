<?php

    // Declarar as variáveis necessárias para gerar a minha conexão com o banco de dados ....
    $hostmane = "sqlXXX.epizy.com";
    $dbname = "epiz_28841636_libraryjoao";
    $username = "epiz_28841636";
    $password = "zcY9oz3dU4XFy";

    try {
        $pdo = new PDO('mysql:host='.$hostmane.';dbname='.$dbname, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo 'Conexão realizada com sucesso!!!';
    } catch (PDOException $e) {
        echo 'Error: '.$e->getMessage();
    }

