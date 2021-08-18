<?php

    // Realizar o include da conexão com o banco de dados
    include('../../conexao/conn.php');

    // Obter os request vindo do banco de dados
    $requestData = $_REQUEST;

    // Obter as colunas vindas do request
    $colunas = $requestData['columns'];

    // Prepara o SQL básico para consulta ao banco de dados
    $sql = "SELECT IDCURSO, NOME FROM CURSO WHERE 1=1";

    // Obter o total de registros cadastrados no banco de dados
    $resultado = $pdo->query($sql);
    $qtdeLinhas = $resultado->rowCount();

    // Verificação se existe algums filtro a ser pesquisado
    $filtro = $requestData['search']['value'];
    if(!empty($filtro)){
        // Montar a lógica para executar o filtro
        // Aqui também determinamos quais colunas farão parte da nossa pesquisa
        $sql .= " AND (IDCURSO LIKE '%$filtro%' ";
        $sql .= " OR NOME LIKE '%$filtro%') " ;
    }

    // Obter o total de dados filtrados
    $resultado = $pdo->query($sql);
    $totalFiltrados = $resultado->rowCount();

    // Criar a lógica para ordenação de dados em tela
    $colunaOrdem = $requestData['order'][0]['column']; //Obtendo a posição da coluna a ser ordenada
    $ordem = $colunas[$colunaOrdem]['data']; //Obtendo o nome da coluna que será organizada
    $direcao = $requestData['order'][0]['dir']; //Obtermos a direção que será ordenado

    // Criar os limites de dados que irão aparecer na tela
    $inicio = $requestData['start']; //Obtendo o início do limite
    $tamanho = $requestData['length']; //Obter o tamanho do limite

    // Criar a query de ordenação e limite da dados
    $sql .= " ORDER BY $ordem $direcao LIMIT $inicio, $tamanho ";
    $resultado = $pdo->query($sql);
    $dados = array();
    while($row = $resultado->fetch(PDO::FETCH_ASSOC)){
        $dados[] = array_map('utf8_encode', $row);
    }

    // Montar o objeto json de retorno nos padrões do DataTables
    $json_data = Array(
        "draw" => intval($requestData['draw']),
        "recordsTotal" => intval($qtdeLinhas),
        "recordsFiltered" => intval($totalFiltrados),
        "data" => $dados
    );

    // Retornamos o elemento JSON
    echo json_encode($json_data);