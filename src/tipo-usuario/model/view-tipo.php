<?php

    // Inclusão do banco de dados
    include('../../conexao/conn.php');

    // Realizar a recepção do id a ser buscado no banco de dados
    $IDTIPO_USUARIO = $_REQUEST['IDTIPO_USUARIO'];

    // Gerar a querie de consulta ao banco de dados
    $sql = "SELECT * FROM TIPO_USUARIO WHERE IDTIPO_USUARIO = $IDTIPO_USUARIO";

    // Executar a nossa querie de consulta ao banco de dados
    $resultado = $pdo->query($sql);

    // Testar o retorno da consulta do nosso banco de dados
    if($resultado){
        $dadosTipo = array();
        while($row = $resultado->fetch(PDO::FETCH_ASSOC)){
            $dadosTipo = array_map('utf8_encode', $row);
        }
        $dados = array(
            'tipo' => 'success',
            'mensagem' => '',
            'dados' => $dadosTipo
        );
    } else {
        $dados = array(
            'tipo' => 'error',
            'mensagem' => 'Não foi possível obter o registro solicitado.',
            'dados' => array()
        );
    }

    echo json_encode($dados);