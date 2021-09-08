<?php

    include('../../conexao/conn.php');

 
    $ID = $_REQUEST['IDCURSO'];

 
    $sql = "DELETE FROM CURSO WHERE IDCURSO = $ID";


    $resultado = $pdo->query($sql);

 
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