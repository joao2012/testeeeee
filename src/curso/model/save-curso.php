<?php

    // Obter nossa conexão com banco de dados
    include('../../conexao/conn.php');

    // Obter os dados enviados do formulário via REQUEST
    $requestData = $_REQUEST;

    // Verificação dos campos obrigatórios do formulário
    if(empty($requestData['NOME'])){
        // Caso a variável venha vazia gerar um retorno com erro
        $dados = array(
            "tipo" => "error",
            "mensagem" => "Existe(m) campo(s) obrigatório(s) não preenchido(s)"
        );
    } else {
        // Caso a variável exista e tenha conteúdo, vamos gerar uma requisição
        $ID = isset($requestData['IDCURSO']) ? $requestData['IDCURSO'] : '';
        $operacao = isset($requestData['operacao']) ? $requestData['operacao'] : '';

        // Verificação se é para cadastrar um novo registro
        if($operacao == 'insert'){
            try {
                $stmt = $pdo->prepare('INSERT INTO CURSO (NOME, EIXO_IDEIXO) VALUES (:a, :b)');
                $stmt->execute(array(
                    ':a' => utf8_decode($requestData['NOME']),
                    ':b' => $requestData['EIXO_IDEIXO']
                ));
                $dados = array(
                    "tipo" => "success",
                    "mensagem" => "Curso cadastrado com sucesso."
                );
            } catch (PDOException $e) {
                $dados = array(
                    "tipo" => "error",
                    "mensagem" => "Não foi possível efetuar o cadastro do curso."
                );
            }
        } else {
            // Se minha variável operação estiver vazia então executa o update do registro
            try {
                $stmt = $pdo->prepare('UPDATE CURSO SET NOME = :a, EIXO_IDEIXO = :b WHERE IDCURSO = :id');
                $stmt->execute(array(
                    ':id' => $ID,
                    ':a' => utf8_decode($requestData['NOME']),
                    ':b' => $requestData['EIXO_IDEIXO']
                ));
                $dados = array(
                    "tipo" => "success",
                    "mensagem" => "Curso alterado com sucesso."
                );
            } catch (PDOException $e) {
                $dados = array(
                    "tipo" => "error",
                    "mensagem" => "Não foi possível efetuar a alteração do curso."
                );
            }
        }
    }

    // Converter um array de dados para a representação JSON
    echo json_encode($dados);