<?php

    // Inclusão do banco de dados
    include('../../conexao/conn.php');

    // Realizar a recepção do id a ser buscado no banco de dados
    $IDEIXO = $_REQUEST['IDEIXO'];

    // Gerar a querie de consulta ao banco de dados
    $sql = "SELECT * FROM EIXO WHERE IDEIXO = $IDEIXO";

    // Executar a nossa querie de consulta ao banco de dados
    $resultado = $pdo->query($sql);

    // Testar o retorno da consulta do nosso banco de dados
    if($resultado){
        $resultQuery = array();
        while($row = $resultado->fetch(PDO::FETCH_ASSOC)){
            $resultQuery = array_map('utf8_encode', $row);
        }
        $dados = array(
            'tipo' => 'success',
            'mensagem' => '',
            'dados' => $resultQuery
        );
    } else {
        $dados = array(
            'tipo' => 'error',
            'mensagem' => 'Não foi possível obter o registro solicitado.',
            'dados' => array()
        );
    }

    echo json_encode($dados);