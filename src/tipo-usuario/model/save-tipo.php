<?php

    // Obter nossa conexão com banco de dados
    include('../../conexao/conn.php');

    // Obter os dados enviados do formulário via REQUEST
    $requestData = $_REQUEST;

    // Verificação dos campos obrigatórios do formulário
    if(empty($requestData['DESCRICAO'])){
        // Caso a variável venha vazia gerar um retorno com erro
        $dados = array(
            "tipo" => "error",
            "mensagem" => "Existe(m) campo(s) obrigatório(s) não preenchido(s)"
        );
    } else {
        // Caso a variável exista e tenha conteúdo, vamos gerar uma requisição
        $IDTIPO_USUARIO = isset($requestData['IDTIPO_USUARIO']) ? $requestData['IDTIPO_USUARIO'] : '';
        $operacao = isset($requestData['operacao']) ? $requestData['operacao'] : '';

        // Verificação se é para cadastrar um novo registro
        if($operacao == 'insert'){
            try {
                $stmt = $pdo->prepare('INSERT INTO TIPO_USUARIO (DESCRICAO) VALUES (:descricao)');
                $stmt->execute(array(
                    ':descricao' => utf8_decode($requestData['DESCRICAO'])
                ));
                $dados = array(
                    "tipo" => "success",
                    "mensagem" => "Tipo de usuário cadastrado com sucesso."
                );
            } catch (PDOException $e) {
                $dados = array(
                    "tipo" => "error",
                    "mensagem" => "Não foi possível efetuar o cadastro do tipo de usuário."
                );
            }
        } else {
            // Se minha variável operação estiver vazia então executa o update do registro
            try {
                $stmt = $pdo->prepare('UPDATE TIPO_USUARIO SET DESCRICAO = :descricao WHERE IDTIPO_USUARIO = :id');
                $stmt->execute(array(
                    ':id' => $IDTIPO_USUARIO,
                    ':descricao' => utf8_decode($requestData['DESCRICAO'])
                ));
                $dados = array(
                    "tipo" => "success",
                    "mensagem" => "Tipo de usuário alterado com sucesso."
                );
            } catch (PDOException $e) {
                $dados = array(
                    "tipo" => "error",
                    "mensagem" => "Não foi possível efetuar a alteração do tipo de usuário."
                );
            }
        }
    }

    // Converter um array de dados para a representação JSON
    echo json_encode($dados);