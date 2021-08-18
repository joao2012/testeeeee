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
        $ID = isset($requestData['IDEIXO']) ? $requestData['IDEIXO'] : '';
        $operacao = isset($requestData['operacao']) ? $requestData['operacao'] : '';

        // Verificação se é para cadastrar um novo registro
        if($operacao == 'insert'){
            try {
                $stmt = $pdo->prepare('INSERT INTO EIXO (NOME) VALUES (:a)');
                $stmt->execute(array(
                    ':a' => utf8_decode($requestData['NOME'])
                ));
                $dados = array(
                    "tipo" => "success",
                    "mensagem" => "Eixo tecnológico cadastrado com sucesso."
                );
            } catch (PDOException $e) {
                $dados = array(
                    "tipo" => "error",
                    "mensagem" => "Não foi possível efetuar o cadastro do eixo."
                );
            }
        } else {
            // Se minha variável operação estiver vazia então executa o update do registro
            try {
                $stmt = $pdo->prepare('UPDATE EIXO SET NOME = :a WHERE IDEIXO = :id');
                $stmt->execute(array(
                    ':id' => $ID,
                    ':a' => utf8_decode($requestData['NOME'])
                ));
                $dados = array(
                    "tipo" => "success",
                    "mensagem" => "Eixo tecnológico alterado com sucesso."
                );
            } catch (PDOException $e) {
                $dados = array(
                    "tipo" => "error",
                    "mensagem" => "Não foi possível efetuar a alteração do eixo tecnológico."
                );
            }
        }
    }

    // Converter um array de dados para a representação JSON
    echo json_encode($dados);