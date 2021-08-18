<?php

    // Instânciar nosso banco de dados
    include('../../conexao/conn.php');

    // Coleta do ID que será excluído do nosso banco de dados
    $ID = $_REQUEST['IDUSUARIO'];

    // Criar a nossa querie para interação com banco de dados
    $sql = "DELETE FROM USUARIO WHERE IDUSUARIO = $ID";

    // Executar nossa consulta sql
    $resultado = $pdo->query($sql);

    // Testar o retorno da consulta sql
    if($resultado){
        $dados = array(
            'tipo' => 'success',
            'mensagem' => 'Registro excluído com sucesso!'
        );
    }else{
        $dados = array(
            'tipo' => 'error',
            'mensagem' => 'Não foi possível excluir o registro'
        );
    }

    echo json_encode($dados);