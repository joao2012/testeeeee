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
        $ID = isset($requestData['IDUSUARIO']) ? $requestData['IDUSUARIO'] : '';
        $operacao = isset($requestData['operacao']) ? $requestData['operacao'] : '';

        // Verificação se é para cadastrar um novo registro
        if($operacao == 'insert'){
            try {
                $stmt = $pdo->prepare('INSERT INTO USUARIO (NOME, EMAIL, SENHA, TIPO_USUARIO_IDTIPO_USUARIO, CURSO_IDCURSO) VALUES (:a, :b, :c, :d, :e)');
                $stmt->execute(array(
                    ':a' => utf8_decode($requestData['NOME']),
                    ':b' => $requestData['EMAIL'],
                    ':c' => md5($requestData['SENHA']),
                    ':d' => $requestData['TIPO_USUARIO_IDTIPO_USUARIO'],
                    ':e' => $requestData['CURSO_IDCURSO']
                ));
                $dados = array(
                    "tipo" => "success",
                    "mensagem" => "Usuário cadastrado com sucesso."
                );
            } catch (PDOException $e) {
                $dados = array(
                    "tipo" => "error",
                    "mensagem" => "Não foi possível efetuar o cadastro do usuário.".$e
                );
            }
        } else {
            // Se minha variável operação estiver vazia então executa o update do registro
            try {
                $stmt = $pdo->prepare('UPDATE USUARIO SET NOME = :a, EMAIL = :b, SENHA = :c, TIPO_USUARIO_IDTIPO_USUARIO = :d, CURSO_IDCURSO = :e WHERE IDUSUARIO = :id');
                $stmt->execute(array(
                    ':id' => $ID,
                    ':a' => utf8_decode($requestData['NOME']),
                    ':b' => $requestData['EMAIL'],
                    ':c' => md5($requestData['SENHA']),
                    ':d' => $requestData['TIPO_USUARIO_IDTIPO_USUARIO'],
                    ':e' => $requestData['CURSO_IDCURSO']
                ));
                $dados = array(
                    "tipo" => "success",
                    "mensagem" => "Usuário alterado com sucesso."
                );
            } catch (PDOException $e) {
                $dados = array(
                    "tipo" => "error",
                    "mensagem" => "Não foi possível efetuar a alteração do usuário."
                );
            }
        }
    }

    // Converter um array de da